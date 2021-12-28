<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Google_Client;
use Google_Service_Gmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DealController extends Controller{

    public function fetchClientDeal(){
        $client = new Google_Client();
        $user_mail = 'office@leos.co.il';


        if ($credentials_file = $this->checkServiceAccountCredentialsFile()) {
            // set the location manually
            $client->setAuthConfig($credentials_file);
        } elseif (getenv('GOOGLE_APPLICATION_CREDENTIALS')) {
            // use the application default credentials
            $client->useApplicationDefaultCredentials();
        } else {
            echo $this->missingServiceAccountDetailsWarning();
            return;
        }

        $client->setApplicationName("Client_Fetch_Deals");
        $client->setScopes([
            'https://mail.google.com',
            'https://www.googleapis.com/auth/gmail.readonly',
        ]);
        $client->setConfig('subject', $user_mail);

        $gmail = new Google_Service_Gmail($client);


        $list = $gmail->users_messages->listUsersMessages($user_mail, [
            'maxResults' => 1000,
            'q' => 'in:sent נסגרה עסקה + איתמר רוזן'
        ]);

        try {
            foreach ($list->getMessages() as $count => $message) {

                $message_id = $message->id;
                $optParamsGet2['format'] = 'full';
                $single_message = $gmail->users_messages->get($user_mail, $message_id, $optParamsGet2);

                $files = $this->getAttachments($message_id, $single_message->getPayload()->parts, $gmail);
                $deal = new Deal();

                if(!empty($files)) {
                    foreach ($files as $key => $value) {
                        $image_64 = $value['data']; //your base64 encoded data
                        $deal->addMediaFromBase64($image_64)->usingFileName(Str::random(40).'.pdf')->toMediaCollection('deal_files');

                    }
                }
                $deal->save();


            }
        }catch (Exception $e) {
            echo $e->getMessage();
        }

        dd($deal);
    }

    private function missingServiceAccountDetailsWarning(){
        $ret = "
    <h3 class='warn'>
      Warning: You need download your Service Account Credentials JSON from the
      <a href='http://developers.google.com/console'>Google API console</a>.
    </h3>
    <p>
      Once downloaded, move them into the root directory of this repository and
      rename them 'service-account-credentials.json'.
    </p>
    <p>
      In your application, you should set the GOOGLE_APPLICATION_CREDENTIALS environment variable
      as the path to this file, but in the context of this example we will do this for you.
    </p>";

        return $ret;
    }


    function checkServiceAccountCredentialsFile()
    {
        // service account creds
        $application_creds = public_path('service-account-credentials.json');

        return file_exists($application_creds) ? $application_creds : false;
    }


    public function decodeBody($body)
    {
        $rawData = $body;
        $sanitizedData = strtr($rawData, '-_', '+/');
        $decodedMessage = base64_decode($sanitizedData);
        if (!$decodedMessage) {
            $decodedMessage = FALSE;
        }
        return $decodedMessage;
    }

    private function getAttachments($message_id, $parts, $gmail) {
        $attachments = [];
        foreach ($parts as $part) {
            if (!empty($part->body->attachmentId)) {
                $attachment = $gmail->users_messages_attachments->get('me', $message_id, $part->body->attachmentId);
                $attachments[] = [
                    'filename' => $part->filename,
                    'mimeType' => $part->mimeType,
                    'data'     => strtr($attachment->data, '-_', '+/')
                ];
            } else if (!empty($part->parts)) {
                $attachments = array_merge($attachments, $this->getAttachments($message_id, $part->parts, $gmail));
            }
        }
        return $attachments;
    }

}
