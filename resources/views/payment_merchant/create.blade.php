@extends('168_template')


@section("header_name")
    Payment Merchant
@endsection

@push("css")
    <link rel="stylesheet" href="{{ asset('/168_res') }}/vendor/summernote/summernote-lite.min.css">
@endpush

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
    @include('payment_merchant.wyswyig')
@endpush

@section("page_content")
    <div class="content-body" style="min-height: 798px;">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Payment Merchant</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Tambah</a></li>
                </ol>
            </div>
            <!-- row -->
            <form action="{{ url('user/store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        @include("168_component.alert_message.message")
                    </div>
                    <div class="col-xl-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Data Payment Merchant</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label for="form-label">Nama Payment Merchant</label>
                                            <input type="text" name="name" required class="form-control"
                                                   value="{{ old('name') }}"
                                                   placeholder="Nama Merchant, misal OVO">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="">Status</label>
                                            <select class="default-select form-control wide mb-3" name="status" id="">
                                                <option value="1">Aktif</option>
                                                <option value="0">Non-Aktif/Dihapus ( Tidak Ditampilkan di Pengguna)</option>
                                            </select>
                                        </div>

                                        <div class="mb-3 col-md-12">
                                            <label for="">Deskripsi</label>
                                            <textarea class="form-control" name="m_description" id="summernote" rows="10"
                                                      placeholder="Deskripsi">{{old('m_description')}}</textarea>
                                        </div>


                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"></h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">


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
