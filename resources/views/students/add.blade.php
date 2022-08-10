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
   <form id="student-form">
        <div class="row">
          <div class="col-md-6">
              <input type="hidden" id="group" value="{{ request()->session()->has('group') ? session('group') : "" }}"/>

              <div class="form-group">
                  <label>Nama Lengkap</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap" onkeypress="return checkChar();">
              </div>

              <div class="form-group">
                <label>Tanggal Lahir</label>
                <div class="input-group">

                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
                <input type="text" id="birthdate" placeholder="Contoh 20 Januari 2020 | Format (dd/mm/yyyy) 20/01/2020" name="birthdate" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                </div>
              </div>

              <div class="form-group clearfix">
                  <label>Jenis Kelamin</label>
                  <div class="icheck-success">
                    <input type="radio" name="gender" id="gender-male" value="Laki-laki">
                    <label for="gender-male">
                        Laki-laki
                    </label>
                  </div>
                  <div class="icheck-danger">
                    <input type="radio" name="gender" id="gender-female" value="Perempuan">
                    <label for="gender-female">
                      Perempuan
                    </label>
                  </div>
              </div>




            <div class="form-group clearfix">
                <label>Status</label>
                <div class="icheck-primary">
                  <input type="radio" name="ispribumi" id="pribumi" value="1">
                  <label for="pribumi">
                      Pribumi
                  </label>
                </div>
                <div class="icheck-secondary">
                  <input type="radio" name="ispribumi" id="non-pribumi" value="0">
                  <label for="non-pribumi">
                    Non Pribumi
                  </label>
                </div>
            </div>

            <div class="form-group">
                <label>Alamat Asal</label>
                <textarea id="address_source" name="address_source" class="form-control" rows="3" placeholder="Tuliskan alamat asal jika generus non pribumi" onkeypress="return checkChar();"></textarea>
            </div>

          </div>

          <div class="col-md-6">

                <div class="form-group">
                    <label>Nama Orang Tua</label>
                    <input type="text" class="form-control" id="parent" name="parent" placeholder="Nama Ayah / Nama Ibu" onkeypress="return checkChar();">
                </div>

                <div class="form-group">
                    <label>Kontak Orang Tua</label>
                    <input type="text" class="form-control" id="parent_phone" name="parent_phone" placeholder="No HP Ayah / No HP Ibu" onkeypress="return checkChar();">
                </div>

                <div class="form-group clearfix">
                    <label>Generus Akselerasi (GP)</label>
                    <div class="icheck-info">
                      <input type="radio" name="is_accel" id="accel" value="1">
                      <label for="accel">
                          Ya
                      </label>
                    </div>
                    <div class="icheck-warning">
                      <input type="radio" name="is_accel" id="non-accel" value="0">
                      <label for="non-accel">
                        Tidak
                      </label>
                    </div>
                </div>

              <div class="form-group">
                <label>Jenjang</label>
                <select id="level" name="level" class="form-control" style="width: 100%;">
                  <option value="">Pilih</option>
                </select>
              </div>



                <div class="form-group">
                  <label>Kelas</label>
                  <select id="class_level" name="class_level" class="form-control" style="width: 100%;">
                    <option value="">Pilih</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Pendidikan</label>
                  <select id="education" name="education" class="form-control" style="width: 100%;">
                    <option value="">Pilih</option>

                  </select>
                </div>
          </div>

      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="btn-group" role="group" aria-label="Button">
            <button type="button" id="btn-back" class="btn btn-secondary">
                <i id="back-icon" class="fa fa-arrow-left" aria-hidden="true"></i>
                <span>Kembali</span>
            </button>
            <button type="button" id="btn-save" class="btn btn-info">
              <i id="save-icon" class="fa fa-save" aria-hidden="true"></i>
              <i id="loading-icon-save" class="fa fa-spinner fa-spin hide"></i>
              <span id="save-text">Save</span>
            </button>
            <button type="submit" id="btn-submit" class="btn btn-success">
              <i id="submit-icon" class="fa fa-paper-plane" aria-hidden="true"></i>
              <i id="loading-icon-submit" class="fa fa-spinner fa-spin hide"></i>
              <span id="submit-text">Submit</span>
            </button>
          </div>
        </div>
      </div>
   </form>
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
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
<!-- icheck bootstrap -->
<link rel="stylesheet" href="/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="/adminlte/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">


<link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


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

<!-- jQuery -->
<script src="/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- InputMask -->
<script src="/adminlte/plugins/moment/moment.min.js"></script>z
<script src="/adminlte/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- Select2 -->
<script src="/adminlte/plugins/select2/js/select2.full.min.js"></script>
<!-- jquery-validation -->
<script src="/adminlte/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="/adminlte/plugins/jquery-validation/additional-methods.min.js"></script>

<script src="/otherjs/sweetalert.js"></script>
    {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}

<script>

$(document).ready(function() {
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    $('.select2').select2()
    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask();

    get_level();
    get_education();

    // select2:select
    $('#level').on('change', function (e) {

      var data = this.value;

      if (data != null) {
        get_class_level(data);
      }
    });


    $('#btn-save').on('click', function() {

      let name = $('#name').val();

      if (name == null || name == "") {
        swal("Info", "Nama lengkap harus diisi", "info"); return;
      }

      post_save_student('save');
    })

    $.validator.setDefaults({
      submitHandler: function () {
        swal({
        title: "Simpan Data",
        text: "Pastikan data yang diisi sesuai",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willSave) => {
        if (willSave) {
          post_save_student('submit');
        }
      });

      }
    });

    $('#student-form').validate({
      ignore: [],
      rules: {
        name: {
          required: true
        },
        birthdate: {
          required: true
        },
        gender: {
          required: true
        },
        ispribumi: {
          required: true
        },
        level: {
          required: true
        },
        class_level: {
          required: true
        },
        education: {
          required: true
        },
        is_accel: {
            required: true
        }
      },
      messages: {
        name: {
          required: "Nama lengkap harus diisi"
        },
        birthdate: {
          required: "Tanggal lahir harus diiisi"
        },
        gender: {
          required: "Jenis kelamin harus dipilih"
        },
        ispribumi: {
          required: "Status pribumi harus dipilih"
        },
        level: {
          required: "Jenjang harus dipilih"
        },
        class_level: {
          required: "Kelas / Rombel harus dipilih"
        },
        education: {
          required: "Pendidikan harus harus dipilih"
        },
        is_accel: {
            required: "Status Generus GP harus dipilih"
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {

        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {

        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });

    $('#btn-back').on('click', function() {
                window.location='{{ url("generus") }}'
            });

  });

  function post_save_student(action) {

      $(`#card-body-id`).addClass('opacity');
      $(`#${action}-icon`).addClass('hide');
      $(`#loading-icon-${action}`).removeClass('hide');
      $(`#${action}-text`).text('Sedang Menyimpan...');

      let name = $('#name').val();
      let birthdate = $('#birthdate').val();
      let gender = $("input[name='gender']:checked").val();
      let ispribumi = $("input[name='ispribumi']:checked").val();
      let level = $('#level').val();
      let class_level = $('#class_level').val();
      let education = $('#education').val();
      let address_source = $('#address_source').val();
      let parent = $('#parent').val();
      let parent_phone = $('#parent_phone').val();
      let isaccel = $("input[name='is_accel']:checked").val();

      let student = {
        name: name,
        birthdate: birthdate,
        gender: gender,
        ispribumi: ispribumi,
        level: level,
        class_level: class_level,
        education: education,
        address_source: address_source,
        parent: parent,
        parent_phone: parent_phone,
        isaccel: isaccel
      };

      $.ajax({
        url:"/api/generus/post-save-student",
        type: 'POST',
        dataType:'json',
        contentType: 'json',
        data: JSON.stringify(student),
        contentType: 'application/json; charset=utf-8',
        headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
        success: function(response){


          swal("Berhasil", `Generus ${response.data.fullname} berhasil ditambahkan`, "success");

          $(`#card-body-id`).removeClass('opacity');
          $(`#${action}-icon`).removeClass('hide');
          $(`#loading-icon-${action}`).addClass('hide');
          $(`#${action}-text`).text(action == 'save' ? 'Simpan' : 'Submit');

          $("#student-form")[0].reset();
        },
        error: function(response) {

          let error_message = response.responseJSON.error_message == undefined ? response.responseJSON.message : response.responseJSON.error_message;
          let logKey = response.responseJSON.log_key;

          let alert_message;

          if (logKey == undefined)
              alert_message = error_message;
          else
              alert_message = `${error_message}. Copy dan beritaukan kode log berikut ke admin = ${logKey}`;

          swal("Gagal", alert_message, "error");

          $(`#card-body-id`).removeClass('opacity');
          $(`#${action}-icon`).removeClass('hide');
          $(`#loading-icon-${action}`).addClass('hide');
          $(`#${action}-text`).text(action == 'save' ? 'Simpan' : 'Submit');
        }
      });
  }

  function get_level() {
    $.ajax({
      url:"/api/level/level-list",
      method: 'GET',
      dataType: 'json',
      success: function(response){
        if (response.data != undefined || response.data != null) {
          for(let i = 0; i < response.data.length; i++) {
            $("#level").append(`<option value="${response.data[i].id}">${response.data[i].name}</option>`);
        }
        }
      },
      error: function(response) {

      }
    });
  }

  function get_class_level(level) {

    let group = $('#group').val();
    $.ajax({
      url:`/api/class-level/class-level-list/${group}/${level}`,
      method: 'GET',
      dataType: 'json',
      success: function(response){
        if (response.data != undefined || response.data != null) {
          $('#class_level').empty().trigger("change");
          $("#class_level").append(`<option value="">Pilih</option>`);
          for(let i = 0; i < response.data.length; i++) {
            $("#class_level").append(`<option value="${response.data[i].id}">${response.data[i].name}</option>`);
        }
        }
      },
      error: function(response) {

      }
    });
  }

  function get_education() {
    $.ajax({
      url:"/api/education/education-list",
      method: 'GET',
      dataType: 'json',
      success: function(response){
        if (response.data != undefined || response.data != null) {
          for(let i = 0; i < response.data.length; i++) {
            $("#education").append(`<option value="${response.data[i].id}">${response.data[i].name}</option>`);
        }
        }
      },
      error: function(response) {

      }
    });
  }

  function checkChar() {

			if(event.keyCode == 39) {
				event.keyCode = 0;
				swal('Peringatan',"Tidak diizinkan menggunakan petik 1 (')","info")
			} else if (event.keyCode == 34) {
                event.keyCode = 0;
				swal('Peringatan',"Tidak diizinkan menggunakan petik 2","info")
            } else if (event.keyCode == 96) {
                event.keyCode = 0;
				swal('Peringatan',"Tidak diizinkan menggunakan backtick (`)","info")
            } else if (event.keyCode == 60) {
                event.keyCode = 0;
				swal('Peringatan',"Tidak diizinkan menggunakan tanda (<)","info")
            } else if (event.keyCode == 62) {
                event.keyCode = 0;
				swal('Peringatan',"Tidak diizinkan menggunakan tanda (>)","info")
            } else if (event.keyCode == 47) {
                event.keyCode = 0;
				swal('Peringatan',"Tidak diizinkan menggunakan tanda (/)","info")
            }
		}




</script>
@endpush
