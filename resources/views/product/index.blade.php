@extends('layouts.main')
@section('title', 'מוצרים')
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
                                        <th>כותרת</th>
                                        <th>תאריך יצירה במערכת</th>
                                        <th>שדות</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $count => $_prod)
                                        <tr>
                                            <td>{{ $_prod->name }}</td>
                                            <td>{{ date('d/m/Y', strtotime($_prod->created_at)) }}</td>
                                            <td>
                                                @if($_prod->data != 'null')
                                                @foreach (json_decode($_prod->data, true) as $dat)
                                                    <span class="badge badge-pill badge-secondary">
                                                        {{ $dat['title'] }}
                                                    </span>
                                                @endforeach
                                                @endif
                                            </td>
                                            <td>

                                                <button type="button" class="btn btn-secondary"
                                                        data-toggle="modal"
                                                        data-target="#fullwindowModal-{{ $count }}">
                                                    פרטים
                                                </button>
                                                <div class="modal fade full-window-modal"
                                                     id="fullwindowModal-{{ $count }}"
                                                     tabindex="-1" role="dialog"
                                                     aria-labelledby="fullwindowModalLabel"
                                                     aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="fullwindowModalLabel">
                                                                    הערות
                                                                </h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                {!! $_prod->notes !!}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                        class="btn btn-secondary"
                                                                        data-dismiss="modal">סגירה
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>כותרת</th>
                                        <th>תאריך יצירה במערכת</th>
                                        <th></th>
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
