@extends('layouts.main')
@section('title', $name)
@section('content')

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8 d-flex justify-content-start mb-3">
                    <div class="page-header-title d-flex align-items-center">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="">
                            <h5 class="d-flex">{{ $name }}</h5>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row clearfix">

                @if($social['facebook'])
                    <div class="col-lg-2 col-md-4 col-6">
                        <div class="widget social-widget">
                            <div class="widget-body">
                                <div class="icon"><i class="fab fa-facebook text-facebook"></i></div>
                                <div class="content">
                                    <a href="{{ $social['facebook'] }}" target="_blank" class="text">
                                        Facebook
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($social['instagram'])
                    <div class="col-lg-2 col-md-4 col-6">
                        <div class="widget social-widget">
                            <div class="widget-body">
                                <div class="icon"><i class="fab fa-instagram text-instagram"></i></div>
                                <div class="content">
                                    <a href="{{ $social['instagram'] }}" target="_blank" class="text">Instagram</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($social['www'])
                    <div class="col-lg-2 col-md-4 col-6">
                        <div class="widget social-widget">
                            <div class="widget-body">
                                <div class="icon"><i class="fab fa-google text-google"></i></div>
                                <div class="content">
                                    <a href="{{ $social['www'] }}" target="_blank" class="text">WWW</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($social['linkedin'])
                    <div class="col-lg-2 col-md-4 col-6">
                        <div class="widget social-widget">
                            <div class="widget-body">
                                <div class="icon"><i class="fab fa-linkedin text-linkedin"></i></div>
                                <div class="content">
                                    <a href="{{ $social['linkedin'] }}" class="text">LinkedIn</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-4">
                    <a href="{{ route('timeline.show',$id) }}" target="_blank" class="btn btn-info">
                        הצג ציר זמן
                    </a>
                </div>
            </div>


        </div>
    </div>

@endsection
