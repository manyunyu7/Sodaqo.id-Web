@extends('168_template')


@section("header_name")
    Payment Merchant
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
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Payment Merchant</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">List</a></li>
                </ol>
            </div>

            <div class="row">

                <div class="col-12">
                    @include("168_component.alert_message.message")
                </div>


                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">List Bank/Wallet/Payment Merchant</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style='font-family: Nunito, sans-serif '>
                                <table id="168dt" class="display" style="min-width: 845px">
                                    <thead>
                                    <tr>
                                        <th data-sortable="">No</th>
                                        <th data-sortable="">Logo</th>
                                        <th data-sortable="">Nama</th>
                                        <th data-sortable="">Status</th>
                                        <th data-sortable="">Diinput Pada</th>
                                        <th data-sortable="">Edit</th>
                                        <th data-sortable="">Hapus</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($datas as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <img height="100px"
                                                     style="border-radius: 20px; max-width: 100px; object-fit: contain"
                                                     src='{{asset("$data->photo")}}' alt="">
                                            </td>
                                            <td>{{ $data->name }}</td>
                                            <td>
                                                @if($data->status==1)
                                                    <span class="badge light badge-success">
														<i class="fa fa-circle text-success me-1"></i>
													Dihapus
													</span>
                                                @elseif($data->status==0)
                                                    <span class="badge light badge-danger">
														<i class="fa fa-circle text-danger me-1"></i>
													Non Aktif
													</span>
                                                @elseif($data->status==-99)
                                                    <span class="badge light badge-danger">
														<i class="fa fa-circle text-danger me-1"></i>
													Dihapus
													</span>
                                                @endif
                                            </td>
                                            <td>{{ $data->created_at }}</td>
                                            <td>
                                                <a href="{{url('/payment-merchant'.'/'.$data->id.'/edit')}}">
                                                    <button type="button" class="btn btn-primary">Edit</button>
                                                </a>
                                            </td>
                                            <td>
                                                @if($data->status!=-99 && $data->status!=0)
                                                    <button id="{{ $data->id }}" type="button"
                                                            class="btn btn-delete btn-danger btn-delete mr-2"
                                                            onclick="openDeleteDialog('lala{{$data->id}}')">
                                                        Hapus Payment Merchant
                                                    </button>
                                                @endif

                                            </td>
                                            <form id="lala{{$data->id}}"
                                                  action='{{ url("payment-merchant/$data->id/delete") }}'
                                                  enctype="multipart/form-data" method="get">
                                            </form>
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
@endsection



@push("script")
    <script>
        function openDeleteDialog(formId) {
            // Use the Sweet Alert `swal` function to open a dialog
            swal({
                title: "Apakah Anda yakin?",
                text: "Merchant ini akan dihapus jika tidak ada rekening terhubung, jika masih ada rekening terhubung atau telah digunakan dalam transaksi payment merchant akan dinonaktifkan",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, hapus",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.value) {
                    // Submit the form if the user confirms the action
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
@endpush
