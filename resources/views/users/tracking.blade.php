@extends('templates.master')
@section('content')
<div class="container-fluid mt-5">
    @if (session('message'))
    <div class="alert alert-{{ session('alert')}} alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button> {{ session('message') }}</div>
    @endif
<div class="row">
    @include("users.sidebar")
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-12 mb-5">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <a href="/myorder"><i class="fa fa-angle-left"></i> Kembali</a>
                            <p style="float: right"><strong>{{$noresi}}</strong></p>
                            <hr>
                        </div>
                        <div class="timeline-line">
                            @foreach ($data_resi as $r )
                            <div class="item-timeline">
                                <p class="t-time"> <small><strong>{{date('H:i', strtotime($r['manifest_time'])) }}</strong> </small></p>
                                <div class="t-dot t-dot-info">
                                </div>
                                <div class="t-text">
                                    <p> {{$r['manifest_description']}}</p>
                                    <p class="t-meta-time"> {{$r['city_name']}}</p>
                                    <small>{{$r['manifest_date']}}</small>
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
@endsection
