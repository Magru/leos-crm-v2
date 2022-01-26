@extends('layouts.main')
@section('title', 'פירוט עסקה')
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
                            <div class="sub-title">לקוח</div>
                            <div class="row">
                                <div class="col-10">
                                    <h2 class="text-right">{{ $deal->client->name }}</h2>
                                </div>
                                <div class="col-2 d-flex align-items-center justify-content-end">
                                    <a href="{{ route('client-show',$deal->client->id) }}" class="btn btn-dark" target="_blank">
                                        כרטיס לקוח
                                    </a>
                                </div>
                                <div class="col-12">
                                    <table class="table text-right mt-5" style="direction: rtl;">
                                        <thead>
                                            <tr>
                                                <th>סקור העסק</th>
                                                <th>סקור ענפי</th>
                                                <th>ותק עסק</th>
                                                <th>מספר מועסקים</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>{{ $deal->client_review }}</th>
                                                <th>{{ $deal->branch_review }}</th>
                                                <th>{{ $deal->client_seniority }}</th>
                                                <th>{{ $deal->employed_numbers }}</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

