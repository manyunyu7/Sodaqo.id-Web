@extends('main.app')

@section('page-breadcrumb')
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">User</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item text-muted active" aria-current="page">User</li>
                        <li class="breadcrumb-item text-muted" aria-current="page">Tambah User</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-5 align-self-center">
            <div class="customize-input float-right">

            </div>
        </div>
    </div>
@endsection

@section('page-wrapper')
    @include('main.components.message')


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action='{{ url("payment-merchant/$data->id/update") }}' enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-5">
                                <img src="{{asset($data->photo)}}" style="border-radius: 20px" id="imgPreview"
                                     class="img-fluid" alt="Responsive image">
                                <h1 class="card-title mt-3">{{$data->name}}</h1>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="card-title" for="basicInput">Nama Merchant</label>
                                    <input type="text" name="name" required class="form-control"
                                           value="{{ old('name',$data->name) }}"
                                           placeholder="Nama Merchant">
                                </div>

                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select class="form-control" name="status" required id="">
                                        <option>Pilih Status</option>
                                        <option @if($data->status==1) selected @endif value="1">Aktif</option>
                                        <option @if($data->status==2) selected @endif value="2">Non-Aktif / Dihapus</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="formFile" class="form-label">Ganti Logo</label>
                                    <input name="photo" class="form-control" type="file" id="formFile">
                                </div>


                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Deskripsi</label>
                                    <textarea
                                        class="form-control" style="height: 300px !important;" name="m_description"
                                        id="textarea" rows="10"
                                        placeholder="Deskripsi">{{old('m_description',$data->m_description)}}</textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>


    </div>





@endsection


@section('app-script')

    <script src="{{ URL::to('bootstrap_ui') }}/assets/libs/tinymce/tinymce.min.js"></script>
    <script src="{{ URL::to('bootstrap_ui') }}/assets/libs/tinymce/plugins/code/plugin.min.js"></script>
    <script>
        tinymce.init({selector: '#textarea'});
        tinymce.init({
            selector: '#dark',
            toolbar: 'undo redo styleselect bold italic alignleft aligncenter alignright bullist numlist outdent indent code',
            plugins: 'code'
        });
    </script>

    <script type="text/javascript"
            src="https://cdn.datatables.net/v/bs4-4.1.1/jszip-2.5.0/dt-1.10.23/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/r-2.2.7/sb-1.0.1/sp-1.2.2/datatables.min.js">
    </script>
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js">
    </script>
    <script type="text/javascript" charset="utf8"
            src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js">
    </script>
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js">
    </script>

    <script>
        var el = document.getElementById('formFile');
        el.onchange = function () {
            var fileReader = new FileReader();
            fileReader.readAsDataURL(document.getElementById("formFile").files[0])
            fileReader.onload = function (oFREvent) {
                document.getElementById("imgPreview").src = oFREvent.target.result;
            };
        }


        $(document).ready(function () {
            $.myfunction = function () {
                $("#previewName").text($("#inputTitle").val());
                var title = $.trim($("#inputTitle").val())
                if (title == "") {
                    $("#previewName").text("Judul")
                }
            };

            $("#inputTitle").keyup(function () {
                $.myfunction();
            });

        });
    </script>





@endsection
