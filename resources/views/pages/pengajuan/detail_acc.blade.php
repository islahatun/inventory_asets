@extends('layouts.app')

@section('title', 'Master Barang')

@push('style')
    <!-- CSS Libraries -->
    {{-- <link rel="stylesheet"
        href="assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet"
        href="assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css"> --}}

    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $menu }}</h1>

            </div>

            <div class="section-body">

                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ $menu }}</h4>
                            </div>
                            <div class="card-body">
                                <input type="hidden" id="user_id" value="{{ $user_id }}">
                                <input type="hidden" id="tgl" value="{{ $tanggal_pengajuan }}">
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th>Nama Barang</th>
                                                <th>Total Barang</th>
                                                <th>Status Pengajuan</th>
                                                <th>Alasan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ $form }}</h4>
                            </div>
                            <form id="formBarang" action="" method="method">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="id">
                                    <div class="form-group">
                                        <label for="catgory_name">Nama Barang</label>
                                        <input type="text" name="nama_barang" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="catgory_name">Status</label>
                                        <select name="status" class="form-control" id="select2">
                                            <option value="2">Disetujui</option>
                                            <option value="3">Ditolak</option>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="catgory_name">Alasan</label>
                                        <input type="text" name="alasan" class="form-control" required>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    {{-- <script src="assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script> --}}
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{ asset() }}"></script> --}}
    {{-- <script src="{{ asset() }}"></script> --}}
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <script>
        var dt = "";
        var formUrl;
        var method;

        $(document).ready(function() {

            var user_id = $('#user_id').val();
            var tgl     = $('#tgl').val();
            var formUrl = "{{ route('getDetailDataAcc', ['user_id' => ':user_id', 'tgl' => ':tgl']) }}";
            formUrl = formUrl.replace(':user_id', user_id).replace(':tgl', tgl);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            dt = $('#table-1').DataTable({
                "destroy": true,
                "processing": true,
                "select": true,
                // "scrollX": true,
                "ajax": {
                    "url": formUrl,
                },
                "columns": [{
                        data: "DT_RowIndex",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "nama_barang",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "jumlah",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "status",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "alasan",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "index",
                        orderable: true,
                        searchable: true,
                        class: "text-center"
                    }
                ],
                "columnDefs": [

                    {
                        "render": function(data, type, row, meta) {
                            var result =
                                `<button class="btn btn-sm btn-success" type="button" onclick='edit(${meta.row})'>Edit</button> &nbsp;`;
                            // result +=
                            //     `<button class="btn btn-sm btn-danger" type="button" onclick='remove(${meta.row})'>Hapus</button>`;
                            return result;
                        },
                        "targets": 5
                    },
                ]
            });
        });

        function edit(obj) {
            var data = dt.row(obj).data();
            $("#formBarang").deserialize(data)

            method = 'POST';
            formUrl = "{{ route('acc.update') }}";

        }



        $("#formBarang").submit(function(e) {

            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: formUrl,
                type: method,
                data: formData,
                processData: false,
                contentType: false, // Pastikan konten tipe diatur ke false
                success: function(data, textStatus, jqXHR) {

                    let view = jQuery.parseJSON(data);
                    if (view.status == true) {
                        toastr.success(view.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        toastr.error(view.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                },
                error: function(reject) {

                    var response = $.parseJSON(reject.responseText);
                    $.each(response.errors, function(key, val) {
                        $("#" + key + "_error").text(val[0]);
                    })

                }

            });
        });

    </script>
@endpush
