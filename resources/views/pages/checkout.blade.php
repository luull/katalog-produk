@extends('templates.master')
@section('content')

<div class="container-fluid mt-5">
            <div class="row ">
                    <div class="col-md-12">
                        <div class="breadcrumb-five">
                            <ul class="breadcrumb">
                                <li class="active mb-2"><a href="/">Beranda</a>
                                </li>
                                <li class="mb-2"><a href="javscript:void(0);">Checkout</a></li>

                            </ul>
                        </div>
                    </div>
                        <div class="col-lg-8 mt-4">
                            <h3 class="nunito bolder mb-3">Checkout</h3>
                            <p class="nunito bolder black size-16">Alamat Pengiriman</p>
                            <hr>
                            <p class="size-12"><b>{{ $getaddress->name}}</b> ({{ $getaddress->category}})</p>
                            <p class="size-12 mb-0">{{ $getaddress->phone}}</p>
                            <p class="text-muted size-12">{{ $getaddress->address}}, {{$getaddress->city_name}}, {{$getaddress->subdistrict_name }}, {{$getaddress->province }}, {{$getaddress->kd_pos }}</p>
                            <hr>
                            <button class="btn btn-default" data-toggle="modal" data-target="#editAddress">Ubah alamat</button>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group ">
                                            <input type="hidden" value="6" class="form-control" name="province_origin">
                                        </div>
                                        <div class="form-group ">
                                            <input type="hidden" value="153" class="form-control" id="city_origin" name="city_origin">
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" value="{{ $getaddress->city}}" name="get_kota" placeholder="ini untuk menangkap nama kota">
                                        </div>
                                        <div class="form-group ">
                                            <label>Pilih Ekspedisi<span>*</span>
                                            </label>
                                            <select name="kurir" id="kurir" class="form-control">
                                                <option value="">Pilih kurir</option>
                                                <option value="jne">JNE</option>
                                                <option value="tiki">TIKI</option>
                                                <option value="pos">POS INDONESIA</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Pilih Layanan<span>*</span>
                                            </label>
                                            <select name="layanan" id="layanan" class="form-control">
                                                <option value="">Pilih layanan</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="ongkoskirim" name="ongkoskirim" placeholder="ini untuk menangkap nama kota">
                                        </div>

                                    </div>
                                    <div class="col-md-4">

                                        <div class="form-group ">
                                            {{-- <label>total berat (gram) </label> --}}
                                            <input class="form-control" type="text" value="{{$berat}}" id="weight" name="weight">
                                        </div>
                                        <div class="form-group ">
                                            {{-- <label>Total Belanja<span>*</span> --}}
                                        </label>
                                            <input type="hidden" value="{{$sum}}" name="totalbelanja" class="form-control" >
                                        </div>
                                        <div class="form-group">
                                            {{-- <label>Total</label> --}}
                                            <input type="hidden" class="form-control" id="ongkoskirim" name="ongkoskirim" placeholder="ini untuk menangkap nama kota">
                                        </div>
                                        <div class="form-group ">
                                            {{-- <label>total keseluruhan </label> --}}
                                            <input class="form-control" type="hidden" id="total" name="total">
                                        </div>
                                    </div>
                                </div>
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
                                    <p class="size-16">Total Ongkir
                                        <span id="ongkirnya" style="float: right;"></span>
                                    </p>
                                    <p class="size-16">Total Diskon Barang
                                        <span style="float: right;">Rp. 0</span>
                                    </p>
                                    <hr>
                                    <h4 class="nunito bolder" >Total Harga  <span id="totalnya" style="float: right;color:#f9591d;"></span></h4>
                                    <a href="#" class="btn btn-block mt-5 bolder nunito size-18 p-2 {{ $sum == '0' ? 'btn-default disabled' : 'btn-success'}}">Pilih Pembayaran</a>
                                </div>
                            </div>
                        </div>
            </div>
</div>
<!-- Modal edit-->
<div class="modal fade" id="editAddress" tabindex="-1" role="dialog" aria-labelledby="editAddressLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAddressLabel">Ubah Alamat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i data-feather="close"></i>
                </button>
            </div>
           <div class="modal-body">
            <form action="{{ route('change-pick') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="form-group ">
                        <label>Pilih Alamat<span>*</span>
                        </label>
                        <select name="nama_kota" id="nama_kota" value="{{ old('nama_kota') }}" class="selectpicker" required>
                            @foreach ($getcontact as $g )
                                @if($g->status == 1)
                                <optgroup label="{{$g->name}} ({{$g->category}}) UTAMA">
                                @else
                                <optgroup label="{{$g->name}} ({{$g->category}})">
                                @endif
                                    <option namakota="{{$g->city}}" value="{{$g->ctid}}" data-subtext="{{$g->city_name}}, {{$g->subdistrict_name}}, {{$g->province}}, {{$g->kd_pos}}">{{$g->address}}</option>
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
           </div>

        </div>
    </div>
</div>
@stop
@section('script')
<script src="https://code.jquery.com/jquery-3.4.1.js"
integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        // $('select[name="province_id"]').on('change', function(){
        //     var namaprovinsiku = $("#province_id option:selected").attr("namaprovinsi");
        //     $("#nama_provinsi").val(namaprovinsiku);
        //     let provinceid = $(this).val();
        //         console.log('prop',provinceid);
        //     if(provinceid){
        //         $.ajax({
        //             type:'get',
        //             method: 'get',
        //             url:"/kota/"+ provinceid,
        //             dataType:'json',
        //             success:function(data){
        //             $('select[name="kota_id"]').empty();
        //                 $.each(data, function(key, value){
        //                     $('select[name="kota_id"]').append('<option value="'+ value.city_id +'" namakota="'+ value.type +' ' +value.city_name+ '">' + value.type + ' ' + value.city_name + '</option>');
        //                 });
        //             }
        //         });
        //         }else {
        //             $('select[name="kota_id"]').empty();
        //         }
        // });
        $('select[name="nama_kota"]').on('change', function(){
            var namakotaku = $("#nama_kota option:selected").attr("namakota");
            $("#get_kota").val(namakotaku);
        });
        $('select[name="kurir"]').on('change', function(){
            let origin = $("input[name=city_origin]").val();
            let destination = $("input[name=get_kota]").val();
            let courier = $("select[name=kurir]").val();
            let weight = $("input[name=weight]").val();
                if(courier){
                    $.ajax({
                    url:"/origin="+origin+"&destination="+destination+"&weight="+weight+"&courier="+courier,
                    type:'GET',
                    dataType:'json',
                    success:function(data){
                        $('select[name="layanan"]').empty();
                        $.each(data, function(key, value){
                            $.each(value.costs, function(key1, value1){
                                $.each(value1.cost, function(key2, value2){
                                    var	number_string = value2.value.toString(),
                                        sisa 	= number_string.length % 3,
                                        hasil 	= number_string.substr(0, sisa),
                                        ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                                    if (ribuan) {
                                        separator = sisa ? '.' : '';
                                        hasil += separator + ribuan.join('.');
                                    }
                                    $('select[name="layanan"]').append('<option value="'+ key +'" harga_ongkir="'+value2.value+'">' + value1.service + '-' +hasil+ '</option>');
                                });
                            });
                        });
                    }
                    });
                } else {
                    $('select[name="layanan"]').empty();
                }
        });
        $('select[name="layanan"]').on('change', function(){
            var harga_ongkir = $("#layanan option:selected").attr("harga_ongkir");
            $("#ongkoskirim").val(harga_ongkir);
            let totalbelanja = $("input[name=totalbelanja]").val();
            // menampilkan hasil nama harga ongkir dari select layanan yg kita pilih
            // kita akan menampilkan harga ongkirnya di id ongkos kirim, jadi kalian bisa buat inputan dengan id ongkos kirim
            let total = parseInt(totalbelanja) + parseInt(harga_ongkir);
            // ini untuk jumlah total nya y,, jd jumlah belanja di tambah jumlah ongkos kirim
            $("#total").val(total);
            var	number_string = harga_ongkir.toString(),
                sisa 	= number_string.length % 3,
                rupiah 	= number_string.substr(0, sisa),
                ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            var	number_string2 = total.toString(),
                sisa2 	= number_string2.length % 3,
                rupiah2 	= number_string2.substr(0, sisa2),
                ribuan2 	= number_string2.substr(sisa2).match(/\d{3}/g);

            if (ribuan2) {
                separator2 = sisa2 ? '.' : '';
                rupiah2 += separator2 + ribuan2.join('.');
            }
            document.getElementById("ongkirnya").innerHTML = 'Rp.'+rupiah;
            document.getElementById("totalnya").innerHTML = 'Rp.'+rupiah2;
            //kita menampilkan totalnya di id total
        });
    });
</script>
@stop
