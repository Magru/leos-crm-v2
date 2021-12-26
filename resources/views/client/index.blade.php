@extends('layouts.main')
@section('title', 'לקוחות')
@section('content')

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8 d-flex justify-content-start mb-3">
                    <div class="page-header-title d-flex align-items-center">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="">
                            <h5 class="d-flex">לקוחות</h5>
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
                                        <th>שם לקוח</th>
                                        <th>תאריך יצירה במערכת</th>
                                        <th>דירוג</th>
                                        <th>פעולות</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($clients as $_client)
                                        <tr class="@if($_client->rank === 'a') a-rank  @endif">
                                            <td>{{ $_client->name }}</td>
                                            <td>{{ date('d/m/Y', strtotime($_client->created_at)) }}</td>
                                            <td>
                                                {{ ucwords($_client->rank) }}
                                            </td>
                                            <td>
                                                <a href="{{ route('client-show',$_client->id) }}" class="btn btn-info">
                                                    הצג פרטים
                                                </a>
                                                @can('manage_client')
                                                    <a href="{{ route('edit-client',$_client->id) }}" class="btn btn-info">
                                                        ערוך
                                                    </a>
                                                @endcan
                                                @can('manage_user')
                                                    <a href="{{ route('destroy-client',$_client->id) }}" class="btn btn-danger" onclick="return confirm('למחוק לקוח?')">
                                                        מחק
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>שם לקוח</th>
                                        <th>תאריך יצירה במערכת</th>
                                        <th>דירוג</th>
                                        <th>פעולות</th>
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
