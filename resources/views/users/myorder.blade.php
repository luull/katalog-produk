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
    <div class="col-md-10 mb-3">
        <div class="row">
            <div class="col-md-12 mb-5">
                <ul class="nav nav-tabs  mb-3 mt-3" id="simpletab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Belum Dibayar ({{$count1}})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Dibayar ({{$count2}})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Dikemas ({{$count3}})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile3-tab" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile2" aria-selected="false">Dikirim ({{$count4}})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile3-tab" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile3" aria-selected="false">Selesai ({{$count5}})</a>
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
                                                        <div class="col-md-2 mb-3">
                                                            <div class="text-center">
                                                                <img src="{{ asset($p->image)}}" class="img-fluid" alt="" style="max-height: 120px !important;">
                                                            </div>
                                                            <hr>
                                                        </div>
                                                        <div class="col-md-10 mb-3">
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
                                                        <hr>
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
                                                        <div class="col-md-2 mb-3">
                                                            <div class="text-center">
                                                                <img src="{{ asset($p->image)}}" class="img-fluid" alt="" style="max-height: 120px !important;">
                                                            </div>
                                                            <hr>
                                                        </div>
                                                        <div class="col-md-10 mb-3">
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
                                                        <hr>
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
                                    @if ($t->status == 2)
                                        @foreach ($list as $l )
                                            @if ($l->id_transaction == $t->id_transaction)
                                                @foreach ($product as $p )
                                                    @if ($p->id == $l->id_barang)
                                                        <div class="col-md-2 mb-3">
                                                            <div class="text-center">
                                                                <img src="{{ asset($p->image)}}" class="img-fluid" alt="" style="max-height: 120px !important;">
                                                            </div>
                                                            <hr>
                                                        </div>
                                                        <div class="col-md-10 mb-3">
                                                            <p>{{ $t->id_transaction}}</p>
                                                            <h4>{{$p->name}}</h4>
                                                            <h4>Rp.{{$p->harga}}</h4>
                                                        </div>
                                                        <hr>
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
                                    @if ($t->status == 3)
                                        @foreach ($list as $l )
                                            @if ($l->id_transaction == $t->id_transaction)
                                                @foreach ($product as $p )
                                                    @if ($p->id == $l->id_barang)
                                                        <div class="col-md-2 mb-3">
                                                            <div class="text-center">
                                                                <img src="{{ asset($p->image)}}" class="img-fluid" alt="" style="max-height: 120px !important;">
                                                            </div>
                                                            <hr>
                                                        </div>
                                                        <div class="col-md-8 mb-3">
                                                            <p style="float: right">No Resi : {{ $t->resi}}</p>
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
                                                        <div class="col-md-2 mb-5">
                                                            <form action="{{ route('cekresi')}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{$t->id_transaction}}" class="form-control">
                                                                <input type="hidden" name="kurir" value="{{$t->kurir}}" class="form-control">
                                                                <input type="hidden" value="{{$t->resi}}" name="resi">
                                                                <button class="btn btn-info btn-sm mb-2">Lacak pengiriman</button>
                                                            </form>
                                                            {{-- <p>{{$t->id_transaction}}</p> --}}
                                                            {{-- <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#showModal">Pesanan Selesai</button> --}}
                                                            <a href="/tracking/{{$t->id_transaction}}/finish" class="btn btn-primary btn-sm">Pesanan Diterima</a>
                                                            {{-- <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-md" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="showModalLabel">Keterangan</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                              <i data-feather="close"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>Apakah anda yakin Pesanan anda telah selesai ??</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Batal</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> --}}
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
                    <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($transaction as $t )
                                    @if ($t->status == 4)
                                        @foreach ($list as $l )
                                            @if ($l->id_transaction == $t->id_transaction)
                                                @foreach ($product as $p )
                                                    @if ($p->id == $l->id_barang)
                                                        <div class="col-md-2 mb-3">
                                                            <div class="text-center">
                                                                <img src="{{ asset($p->image)}}" class="img-fluid" alt="" style="max-height: 120px !important;">
                                                            </div>
                                                            <hr>
                                                        </div>
                                                        <div class="col-md-8 mb-3">
                                                            <p style="float: right">No Resi : {{ $t->resi}}</p>
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
                                                        <div class="col-md-2 mb-5">
                                                            <form action="{{ route('cekresi')}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{$t->id_transaction}}" class="form-control">
                                                                <input type="hidden" name="kurir" value="{{$t->kurir}}" class="form-control">
                                                                <input type="hidden" value="{{$t->resi}}" name="resi">
                                                                <button class="btn btn-success btn-sm">Histori pengiriman</button>
                                                            </form>

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
