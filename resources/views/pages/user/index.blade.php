@extends('layouts.app')

@section('title', 'User')

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
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th>Nama Divisi</th>
                                                <th>Code</th>
                                                <th>Role</th>
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
                            <form id="formUser" action="" method="method">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="id">
                                    <div class="form-group">
                                        <label for="catgory_name">Nama Divisi</label>
                                        <select name="departement_id" class="form-control" id="select2">
                                            @foreach ($divisi as $d )
                                            <option value="{{ $d->id }}">{{ $d->name_departement }}</option>
                                            @endforeach

                                        </select>
                                        {{-- <input type="text" id="name_departement" name="name_departement" class="form-control"> --}}
                                    </div>
                                    <div class="form-group">
                                        <label for="catgory_name">E-Mail</label>
                                        <input type="text" name="email" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="catgory_name">Hak Akses</label>
                                        <select name="role" class="form-control" id="select2">
                                            <option value="1">User</option>
                                            <option value="2">Administrator</option>
                                            <option value="3">Pengawas</option>

                                        </select>
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

        method = 'POST';
        formUrl= "{{ route('user.store') }}"


        $(document).ready(function() {

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
                    "url": "{{ route('getDataUser') }}",
                },
                "columns": [{
                        data: "DT_RowIndex",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "departement",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "user_code",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "role",
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
                            var result = `<button class="btn btn-sm btn-success" type="button" onclick='edit(${meta.row})'>Edit</button> &nbsp;`;
                            result += `<button class="btn btn-sm btn-danger" type="button" onclick='remove(${meta.row})'>Hapus</button>`;
                            return result ;
                        },
                        "targets": 4
                    },
                ]
            });
        });

        function edit(obj) {
            var data = dt.row(obj).data();
            $("#formUser").deserialize(data)

            method = 'POST';
            formUrl= "{{ route('user.update') }}";

        }



        $("#formUser").submit(function(e) {

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

        function remove(obj) {

                            let data = dt.row(obj).data();
                            Swal
                                .fire({
                                    title: 'Apakah anda yakin.?',
                                    text: "Data yang dihapus tidak dapat dikembalikan!",
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ya!'
                                })
                                .then((result) => {
                                    if (result.isConfirmed) {
                                        $.ajax({
                                            url:  "{{ route('user.destroy', ':id') }}".replace(':id', data.id),
                                            type: "DELETE",
                                            cache: false,
                                            data: {
                                                "_token": "{{ csrf_token() }}"
                                            },
                                            success: function (data, textStatus, jqXHR) {
                                                let view = jQuery.parseJSON(data);
                                                if (view.status == true) {
                                                    toastr.success(view.message);
                                                    setTimeout(function() {
                                                        location.reload();
                                                    }, 500);
                                                } else {
                                                    toastr.error(view.message);
                                                    setTimeout(function() {
                                                        location.reload();
                                                    }, 500);
                                                }
                                            },
                                            error: function (jqXHR, textStatus, errorThrown) {
                                                toastr.error('Data gagal dihapus.');
                                            }
                                        });
                                    }
                                })


        }
    </script>
@endpush
