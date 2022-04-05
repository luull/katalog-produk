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
                <ul class="nav nav-tabs  mb-3 mt-3" id="simpletab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Belum Dibayar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Dibayar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Dikemas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile2-tab" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile2" aria-selected="false">Dikirim</a>
                    </li>
                </ul>
                <div class="tab-content" id="simpletabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    @foreach ($transaction as $t )
                                    @if ($t->status == 0)
                                        @foreach ($list as $l )
                                            @if ($l->id_transaction == $t->id_transaction)
                                                @foreach ($product as $p )
                                                    @if ($p->id == $l->id_barang)
                                                        <div class="col-md-2">
                                                            <div class="text-center">
                                                                <img src="{{ asset($p->image)}}" class="img-fluid" alt="" style="max-height: 120px !important;">
                                                            </div>
                                                            <hr>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <p>{{ $t->id_transaction}}</p>
                                                            <h4>{{$p->name}}</h4>
                                                            <h4>Rp.{{$p->harga}}</h4>
                                                            @foreach ($getaddress as $g )
                                                                @if ($g->ctid == $t->id_address)
                                                                    <small>
                                                                        {{ $g->address}}, {{$g->city_name}}, {{$g->subdistrict_name }}, {{$g->province }}, {{$g->kd_pos }}
                                                                    </small>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                       <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($transaction as $t )
                                    @if ($t->status == 1)
                                        @foreach ($list as $l )
                                            @if ($l->id_transaction == $t->id_transaction)
                                                @foreach ($product as $p )
                                                    @if ($p->id == $l->id_barang)
                                                        <div class="col-md-2">
                                                            <div class="text-center">
                                                                <img src="{{ asset($p->image)}}" class="img-fluid" alt="" style="max-height: 120px !important;">
                                                            </div>
                                                            <hr>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <p>{{ $t->id_transaction}}</p>
                                                            <h4>{{$p->name}}</h4>
                                                            <h4>Rp.{{$p->harga}}</h4>
                                                            @foreach ($getaddress as $g )
                                                            @if ($g->ctid == $t->id_address)
                                                                <small>
                                                                    {{ $g->address}}, {{$g->city_name}}, {{$g->subdistrict_name }}, {{$g->province }}, {{$g->kd_pos }}
                                                                </small>
                                                            @endif
                                                        @endforeach
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($transaction as $t )
                                    @if ($t->status == 3)
                                        @foreach ($list as $l )
                                            @if ($l->id_transaction == $t->id_transaction)
                                                @foreach ($product as $p )
                                                    @if ($p->id == $l->id_barang)
                                                        <div class="col-md-2">
                                                            <div class="text-center">
                                                                <img src="{{ asset($p->image)}}" class="img-fluid" alt="" style="max-height: 120px !important;">
                                                            </div>
                                                            <hr>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <p>{{ $t->id_transaction}}</p>
                                                            <h4>{{$p->name}}</h4>
                                                            <h4>Rp.{{$p->harga}}</h4>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab2">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($transaction as $t )
                                    @if ($t->status == 2)
                                        @foreach ($list as $l )
                                            @if ($l->id_transaction == $t->id_transaction)
                                                @foreach ($product as $p )
                                                    @if ($p->id == $l->id_barang)
                                                        <div class="col-md-2">
                                                            <div class="text-center">
                                                                <img src="{{ asset($p->image)}}" class="img-fluid" alt="" style="max-height: 120px !important;">
                                                            </div>
                                                            <hr>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <p style="float: right">No Resi : {{ $t->resi}}</p>
                                                            <p>{{ $t->id_transaction}}</p>
                                                            <h4>{{$p->name}}</h4>
                                                            <h4>Rp.{{$p->harga}}</h4>
                                                            <form action="{{ route('cekresi')}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{$t->id_transaction}}" class="form-control">
                                                                <input type="hidden" name="kurir" value="{{$t->kurir}}" class="form-control">
                                                                <input type="hidden" value="{{$t->resi}}" name="resi">
                                                                <button class="btn btn-success btn-sm" style="float: right;">Lacak pengiriman</button>
                                                            </form>
                                                            @foreach ($getaddress as $g )
                                                            @if ($g->ctid == $t->id_address)
                                                                <small>
                                                                    {{ $g->address}}, {{$g->city_name}}, {{$g->subdistrict_name }}, {{$g->province }}, {{$g->kd_pos }}
                                                                </small>
                                                            @endif
                                                            @endforeach

                                                        </div>

                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
