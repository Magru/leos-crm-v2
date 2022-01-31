@extends('layouts.main')
@section('title', 'Roles')
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
                        <i class="ik ik-award bg-blue"></i>
                        <div class="">
                            <h5 class="d-flex">תפקידים</h5>
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">

                </div>
            </div>
        </div>
        <div class="row clearfix">
	        <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
            <!-- only those have manage_role permission will get access -->
            @can('manage_role')
			<div class="col-md-12">
	            <div class="card">
	                <div class="card-header"><h3>הוסף תפקיד</h3></div>
	                <div class="card-body">
	                    <form class="forms-sample" method="POST" action="{{url('role/create')}}">
	                    	@csrf
	                        <div class="row">
	                            <div class="col-sm-5">
	                                <div class="form-group">
	                                    <label for="role">תפקיד<span class="text-red">*</span></label>
	                                    <input type="text" class="form-control is-valid" id="role" name="name" placeholder="כותרת" required>
	                                </div>
	                            </div>
	                            <div class="col-sm-7" style="direction: rtl; text-align: right">
	                                <label for="exampleInputEmail3">שיוך הרשאות</label>
	                                <div class="row">
	                                	@foreach($permissions as $key => $permission)
	                                	<div class="col-sm-4">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="item_checkbox" name="permissions[]" value="{{$key}}">
                                                <span class="custom-control-label">
                                                	<!-- clean unescaped data is to avoid potential XSS risk -->
                                                	{{ clean($permission,'titles')}}
                                                </span>
                                            </label>

	                                	</div>
	                                	@endforeach
	                                </div>

	                                <div class="form-group">
	                                	<button type="submit" class="btn btn-primary btn-rounded">שמור</button>
	                                </div>
	                            </div>
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>
            @endcan
		</div>
		<div class="row">
	        <div class="col-md-12">
	            <div class="card p-3">
	                <div class="card-header"><h3>תפקידים</h3></div>
	                <div class="card-body">
	                    <table id="roles_table" class="table" style="text-align: right; direction: rtl;">
	                        <thead style="text-align: right; direction: rtl;">
	                            <tr>
	                                <th>תפקיד</th>
	                                <th>הרשאות</th>
	                                <th></th>
	                            </tr>
	                        </thead>
	                        <tbody>
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
    <!--server side roles table script-->
    <script src="{{ asset('js/custom.js') }}"></script>
	@endpush
@endsection
