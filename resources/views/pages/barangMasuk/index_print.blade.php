@extends('layouts.app')

@section('title', 'Barang Masuk')

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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ $menu }}</h4>
                            </div>
                            <div class="card-body">
                                <div>

                                        <input type="date" name="tgl_awal" id="tgl_awal">
                                        <input type="date" name="tgl_akhir" id="tgl_akhir">

                                        <button class="btn btn-dark" type="button" onclick="filter()">Filter</button>
                                         <button class="btn btn-dark" type="button" onclick="download()">Download</button>


                                </div>
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th>Nama Barang</th>
                                                <th>Tanggal Barang Masuk</th>
                                                <th>Jumlah Barang Masuk</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
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

            initialDt();


        });

        function initialDt(tgl_awal = null, tgl_akhir=null){
            dt = $('#table-1').DataTable({
                "destroy": true,
                "processing": true,
                "select": true,
                // "scrollX": true,
                "ajax": {
                    "url": "{{ route('getBarangMasuk') }}",
                    "data":{
                        'tgl_awal':tgl_awal,
                        'tgl_akhir':tgl_akhir
                    }
                },
                "columns": [{
                        data: "DT_RowIndex",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "barang",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "tanggal_masuk",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "jumlah",
                        orderable: true,
                        searchable: true
                    },
                ]
            });
        }

        function filter(){
            var awal    = $('#tgl_awal').val();
            var akhir   = $('#tgl_akhir').val();

            initialDt(awal,akhir)

        }

        function download(){
            var awal    = $('#tgl_awal').val()  ? $('#tgl_awal').val():0;
            var akhir   = $('#tgl_akhir').val() ? $('#tgl_akhir').val():0;

            const url = `{{ route('printBarangMasuk', [':tgl_awal', ':tgl_akhir']) }}`.replace(':tgl_awal', awal).replace(':tgl_akhir', akhir);
    window.location.href = url;
        }


    </script>
@endpush
