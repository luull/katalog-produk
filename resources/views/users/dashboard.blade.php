@extends('templates.master')
@section('content')
<style>
    input[type="file"] {
        display: none;
    }
</style>
<div class="container-fluid mt-5">
    @if (session('message'))
    <div class="alert {{ session('color')}} alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button> {{ session('message') }}</div>
    @endif
    @csrf
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('update-avatar') }}" method="post" enctype="multipart/form-data">
                        <input type="text" name="id" value="{{$data->id}}" id="" hidden>
                            @if($data->photo != null)
                            <img src="{{ asset($data->photo)}}" class="img-fluid" style="max-height: 300px;" alt="">
                            <hr>
                            <label class="btn btn-default btn-block mb-4">
                            <input type="file" class="form-control" name="photo">
                            Pilih foto
                            </label>
                            <input type="text" value="{{$data->photo}}" name="default" hidden>
                            <p class="mb-0">Besar file: maksimum 2mb</p>
                            <p>Ekstensi file yang diperbolehkan: .JPG.JPEG.PNG</p>
                            @error('photo')
                            <br>
                            <div class="text-danger mt-1">Foto tidak sesuai persyaratan</div>
                            @enderror
                            @else
                            <img src="{{ asset('default-user.jpeg')}}" class="img-fluid" style="max-height: 300px;" alt="">
                            <hr>
                            <label class="btn btn-default btn-block mb-4">
                                <input type="file" class="form-control" name="photo">
                                Pilih foto
                            </label>
                            <p class="mb-0">Besar file: maksimum 2mb</p>
                            <p>Ekstensi file yang diperbolehkan: .JPG.JPEG.PNG</p>
                            @error('photo')
                            <br>
                            <div class="text-danger mt-1">Foto tidak sesuai persyaratan</div>
                            @enderror
                            @endif
                            <button type="submit" class="btn btn-success btn-block">Simpan</button>
                        </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12">
                            <i data-feather="user" class="mb-3"></i> {{ session('user-session')->name}}
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-tabs  mb-3" id="simpletab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Biodata Diri</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Daftar Alamat</a>
                                        </li>

                                    </ul>
                                    <div class="tab-content" id="simpletabContent">
                                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                    <form action="{{ route('update-avatar') }}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="text" name="id" value="{{$data->id}}" id="" hidden>
                                                        <div class="row mb-4">
                                                            <div class="col-md-12">
                                                                <h3 class="semi-bolder size-14 text-muted">Ubah Biodata Diri</h3>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4">
                                                            <div class="col-md-3">
                                                                <p>Nama</p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="name" value="{{$data->name}}">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4">
                                                            <div class="col-md-3">
                                                                <p>Email</p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="" value="{{$data->email}}" readonly>
                                                            </div>
                                                        </div>
                                                    </form>
                                        </div>
                                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                                    @if ($countcontact == null)
                                                        <button class="btn btn-success" data-toggle="modal" data-target="#address">Aktivasi Alamat</button>
                                                    @else
                                                        <button class="btn btn-success mb-3" style="float: right" data-toggle="modal" data-target="#address">Tambah Alamat</button>
                                                        <br>
                                                        @foreach ($contact as $c)
                                                        <div class="infobox-3">
                                                            <div class="info-icon">
                                                                <i data-feather="map-pin" style="max-height:50px;"></i> <span style="color: #fff;">Utama</span>
                                                            </div>
                                                            <p class="size-16">{{$c->category}}</p>
                                                            <p class="size-18">{{$getuser->name}}</p>
                                                            <p class="info-text">{{$c->address}}, {{$c->province}}, {{$getcity->city_name}}, {{$getsubdistrict->subdistrict_name}}, {{$c->kd_pos}}</p>
                                                            {{-- <a class="info-link" href="">Discover <svg> ... </svg></a> --}}
                                                        </div>
                                                        @endforeach
                                                    @endif
                                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>
<!-- Modal -->
<div class="modal fade" id="address" tabindex="-1" role="dialog" aria-labelledby="addressLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressLabel">Tambah Alamat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="fa fa-times"></i>
                </button>
            </div>
            <form action="{{ route('add-contact') }}" method="post" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>Kategori Alamat</label>
                                <br>
                                <select name="category" class="form-control" required>
                                    <option value="rumah">Rumah</option>
                                    <option value="kantor">Kantor</option>
                                    <option value="toko">Toko</option>
                                </select>
                                <br>
                                @error('category')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Propinsi</label>
                                <select name="propinsi" id="propinsi" class="form-control" value="{{ old('propinsi') }}" required>
                                    @foreach ($province as $prov)
                                    <option value="{{$prov->province}}">{{$prov->province}}</option>
                                    @endforeach
                                </select>
                                <br>
                                @error('propinsi')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Kota</label>
                                <select id="kota" name="kota" class="form-control" value="{{ old('kota') }}" required>

                                </select>
                                <br>
                                @error('kota')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label>Kecamatan</label>
                                <select id="kecamatan" name="kecamatan" class="form-control" value="{{ old('kecamatan') }}" required>

                                </select>
                                <br>
                                @error('kecamatan')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label>Kode Pos</label>
                                <input type="text" name="kd_pos" class="form-control" value="{{ old('kd_pos') }}" required>
                                <br>
                                @error('kd_pos')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>No Handphone</label>
                                <input type="text" class="form-control" name="phone" max="12" value="{{ old('phone') }}">
                                <br>
                                @error('phone')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>Alamat</label>
                                <textarea name="alamat" id="" cols="5" rows="4" class="form-control"></textarea>
                                <br>
                                @error('alamat')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
    $(document).ready(function() {
        $("#propinsi").change(function() {
            var propinsi = $("#propinsi").val();
            $.ajax({
                type: 'get',
                method: 'get',
                url: '/city/find/' + propinsi,
                data: '_token = <?php echo csrf_token() ?>',
                success: function(hsl) {
                    if (hsl.code == 404) {
                        alert(hsl.error);

                    } else {
                        var data = [];
                        data = hsl.result;
                        $("#kota").children().remove().end();
                        $.each(data, function(i, item) {
                            $("#kota").append('<option value="' + item.city_id + '">' + item.city_name + ' ' + item.type + '</option>');
                        })
                        kecamatan();
                        $("#kota").focus();

                    }
                }
            });
        })
        $("#kota").change(function() {
            kecamatan();
        })
    })
    function kecamatan() {
        var kota = $("#kota").val();
        $.ajax({
            type: 'get',
            method: 'get',
            url: '/subdistrict/find/' + kota,
            data: '_token = <?php echo csrf_token() ?>',
            success: function(hsl) {
                if (hsl.code == 404) {
                    alert(hsl.error);

                } else {
                    var data = [];
                    data = hsl.result;
                    console.log(hsl.result)
                    $("#kecamatan").children().remove().end();
                    $.each(data, function(i, item) {
                        $("#kecamatan").append('<option value="' + item.subdistrict_id + '">' + item.subdistrict_name + '</option>');
                    })
                    $("#kecamatan").focus();

                }
            }
        });
    }
    </script>
@stop
