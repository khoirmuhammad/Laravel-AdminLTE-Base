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
<div class="container-fluid">
    <div class="row">
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle"
                   src="/adminlte/dist/img/user4-128x128.jpg"
                   alt="User profile picture">
            </div>

            <h3 class="profile-username text-center">MDT Al A'laa</h3>

            <p class="text-muted text-center">No. Statistik 311234040101</p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Ketua MDT</b> <a class="float-right">H. Arwanto</a>
              </li>
              <li class="list-group-item">
                <b>Ketua KBM</b> <a class="float-right">Muhammad Khoirudin</a>
              </li>
              <li class="list-group-item">
                <b>Ketua Muda Mudi</b> <a class="float-right">Achmad Choirul S</a>
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

            <p class="text-muted">
              Karangtengah RT 01, RW 57 Sendangtirto, Berbah, Sleman
            </p>

            <hr>

            <strong><i class="fas fa-envelope mr-1"></i> Email</strong>

            <p class="text-muted">mk.muhammadkhoirudin@gmail.com</p>

            <hr>

            <strong><i class="fas fa-phone-alt mr-1"></i> Kontak</strong>

            <p class="text-muted">+6281385247038</p>
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
@endsection

@push('css')
<style>
  th:first-child, td:first-child
  {
    position:sticky;
    left:0px;
    background-color:rgb(233, 232, 232);
  }
</style>
@endpush

@push('js')
<script>
$(document).ready(function() {

    get_statistic_general_level();
    get_statistic_general_education();
    get_statistic_caberawit();
    get_statistic_praremaja();
    get_statistic_remaja();
    get_statistic_unik();
    get_statistic_unik_pribumi_status();

});

function get_statistic_unik_pribumi_status() {
  $.ajax({
    url:"/api/generus/statistika-unik-kelompok-by-pribumi-status",
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

        row += `<tr>
                <td class="text-center">` + total_pribumi + `</td>
                <td class="text-center">` + total_nonpribumi + `</td>
                <td class="text-center"><b>` + parseInt(total_pribumi + total_nonpribumi) + `</b></td>
                </tr>`;

        unikStatisticTbl.innerHTML = row;


      }
    },
    error: function(response) {

    }
  });

}

function get_statistic_unik() {
    $.ajax({
        url:"/api/generus/statistika-unik-kelompok",
        method: 'GET',
        dataType: 'json',
        success: function(response){
            if (response.data != undefined || response.data != null) {

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

                for(let i = 0; i < response.data.length; i++) {

                    totalMale = parseInt(totalMale + response.data[i].male);
                    totalFemale = parseInt(totalFemale + response.data[i].female);

                    row += `<tr>
                            <td class="text-center">` + no + `</td>
                            <td class="text-center">` + response.data[i].education + `</td>
                            <td class="text-center">` + response.data[i].male + `</td>
                            <td class="text-center">` + response.data[i].female + `</td>
                            <td class="text-center"><b>` + parseInt(response.data[i].male + response.data[i].female) + `</b></td>
                            </tr>`;
                    no++;
                }

                row += `<tr>
                        <td colspan="2" class="text-center"><b>TOTAL</b></td>
                        <td class="text-center"><b>${totalMale}</b></td>
                        <td class="text-center"><b>${totalFemale}</b></td>
                        <td class="text-center"><b>${parseInt(totalMale + totalFemale)}</b></td>
                        </tr>`;

                unikStatisticTbl.innerHTML = row;
            }
        },
        error: function(response) {
            debugger;
        }
    });
}

function get_statistic_remaja() {
  $.ajax({
    url:"/api/generus/statistika-remaja-kelompok",
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

        for(let i = 0; i < response.data.length; i++) {
          if (response.data[i].gender == "Laki-laki")
            total_male = response.data[i].total;
          else if (response.data[i].gender == "Perempuan")
            total_female = response.data[i].total;
        }

        row += `<tr>
                <td class="text-center">REMAJA</td>
                <td class="text-center">` + total_male + `</td>
                <td class="text-center">` + total_female + `</td>
                <td class="text-center"><b>` + parseInt(total_male + total_female) + `</b></td>
                </tr>`;

        remajaStatisticTbl.innerHTML = row;


      }
    },
    error: function(response) {

    }
  });

}

function get_statistic_praremaja() {
  $.ajax({
    url:"/api/generus/statistika-praremaja-kelompok",
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

        for(let i = 0; i < response.data.length; i++) {
          if (response.data[i].gender == "Laki-laki")
            total_male = response.data[i].total;
          else if (response.data[i].gender == "Perempuan")
            total_female = response.data[i].total;
        }

        row += `<tr>
                <td class="text-center">PRAREMAJA</td>
                <td class="text-center">` + total_male + `</td>
                <td class="text-center">` + total_female + `</td>
                <td class="text-center"><b>` + parseInt(total_male + total_female) + `</b></td>
                </tr>`;

        praremajaStatisticTbl.innerHTML = row;


      }
    },
    error: function(response) {

    }
  });

}

function get_statistic_caberawit() {
    $.ajax({
        url:"/api/generus/statistika-caberawit-kelompok",
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

                for(let i = 0; i < response.data.length; i++) {

                    totalMale = parseInt(totalMale + response.data[i].male);
                    totalFemale = parseInt(totalFemale + response.data[i].female);

                    row += `<tr>
                            <td class="text-center">` + no + `</td>
                            <td class="text-center">` + response.data[i].class + `</td>
                            <td class="text-center">` + response.data[i].male + `</td>
                            <td class="text-center">` + response.data[i].female + `</td>
                            <td class="text-center"><b>` + parseInt(response.data[i].male + response.data[i].female) + `</b></td>
                            </tr>`;
                    no++;
                }

                row += `<tr>
                        <td colspan="2" class="text-center"><b>TOTAL</b></td>
                        <td class="text-center"><b>${totalMale}</b></td>
                        <td class="text-center"><b>${totalFemale}</b></td>
                        <td class="text-center"><b>${parseInt(totalMale + totalFemale)}</b></td>
                        </tr>`;

                caberawitStatisticTbl.innerHTML = row;
            }
        },
        error: function(response) {
            debugger;
        }
    });
}

function get_statistic_general_education() {
    $.ajax({
        url:"/api/generus/statistika-general-kelompok-by-education",
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

                for(let i = 0; i < response.data.length; i++) {

                    totalMale = parseInt(totalMale + response.data[i].male);
                    totalFemale = parseInt(totalFemale + response.data[i].female);

                    row += `<tr>
                            <td class="text-center">` + no + `</td>
                            <td class="text-center">` + response.data[i].education + `</td>
                            <td class="text-center">` + response.data[i].male + `</td>
                            <td class="text-center">` + response.data[i].female + `</td>
                            <td class="text-center"><b>` + parseInt(response.data[i].male + response.data[i].female) + `</b></td>
                            </tr>`;
                    no++;
                }

                row += `<tr>
                        <td colspan="2" class="text-center"><b>TOTAL</b></td>
                        <td class="text-center"><b>${totalMale}</b></td>
                        <td class="text-center"><b>${totalFemale}</b></td>
                        <td class="text-center"><b>${parseInt(totalMale + totalFemale)}</b></td>
                        </tr>`;

                generalStatisticTbl.innerHTML = row;
            }
        },
        error: function(response) {
            debugger;
        }
    });
}

function get_statistic_general_level() {
  debugger;
    $.ajax({
        url:"/api/generus/statistika-general-kelompok-by-level",
        method: 'GET',
        dataType: 'json',
        success: function(response){
            if (response.data != undefined || response.data != null) {
                debugger;
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

                for(let i = 0; i < response.data.length; i++) {

                    totalMale = parseInt(totalMale + response.data[i].male);
                    totalFemale = parseInt(totalFemale + response.data[i].female);

                    row += `<tr>
                            <td class="text-center">` + no + `</td>
                            <td class="text-center">` + response.data[i].level + `</td>
                            <td class="text-center">` + response.data[i].male + `</td>
                            <td class="text-center">` + response.data[i].female + `</td>
                            <td class="text-center"><b>` + parseInt(response.data[i].male + response.data[i].female) + `</b></td>
                            </tr>`;
                    no++;
                }

                row += `<tr>
                        <td colspan="2" class="text-center"><b>TOTAL</b></td>
                        <td class="text-center"><b>${totalMale}</b></td>
                        <td class="text-center"><b>${totalFemale}</b></td>
                        <td class="text-center"><b>${parseInt(totalMale + totalFemale)}</b></td>
                        </tr>`;

                generalStatisticTbl.innerHTML = row;
            }
        },
        error: function(response) {
            debugger;
        }
    });
}

</script>
@endpush