@extends('layouts.main')
@section('title', 'הזמנה חדשה')
@section('content')


    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/mohithg-switchery/dist/switchery.min.css') }}">
    @endpush


    <div class="container">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8 d-flex justify-content-start">
                    <div class="page-header-title d-flex align-items-center">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="">
                            <h5 class="d-flex">הזמנה חדשה</h5>
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4"></div>
            </div>

            <form class="new-deal-form" method="POST" action="{{ route('deal.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row mt-3">
                    <div class="col-md-12 pb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="sub-title">לקוח</div>
                                <div class="form-group row">
                                    <div class="col-md-10">
                                        <label for="fetch_client_name">שם לקוח</label>
                                        <select class="form-control client" required id="client" name="client">
                                        </select>
                                        @error('client')
                                        <div class="alert m-0 p-1 alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button class="btn btn-primary" id="new-client" style="height: 35px">לקוח חדש
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 pb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="sub-title">מדדי לקוח</div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="client_review">סקור העסק</label>
                                        <input type="text" class="form-control" name="client_review" required
                                               value="{{ old('client_review') }}"
                                               id="client_review">
                                        @error('client_review')
                                        <div class="alert m-0 p-1 alert-danger"
                                             style="font-size: 12px;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="branch_review">סקור ענפי</label>
                                        <input type="text" class="form-control" name="branch_review" required
                                               value="{{ old('branch_review') }}"
                                               id="branch_review">
                                        @error('branch_review')
                                        <div class="alert m-0 p-1 alert-danger"
                                             style="font-size: 12px;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="client_seniority">ותק עסק</label>
                                        <input type="text" class="form-control" value="{{ old('client_seniority') }}"
                                               name="client_seniority" required
                                               id="client_seniority">
                                        @error('client_seniority')
                                        <div class="alert m-0 p-1 alert-danger"
                                             style="font-size: 12px;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="employed_numbers">מספר מועסקים</label>
                                        <input type="text" class="form-control" name="employed_numbers"
                                               id="employed_numbers">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 pb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="sub-title">הצעת מחיר</div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="client_seniority">מספר הצעת מחיר</label>
                                        <input type="text" class="form-control" name="price_request_num"
                                               value="{{ old('price_request_num') }}"
                                               id="price_request_num">
                                        @error('price_request_num')
                                        <div class="alert m-0 p-1 alert-danger"
                                             style="font-size: 12px;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div
                                        class="col-6 deal-user-select @can('manage_deals') user-editable-select @endcan">
                                        <label for="fetch_client_name">נציג</label>
                                        <select class="form-control client " id="user_id" name="user_id">
                                            <option disabled selected>בחר נחיג</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}"
                                                        @if(Auth::user()->id === $user->id)
                                                        selected
                                                    @endif
                                                >{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                        <div class="alert m-0 p-1 alert-danger"
                                             style="font-size: 12px;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 pb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="sub-title">מוצרים</div>
                                <div class="form-group row">
                                    @foreach($products as $product)
                                        <div class="col-md-6 p-1">
                                            <div class="border p-1">
                                                <input type="checkbox"
                                                       class="js-switch product-switch"
                                                       data-id="{{ $product->id }}"
                                                       name="products[]"
                                                       id="product-{{ $product->id }}" value="{{ $product->id }}"/>
                                                <label for="product-{{ $product->id }}"
                                                       class="mb-0">{{ $product->name }}</label>

                                                <div class="input-group hidden" id="price-{{ $product->id }}-group">
                                                    <div class="d-flex w-100">
                                                    <span class="input-group-prepend" id="basic-addon2">
                                                        <label class="input-group-text"
                                                               for="price-{{ $product->name }}">מחיר</label>
                                                    </span>
                                                        <input type="text"
                                                               style="width: 100%"
                                                               value="{{ $product->price }}"
                                                               id="price-{{ $product->id }}"
                                                               name="price-{{ $product->id }}"
                                                               class="form-control" placeholder="מחיר">

                                                        <span class="input-group-prepend" id="basic-addon2">
                                                        <label class="input-group-text"
                                                               for="qty-for-{{ $product->id }}">כמות</label>
                                                        </span>
                                                        <input type="number"
                                                               value="1"
                                                               id="qty-for-{{ $product->id }}"
                                                               style="height: 37px; width: 80px;" name="qty-for-{{ $product->id }}">
                                                    </div>

                                                </div>

                                                <div class="product-attributes mt-3"  id="attr-for-{{ $product->id }}">
                                                    @if($product->data !== 'null')
                                                        @foreach(json_decode($product->data, true) as $index => $_data)
                                                            <?php
                                                            $template = 'product.attributes.' . $_data['type'];
                                                            $id = 'prod-' . $product->id . '-attr'
                                                            ?>
                                                            <label class="mb-0"
                                                                   for="{{ $id }}">{{ $_data['title'] }}</label>

                                                            @include($template, ['id' => $id, 'label' => $_data['title'], 'type' => $_data['type']])
                                                        @endforeach
                                                        <input type="hidden" name="{{ $id }}-data">
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>


                    @if(0)
                        <div class="col-md-12 pb-4">
                            @include('deal.card');
                        </div>
                    @endif

                    <div class="col-md-12 pb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="sub-title">תשלום</div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="payment_type">תשלום</label>
                                        <select name="payment_type" class="form-control" id="payment_type">
                                            @foreach(\App\Models\Deal::PAYMENT_TYPE as $id => $_type)
                                                <option value="{{ $id }}">{{ $_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 pb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="sub-title">מסמכים</div>
                                <div class="needsclick dropzone" id="document-dropzone">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 pb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="sub-title">הערות</div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="order-notes" id="order-notes"
                                                  rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 pb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="sub-title">סיכום</div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="sub_total">סכום ביניים</label>
                                        <input type="text" class="form-control" name="sub_total" id="sub_total">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tax">הנחה</label>
                                        <input type="text" class="form-control" value="0" name="discount" id="discount">
                                    </div>
                                    <div class="col-md-6 mt-3" id="tax-value" data-value="{{Config::get('app.tax')}}">
                                        <label for="tax">מע״מ</label>
                                        <input type="text" class="form-control" value="" name="tax" id="tax">
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label for="tax">סה״כ לתשלום</label>
                                        <input type="text" class="form-control" style="border: 3px solid red;" value="" name="total" id="total">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 pb-4">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <button type="button" disabled class="btn btn-success mx-1" id="new-deal-submit"
                                        style=" height: 41px;">
                                    <span style="font-size: 22px;">שדר</span>
                                    <i class="ik ik-check-circle"></i>
                                </button>
                                <button class="btn btn-success mx-1" id="calculate" style=" height: 41px;">
                                    <span style="font-size: 20px;">חישוב סה״כ</span>
                                    <i class="ik ik-check-circle"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>


        </div>
    </div>

    <div class="modal fade" id="new_client_modal" tabindex="-1" role="dialog" aria-labelledby="new_client_modal-label"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="remote-add-client" class="has-repeater">
                    @csrf
                    <div class="modal-header d-flex justify-content-between align-content-center">
                        <h5 class="modal-title" id="exampleModalLabel">
                            לקוח חדש
                        </h5>
                        <button type="button" class="close m-0 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header"><h3>פרטי לקוח</h3></div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="form-group col-sm-12 row">
                                        <label for="name" class="col-sm-12 col-form-label">שם לקוח</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" required name="name" id="name"
                                                   placeholder="שם לקוח">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12 row">
                                        <label for="rank" class="col-sm-12 col-form-label">דירוג</label>
                                        <div class="col-sm-12">
                                            <select class="form-control" id="rank" name="rank">
                                                <option value="a">A</option>
                                                <option value="b">B</option>
                                                <option value="c">C</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12 row">
                                        <label for="name" class="col-sm-12 col-form-label">ח״פ</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" required name="company_id"
                                                   id="company_id"
                                                   placeholder="ח״פ">
                                        </div>
                                    </div>
                                </div>

                                <h4 class="sub-title">אנשי קשר</h4>
                                <div class="form-group row">
                                    <div data-repeater-list="contact_persons" class="pl-3">
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
                                                <input type="text" class="form-control" name="contact-tel"
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
                                    </div>
                                    <button data-repeater-create type="button"
                                            class="btn btn-success btn-icon mr-2  repeater-add-btn"><i
                                            class="ik ik-plus"></i></button>
                                </div>


                                <h4 class="sub-title">כתובות</h4>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label for="city">עיר</label>
                                        <input type="text" name="city" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="address">כתובת</label>
                                        <input type="text" name="address" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="zip">מיקוד</label>
                                        <input type="text" name="zip" class="form-control">
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <img src="{{ asset('img/loader.svg')}}" id="remote-add-loader" alt="">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">סגור</button>
                        <button type="submit" class="btn btn-primary">שמור</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- push external js -->
    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/3.4.0/imask.min.js"></script>
        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css"/>

        <script src="{{ asset('plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ asset('js/card.js') }}"></script>
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('js/new-deal.js') }}"></script>
        <script src="{{ asset('plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
        <script src="{{ asset('js/form-components.js') }}"></script>
        <script>
            Dropzone.prototype.defaultOptions.dictDefaultMessage = "גרור קבצים לכאן";
            Dropzone.prototype.defaultOptions.dictRemoveFile = "מחק קובץ";
            var uploadedDocumentMap = {}
            Dropzone.options.documentDropzone = {
                url: '{{ route('deal.store.media') }}',
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

