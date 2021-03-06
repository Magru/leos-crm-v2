@extends('layouts.main')
@section('title', 'הזמנה חדשה')
@section('content')


    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/mohithg-switchery/dist/switchery.min.css') }}">
    @endpush


    <div class="container" >
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
                <input type="hidden" name="deal_id" id="dela_id" value="{{ $deal->id }}">
                <div class="row mt-3">
                    <div class="col-md-12 pb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="sub-title">לקוח</div>
                                <div class="form-group row">
                                    <div class="col-md-10">
                                        <label for="fetch_client_name">שם לקוח</label>
                                        <select class="form-control client" required id="client" name="client">
                                            <option value="{{ $deal->client->id }}" selected>{{ $deal->client->name }}</option>
                                        </select>
                                        @error('client')
                                        <div class="alert m-0 p-1 alert-danger">{{ $message }}</div>
                                        @enderror
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
                                               value="{{ $deal->client_review }}"
                                               id="client_review">
                                        @error('client_review')
                                        <div class="alert m-0 p-1 alert-danger"
                                             style="font-size: 12px;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="branch_review">סקור ענפי</label>
                                        <input type="text" class="form-control" name="branch_review" required
                                               value="{{  $deal->branch_review }}"
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
                                        <input type="text" class="form-control" value="{{ $deal->client_seniority }}"
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
                                               value="{{ $deal->employed_numbers }}"
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
                                               value="{{ $deal->bid_number }}"
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
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}"
                                                        @if($deal->user->id === $user->id)
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
                                                       @if(isset($deal_products[$product->id]))
                                                        checked
                                                       @endif
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
                                                               id="price-{{ $product->id }}"
                                                               name="price-{{ $product->id }}"
                                                               value="@if(isset($deal_products[$product->id])){{ $deal_products[$product->id]['price'] }}@endif"
                                                               class="form-control" placeholder="מחיר">

                                                        <span class="input-group-prepend" id="basic-addon2">
                                                        <label class="input-group-text"
                                                               for="qty-for-{{ $product->id }}">כמות</label>
                                                        </span>
                                                        <input type="number"
                                                               value="@if(isset($deal_products[$product->id])){{(int)$deal_products[$product->id]['qty']}}@endif"
                                                               id="qty-for-{{ $product->id }}"
                                                               style="height: 37px; width: 80px;" name="qty-for-{{ $product->id }}">
                                                    </div>

                                                </div>

                                                <div class="product-attributes mt-3"  id="attr-for-{{ $product->id }}">
                                                    @if($product->data !== null)
                                                        @foreach(json_decode($product->data, true) as $index => $_data)
                                                            <?php
                                                            $template = 'product.attributes.' . $_data['type'];
                                                            $id = 'prod-' . $product->id . '-attr'
                                                            ?>
                                                            <label class="mb-0"
                                                                   for="{{ $id }}">{{ $_data['title'] }}</label>

                                                            @include($template, [
                                                                'id' => $id,
                                                                'label' => $_data['title'],
                                                                'value' => isset($deal_products[$product->id]['attr'][$index]) ?  $deal_products[$product->id]['attr'][$index]['value'] : null,
                                                                'type' => $_data['type']]
                                                                )
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
                                                <option value="{{ $id }}" @if($deal->payment_type == $id) selected @endif>
                                                    {{ $_type }}
                                                </option>
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
                                <div class="form-group row">
                                    @foreach($files as $_f)
                                        <a href="{{ $_f['original_url'] }}" target="_blank" class="col-12 d-flex">
                                            <i class="ik ik-file-text" style="font-size: 20px; color: #000; text-decoration: none;"></i>
                                            <p style="font-size: 12px; color: #000; margin-right: 15px;">{{ $_f['file_name'] }}</p>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 pb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="sub-title">מסמכים חדשים</div>
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
                                        <textarea class="form-control"  name="order-notes" id="order-notes"
                                                  rows="10">{{ $deal->note }}</textarea>
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
                                        <input type="text" class="form-control" value="{{ $deal->total_price - $deal->tax_total }}" name="sub_total" id="sub_total">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tax">הנחה</label>
                                        <input type="text" class="form-control" value="0" name="discount" id="discount">
                                    </div>
                                    <div class="col-md-6 mt-3" id="tax-value" data-value="{{Config::get('app.tax')}}">
                                        <label for="tax">מע״מ</label>
                                        <input type="text"  class="form-control" value="{{ $deal->tax_total }}" name="tax" id="tax">
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label for="tax">סה״כ לתשלום</label>
                                        <input type="text" class="form-control" style="border: 3px solid red;" value="{{ $deal->total_price }}" name="total" id="total">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 pb-4">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <div class="form-group row w-100">
                                    <div class="col-6">
                                        <select name="status" id="status" class="form-control">
                                            <option selected disabled>סטטוס</option>
                                            <option value="בעבודה">בעבודה</option>
                                            <option value="בוטלה">בוטלה</option>
                                            <option value="המתנה">המתנה</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
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
                    </div>

                </div>
            </form>


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

                }
            }
        </script>
    @endpush
@endsection

