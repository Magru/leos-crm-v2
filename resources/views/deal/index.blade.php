@extends('layouts.main')
@section('title', 'עסקאות')
@section('content')

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8 d-flex justify-content-start mb-3">
                    <div class="page-header-title d-flex align-items-center">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="">
                            <h5 class="d-flex">עסקאות</h5>
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4"></div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-responsive">
                                <div id="filters"></div>
                                <table id="clients-table"
                                       class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>לקוח</th>
                                        <th>סטטוס</th>
                                        <th>נציג</th>
                                        <th>תאריך יצירה במערכת</th>
                                        <th>סכום</th>
                                        <th>תשלום</th>
                                        <th>קבצים</th>
                                        <th>Monday</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($deals as $count => $_d)
                                        <tr>
                                            <td>{{ $_d->id }}</td>
                                            <td>
                                                @if($_d->client) {{ $_d->client->name }} @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-pill status-pill mb-1" data-name="{{ $_d->status }}">
                                                    {{ $_d->status }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $_d->user ? $_d->user->name : null }}
                                            </td>
                                            <td>{{ date('d/m/Y', strtotime($_d->created_at)) }}</td>
                                            <td>
                                                {{ $_d->total_price + $_d->tax_total }} ש״ח
                                            </td>
                                            <td>
                                                {{ $_d->payment() }}
                                            </td>
                                            <td>
                                                @foreach($_d->getMedia('deal-document') as $_m)
                                                    <a href="{{ $_m->getUrl() }}" title="{{ $_m->name }}" target="_blank">
                                                        <i class="ik ik-file"></i>
                                                    </a>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if($_d->monday_pulse)
                                                <a href="https://leosmediainteractive.monday.com/boards/2219425041/pulses/{{ $_d->monday_pulse }}" target="_blank">
                                                    <img src="{{ asset('img/monday_logo.png') }}" width="35" height="35" alt="Monday Logo">
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>לקוח</th>
                                        <th>סטטוס</th>
                                        <th>נציג</th>
                                        <th>תאריך יצירה במערכת</th>
                                        <th>סכום</th>
                                        <th>תשלום</th>
                                        <th>קבצים</th>
                                        <th>Monday</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
        <script src="{{ asset('js/datatables.js') }}"></script>
    @endpush
@endsection
