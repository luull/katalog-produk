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
                            <h3 class="nunito bolder">Checkout</h3>
                            <hr>
                            <p><b>{{ session('user-session')->name}}</b></p>
                            <form class="ps-checkout__form" action="" method="post">
                            @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group ">
                                            <input type="hidden" value="6" class="form-control" name="province_origin">
                                        </div>
                                        <div class="form-group ">
                                            <input type="hidden" value="153" class="form-control" id="city_origin" name="city_origin">
                                        </div>

                                        <div class="form-group form-group--inline">
                                                <label for="provinsi">Provinsi</label>
                                                <select name="province_id" id="province_id" class="form-control">
                                                    <option value="">Provinsi</option>
                                                    @foreach ($provinsi  as $row)
                                                        <option value="{{$row['province_id']}}" namaprovinsi="{{$row['province']}}">{{$row['province']}}</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="nama_provinsi" nama="nama_provinsi" placeholder="ini untuk menangkap nama provinsi ">
                                        </div>
                                        <div class="form-group ">
                                            <label>Kota<span>*</span>
                                            </label>
                                            <select name="kota_id" id="kota_id" class="form-control">
                                                <option value="">Pilih Kota</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="nama_kota" name="nama_kota" placeholder="ini untuk menangkap nama kota">
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
                                            <label>Alamat<span>*</span>
                                            </label>
                                            <textarea name="address" class="form-control" rows="5" placeholder="Alamat Lengkap pengiriman" ></textarea>
                                        </div>
                                        <div class="form-group ">
                                            <label>Kode Pos<span>*</span>
                                            </label>
                                            <input type="text" name="kode_pos" class="form-control" >
                                        </div>
                                        <div class="form-group ">
                                            {{-- <label>total berat (gram) </label> --}}
                                            <input class="form-control" type="hidden" value="200" id="weight" name="weight">
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
                                        {{-- <div class="form-group">
                                            <button class="btn btn-primary" type="submit">Proses Order</button>
                                        </div> --}}
                                    </div>
                                </div>
                            </form>
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
@stop
@section('script')
<script src="https://code.jquery.com/jquery-3.4.1.js"
integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $('select[name="province_id"]').on('change', function(){
            var namaprovinsiku = $("#province_id option:selected").attr("namaprovinsi");
            $("#nama_provinsi").val(namaprovinsiku);
            let provinceid = $(this).val();
                console.log('prop',provinceid);
            if(provinceid){
                $.ajax({
                    type:'get',
                    method: 'get',
                    url:"/kota/"+ provinceid,
                    dataType:'json',
                    success:function(data){
                    $('select[name="kota_id"]').empty();
                        $.each(data, function(key, value){
                            $('select[name="kota_id"]').append('<option value="'+ value.city_id +'" namakota="'+ value.type +' ' +value.city_name+ '">' + value.type + ' ' + value.city_name + '</option>');
                        });
                    }
                });
                }else {
                    $('select[name="kota_id"]').empty();
                }
        });
        $('select[name="kota_id"]').on('change', function(){
            var namakotaku = $("#kota_id option:selected").attr("namakota");
            $("#nama_kota").val(namakotaku);
        });
        $('select[name="kurir"]').on('change', function(){
            let origin = $("input[name=city_origin]").val();
            let destination = $("select[name=kota_id]").val();
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
                                    $('select[name="layanan"]').append('<option value="'+ key +'" harga_ongkir="'+value2.value+'">' + value1.service + '-' +value2.value+ '</option>');
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
