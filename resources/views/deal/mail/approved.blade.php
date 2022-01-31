<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 500px;" width="500">
    <tr>
        <td style="text-align: right;">
            <h1 style="text-align: center">
                <span>#{{ $dealID }}</span>
                -
                <a href="{{ $link }}" style="text-align: center">
                    <span>{{ $client }}</span>
                </a>
            </h1>
        </td>
    </tr>
    <tr>
        <td style="text-align: right">{{ $bid_number }}</td>
        <td style="text-align: right">מספר הצעה</td>
    </tr>
</table>


<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 500px;" width="500">
    <tbody>
        <tr>
            <td style="text-align: center">
                <p style="text-align: center">סקור עסק</p>
                <p style="text-align: center">{{ $client_review }}</p>
            </td>
            <td style="text-align: center">
                <p style="text-align: center">סקור ענפי</p>
                <p style="text-align: center">{{ $branch_review }}</p>
            </td>
            <td style="text-align: center">
                <p style="text-align: center">ותק עסק</p>
                <p style="text-align: center">{{ $client_seniority }}</p>
            </td>
            <td style="text-align: center">
                <p style="text-align: center">מספר מועסקים</p>
                <p style="text-align: center">{{ $employed_numbers }}</p>
            </td>
        </tr>
    </tbody>
</table>
<h2 style="text-align: center;">מוצרים</h2>
<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 500px;" width="500">
    <tbody>
    @foreach($products as $_p)
    <tr>
        <td style="text-align: center;">{{ $_p['qty'] }}</td>
        <td style="text-align: right">{{ $_p['name'] }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
<p style="text-align: center">
    @if($_d->monday_pulse)
        <a href="https://leosmediainteractive.monday.com/boards/2219425041/pulses/{{ $monday }}" target="_blank">
            <img src="{{ asset('img/monday_logo.png') }}" width="80" height="80" alt="Monday Logo">
        </a>
    @endif
</p>
