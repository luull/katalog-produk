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
                        <div class="col-lg-8 mt-4">

                            <h4 class="nunito bolder mb-4">Keranjang</h4>
                            @if (session('message'))
                            <div class="alert alert-{{session('alert')}} alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                </button> {{ session('message') }}
                            </div>
                            @endif
                                @foreach ( $data as $d )
                                @if ($d->id_user == session('user-session')->id)
                                <div class="card card-cart mb-3 ">
                                    @if($d->status == 0)

                                    <label class="containers mt-3"> &nbsp;
                                        <input type="checkbox" value="{{$d->id_barang}}" name="values"/>
                                        <span class="checkmark"></span>
                                    </label>
                                    @else
                                    <form action="{{ route('delete-dummy')}}" class="mt-3" method="post">
                                        @csrf
                                        <input type="hidden" value="{{$d->id_barang}}" name="id_barang">
                                        <button type="submit" class="btn-checkbox"><i data-feather="check"></i></button>
                                    </form>
                                    {{-- <label class="containers mt-3"> &nbsp;
                                        <input type="checkbox" id="myCheck" value="{{$d->id_barang}}" onclick="myFunction()" checked />
                                        <span class="checkmark"></span>
                                    </label> --}}
                                    @endif

                                    <div class="card-body">
                                        <div class="row pl-3">
                                        <div class="col-md-1 col-sm-3 col-xs-3 col-3 align-self-start">
                                            <img alt="avatar" src="{{ asset($d->foto)}}" class="img-fluid">
                                        </div>
                                        <div class="col-md-11 col-sm-9 col-xs-9 col-9 align-self-center">
                                            <div class="row">
                                                <div class="col-md-12">

                                                    <h4 class="size-16">{{$d->nama_brg}}{{$d->id_barang}}</h4>
                                                    <h5 class="semi-bolder size-14 mb-0">Rp.{{ number_format($d->harga) }}</h5>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 align-self-center">
                                            <hr>
                                            <div class="row justify-content-end">
                                                <div class="col-md-1 col-sm-3 col-xs-3 col-3  align-self-center mb-3">
                                                   <a href="/deletecart/{{$d->id}}"> <i data-feather="trash"></i></a>
                                                </div>
                                                <div class="col-md-3 col-sm-9 col-xs-9 col-9 mb-3">
                                                    <input type="text" value="{{$d->qty}}" id="demo6" style="width: 20% !important;text-align:center;" name="qty">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endif
                            @endforeach
                        </div>
                        <div class="col-md-4">
                            <form id="myForm" action="{{ route('add-dummy')}}" method="post">
                                @csrf
                                <input type="hidden" id="getID" name="id_barang">
                            </form>
                            <div class="card card-cart2">
                                <div class="card-body">
                                    <h4 class="nunito bolder">Ringkasan Belanja</h4>
                                    <p class="size-16">Total Harga ({{$countbuy}} Barang)
                                        <span style="float: right;">Rp. {{ number_format($sum) }}</span>
                                    </p>
                                    <p class="size-16">Total Diskon Barang
                                        <span style="float: right;">Rp. 0</span>
                                    </p>
                                    <hr>
                                    <h4 class="nunito bolder">Total Harga  <span style="float: right;">Rp. {{ number_format($sum) }}</span></h4>
                                    <button class="btn btn-block mt-5 bolder nunito size-18 p-2 {{ $sum == '0' ? 'btn-default disabled' : 'btn-success'}}">Beli</button>
                                </div>
                            </div>
                        </div>

            </div>
</div>

@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
  var ckbox = $("input[name='values']");
  var chkId = '';
  $("input[name='values']").on('click', function() {

    if (ckbox.is(':checked')) {
      $("input[name='values']:checked").each ( function() {
   		chkId = $(this).val() + ",";
        chkId = chkId.slice(0, -1);
 	  });

       console.log(chkId); // return value of checkbox checked
       document.getElementById("getID").value = chkId;
       document.getElementById("myForm").submit();
    }
  });
});
</script>
{{-- <script>
function myFunction() {
  var checkBox = document.getElementById("myCheck");
  var get = document.getElementById("myCheck").value;
  if (checkBox.checked == true){
    console.log(get);
    document.getElementById("getID2").value = get;
    // document.getElementById("myForm2").submit();
  } else {
    document.getElementById("getID2").value = get;
    // document.getElementById("myForm2").submit();
  }
}
</script> --}}

@endsection

