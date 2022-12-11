@extends('168_template')


@section("header_name")
    Daftar Transaksi {{$programName}}
@endsection

@push('css')
    <!-- Datatable -->
    <link href="{{asset('/168_res')}}/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
@endpush

@push('css_content')
    .buttons-columnVisibility {
    font-family: Nunito, sans-serif;
    font-size: medium;
    font-style: normal;
    border-radius: 20px;
    padding-left: 3px;
    padding-right: 3px;
    font-size: larger;
    font-weight: bold;
    }

    .buttons-columnVisibility.active{
    padding-right: 3px;
    font-weight: normal;
    padding-left: 3px;
    padding-right: 3px;
    }

    .modal-body img {
    max-width: 100%;
    max-height : 500px;
    height: auto;
    display: block;
    margin: 0 auto;
    }
@endpush

@push('script')
    <!-- Datatable -->
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.4/kt-2.7.0/r-2.3.0/rg-1.2.0/rr-1.2.8/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/sr-1.1.1/datatables.min.js"></script>

    <script src="{{ asset('/168_js') }}/168_datatable.js"></script>


    <script src="{{ asset('/168_res') }}/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
@endpush

@section("page_content")
    <div class="content-body" style="min-height: 798px;">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)"> Daftar Transaksi
                        </a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">{{$programName}}</a></li>
                </ol>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"> Daftar Transaksi {{$programName}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style='font-family: Nunito, sans-serif '>
                                <table id="168dt" class="display" style="min-width: 845px">
                                    <thead>
                                    <tr>
                                        <th data-sortable="">No</th>
                                        <th data-sortable="">Img</th>
                                        <th data-sortable="">Nama</th>
                                        <th data-sortable="">Nominal Donasi</th>
                                        <th data-sortable="">Account</th>
                                        <th data-sortable=""></th>
                                        <th data-sortable="">Status</th>
                                        <th data-sortable="">Diinput Pada</th>
                                        <th data-sortable="">Edit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($datas as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <img height="100px"
                                                     style="border-radius: 20px; max-width: 100px; object-fit: contain"
                                                     src='{{asset("$data->photo_path")}}' alt="">
                                            </td>
                                            <td>{{ $data->user_detail->name }}</td>
                                            <td>{{ number_format($data->nominal, 2) }}</td>
                                            <td>{{ $data->donation_account->account_number." (".$data->donation_account->name." - ".$data->donation_account->merchantNames .")"}}</td>
                                            <td>
                                                <img height="100px"
                                                     style="border-radius: 20px; max-width: 100px; object-fit: contain"
                                                     src='{{asset("$data->merchant->photo_path")}}' alt="">
                                            </td>
                                            <td>
                                                @if($data->status==1)
                                                    <a href="javascript:void(0)"
                                                       class="btn btn-success btn-rounded light">Terverifikasi</a>
                                                @endif

                                                @if($data->status==0)
                                                    <a href="javascript:void(0)"
                                                       class="btn btn-danger btn-rounded light">Belum Diverifikasi</a>
                                                @endif
                                            </td>
                                            <td>{{ $data->created_at }}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary mb-2"
                                                        data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg"
                                                        data-img-src='{{ asset($data->photo_path) }}'
                                                        data-aidi='{{ ($data->id) }}'
                                                        data-user-name='{{ $data->user_detail->name }}'
                                                        data-nominal='{{ number_format($data->nominal, 2) }}'
                                                        data-qw='{{$data->donation_account->account_number }}'
                                                        data-er='{{$data->donation_account->name }}'
                                                        data-ty='{{ $data->donation_account->merchantNames }}'
                                                        data-xss='{{ $data->created_at }}'
                                                        data-created='{{ $data->created_at }}'
                                                        data-razky='{{ $data->user_detail->photo_path }}'
                                                        data-nomnet='{{ $data->nominal_net }}'
                                                        data-donm='{{ $data->doa }}'
                                                        data-valid='{{ $data->status }}'>
                                                    Edit
                                                </button>
                                            </td>
                                        </tr>
                                    @empty

                                    @endforelse
                                    </tbody>
                                    <tfoot>

                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action='{{ url("transaction/update") }}' enctype="multipart/form-data" method="post">
                @csrf
                <input hidden class="aidi" name="id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Data Donasi <span class="title-aidi"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <img style="border-radius: 20px" class="col-6"
                                 src="" alt="User image">

                            <div class="col-6 text-black">
                                <div class="media pt-3 pb-3"
                                     style="border: 0.5px dashed lightgrey; padding: 10px; border-radius: 20px">
                                    <div class="media-body">
                                        <h5 class="m-b-5"><a class="text-black">Nama Donatur : <span
                                                    class="user-name"></span></a></h5>
                                        <p class="mb-0">Nominal : Rp.<small class="text-end font-w400"> <span
                                                    class="nominal"></span></small></p>
                                        <p class="mb-0"><span class="modal-doa"></span></p>
                                    </div>
                                </div>

                                <div class="mt-3"
                                     style="border: 0.5px dashed lightgrey; padding: 10px; border-radius: 20px">
                                    <h6 class="">Donasi </h6>
                                    <p>E-Wallet/Rekening: <span class="mod-donation-merch"></span></p>
                                    <p>Rekening/Nomer : <span class="mod-donation-account"></span></p>
                                    <p>Tanggal Transfer : <span class="mod-date"></span></p>
                                    <p><span class="mod-timer"></span></p>
                                </div>
                            </div>


                            <div class="col-12 mt-4"
                                 style="border: 0.5px dashed lightgrey; padding: 10px; border-radius: 20px">
                                <!-- Dropdown for verification status -->
                                <div class="form-group">
                                    <label for="verification-status">Ubah Status</label>
                                    <select name="status" class="form-control default-select wide"
                                            id="verification-status">
                                        <option value="1">Diterima</option>
                                        <option value="2">Tidak Sesuai</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Nominal Terverifikasi</label>
                                    <input type="text" class="nominal_net form-control" name="nominal_net"
                                           placeholder="Jumlah Donasi Terverifikasi">
                                </div>

                                <!-- Textarea for rejection reason -->
                                <div class="form-group" id="rejection-reason-group">
                                    <label for="rejection-reason">Catatan:</label>
                                    <textarea name="notes" class="form-control" id="rejection-reason"></textarea>
                                </div>


                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    @push('script')
        <script>
            function getTimeDifference(donCreatedx) {
                // Get the current date and time
                var currentDate = new Date();

                // Parse the donCreated date and time from the string
                var donCreated = new Date(donCreatedx);

                // Calculate the difference between the two dates in milliseconds
                var timeDifference = currentDate - donCreated;

                // Convert the time difference to minutes
                var timeDifferenceInMinutes = timeDifference / (60 * 1000);

                // Check if the time difference is less than 2 hours
                if (timeDifferenceInMinutes < 120) {
                    // If it is, check if the time difference is less than 15 minutes
                    if (timeDifferenceInMinutes < 15) {
                        // If it is, convert the time difference to seconds
                        var timeDifferenceInSeconds = timeDifference / 1000;
                        // Return the time difference in seconds
                        return "Ditransfer " + timeDifferenceInSeconds + " detik yang lalu";
                    } else {
                        // If the time difference is more than 15 minutes but less than 2 hours, return the time difference in minutes
                        return "Ditransfer " + timeDifferenceInMinutes + " menit yang lalu";
                    }
                } else {
                    // If the time difference is more than 2 hours, convert the time difference to hours
                    var timeDifferenceInHours = timeDifference / (60 * 60 * 1000);

                    // Check if the time difference is less than 24 hours
                    if (timeDifferenceInHours < 24) {
                        // If it is, round the number of hours down to the nearest integer
                        var hours = Math.floor(timeDifferenceInHours);

                        // Calculate the number of minutes
                        var minutes = (timeDifferenceInHours - hours) * 60;

                        // Return the time difference in hours and minutes
                        return "Ditransfer " + hours + " jam " + minutes + " menit yang lalu";
                    } else {
                        // If the time difference is more than 24 hours, convert the time difference to days
                        var timeDifferenceInDays = timeDifference / (24 * 60 * 60 * 1000);
                        // Round the number of days down to the nearest integer
                        var days = Math.floor(timeDifferenceInDays);

                        // Calculate the number of hours
                        var hours = Math.floor((timeDifferenceInDays - days) * 24)

                        // Return the time difference in days and hours
                        return "Ditransfer " + days + " hari " + hours + " jam yang lalu";
                    }
                }
            }


            document.querySelector('.bd-example-modal-lg').addEventListener('show.bs.modal', function (e) {
                var imgSrc = e.relatedTarget.dataset.imgSrc;
                var userName = e.relatedTarget.dataset.userName;
                var nominal = e.relatedTarget.dataset.nominal;
                var donAccount = e.relatedTarget.dataset.qw;
                var donAccountName = e.relatedTarget.dataset.er;
                var donMerchant = e.relatedTarget.dataset.ty;
                var picUser = e.relatedTarget.dataset.razky;
                var doa = e.relatedTarget.dataset.donm;
                var nomNet = e.relatedTarget.dataset.nomnet;
                var aidi = e.relatedTarget.dataset.aidi;

                this.querySelector('.modal-body .mod-timer').textContent = getTimeDifference(e.relatedTarget.dataset.xss);
                this.querySelector('.modal-body .mod-date').textContent = e.relatedTarget.dataset.xss;


                this.querySelector('.modal-body img').src = imgSrc;
                // this.querySelector('.modal-body .profx').src = picUser;
                this.querySelector('.modal-body .user-name').textContent = userName;
                this.querySelector('.modal-body .nominal').textContent = nominal;
                this.querySelector('.modal-body .modal-doa').textContent = doa;
                this.querySelector('.modal-body .mod-donation-account').textContent = donAccount;
                this.querySelector('.modal-body .nominal_net').value = nomNet;
                this.querySelector('.modal-body .aidi').value = aidi;
                this.querySelector('.modal-body .title-aidi').textContent = aidi;
                this.querySelector('.modal-body .mod-donation-merch').textContent = donMerchant;
                this.querySelector('.modal-body .mod-donation-name').textContent = donAccountName;

                this.querySelector('.modal-body img').onerror = "this.onerror=null;this.src='https://avatarsb.s3.amazonaws.com/others/panda-black-toy1-31-min.png'"
            });


        </script>

    @endpush

@endsection



