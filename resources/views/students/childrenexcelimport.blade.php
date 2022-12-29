@extends('layouts.main')

@section('content-header')
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
  <h1>{{ $title}}</h1>
</div>
<div class="col-sm-6">
  <ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="#">Beranda</a></li>
  <li class="breadcrumb-item active">{{ $title }}</li>
  </ol>
</div>
</div>
</div><!-- /.container-fluid -->
@endsection

@section('content')
<!-- Default box -->
<div class="card">
<div class="card-header">
<h3 class="card-title">{{ $title }}</h3>

<div class="card-tools">
<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
  <i class="fas fa-minus"></i>
</button>
<button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
  <i class="fas fa-times"></i>
</button>
</div>
</div>
<div class="card-body" id="card-body-id">

    <div id="actions" class="row">
        <div class="col-lg-12">
            <label for="formFileLg" class="form-label">Pilih Dokumen Excel</label>
            <input class="form-control form-control-lg" id="excel-doc" type="file" name="excel-doc">
        </div>
    </div>

    <div class="table table-striped files" id="previews" style="margin-top:20px">
        <div id="template" class="row mt-2">
        <div class="col-auto d-flex align-items-center">
            <div class="btn-group">
            <button class="btn btn-info start hide" type="submit" id="btnScan">
                <i id="pindai-icon" class="fas fa-upload"></i>
                <i id="loading-icon-pindai" class="fa fa-spinner fa-spin hide"></i>
                <span id="pindai-text">Pindai Excel</span>
            </button>
            <button data-dz-remove class="btn btn-danger delete hide" id="btnDelete">
                <i class="fas fa-trash"></i>
                <span>Hapus</span>
            </button>
            </div>
        </div>
        </div>
    </div>



    <div id="pratinjau-id" class="hide">
        <hr>
        <p>PRATINJAU / PREVIEW DATA</p>

        <table class="table table-hover table-responsive table-sm" id="tbl-preview">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Jenjang</th>
                    <th>Pendidikan</th>
                    <th>Status</th>
                    <th>Kelompok</th>
                    <th>Kode Kelompok<th>
                    <th>Kode Desa<th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

        <div class="row mt-2">
            <div class="col-md-12">
                <button class="btn btn-success start" id="btnStore">
                    <i id="store-icon" class="fas fa fa-save"></i>
                    <i id="loading-icon-store" class="fa fa-spinner fa-spin hide"></i>
                    <span id="store-text">Simpan Data ke Database</span>
                </button>
            </div>
        </div>

    </div>

</div>
<!-- /.card-body -->
<div class="card-footer">
Footer
</div>
<!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection

@push('css')
<!-- Font Awesome -->
<link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="/adminlte/plugins/dropzone/min/dropzone.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .opacity {
        opacity: 0.5;
    }

    .hide {
        display: none;
    }
</style>
@endpush

@push('js')
<!-- dropzonejs -->
<script src="/otherjs/sweetalert.js"></script>
    {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}

<script>
    $(document).ready(function() {
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        $('#btnScan').on('click',function() {


            $('#card-body-id').addClass('opacity');
            $('#pindai-icon').addClass('hide');
            $('#loading-icon-pindai').removeClass('hide');
            $('#pindai-text').text('Sedang Membaca File Excel...');
             // Get the selected file
            let files = $('#excel-doc')[0].files;

            if(files.length > 0)
            {
                const fd = new FormData();
                // Append data
                fd.append('excel-doc',files[0]);
                fd.append('_token',CSRF_TOKEN);

                // AJAX request
                $.ajax({
                    url:"post-impor-excel-caberawit",
                    method: 'POST',
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response){

                        swal("Berhasil", "Data excel berhasil dipindai sistem", "success")

                        $('#card-body-id').removeClass('opacity');
                        $('#pindai-icon').removeClass('hide');
                        $('#loading-icon-pindai').addClass('hide');
                        $('#pindai-text').text('Pindai Excel');


                        //append data to table
                        let tablePreview = document.querySelector("#tbl-preview");

                        let row = `<tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Kelas</th>
                                        <th>Kelompok</th>
                                        <th>Kode Kelompok</th>
                                        <th>Kode Desa</th>
                                    </tr>`;

                        tablePreview.innerHTML = row;

                        let no = 1;

                        if (response.male_data != null)
                        {
                            for(let i = 0; i < response.male_data.length; i++) {
                                row += `<tr>
                                    <td>` + no + `</td>
                                    <td>` + response.male_data[i].fullname + `</td>
                                    <td>` + `Laki-laki` + `</td>
                                    <td>` + response.male_data[i].class + `</td>
                                    <td>` + response.male_data[i].group + `</td>
                                    <td>` + response.male_data[i].group_id + `</td>
                                    <td>` + response.male_data[i].village_id + `</td>
                                    </tr>`;

                                    no++;

                            }
                        }

                        if (response.female_data != null)
                        {
                            for(let i = 0; i < response.female_data.length; i++) {
                                row += `<tr>
                                    <td>` + no + `</td>
                                    <td>` + response.female_data[i].fullname + `</td>
                                    <td>` + `Perempuan` + `</td>
                                    <td>` + response.female_data[i].class + `</td>
                                    <td>` + response.female_data[i].group + `</td>
                                    <td>` + response.female_data[i].group_id + `</td>
                                    <td>` + response.female_data[i].village_id + `</td>
                                    </tr>`;

                                    no++;

                            }
                        }

                        tablePreview.innerHTML = row;

                        $('#pratinjau-id').removeClass('hide');
                    },
                    error: function(response){


                        $('#card-body-id').removeClass('opacity');
                        $('#pindai-icon').removeClass('hide');
                        $('#loading-icon-pindai').addClass('hide');
                        $('#pindai-text').text('Pindai Excel');


                        let error_message = response.responseJSON.error_message == undefined ? response.responseJSON.message : response.responseJSON.error_message;
                        let logKey = response.responseJSON.log_key;

                        let alert_message;

                        if (logKey == undefined)
                            alert_message = error_message;
                        else
                            alert_message = `${error_message}. Copy dan beritaukan kode log berikut ke admin = ${logKey}`;

                        swal("Gagal", alert_message, "error")


                    }
                });



            }
        });

        $('#btnStore').on('click', function() {

            $('#card-body-id').addClass('opacity');
            $('#store-icon').addClass('hide');
            $('#loading-icon-store').removeClass('hide');
            $('#store-text').text('Sedang Memperbarui Database...');

            let students = [];

            $('#tbl-preview tr').each(function(index, tr) {
                let fullname;
                let gender;
                let classes;
                let group_id;
                let village_id;

                $(tr).find('td').each (function (index, td) {
                    switch (index) {
                        case 1:
                            fullname = td.innerHTML;
                            break;
                        case 2:
                            gender = td.innerHTML;
                        case 3:
                            classes = td.innerHTML;
                        case 5:
                            group_id = td.innerHTML;
                        case 6:
                            village_id = td.innerHTML;
                        default:
                            break;
                    }
                });

                if (fullname != undefined || fullname != null)
                {
                    students.push({
                        fullname: fullname,
                        gender: gender,
                        classes: classes,
                        group_id: group_id,
                        village_id: village_id,
                    });
                }

            });



            $.ajax({
                url:"post-simpan-impor-caberawit",
                type: 'POST',
                dataType:'json',
                contentType: 'json',
                data: JSON.stringify(students),
                contentType: 'application/json; charset=utf-8',
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                success: function(response){

                    let alert_message = '';

                    if (response.data_insert.length > 0) {
                        alert_message += `${response.data_insert.length} data berhasil ditambahkan \n`;
                    }

                    if (response.data_update.length > 0) {
                        alert_message += `${response.data_update.length} data berhasil diperbarui \n`;
                    }

                    swal("Berhasil", alert_message, "success")

                    let tablePreview = document.querySelector("#tbl-preview");
                    let row = `<tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Kelas</th>
                                        <th>Kelompok</th>
                                        <th>Kode Kelompok</th>
                                        <th>Kode Desa</th>
                                    </tr>`;

                    tablePreview.innerHTML = row;

                    $('#card-body-id').removeClass('opacity');
                    $('#store-icon').removeClass('hide');
                    $('#loading-icon-store').addClass('hide');
                    $('#store-text').text('Simpan Data ke Database');

                    $('#pratinjau-id').addClass('hide');
                    $('#excel-doc').val(null);
                    $('#btnDelete').addClass('hide');
                    $('#btnScan').addClass('hide');
                },
                error: function(response){

                    $('#card-body-id').removeClass('opacity');
                    $('#store-icon').removeClass('hide');
                    $('#loading-icon-store').addClass('hide');
                    $('#store-text').text('Simpan Data ke Database');

                    let error_message = response.responseJSON.error_message == undefined ? response.responseJSON.message : response.responseJSON.error_message;
                    let logKey = response.responseJSON.log_key;

                    let alert_message;

                    if (logKey == undefined)
                        alert_message = error_message;
                    else
                        alert_message = `${error_message}. Copy dan beritaukan kode log berikut ke admin = ${logKey}`;

                    swal("Gagal", alert_message, "error")
                }
            });
        });



        $('#btnDelete').on('click',function() {
            $('#excel-doc').val(null);
            $('#btnDelete').addClass('hide');
            $('#btnScan').addClass('hide');
        });

        $('#excel-doc').on('change',function(e){
            if (e.target.files.length > 0) {
                $('#btnDelete').removeClass('hide');
                $('#btnScan').removeClass('hide');
            }
        });
    });
</script>

@endpush
