@extends('layouts.main')
@section('title', $page_title)
@section('content')

    <div class="container">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8 d-flex justify-content-start">
                    <div class="page-header-title d-flex align-items-center">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="">
                            <h5 class="d-flex">ערוך מוצר</h5>
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <form class="forms-sample has-repeater" method="POST" action="{{ route('product.update') }}"
                      enctype="multipart/form-data">
                    @csrf {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <div class="row justify-content-center">
                        <div class="col-md-12 pb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group col-sm-12 row">
                                        <label for="product-title" class="col-sm-3 col-form-label">כותרת</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" value="{{ $product->name }}"
                                                   name="product-title" id="product-title">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 pb-4">
                            <div class="card">
                                <div class="card-header"><h3>פרטי מוצר</h3></div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div data-repeater-list="product-data" class="pl-3 col-6 repeater">
                                            @foreach(json_decode($product->data) as $d)
                                                <div data-repeater-item class="d-flex mb-2">
                                                    <div class="form-group mb-2 mr-sm-2 mb-sm-0">
                                                        <input type="text" class="form-control mt-0" value="{{ $d->title }}"
                                                               name="data-name"
                                                               placeholder="שם">
                                                    </div>
                                                    <div class="form-group mb-2 col-5 mr-sm-2 mb-sm-0">
                                                        <select name="data-type" class="form-control w-100">
                                                            <option value="date"
                                                                    @if($d->type == 'date') selected @endif>תאריך
                                                            </option>
                                                            <option value="text"
                                                                    @if($d->type == 'text') selected @endif>טקסט
                                                            </option>
                                                            <option value="money"
                                                                    @if($d->type == 'money') selected @endif>כסף
                                                            </option>
                                                            <option value="number"
                                                                    @if($d->type == 'number') selected @endif>מספר
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <button data-repeater-delete type="button"
                                                            class="btn btn-danger repeater-remove-btn btn-icon mr-2"><i
                                                            class="ik ik-trash-2"></i></button>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button data-repeater-create type="button"
                                                class="btn btn-success btn-icon mr-2  repeater-add-btn"><i
                                                class="ik ik-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 pb-4">
                            <div class="card">
                                <div class="card-header"><h3>מחלקות</h3></div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <select class="form-control monday_watcher" required id="monday_watcher"
                                                    multiple="multiple" name="monday_watcher[]">
                                                @foreach($monday_watchers as $m)
                                                    <option value="{{ $m->monday_id }}">{{ $m->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 pb-4">
                            <div class="card">
                                <div class="card-header"><h3>מחיר</h3></div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">₪</div>
                                                </div>
                                                <input type="text" class="form-control" value="{{ $product->price }}" name="price" id="price" placeholder="מחיר">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header"><h3>הערות</h3></div>
                                <div class="card-body">
                                    <textarea class="form-control" name="product-notes" id="product-notes" rows="10">
                                        {{ $product->notes }}
                                    </textarea>
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
        <script src="{{ asset('plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('js/form-components.js') }}"></script>
        <script>
            $(document).ready(function () {


                var $repeater = $('.repeater').repeater();
                $repeater.setList([
                    {
                        'text-input': 'set-a',
                        'inner-group': [{'inner-text-input': 'set-b'}]
                    },
                    {'text-input': 'set-foo'}
                ]);

                console.log($repeater);


                $('#monday_watcher').select2({
                    minimumResultsForSearch: Infinity
                });

                tinymce.init({
                    selector: '#product-notes',
                    language: 'he_IL',
                    directionality: 'rtl',
                    height: 400
                });

            });
        </script>
    @endpush
@endsection

