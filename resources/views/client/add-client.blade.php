@extends('layouts.main')
@section('title', $page_title)
@section('content')

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8 d-flex justify-content-start">
                    <div class="page-header-title d-flex align-items-center">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="">
                            <h5 class="d-flex">הוספת לקוח חדש למערכת</h5>
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4"></div>
            </div>
        </div>

        <div class="row">
            @if(!isset($client))
            <div class="col-md-12 pb-4">
                <div class="card">
                    <div class="card-header"><h3>משיכת לקוח במערכת סטטוס הישנה</h3></div>
                    <div class="card-body">
                        <form class="forms-sample">
                            <div class="form-group">
                                <label for="fetch_client_name">שם לקוח</label>
                                <input type="text" class="form-control" id="fetch_client_name" placeholder="שם לקוח">
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">משוך נתונים</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="row">
            <div class="col-12">
                <form class="forms-sample has-repeater" method="POST" action="{{ route('store-client') }}"
                      enctype="multipart/form-data">
                    @csrf {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6 pb-4">
                            <div class="card">
                                <div class="card-header"><h3>פרטי לקוח</h3></div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="form-group col-sm-6 row">
                                            <label for="name" class="col-sm-3 col-form-label">שם לקוח</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="name" id="name"
                                                       value="@if($client) {{ $client->name }} @endif"
                                                       placeholder="שם לקוח">
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6 row">
                                            <label for="rank" class="col-sm-auto col-form-label">דירוג</label>
                                            <div class="col-sm">
                                                <select class="form-control" id="rank" name="rank">
                                                    <option value="a" @if($client && $client->rank === 'a') selected @endif>A</option>
                                                    <option value="b" @if($client && $client->rank === 'b') selected @endif>B</option>
                                                    <option value="c" @if($client && $client->rank === 'c') selected @endif>C</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="sub-title">אנשי קשר</h4>
                                    <div class="form-group row">
                                        <div data-repeater-list="contact-persons" class="pl-3">
                                            @if($client)
                                                @php $contacts= json_decode($client->contacts); @endphp
                                                @foreach($contacts  as $count=>$_contact)
                                                    <div data-repeater-item class="d-flex mb-2">

                                                        <label class="sr-only"
                                                               for="inlineFormInputGroup1">{{ __('Users')}}</label>
                                                        <div class="form-group mb-2 mr-sm-2 mb-sm-0">
                                                            <input type="text" class="form-control" value="{{ $_contact->name }}" name="contact-name"
                                                                   placeholder="שם">
                                                        </div>
                                                        <div class="form-group mb-2 mr-sm-2 mb-sm-0">
                                                            <input type="email" class="form-control" value="{{ $_contact->email }}" name="contact-email"
                                                                   placeholder="מייל">
                                                        </div>
                                                        <div class="form-group mb-2 mr-sm-2 mb-sm-0">
                                                            <input type="tel" class="form-control" value="{{ $_contact->tel }}" name="contact-tel"
                                                                   placeholder="מספר טלפון">
                                                        </div>
                                                        <div class="form-group mb-2 mr-sm-2 mb-sm-0">
                                                            <input type="text" class="form-control" value="{{ $_contact->role }}" name="contact-role"
                                                                   placeholder="תפקיד">
                                                        </div>
                                                        <button data-repeater-delete type="button"
                                                                class="btn btn-danger repeater-remove-btn btn-icon mr-2"><i
                                                                class="ik ik-trash-2"></i></button>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div data-repeater-item class="d-flex mb-2">

                                                    <label class="sr-only"
                                                           for="inlineFormInputGroup1">{{ __('Users')}}</label>
                                                    <div class="form-group mb-2 mr-sm-2 mb-sm-0">
                                                        <input type="text" class="form-control" name="contact-name"
                                                               placeholder="שם">
                                                    </div>
                                                    <div class="form-group mb-2 mr-sm-2 mb-sm-0">
                                                        <input type="email" class="form-control" name="contact-email"
                                                               placeholder="מייל">
                                                    </div>
                                                    <div class="form-group mb-2 mr-sm-2 mb-sm-0">
                                                        <input type="tel" class="form-control" name="contact-tel"
                                                               placeholder="מספר טלפון">
                                                    </div>
                                                    <div class="form-group mb-2 mr-sm-2 mb-sm-0">
                                                        <input type="text" class="form-control" name="contact-role"
                                                               placeholder="תפקיד">
                                                    </div>
                                                    <button data-repeater-delete type="button"
                                                            class="btn btn-danger repeater-remove-btn btn-icon mr-2"><i
                                                            class="ik ik-trash-2"></i></button>
                                                </div>
                                            @endif
                                        </div>
                                        <button data-repeater-create type="button"
                                                class="btn btn-success btn-icon mr-2  repeater-add-btn"><i
                                                class="ik ik-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 pb-4">
                            <div class="card">
                                <div class="card-header"><h3>Web</h3></div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <div class="widget social-widget">
                                                <div class="widget-body">
                                                    <div class="icon"><i class="fab fa-facebook text-facebook"></i>
                                                    </div>
                                                    <div class="content">
                                                        <label for="client-facebook">Facebook</label>
                                                        <input type="text" name="client-facebook"
                                                               placeholder="Facebook Url" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="widget social-widget">
                                                <div class="widget-body">
                                                    <div class="icon"><i class="fab fa-instagram text-instagram"></i>
                                                    </div>
                                                    <div class="content">
                                                        <label for="client-instagram">Instagram</label>
                                                        <input type="text" name="client-instagram"
                                                               placeholder="Instagram Url" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="widget social-widget">
                                                <div class="widget-body">
                                                    <div class="icon"><i class="fab fa-linkedin-in text-linkedin"></i>
                                                    </div>
                                                    <div class="content">
                                                        <label for="client-linkedin">LinkedIn</label>
                                                        <input type="text" name="client-linkedin"
                                                               placeholder="Linekedin Url" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="widget social-widget">
                                                <div class="widget-body">
                                                    <div class="icon"><i class="fab fa-twitter text-twitter"></i></div>
                                                    <div class="content">
                                                        <label for="client-linkedin">Twitter</label>
                                                        <input type="text" name="client-linkedin"
                                                               placeholder="Twitter Url" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="widget social-widget">
                                                <div class="widget-body">
                                                    <div class="icon"><i class="fab fa-google text-google"></i></div>
                                                    <div class="content">
                                                        <label for="client-www">כתובת אתר</label>
                                                        <input type="text" name="client-www" placeholder="Website url"
                                                               class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body d-flex">
                                    <button type="submit" class="btn btn-success"><i class="ik ik-check-circle"></i>
                                        שמור
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- push external js -->
    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
        <script src="{{ asset('plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
        <script src="{{ asset('js/form-components.js') }}"></script>
        <script>
            var uploadedDocumentMap = {};
            Dropzone.prototype.defaultOptions.dictDefaultMessage = "גרור קבצים לכאן";
            Dropzone.prototype.defaultOptions.dictRemoveFile = "מחק קובץ";
            Dropzone.options.documentDropzone = {
                url: '{{ route('store-client-media') }}',
                maxFilesize: 2, // MB
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function (file, response) {
                    $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
                    uploadedDocumentMap[file.name] = response.name
                },
                removedfile: function (file) {
                    file.previewElement.remove()
                    var name = ''
                    if (typeof file.file_name !== 'undefined') {
                        name = file.file_name
                    } else {
                        name = uploadedDocumentMap[file.name]
                    }
                    $('form').find('input[name="document[]"][value="' + name + '"]').remove()
                },
                init: function () {
                    @if(isset($project) && $project->document)
                    var files =
                        {!! json_encode($project->document) !!}
                        for(
                    var i
                in
                    files
                )
                    {
                        var file = files[i]
                        this.options.addedfile.call(this, file)
                        file.previewElement.classList.add('dz-complete')
                        $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
                    }
                    @endif
                }
            }
        </script>
    @endpush
@endsection

