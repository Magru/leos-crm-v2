@extends('layouts.main')
@section('title', 'Users')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
    @endpush


    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title d-flex align-items-center">
                        <i class="ik ik-users bg-blue"></i>
                        <div class="">
                            <h5 class="d-flex">משתמשים</h5>
                            <span></span>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4">

                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="card-body">
                        <table id="user_table" class="table">
                            <thead style="text-align: right">
                                <tr>
                                    <th style="text-align: right">שם</th>
                                    <th>מייל</th>
                                    <th>תפקיד</th>
                                    <th>הרשאות</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody style="text-align: right">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <!--server side users table script-->
    <script src="{{ asset('js/custom.js') }}"></script>
    @endpush
@endsection
