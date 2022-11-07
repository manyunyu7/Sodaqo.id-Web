@extends('168_template')
@include('168_component.util.wyswyig')


@section("header_name")
    Tambah Konten Baru
@endsection

@push("css")
    <!-- Form step -->
    <link href="{{asset("/168_res")}}/vendor/jquery-smartwizard/dist/css/smart_wizard.min.css" rel="stylesheet">
@endpush

@push("script")
    <script src="{{asset("/168_res")}}/vendor/jquery-smartwizard/dist/js/jquery.smartWizard.js"></script>

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
    <div class="content-body" style="min-height: 798px;">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{url("sodaqo-category")}}">Kategori Program</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Tambah Baru</a></li>
                </ol>
            </div>
            <!-- row -->
            <form action="{{ url('sodaqo-category/store') }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="row">
                    <div class="col-xl-12 col-xxl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Form step</h4>
                            </div>
                            <div class="card-body">
                                <div id="smartwizard" class="form-wizard order-create sw sw-theme-default sw-justified">
                                    <ul class="nav nav-wizard">
                                        <li><a class="nav-link inactive active" href="#wizard_Service">
                                                <span>1</span>
                                            </a></li>
                                        <li><a class="nav-link inactive done" href="#wizard_Time">
                                                <span>2</span>
                                            </a></li>
                                        <li><a class="nav-link inactive done" href="#wizard_Details">
                                                <span>3</span>
                                            </a></li>
                                        <li><a class="nav-link inactive" href="#wizard_Payment">
                                                <span>4</span>
                                            </a></li>
                                    </ul>
                                    <div class="tab-content" style="height: 287px;">
                                        <div id="wizard_Service" class="tab-pane" role="tabpanel" style="display: block;">
                                            <div class="row">
                                                <div class="col-lg-6 mb-2">
                                                    <div class="mb-3">
                                                        <label class="text-label form-label">First Name*</label>
                                                        <input type="text" name="firstName" class="form-control" placeholder="Parsley" required="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-2">
                                                    <div class="mb-3">
                                                        <label class="text-label form-label">Last Name*</label>
                                                        <input type="text" name="lastName" class="form-control" placeholder="Montana" required="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-2">
                                                    <div class="mb-3">
                                                        <label class="text-label form-label">Email Address*</label>
                                                        <input type="email" class="form-control" id="inputGroupPrepend2" aria-describedby="inputGroupPrepend2" placeholder="example@example.com.com" required="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-2">
                                                    <div class="mb-3">
                                                        <label class="text-label form-label">Phone Number*</label>
                                                        <input type="text" name="phoneNumber" class="form-control" placeholder="(+1)408-657-9007" required="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 mb-3">
                                                    <div class="mb-3">
                                                        <label class="text-label form-label">Where are you from*</label>
                                                        <input type="text" name="place" class="form-control" required="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="wizard_Time" class="tab-pane" role="tabpanel" style="display: none;">
                                            <div class="row">
                                                <div class="col-lg-6 mb-2">
                                                    <div class="mb-3">
                                                        <label class="text-label form-label">Company Name*</label>
                                                        <input type="text" name="firstName" class="form-control" placeholder="Cellophane Square" required="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-2">
                                                    <div class="mb-3">
                                                        <label class="text-label form-label">Company Email Address*</label>
                                                        <input type="email" class="form-control" id="emial1" placeholder="example@example.com.com" required="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-2">
                                                    <div class="mb-3">
                                                        <label class="text-label form-label">Company Phone Number*</label>
                                                        <input type="text" name="phoneNumber" class="form-control" placeholder="(+1)408-657-9007" required="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-2">
                                                    <div class="mb-3">
                                                        <label class="text-label form-label">Your position in Company*</label>
                                                        <input type="text" name="place" class="form-control" required="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="wizard_Details" class="tab-pane" role="tabpanel" style="display: none;">
                                            <div class="row">
                                                <div class="col-sm-4 mb-2">
                                                    <h4>Monday *</h4>
                                                </div>
                                                <div class="col-6 col-sm-4 mb-2">
                                                    <div class="mb-3">
                                                        <input class="form-control" value="9.00" type="number" name="input1" id="input1">
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-4 mb-2">
                                                    <div class="mb-3">
                                                        <input class="form-control" value="6.00" type="number" name="input2" id="input2">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 mb-2">
                                                    <h4>Tuesday *</h4>
                                                </div>
                                                <div class="col-6 col-sm-4 mb-2">
                                                    <div class="mb-3">
                                                        <input class="form-control" value="9.00" type="number" name="input3" id="input3">
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-4 mb-2">
                                                    <div class="mb-3">
                                                        <input class="form-control" value="6.00" type="number" name="input4" id="input4">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 mb-2">
                                                    <h4>Wednesday *</h4>
                                                </div>
                                                <div class="col-6 col-sm-4 mb-2">
                                                    <div class="mb-3">
                                                        <input class="form-control" value="9.00" type="number" name="input5" id="input5">
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-4 mb-2">
                                                    <div class="mb-3">
                                                        <input class="form-control" value="6.00" type="number" name="input6" id="input6">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 mb-2">
                                                    <h4>Thrusday *</h4>
                                                </div>
                                                <div class="col-6 col-sm-4 mb-2">
                                                    <div class="mb-3">
                                                        <input class="form-control" value="9.00" type="number" name="input7" id="input7">
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-4 mb-2">
                                                    <div class="mb-3">
                                                        <input class="form-control" value="6.00" type="number" name="input8" id="input8">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 mb-2">
                                                    <h4>Friday *</h4>
                                                </div>
                                                <div class="col-6 col-sm-4 mb-2">
                                                    <div class="mb-3">
                                                        <input class="form-control" value="9.00" type="number" name="input9" id="input9">
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-4 mb-2">
                                                    <div class="mb-3">
                                                        <input class="form-control" value="6.00" type="number" name="input10" id="input10">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="wizard_Payment" class="tab-pane" role="tabpanel" style="display: none;">
                                            <div class="row emial-setup">
                                                <div class="col-lg-3 col-sm-6 col-6">
                                                    <div class="mb-3">
                                                        <label for="mailclient11" class="mailclinet mailclinet-gmail">
                                                            <input type="radio" name="emailclient" id="mailclient11">
                                                            <span class="mail-icon">
																<i class="mdi mdi-google-plus" aria-hidden="true"></i>
															</span>
                                                            <span class="mail-text">I'm using Gmail</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6 col-6">
                                                    <div class="mb-3">
                                                        <label for="mailclient12" class="mailclinet mailclinet-office">
                                                            <input type="radio" name="emailclient" id="mailclient12">
                                                            <span class="mail-icon">
																<i class="mdi mdi-office" aria-hidden="true"></i>
															</span>
                                                            <span class="mail-text">I'm using Office</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6 col-6">
                                                    <div class="mb-3">
                                                        <label for="mailclient13" class="mailclinet mailclinet-drive">
                                                            <input type="radio" name="emailclient" id="mailclient13">
                                                            <span class="mail-icon">
																<i class="mdi mdi-google-drive" aria-hidden="true"></i>
															</span>
                                                            <span class="mail-text">I'm using Drive</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6 col-6">
                                                    <div class="mb-3">
                                                        <label for="mailclient14" class="mailclinet mailclinet-another">
                                                            <input type="radio" name="emailclient" id="mailclient14">
                                                            <span class="mail-icon">
																<i class="fas fa-question-circle" aria-hidden="true"></i>
															</span>
                                                            <span class="mail-text">Another Service</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="skip-email text-center">
                                                        <p>Or if want skip this step entirely and setup it later</p>
                                                        <a href="javascript:void(0)">Skip step</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><div class="toolbar toolbar-bottom" role="toolbar" style="text-align: right;"><button class="btn btn-primary sw-btn-prev disabled" type="button">Previous</button><button class="btn btn-primary sw-btn-next" type="button">Next</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
