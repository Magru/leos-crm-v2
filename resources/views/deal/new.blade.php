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
                                            <button class="btn btn-primary" style="height: 35px">לקוח חדש</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>


        </div>
    </div>

    <!-- push external js -->
    @push('script')
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('js/new-deal.js') }}"></script>
    @endpush
@endsection

