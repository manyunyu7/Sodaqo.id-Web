@extends('168_template')
@include('168_component.util.wyswyig')

@section("header_name")
    Rekening/ID Wallet
@endsection


@push("script")
    <script>
        var el = document.getElementById('formFile168');
        el.onchange = function () {
            var fileReader = new FileReader();
            fileReader.readAsDataURL(document.getElementById("formFile168").files[0])
            fileReader.onload = function (oFREvent) {
                document.getElementById("imgPreview").src = oFREvent.target.result;
            };
        }
    </script>

@endpush

@section("page_content")

    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

    <div class="content-body" style="min-height: 798px;">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Rekening</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Tambah</a></li>
                </ol>
            </div>
            <!-- row -->
            <form action="{{ url('payment-merchant/store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        @include("168_component.alert_message.message")
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Data Payment Merchant</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <div class="row">

                                        <div class="mb-3 row">

                                            <div class="col-12">
                                                <img
                                                    id="imgPreview"
                                                    src="https://i.stack.imgur.com/y9DpT.jpg" alt="image" class="me-3 rounded"
                                                    width="275">
                                            </div>

                                            <label class="col-form-label mt-4">Foto Baru</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="form-file">
                                                        <input id="formFile168" type="file" name="photo"
                                                               class="form-file-input form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3 col-md-12">
                                            <label class="form-label" for="basicInput">Nama Pemilik Akun</label>
                                            <input type="text" name="name" required class="form-control"
                                                   value="{{ old('name') }}"
                                                   placeholder="Nama Pemilik Akun">
                                        </div>

                                        <div class="col-md-12">
                                            <label for="">Status</label>
                                            <select class="default-select form-control wide mb-3" name="status" id="">
                                                <option value="1">Aktif</option>
                                                <option value="0">Non-Aktif/Dihapus ( Tidak Ditampilkan di Pengguna)</option>
                                            </select>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Deskripsi</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">

                                    <div class="mb-3 col-md-12">
                                        <label class="form-label" for="basicInput">Jenis Merchant</label>
                                        <select class="form-control default-select form-control wide mb-3" name="merchant_id" id="" required>
                                            @forelse($merchants as $data)
                                                <option  value="{{$data->id}}">

                                                    {{$data->name}}</option>
                                            @empty

                                            @endforelse
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-12">
                                        <label class="form-label" for="basicInput">Nomor/Alamat Akun</label>
                                        <input type="text" name="account_number" required class="form-control"
                                               value="{{ old('account_number') }}"
                                               placeholder="Alamat Akun misal 5680630846">
                                    </div>

                                    <div class="mb-3 col-md-12">
                                        <label class="form-label" for="">Deskripsi</label>
                                        <textarea class="form-control" name="m_description" id="summernote" rows="10"
                                                  placeholder="Deskripsi">{{old('m_description')}}</textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-5">Tambah Payment Merchant</button>

                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </form>
        </div>
    </div>
@endsection
