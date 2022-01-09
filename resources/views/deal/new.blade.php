@extends('layouts.main')
@section('title', 'הזמנה חדשה')
@section('content')


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

            <div class="row mt-3">
                <div class="col-md-12 pb-4">
                    <div class="card">
                        <div class="card-body">
                            <form class="new-deal-form">
                                {{ csrf_field() }}
                                <div class="sub-title">לקוח</div>
                                <div class="form-group row">
                                    <div class="col-md-10">
                                        <label for="fetch_client_name">שם לקוח</label>
                                        <select class="form-control client" id="client" name="client">
                                        </select>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button class="btn btn-primary" id="new-client" style="height: 35px">לקוח חדש
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


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
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('js/new-deal.js') }}"></script>
        <script src="{{ asset('plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
        <script src="{{ asset('js/form-components.js') }}"></script>
    @endpush
@endsection

