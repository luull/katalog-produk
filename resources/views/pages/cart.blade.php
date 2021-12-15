@extends('templates.master')
@section('content')

<div class="container-fluid mt-5">
            <div class="row ">
                    <div class="col-md-12">
                        <div class="breadcrumb-five">
                            <ul class="breadcrumb">
                                <li class="active mb-2"><a href="/">Beranda</a>
                                </li>
                                <li class="mb-2"><a href="javscript:void(0);">Keranjang</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="col-lg-8 mt-4">

                            <h4 class="nunito bolder mb-4">Keranjang</h4>
                            @if (session('message'))
                            <div class="alert alert-{{session('alert')}} alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                </button> {{ session('message') }}</div>
                            @endif
                            @foreach ( $data as $d )
                            @if ($d->id_user == session('user-session')->id)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row pl-3">
                                        <div class="col-md-1 col-sm-3 col-xs-3 col-3 align-self-start">
                                            <img alt="avatar" src="{{ asset($d->foto)}}" class="img-fluid">
                                        </div>
                                        <div class="col-md-11 col-sm-9 col-xs-9 col-9 align-self-center">
                                            <div class="row">
                                                <div class="col-md-12">

                                                    <h4 class="size-16">{{$d->nama_brg}}</h4>
                                                    <h5 class="semi-bolder size-14 mb-0">Rp.{{ number_format($d->harga) }}</h5>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 align-self-center">
                                            <hr>
                                            <div class="row justify-content-end">
                                                <div class="col-md-3 col-sm-9 col-xs-9 col-9 mb-3">
                                                    <input  type="text" id="demo6" value="{{$d->qty}}" style="width: 20% !important;text-align:center;" name="qty">

                                                </div>
                                                <div class="col-md-1 col-sm-3 col-xs-3 col-3  align-self-center mb-3">
                                                   <a href="/deletecart/{{$d->id}}"> <i data-feather="trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <blockquote class="blockquote">
                                <div class="row">
                                    <div class="col-md-2 mr-2">
                                        <img alt="avatar" src="{{ asset($d->foto)}}" class="img-fluid" style="width: 250px !important;">
                                    </div>
                                    <div class="col-md-5 align-self-start">
                                        <p>{{$d->nama_brg}}</p>
                                        <p>{{$d->harga}}</p>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-md-4">
                                        <input  type="text" id="demo6" value="{{$d->qty}}" style="width: 20% !important;" name="qty">

                                    </div>
                                </div>
                            </blockquote> --}}
                            @endif
                            @endforeach
                        </div>
                    </div>
            </div>
</div>

@endsection
