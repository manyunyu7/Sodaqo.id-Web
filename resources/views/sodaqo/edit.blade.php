@extends('168_template')
@include('168_component.util.wyswyig')


@section("header_name")
    {{$data->title}}
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
    <!--**********************************
            Content body start
        ***********************************-->
    <div class="content-body">
        <div class="container-fluid">

            <!-- row -->
            <div class="row">
                <div class="col-12">
                    @include("168_component.alert_message.message")
                </div>

                <div class="col-xl-12 col-12">
                    <div class="mt-4">
                        <img src="{{$data->photo_path}}" style="max-height: 300px" alt=""
                             class="img-fluid mb-3 w-100 rounded">
                </div>

                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="profile-name px-lg-3 pt-2">
                                <h1 class="text-primary mb-0">{{$data->name}}</h1>
                                <h5 class="mt-2 text-dark">{{$data->category_name}} | {{$data->fundraising_target_formatted}}</h5>

                                <a href="{{url('/sodaqo'.'/'.$data->id.'/transaction/manage')}}">
                                    <button class="btn btn-outline-dark me-2 mt-2">
{{--                                        <span class="me-2"><i class="fa fa-heart"></i></span>--}}
                                        Lihat Transaksi dan Donasi
                                    </button>
                                </a>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="profile-tab">
                                <div class="custom-tab-1">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item"><a href="#about-me" data-bs-toggle="tab"
                                                                class="nav-link  active show">Tentang Program</a>
                                        </li>
                                        <li class="nav-item"><a href="#my-posts" data-bs-toggle="tab" class="nav-link">Timeline</a>
                                        </li>
                                        <li class="nav-item"><a href="#ganti_foto" data-bs-toggle="tab"
                                                                class="nav-link">Foto</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="about-me" class="tab-pane fade active show">
                                            <div class="mt-4">
                                                <img src="{{$data->photo_path}}" style="max-height: 300px" alt=""
                                                     class="img-fluid mb-3 w-100 rounded">
                                            </div>
                                            <div class="mt-4 mb-4">
                                                <form action="{{ url('sodaqo/creation/story/edit') }}"
                                                      enctype="multipart/form-data" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$data->id}}">
                                                    <textarea name="story" id="summernote" cols="30" rows="5"
                                                              class="form-control bg-transparent"
                                                              placeholder="Please type what you want....">{!! $data->story !!}</textarea>
                                                    <button type="submit" class="btn btn-primary mt-2">Simpan
                                                        Perubahan
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <div id="my-posts" class="tab-pane fade">
                                            <div class="pt-3">
                                                <div class="settings-form">
                                                    <div class="accordion-item accordion-solid-bg">
                                                        <div class="accordion-header rounded-lg collapsed"
                                                             id="accord-8One" data-bs-toggle="collapse"
                                                             data-bs-target="#collapse8One" aria-controls="collapse8One"
                                                             aria-expanded="false" role="button">
                                                            <span class="accordion-header-icon"></span>
                                                            <span class="accordion-header-text">Tambah Data Timeline (Admin)</span>
                                                            <span class="accordion-header-indicator"></span>
                                                        </div>
                                                        <div id="collapse8One" class="accordion__body collapse"
                                                             aria-labelledby="accord-8One"
                                                             data-bs-parent="#accordion-eight" style="">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <form
                                                                        action="{{ url('sodaqo/creation/timeline/store') }}"
                                                                        enctype="multipart/form-data" method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="id"
                                                                               value="{{$data->id}}">
                                                                        <div class="row">
                                                                            <div class="mb-3 col-md-6">
                                                                                <label class="form-label">Judul</label>
                                                                                <input name="title" type="text"
                                                                                       placeholder="Judul"
                                                                                       class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">Pengeluaran</label>
                                                                            <input name="expense" type="text"
                                                                                   placeholder="Pengeluaran"
                                                                                   class="form-control">
                                                                            <div class="form-text">Masukkan Jumlah
                                                                                pengeluaran
                                                                                jika pada
                                                                                timeline ini terdapat pengeluaran
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Biaya
                                                                                Operasional/Admin</label>
                                                                            <input name="expense_admin" type="text"
                                                                                   placeholder="Masukkan jika ada"
                                                                                   class="form-control">
                                                                            <div class="form-text">Masukkan Jumlah
                                                                                pengeluaran
                                                                                operasional/admin jika pada timeline ini
                                                                                terdapat
                                                                                pengeluaran
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="mb-3 col-md-12">
                                                                                <label
                                                                                    class="form-label">Timeline</label>
                                                                                <textarea name="story" id="summernote3"
                                                                                          cols="30"
                                                                                          rows="5"
                                                                                          class="form-control bg-transparent"
                                                                                          placeholder="Tambahkan Deskripsi Pengeluaran"></textarea>
                                                                                <div class="form-text">Story Timeline,
                                                                                    Jelaskan
                                                                                    kegiatan
                                                                                    yang dilakukan jika ada, misalnya
                                                                                    pembagian
                                                                                    makanan
                                                                                    atau lainnya
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                        <button class="btn btn-primary" type="submit">
                                                                            Tambahkan
                                                                            Timeline
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="card">
                                                        <div class="card-header border-0 pb-0">
                                                            <h4 class="card-title">Timeline</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            @forelse ($timelines as $item)
                                                                <div class="mb-3" style="border: 2px solid lightgrey; border-radius: 20px; padding: 10px">
                                                                    <button type="submit" class="btn btn-outline-primary btn-primary mb-2">
                                                                        Ubah Timeline
                                                                    </button>
                                                                    <h4> {{$item->title}}</h4>
                                                                    <h3> {{$item->sub_title}}</h3>
                                                                    <hr>
                                                                    {!! $item->content  !!}
                                                                </div>
                                                            @empty

                                                            @endforelse
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div id="ganti_foto" class="tab-pane fade">
                                            <div class="pt-3">
                                                <form action="{{ url('sodaqo/creation/photo/edit') }}"
                                                      enctype="multipart/form-data"
                                                      method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$data->id}}">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="card-title"></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="basic-form">
                                                                <div class="col-12">
                                                                    <img
                                                                        id="imgPreview"
                                                                        src="{{$data->photo_path}}"
                                                                        alt="image" class="me-3 rounded"
                                                                        width="275">
                                                                </div>

                                                                <label class="col-form-label mt-4">Foto Baru</label>
                                                                <div class="col-sm-9">
                                                                    <div class="input-group">
                                                                        <div class="form-file">
                                                                            <input id="formFile168" type="file"
                                                                                   name="photo"
                                                                                   class="form-file-input form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary mt-5">
                                                                    Simpan Konten
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
        Content body end
    ***********************************-->
@endsection
