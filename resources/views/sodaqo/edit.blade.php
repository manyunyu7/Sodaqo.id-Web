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


            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Program Saya</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">{{$data->name}}</a></li>
                </ol>
            </div>

            <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="profile card card-body px-3 pt-3 pb-0">
                        <div class="profile-head">
                            <div class="photo-content">
                                <div class="cover-photo rounded"></div>
                            </div>
                            <div class="profile-info">
                                <div class="profile-photo">

                                    <img style="width: 108px!important; height: 108px !important;"
                                         src="{{$data->creator->photo_path}}" class="rounded-circle" alt="">
                                </div>
                                <div class="profile-details">
                                    <div class="profile-name px-lg-3 pt-2">
                                        <h4 class="text-primary mb-0">{{$data->creator->name}}</h4>
                                        <p>{{$data->creator->email}} | {{$data->creator->contact}}</p>
                                    </div>
                                    <div class="profile-email px-2 pt-2">
                                        <h4 class="text-muted mb-0">Target Dana : </h4>
                                        <p>
                                            Rp. {{ number_format($data->fundraising_target, 2) ?: "Tidak Ada Batas" }}</p>
                                    </div>
                                    <div class="profile-email px-2 pt-2 mr-lg-2">
                                        <h4 class="text-muted mb-0">Terkumpul : </h4>
                                        <p>
                                            Rp. {{ number_format($data->fundraising_target, 2) ?: "Tidak Ada Batas" }}</p>
                                    </div>
                                    <div class="dropdown ms-auto">
                                        <a href="#" class="btn btn-primary light sharp" data-bs-toggle="dropdown"
                                           aria-expanded="true">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px"
                                                 viewbox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <circle fill="#000000" cx="5" cy="12" r="2"></circle>
                                                    <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                                    <circle fill="#000000" cx="19" cy="12" r="2"></circle>
                                                </g>
                                            </svg>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li class="dropdown-item"><i
                                                    class="fa fa-user-circle text-primary me-2"></i> View profile
                                            </li>
                                            <li class="dropdown-item"><i class="fa fa-users text-primary me-2"></i> Add
                                                to btn-close friends
                                            </li>
                                            <li class="dropdown-item"><i class="fa fa-plus text-primary me-2"></i> Add
                                                to group
                                            </li>
                                            <li class="dropdown-item"><i class="fa fa-ban text-primary me-2"></i> Block
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @include("168_component.alert_message.message")
                </div>

                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="profile-statistics">
                                        <div class="text-center">
                                            <div class="row">
                                                <div class="col">
                                                    <h3 class="m-b-0">150</h3><span>Donatur</span>
                                                </div>
                                                <div class="col">
                                                    <h3 class="m-b-0">5</h3><span>Laporan</span>
                                                </div>

                                            </div>
                                            <div class="mt-4">
                                                <a href="{{url("sodaqo/".$data->id."/transaction/manage")}}" class="btn btn-primary mb-1 me-1">Lihat
                                                    Donatur</a>
                                                <a href="javascript:void(0);" class="btn btn-primary mb-1 me-1">Lihat
                                                    Laporan</a>
                                            </div>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="sendMessageModal">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Send Message</h5>
                                                        <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="comment-form">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="text-black font-w600 form-label">Name
                                                                            <span class="required">*</span></label>
                                                                        <input type="text" class="form-control"
                                                                               value="Author" name="Author"
                                                                               placeholder="Author">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="text-black font-w600 form-label">Email
                                                                            <span class="required">*</span></label>
                                                                        <input type="text" class="form-control"
                                                                               value="Email" placeholder="Email"
                                                                               name="Email">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="mb-3">
                                                                        <label class="text-black font-w600 form-label">Comment</label>
                                                                        <textarea rows="8" class="form-control"
                                                                                  name="comment"
                                                                                  placeholder="Comment"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="mb-3 mb-0">
                                                                        <input type="submit" value="Post Comment"
                                                                               class="submit btn btn-primary"
                                                                               name="submit">
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
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="profile-blog">
                                        <h5 class="text-primary d-inline">Today Highlights</h5>
                                        <img src="images/profile/1.jpg" alt="" class="img-fluid mt-4 mb-4 w-100">
                                        <h4><a href="post-details.html" class="text-black">Darwin Creative Agency
                                                Theme</a></h4>
                                        <p class="mb-0">A small river named Duden flows by their place and supplies it
                                            with the necessary regelialia. It is a paradisematic country, in which
                                            roasted parts of sentences fly into your mouth.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="profile-interest">
                                        <h5 class="text-primary d-inline">Interest</h5>
                                        <div class="row mt-4 sp4" id="lightgallery">
                                            <a href="images/profile/2.jpg" data-exthumbimage="images/profile/2.jpg"
                                               data-src="images/profile/2.jpg"
                                               class="mb-1 col-lg-4 col-xl-4 col-sm-4 col-6">
                                                <img src="images/profile/2.jpg" alt="" class="img-fluid">
                                            </a>
                                            <a href="images/profile/3.jpg" data-exthumbimage="images/profile/3.jpg"
                                               data-src="images/profile/3.jpg"
                                               class="mb-1 col-lg-4 col-xl-4 col-sm-4 col-6">
                                                <img src="images/profile/3.jpg" alt="" class="img-fluid">
                                            </a>
                                            <a href="images/profile/4.jpg" data-exthumbimage="images/profile/4.jpg"
                                               data-src="images/profile/4.jpg"
                                               class="mb-1 col-lg-4 col-xl-4 col-sm-4 col-6">
                                                <img src="images/profile/4.jpg" alt="" class="img-fluid">
                                            </a>
                                            <a href="images/profile/3.jpg" data-exthumbimage="images/profile/3.jpg"
                                               data-src="images/profile/3.jpg"
                                               class="mb-1 col-lg-4 col-xl-4 col-sm-4 col-6">
                                                <img src="images/profile/3.jpg" alt="" class="img-fluid">
                                            </a>
                                            <a href="images/profile/4.jpg" data-exthumbimage="images/profile/4.jpg"
                                               data-src="images/profile/4.jpg"
                                               class="mb-1 col-lg-4 col-xl-4 col-sm-4 col-6">
                                                <img src="images/profile/4.jpg" alt="" class="img-fluid">
                                            </a>
                                            <a href="images/profile/2.jpg" data-exthumbimage="images/profile/2.jpg"
                                               data-src="images/profile/2.jpg"
                                               class="mb-1 col-lg-4 col-xl-4 col-sm-4 col-6">
                                                <img src="images/profile/2.jpg" alt="" class="img-fluid">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
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
                                                                            <div class="mb-3 col-md-6">
                                                                                <label
                                                                                    class="form-label">Subjudul</label>
                                                                                <input type="text"
                                                                                       placeholder="subtitle"
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
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Deskripsi
                                                                                Pengeluaran</label>
                                                                            <textarea name="expense_desc"
                                                                                      id="summernote2"
                                                                                      cols="30" rows="5"
                                                                                      class="form-control bg-transparent"
                                                                                      placeholder="Deskripsi Pengeluaran"></textarea>
                                                                            <div class="form-text">Detail dari
                                                                                pengeluaran yang
                                                                                telah
                                                                                diinput jika ada
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

                                                            <div id="dlab_W_TimeLine"
                                                                 class="widget-timeline ps ps--active-y">
                                                                <ul class="timeline">

                                                                    @forelse ($timelines as $item)
                                                                        <li>
                                                                            <div class="timeline-badge danger">
                                                                            </div>
                                                                            <a class="timeline-panel text-muted"
                                                                               href="#">
                                                                                <span>{{$item->created_at}}</span>
                                                                                <br>
                                                                                <div class="container">
                                                                                    {!! $item->content  !!}
                                                                                </div>
                                                                            </a>
                                                                        </li>
                                                                    @empty

                                                                    @endforelse
                                                                </ul>
                                                                <div class="ps__rail-x"
                                                                     style="left: 0px; bottom: -299px;">
                                                                    <div class="ps__thumb-x" tabindex="0"
                                                                         style="left: 0px; width: 0px;"></div>
                                                                </div>
                                                                <div class="ps__rail-y"
                                                                     style="top: 299px; height: 370px; right: 0px;">
                                                                    <div class="ps__thumb-y" tabindex="0"
                                                                         style="top: 166px; height: 204px;"></div>
                                                                </div>
                                                            </div>
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
