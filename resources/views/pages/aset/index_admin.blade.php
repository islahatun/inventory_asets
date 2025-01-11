@extends('layouts.app')

@section('title', 'Aset Divisi')

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
                    <div class="col-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ $form }}</h4>
                            </div>
                            <form id="formBarang" action="" method="method">
                                @csrf
                                <div class="card-body">
                                    @foreach ($divisi as $d )
                                    <div class="form-check">
                                        <input class="form-check-input"
                                            type="radio"
                                            name="departement_id"
                                            id="departement_id{{ $d->id }}"
                                             value="{{ $d->id }}" onchange="filter()"
                                            >
                                        <label class="form-check-label"
                                            for="departement_id{{ $d->id }}">
                                            {{ $d->name_departement }}
                                        </label>
                                    </div>
                                    @endforeach


                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ $menu }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th>Nama Barang</th>
                                                <th>Total Barang</th>
                                                <th>Status</th>
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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            initialDt();


        });

        function initialDt(divisi = null){
            dt = $('#table-1').DataTable({
                "destroy": true,
                "processing": true,
                "select": true,
                // "scrollX": true,
                "ajax": {
                    "url": "{{ route('getDataAset') }}",
                    "data" : {
                        departement_id : divisi
                    }
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
                        searchable: true,
                        class: "text-center"
                    }
                ],

            });
        }

        function filter(){
           var divisi =  $('[name="departement_id"]:checked').val();

           console.log(divisi);
            initialDt(divisi)
        }
    </script>
@endpush
