@extends('layouts.main')
@section('title',  $name)
@section('content')

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="widget">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="state text-right">
                                    <h6>מיילים</h6>
                                    <h2>{{ $mails_count }}</h2>
                                </div>
                                <div class="icon">
                                    <i class="ik ik-mail"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="widget">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="state text-right">
                                    <h6>שיחות</h6>
                                    <h2>{{ $calls_count }}</h2>
                                </div>
                                <div class="icon">
                                    <i class="ik ik-phone"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-xl-12 col-md-12">
                    <div class="card latest-update-card">
                        <div class="card-header">
                            <h3>
                                {{ $name }}
                            </h3>
                            <div class="card-header-right">
                                <a href="{{ route('update-conversation',$id) }}" class="btn btn-info">
                                    עדכן
                                </a>
                                <a href="{{ route('update-deals',$id) }}" class="btn btn-info">
                                    עדכן עסקעות
                                </a>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="scroll-widget">
                                <div class="latest-update-box mt-3">
                                    @foreach($timeline as $_time)
                                        <div
                                            class="row @if($_time->type === 'deal') deal-row @endif border-bottom pb-30 pt-30 @if ((str_contains($_time->from, Auth::user()->email) !== false) || (str_contains($_time->to, Auth::user()->email) !== false)) my-mail @endif">
                                            <div
                                                class="col-auto text-right d-flex align-items-center justify-content-center update-meta pr-0">
                                                @if($_time->type === 'mail')
                                                    <i class="ik ik-mail bg-green update-icon"></i>
                                                @elseif($_time->type === 'tel')
                                                    @if($_time->callType() === 'Incoming Call')
                                                        <i class="ik ik-phone-incoming @if($_time->callStatus() === 'CANCEL') bg-red @else bg-blue @endif update-icon"></i>
                                                    @elseif($_time->callType() === 'Extension Outgoing')
                                                        <i class="ik ik-phone-outgoing @if($_time->callStatus() === 'CANCEL') bg-red @else bg-green @endif update-icon"></i>
                                                    @else
                                                        <i class="ik ik-phone bg-red update-icon"></i>
                                                    @endif
                                                @elseif($_time->type === 'deal')
                                                    <i class="ik ik-clipboard bg-yellow update-icon"></i>
                                                @endif
                                            </div>
                                            <div class="col pl-5">

                                                <h4 class="sl-date text-right" style="direction: ltr;">
                                                    <span class="badge badge-light">
                                                        {{ date('d/m/Y H:s', strtotime($_time->date)) }}
                                                    </span>
                                                </h4>
                                                <p class="d-flex align-items-center" style="font-size: 18px">
                                                    @if($_time->type !== 'deal')
                                                    <span
                                                        style="direction: ltr;">{{ str_replace(['<', '>'], '', $_time->from) }}</span>
                                                    <i class="ik ik-arrow-right"></i>
                                                    <span
                                                        style="direction: ltr;">{{ str_replace(['<', '>'], '', $_time->to) }}</span>
                                                    @endif
                                                </p>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h5 class="text-right">
                                                            @if($_time->type === 'deal')
                                                                עסקה נסגרה
                                                                <br>

                                                                @if($_time->getMedia('deal_files')->first())
                                                                    <a href="{{ $_time->getMedia('deal_files')->first()->getUrl() }}" target="_blank">הסכם</a>
                                                                @endif
                                                            @else
                                                                {{ $_time->subject }}
                                                            @endif
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="row flex-row">
                                                    <div class="col-auto">
                                                        @if($_time->type === 'mail')
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-toggle="modal"
                                                                    data-target="#fullwindowModal-{{ $_time->id }}">
                                                                תוכן המייל
                                                            </button>
                                                            <div class="modal fade full-window-modal"
                                                                 id="fullwindowModal-{{ $_time->id }}"
                                                                 tabindex="-1" role="dialog"
                                                                 aria-labelledby="fullwindowModalLabel"
                                                                 aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="fullwindowModalLabel">
                                                                                {{ $_time->subject }}
                                                                            </h5>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            {!! $_time->body !!}
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
                                                        @elseif($_time->type === 'tel')
                                                            <a href="{{ $_time->callUrl() }}" target="-_blank"
                                                               class="btn btn-info">
                                                                הקלטה
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
