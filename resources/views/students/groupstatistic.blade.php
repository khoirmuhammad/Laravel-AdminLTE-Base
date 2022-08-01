@extends('layouts.main')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Profile</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">User Profile</li>
        </ol>
      </div>
    </div>
</div><!-- /.container-fluid -->
@endsection

@section('content')
<div id="container-content" class="container-fluid" style="display: none">
    <div class="row">
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle"
                   src="{{ URL::asset('assets/ms-icon-310x310.png') }}"
                   alt="User profile picture">
            </div>

            <h3 id="kbm-name" class="profile-username text-center"></h3>

            <p id="mdt-statistic" class="text-muted text-center"></p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Ketua MDT</b> <p id="mdt-principle" class="float-right"></p>
              </li>
              <li class="list-group-item">
                <b>Ketua KBM</b> <p id="kbm-principle" class="float-right"></p>
              </li>
              <li class="list-group-item">
                <b>Ketua Muda Mudi</b> <p id="mudamudi-principle" class="float-right"></p>
              </li>
            </ul>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- About Me Box -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Tentang KBM</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <strong><i class="fas fa-map-marker-alt mr-1"></i> Sekretariat</strong>

            <p id="kbm-address" class="text-muted">

            </p>

            <hr>

            <strong><i class="fas fa-envelope mr-1"></i> Email</strong>

            <p id="kbm-email" class="text-muted"></p>

            <hr>

            <strong><i class="fas fa-phone-alt mr-1"></i> Kontak</strong>

            <p id="kbm-phone" class="text-muted"></p>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#general" data-toggle="tab">General</a></li>
              <li class="nav-item"><a class="nav-link" href="#caberawit" data-toggle="tab">Caberawit</a></li>
              <li class="nav-item"><a class="nav-link" href="#praremaja" data-toggle="tab">Pra Remaja</a></li>
              <li class="nav-item"><a class="nav-link" href="#remaja" data-toggle="tab">Remaja</a></li>
              <li class="nav-item"><a class="nav-link" href="#unik" data-toggle="tab">Usia Nikah</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="general">
                <table class="table table-bordered" id="general-statistic-level">

                </table>
                <br>
                <table class="table table-bordered" id="general-statistic-education">

                </table>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="caberawit">
                <table class="table table-bordered" id="caberawit-statistic">

                </table>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="praremaja">
                <table class="table table-bordered" id="praremaja-statistic">

                </table>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="remaja">
                <table class="table table-bordered" id="remaja-statistic">

                </table>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="unik">

                <table class="table table-bordered" id="unik-statistic">

                </table>

                <br>

                <table class="table table-bordered" id="unik-statistic-pribumi-status">

                </table>
              </div>
              <!-- /.tab-pane -->

            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->

  <div class="modal fade" id="modal-group">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Pilih PPK / KBM / MDT</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="role-type" value="{{ session('role_type') }}"/>
          <input type="hidden" id="group" value="{{ request()->session()->has('group') ? session('group') : "" }}"/>
          <input type="hidden" id="village" value="{{ request()->session()->has('village') ? session('village') : "" }}"/>
          <div class="col-sm-12">
            <div class="form-group">
              <label>PPK / KBM / MDT</label>
              <select id="kbm-select2" class="form-control select2" style="width: 100%;">
                <option value="" >Pilih</option>
              </select>
            </div>
          </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="button" id="btnSelect" class="btn btn-primary">
              <i id="loading-icon-select" class="fa fa-spinner fa-spin hide"></i>
              <span id="select-text">Pilih</span>
          </button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection

@push('css')
<style>
  /* th:first-child, td:first-child
  {
    position:sticky;
    left:0px;
    background-color:rgb(233, 232, 232);
  } */

  .hide {
        display: none;
    }
</style>

<link rel="stylesheet" href="/adminlte/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
@endpush

@push('js')
<script src="/adminlte/plugins/select2/js/select2.full.min.js"></script>

<script src="/otherjs/sweetalert.js"></script>
    {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}

<script>
$(document).ready(function() {
    $('.select2').select2();

    populate_kbm_select2();

    let roleType = $('#role-type').val();

    if (roleType != 'ppk') {
      $('#modal-group').modal('show');
    } else {

      $('#container-content').show();

      let group = $("#group").val();

      get_group_info(group);

      get_statistic_general_level(group);
      get_statistic_general_education(group);
      get_statistic_caberawit(group);
      get_statistic_praremaja(group);
      get_statistic_remaja(group);
      get_statistic_unik(group);
      get_statistic_unik_pribumi_status(group);
    }

    // Role unless ppk
    $('#btnSelect').on('click', function(){
        var group = $(".select2 option:selected").val();

        if (group == undefined || group == null || group == '') {
          swal("Info", "Silakan pilih PPK / KBM / MDT", "info"); return;
        }

        $('#loading-icon-select').removeClass('hide');
        $('#select-text').text('');

        get_group_info(group);

        get_statistic_general_level(group);
        get_statistic_general_education(group);
        get_statistic_caberawit(group);
        get_statistic_praremaja(group);
        get_statistic_remaja(group);
        get_statistic_unik(group);
        get_statistic_unik_pribumi_status(group);


        $('#loading-icon-select').addClass('hide');
        $('#select-text').text('Pilih');

        $('#modal-group').modal('hide');
        $('#container-content').show();


    });





});

function populate_kbm_select2() {

  let village = $('#village').val();
  let url = village == "" ? "/api/group/group-list" : "/api/group/group-list-by-village/"+ village;
  $.ajax({
    url:url,
    method: 'GET',
    dataType: 'json',
    success: function(response){
      if (response.data != undefined || response.data != null) {
        for(let i = 0; i < response.data.length; i++) {
          $("#kbm-select2").append(`<option value="${response.data[i].id}">${response.data[i].name} - ${response.data[i].kbm_name}</option>`);
        }

      }
    },
    error: function(response) {

    }
  });

}

function get_group_info(group) {
  $.ajax({
    url:"/api/group/group-info/"+ group,
    method: 'GET',
    dataType: 'json',
    success: function(response){
      if (response.data != undefined || response.data != null) {
        let obj = response.data[0];

        $('#kbm-name').html(`${obj.is_mdt ? "MDT " : "KBM "} ${obj.kbm_name}`);
        $('#mdt-statistic').html(obj.mdt_statistic);
        $('#mdt-principle').html(obj.mdt_principle);
        $('#kbm-principle').html(obj.kbm_principle);
        $('#mudamudi-principle').html(obj.muda_mudi_principle);

        $('#kbm-address').html(obj.address);
        $('#kbm-email').html(obj.email);
        $('#kbm-phone').html(obj.hp);

      }
    },
    error: function(response) {

    }
  });
}

function get_statistic_unik_pribumi_status(group) {
  $.ajax({
    url:"/api/generus/statistika-unik-kelompok-by-pribumi-status/"+ group,
    method: 'GET',
    dataType: 'json',
    success: function(response){
      if (response.data != undefined || response.data != null) {
        let unikStatisticTbl = document.querySelector("#unik-statistic-pribumi-status");
        unikStatisticTbl.innerHTML = "";

        let row = `<tr>
                  <th style="width: 30%" class="text-center">PRIBUMI</th>
                  <th style="width: 30%" class="text-center">NON PRIBUMI</th>
                  <th style="width: 40%" class="text-center">TOTAL</th>
                  </tr>`;

        let total_pribumi = response.data[0].total_pribumi[0].total;
        let total_nonpribumi = response.data[0].total_nonpribumi[0].total;
        let totalAll = parseInt(total_pribumi) + parseInt(total_nonpribumi);

        row += `<tr>
                <td class="text-center">` + total_pribumi + `</td>
                <td class="text-center">` + total_nonpribumi + `</td>
                <td class="text-center"><b>` + totalAll + `</b></td>
                </tr>`;

        unikStatisticTbl.innerHTML = row;


      }
    },
    error: function(response) {

    }
  });

}

function get_statistic_unik(group) {
    $.ajax({
        url:"/api/generus/statistika-unik-kelompok/"+ group,
        method: 'GET',
        dataType: 'json',
        success: function(response){
            if (response.data != undefined || response.data != null) {
                debugger;
                let unikStatisticTbl = document.querySelector("#unik-statistic");

                unikStatisticTbl.innerHTML = "";

                let row = `<tr>
                              <th style="width: 10%" class="text-center">#</th>
                              <th style="width: 30%" class="text-center">STATUS PENDIDIKAN</th>
                              <th style="width: 20%" class="text-center">PUTRA</th>
                              <th style="width: 20%" class="text-center">PUTRI</th>
                              <th style="width: 20%" class="text-center">TOTAL</th>
                            </tr>`;

                let no = 1;

                let totalMale = 0;
                let totalFemale = 0;
                let totalAll = 0;

                for(let i = 0; i < response.data.length; i++) {

                    totalMale = parseInt(totalMale) + parseInt(response.data[i].male);
                    totalFemale = parseInt(totalFemale) + parseInt(response.data[i].female);

                    totalAll = parseInt(totalMale) + parseInt(totalFemale);

                    row += `<tr>
                            <td class="text-center">` + no + `</td>
                            <td class="text-center">` + response.data[i].education + `</td>
                            <td class="text-center">` + response.data[i].male + `</td>
                            <td class="text-center">` + response.data[i].female + `</td>
                            <td class="text-center"><b>` + parseInt(response.data[i].male + response.data[i].female)  + `</b></td>
                            </tr>`;
                    totalAll = 0;
                    no++;
                }

                row += `<tr>
                        <td colspan="2" class="text-center"><b>TOTAL</b></td>
                        <td class="text-center"><b>${totalMale}</b></td>
                        <td class="text-center"><b>${totalFemale}</b></td>
                        <td class="text-center"><b>${parseInt(totalMale) + parseInt(totalFemale)}</b></td>
                        </tr>`;

                unikStatisticTbl.innerHTML = row;
            }
        },
        error: function(response) {

        }
    });
}

function get_statistic_remaja(group) {
  $.ajax({
    url:"/api/generus/statistika-remaja-kelompok/"+ group,
    method: 'GET',
    dataType: 'json',
    success: function(response){
      if (response.data != undefined || response.data != null) {
        let remajaStatisticTbl = document.querySelector("#remaja-statistic");

        remajaStatisticTbl.innerHTML = "";

        let row = `<tr>
                  <th style="width: 40%" class="text-center">#</th>
                  <th style="width: 20%" class="text-center">PUTRA</th>
                  <th style="width: 20%" class="text-center">PUTRI</th>
                  <th style="width: 20%" class="text-center">TOTAL</th>
                  </tr>`;

        let total_male = 0;
        let total_female = 0;
        let totalAll = 0;

        for(let i = 0; i < response.data.length; i++) {
          if (response.data[i].gender == "Laki-laki")
            total_male = response.data[i].total;
          else if (response.data[i].gender == "Perempuan")
            total_female = response.data[i].total;
        }

        totalAll = parseInt(total_male) + parseInt(total_female);

        row += `<tr>
                <td class="text-center">REMAJA</td>
                <td class="text-center">` + total_male + `</td>
                <td class="text-center">` + total_female + `</td>
                <td class="text-center"><b>` + totalAll + `</b></td>
                </tr>`;

        remajaStatisticTbl.innerHTML = row;


      }
    },
    error: function(response) {

    }
  });

}

function get_statistic_praremaja(group) {
  $.ajax({
    url:"/api/generus/statistika-praremaja-kelompok/"+ group,
    method: 'GET',
    dataType: 'json',
    success: function(response){
      if (response.data != undefined || response.data != null) {
        let praremajaStatisticTbl = document.querySelector("#praremaja-statistic");

        praremajaStatisticTbl.innerHTML = "";

        let row = `<tr>
                  <th style="width: 40%" class="text-center">#</th>
                  <th style="width: 20%" class="text-center">PUTRA</th>
                  <th style="width: 20%" class="text-center">PUTRI</th>
                  <th style="width: 20%" class="text-center">TOTAL</th>
                  </tr>`;

        let total_male = 0;
        let total_female = 0;
        let totalAll = 0;

        for(let i = 0; i < response.data.length; i++) {
          if (response.data[i].gender == "Laki-laki")
            total_male = response.data[i].total;
          else if (response.data[i].gender == "Perempuan")
            total_female = response.data[i].total;
        }

        totalAll = parseInt(total_male) + parseInt(total_female);

        row += `<tr>
                <td class="text-center">PRAREMAJA</td>
                <td class="text-center">` + total_male + `</td>
                <td class="text-center">` + total_female + `</td>
                <td class="text-center"><b>` + totalAll + `</b></td>
                </tr>`;

        praremajaStatisticTbl.innerHTML = row;


      }
    },
    error: function(response) {

    }
  });

}

function get_statistic_caberawit(group) {
    $.ajax({
        url:"/api/generus/statistika-caberawit-kelompok/"+ group,
        method: 'GET',
        dataType: 'json',
        success: function(response){
            if (response.data != undefined || response.data != null) {

                let caberawitStatisticTbl = document.querySelector("#caberawit-statistic");

                caberawitStatisticTbl.innerHTML = "";

                let row = `<tr>
                              <th style="width: 10%" class="text-center">#</th>
                              <th style="width: 30%" class="text-center">KELAS</th>
                              <th style="width: 20%" class="text-center">PUTRA</th>
                              <th style="width: 20%" class="text-center">PUTRI</th>
                              <th style="width: 20%" class="text-center">TOTAL</th>
                            </tr>`;

                let no = 1;

                let totalMale = 0;
                let totalFemale = 0;
                let totalAll = 0;

                for(let i = 0; i < response.data.length; i++) {

                    totalMale = parseInt(totalMale) + parseInt(response.data[i].male);
                    totalFemale = parseInt(totalFemale) + parseInt(response.data[i].female);
                    totalAll = parseInt(response.data[i].male) + parseInt(response.data[i].female);

                    row += `<tr>
                            <td class="text-center">` + no + `</td>
                            <td class="text-center">` + response.data[i].class + `</td>
                            <td class="text-center">` + response.data[i].male + `</td>
                            <td class="text-center">` + response.data[i].female + `</td>
                            <td class="text-center"><b>` + totalAll + `</b></td>
                            </tr>`;
                    totalAll = 0;
                    no++;
                }

                row += `<tr>
                        <td colspan="2" class="text-center"><b>TOTAL</b></td>
                        <td class="text-center"><b>${totalMale}</b></td>
                        <td class="text-center"><b>${totalFemale}</b></td>
                        <td class="text-center"><b>${parseInt(totalMale) + parseInt(totalFemale)}</b></td>
                        </tr>`;

                caberawitStatisticTbl.innerHTML = row;
            }
        },
        error: function(response) {

        }
    });
}

function get_statistic_general_education(group) {
    $.ajax({
        url:"/api/generus/statistika-general-kelompok-by-education/"+ group,
        method: 'GET',
        dataType: 'json',
        success: function(response){
            if (response.data != undefined || response.data != null) {

                let generalStatisticTbl = document.querySelector("#general-statistic-education");

                generalStatisticTbl.innerHTML = "";

                let row = `<tr>
                              <th style="width: 10%" class="text-center">#</th>
                              <th style="width: 30%" class="text-center">STATUS PENDIDIKAN</th>
                              <th style="width: 20%" class="text-center">PUTRA</th>
                              <th style="width: 20%" class="text-center">PUTRI</th>
                              <th style="width: 20%" class="text-center">TOTAL</th>
                            </tr>`;

                let no = 1;

                let totalMale = 0;
                let totalFemale = 0;
                let totalAll = 0;

                for(let i = 0; i < response.data.length; i++) {

                    totalMale = parseInt(totalMale) + parseInt(response.data[i].male);
                    totalFemale = parseInt(totalFemale) + parseInt(response.data[i].female);
                    totalAll = parseInt(response.data[i].male) + parseInt(response.data[i].female);

                    row += `<tr>
                            <td class="text-center">` + no + `</td>
                            <td class="text-center">` + response.data[i].education + `</td>
                            <td class="text-center">` + response.data[i].male + `</td>
                            <td class="text-center">` + response.data[i].female + `</td>
                            <td class="text-center"><b>` + totalAll+ `</b></td>
                            </tr>`;
                    totalAll = 0;
                    no++;
                }

                row += `<tr>
                        <td colspan="2" class="text-center"><b>TOTAL</b></td>
                        <td class="text-center"><b>${totalMale}</b></td>
                        <td class="text-center"><b>${totalFemale}</b></td>
                        <td class="text-center"><b>${parseInt(totalMale) + parseInt(totalFemale)}</b></td>
                        </tr>`;

                generalStatisticTbl.innerHTML = row;
            }
        },
        error: function(response) {

        }
    });
}

function get_statistic_general_level(group) {

    $.ajax({
        url:"/api/generus/statistika-general-kelompok-by-level/" + group,
        method: 'GET',
        dataType: 'json',
        success: function(response){
            if (response.data != undefined || response.data != null) {

                let generalStatisticTbl = document.querySelector("#general-statistic-level");

                generalStatisticTbl.innerHTML = "";

                let row = `<tr>
                              <th style="width: 10%" class="text-center">#</th>
                              <th style="width: 30%" class="text-center">JENJANG</th>
                              <th style="width: 20%" class="text-center">PUTRA</th>
                              <th style="width: 20%" class="text-center">PUTRI</th>
                              <th style="width: 20%" class="text-center">TOTAL</th>
                            </tr>`;

                let no = 1;

                let totalMale = 0;
                let totalFemale = 0;
                let totalAll = 0;

                for(let i = 0; i < response.data.length; i++) {

                    totalMale = parseInt(totalMale) + parseInt(response.data[i].male);
                    totalFemale = parseInt(totalFemale) + parseInt(response.data[i].female);
                    totalAll = parseInt(response.data[i].male) + parseInt(response.data[i].female);

                    row += `<tr>
                            <td class="text-center">` + no + `</td>
                            <td class="text-center">` + response.data[i].level + `</td>
                            <td class="text-center">` + response.data[i].male + `</td>
                            <td class="text-center">` + response.data[i].female + `</td>
                            <td class="text-center"><b>` + totalAll + `</b></td>
                            </tr>`;

                    totalAll = 0;
                    no++;
                }

                row += `<tr>
                        <td colspan="2" class="text-center"><b>TOTAL</b></td>
                        <td class="text-center"><b>${totalMale}</b></td>
                        <td class="text-center"><b>${totalFemale}</b></td>
                        <td class="text-center"><b>${parseInt(totalMale) + parseInt(totalFemale)}</b></td>
                        </tr>`;

                generalStatisticTbl.innerHTML = row;
            }
        },
        error: function(response) {

        }
    });
}

</script>
@endpush
