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

            <h3 class="profile-username text-center">PPD BERBAH</h3>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Ketua PPD</b> <a class="float-right">Abdul Basir</a>
              </li>
              <li class="list-group-item">
                <b>Ketua Muda Mudi</b> <a class="float-right">Hamba Allah</a>
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
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered" id="statistic-group-level-gender">
                
                    </table>

                    <br>

                    <table class="table table-bordered" id="statistic-group-education-gender">
                
                    </table>
                </div>
            </div>
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
  /* th:first-child, td:first-child
  {
    position:sticky;
    left:0px;
    background-color:rgb(233, 232, 232);
  } */
</style>
@endpush

@push('js')

<script>
$(document).ready(function() {
    get_statistic_by_group_level_gender();
    get_statistic_by_group_education_gender();
});

function get_statistic_by_group_education_gender() {
    debugger
    $.ajax({
        url:"/api/generus/statistika-desa-by-group-education-gender",
        method: 'GET',
        dataType: 'json',
        success: function(response){
            debugger;
            if (response.data != undefined || response.data != null) {
                let table = document.querySelector("#statistic-group-education-gender");

                table.innerHTML = "";

                let row = `<thead>
                            <tr>
                            <th class="text-center">#</th>
                            <th colspan="3" class="text-center">SD</th>
                            <th colspan="3" class="text-center">SMP</th>
                            <th colspan="3" class="text-center">SMA/SMK</th>
                            <th colspan="3" class="text-center">KULIAH</th>
                            <th colspan="3" class="text-center">USMAN</th>
                            </tr>
                        </thead>`;

                row += `<tr>
                    <th class="text-center"></th>
                    <th class="text-center">PUTRA</th>
                    <th class="text-center">PUTRI</th>
                    <th class="text-center">TOTAL</th>
                    <th class="text-center">PUTRA</th>
                    <th class="text-center">PUTRI</th>
                    <th class="text-center">TOTAL</th>
                    <th class="text-center">PUTRA</th>
                    <th class="text-center">PUTRI</th>
                    <th class="text-center">TOTAL</th>
                    <th class="text-center">PUTRA</th>
                    <th class="text-center">PUTRI</th>
                    <th class="text-center">TOTAL</th>
                    <th class="text-center">PUTRA</th>
                    <th class="text-center">PUTRI</th>
                    <th class="text-center">TOTAL</th>
                    </tr>`;

                let groups = response.data.map(function(obj)
                {
                    return obj.group;
                });

                let distinctGroups = groups.filter(function(v,i) { return groups.indexOf(v) == i; });

                let male_sd_total = 0;
                let female_sd_total = 0;
                let male_smp_total = 0;
                let female_smp_total = 0;
                let male_sma_total = 0;
                let female_sma_total = 0;
                let male_kuliah_total = 0;
                let female_kuliah_total = 0;
                let male_usman_total = 0;
                let female_usman_total = 0;

                for(let group of distinctGroups)
                {
                    let groupData = response.data.filter(obj => {
                        return obj.group === group
                    });

                    let male_sd = 0;
                    let female_sd = 0;
                    let male_smp = 0;
                    let female_smp = 0;
                    let male_sma = 0;
                    let female_sma = 0;
                    let male_kuliah = 0;
                    let female_kuliah = 0;
                    let male_usman = 0;
                    let female_usman = 0;

                    for(let i = 0; i < groupData.length; i++) {
                        if (groupData[i].education === 'SD') {
                            male_sd = groupData[i].male; male_sd_total = parseInt(male_sd_total) + parseInt(male_sd);
                            female_sd = groupData[i].female; female_sd_total = parseInt(female_sd_total)+ parseInt(female_sd);
                        } else if (groupData[i].education === 'SMP') {
                            male_smp = groupData[i].male; male_smp_total = parseInt(male_smp_total) + parseInt(male_smp);
                            female_smp = groupData[i].female; female_smp_total = parseInt(female_smp_total) + parseInt(female_smp);
                        } else if (groupData[i].education === 'SMA/SMK') {
                            male_sma = groupData[i].male; male_sma_total = parseInt(male_sma_total) + parseInt(male_sma);
                            female_sma = groupData[i].female; female_sma_total = parseInt(female_sma_total) + parseInt(female_sma);
                        } else if (groupData[i].education === 'KULIAH') {
                            male_kuliah = groupData[i].male; male_kuliah_total = parseInt(male_kuliah_total) + parseInt(male_kuliah);
                            female_kuliah = groupData[i].female; female_kuliah_total = parseInt(female_kuliah_total) + parseInt(female_kuliah);
                        } else if (groupData[i].education === 'USMAN') {
                            male_usman = groupData[i].male; male_usman_total = parseInt(male_usman_total) + parseInt(male_usman);
                            female_usman= groupData[i].female; female_usman_total = parseInt(female_usman_total) + parseInt(female_usman);
                        }
                    }

                    let total_sd = parseInt(male_sd) + parseInt(female_sd);
                    let total_smp = parseInt(male_smp) + parseInt(female_smp);
                    let total_sma = parseInt(male_sma) + parseInt(female_sma);
                    let total_kuliah = parseInt(male_kuliah) + parseInt(female_kuliah);
                    let total_usman = parseInt(male_usman) + parseInt(female_usman);

                    row += `<tr>
                    <td class="text-center">${group}</td>
                    <td class="text-center">${male_sd}</td>
                    <td class="text-center">${female_sd}</td>
                    <td class="text-center"><b>${total_sd}</b></td>
                    <td class="text-center">${male_smp}</td>
                    <td class="text-center">${female_smp}</td>
                    <td class="text-center"><b>${total_smp}</b></td>
                    <td class="text-center">${male_sma}</td>
                    <td class="text-center">${female_sma}</td>
                    <td class="text-center"><b>${total_sma}</b></td>
                    <td class="text-center">${male_kuliah}</td>
                    <td class="text-center">${female_kuliah}</td>
                    <td class="text-center"><b>${total_kuliah}</b></td>
                    <td class="text-center">${male_usman}</td>
                    <td class="text-center">${female_usman}</td>
                    <td class="text-center"><b>${total_usman}</b></td>
                    </tr>`;
                }

                let grand_total_sd = parseInt(male_sd_total) + parseInt(female_sd_total);
                let grand_total_smp = parseInt(male_smp_total) + parseInt(female_smp_total);
                let grand_total_sma = parseInt(male_sma_total) + parseInt(female_sma_total);
                let grand_total_kuliah = parseInt(male_kuliah_total) + parseInt(female_kuliah_total);
                let grand_total_usman = parseInt(male_usman_total) + parseInt(female_usman_total);

                row += `<tr>
                    <td class="text-center"><b>TOTAL</b></td>
                    <td bgcolor="#ececec" class="text-center"><b>${male_sd_total}</b></td>
                    <td bgcolor="#ececec" class="text-center"><b>${female_sd_total}</b></td>
                    <td bgcolor="#c1c0b9" class="text-center"><b>${grand_total_sd}</b></td>
                    <td bgcolor="#ececec" class="text-center"><b>${male_smp_total}</b></td>
                    <td bgcolor="#ececec" class="text-center"><b>${female_smp_total}</b></td>
                    <td bgcolor="#c1c0b9" class="text-center"><b>${grand_total_smp}</b></td>
                    <td bgcolor="#ececec" class="text-center"><b>${male_sma_total}</b></td>
                    <td bgcolor="#ececec" class="text-center"><b>${female_sma_total}</b></td>
                    <td bgcolor="#c1c0b9" class="text-center"><b>${grand_total_sma}</b></td>
                    <td bgcolor="#ececec" class="text-center"><b>${male_kuliah_total}</b></td>
                    <td bgcolor="#ececec" class="text-center"><b>${female_kuliah_total}</b></td>
                    <td bgcolor="#c1c0b9" class="text-center"><b>${grand_total_kuliah}</b></td>
                    <td bgcolor="#ececec" class="text-center"><b>${male_usman_total}</b></td>
                    <td bgcolor="#ececec" class="text-center"><b>${female_usman_total}</b></td>
                    <td bgcolor="#c1c0b9" class="text-center"><b>${grand_total_usman}</b></td>
                    </tr>`;

                  let totalAllGenerus = parseInt(male_sd_total) + parseInt(female_sd_total) + parseInt(male_smp_total) + parseInt(female_smp_total) + parseInt(male_sma_total) +
                  parseInt(female_sma_total) + parseInt(male_kuliah_total) + parseInt(female_kuliah_total) + parseInt(male_usman_total) + parseInt(female_usman_total);

                  row += `<tr>
                          <td colspan="2" class="text-center"> <b>TOTAL GENERUS</b> </td>
                          <td colspan="14" bgcolor="#c1c0b9" class="text-center"><b>${totalAllGenerus}</b></td>
                          </tr>`;

                table.innerHTML = row;
                
            }
        },
        error: function(response) {

        }
    });

}

function get_statistic_by_group_level_gender() {
    debugger
    $.ajax({
        url:"/api/generus/statistika-desa-by-group-level-gender",
        method: 'GET',
        dataType: 'json',
        success: function(response){
            debugger;
            if (response.data != undefined || response.data != null) {
                let table = document.querySelector("#statistic-group-level-gender");

                table.innerHTML = "";

                let row = `<thead>
                            <tr>
                            <th class="text-center">#</th>
                            <th colspan="3" class="text-center">CABERAWIT</th>
                            <th colspan="3" class="text-center">PRAREMAJA</th>
                            <th colspan="3" class="text-center">REMAJA</th>
                            <th colspan="3" class="text-center">USIA NIKAH</th>
                            </tr>
                        </thead>`;

                row += `<tr>
                    <th class="text-center"></th>
                    <th class="text-center">PUTRA</th>
                    <th class="text-center">PUTRI</th>
                    <th class="text-center">TOTAL</th>
                    <th class="text-center">PUTRA</th>
                    <th class="text-center">PUTRI</th>
                    <th class="text-center">TOTAL</th>
                    <th class="text-center">PUTRA</th>
                    <th class="text-center">PUTRI</th>
                    <th class="text-center">TOTAL</th>
                    <th class="text-center">PUTRA</th>
                    <th class="text-center">PUTRI</th>
                    <th class="text-center">TOTAL</th>
                    </tr>`;

                let groups = response.data.map(function(obj)
                {
                    return obj.group;
                });

                let distinctGroups = groups.filter(function(v,i) { return groups.indexOf(v) == i; });

                let male_cr_total = 0;
                let female_cr_total = 0;
                let male_pr_total = 0;
                let female_pr_total = 0;
                let male_r_total = 0;
                let female_r_total = 0;
                let male_unik_total = 0;
                let female_unik_total = 0;

                for(let group of distinctGroups)
                {
                    let groupData = response.data.filter(obj => {
                        return obj.group === group
                    });

                    let male_cr = 0;
                    let female_cr = 0;
                    let male_pr = 0;
                    let female_pr = 0;
                    let male_r = 0;
                    let female_r = 0;
                    let male_unik = 0;
                    let female_unik = 0;

                    for(let i = 0; i < groupData.length; i++) {
                        if (groupData[i].level === 'CABERAWIT') {
                            male_cr = groupData[i].male; male_cr_total = parseInt(male_cr_total) + parseInt(male_cr);
                            female_cr = groupData[i].female; female_cr_total = parseInt(female_cr_total) + parseInt(female_cr);
                        } else if (groupData[i].level === 'PRAREMAJA') {
                            male_pr = groupData[i].male; male_pr_total = parseInt(male_pr_total) + parseInt(male_pr);
                            female_pr = groupData[i].female; female_pr_total = parseInt(female_pr_total) + parseInt(female_pr);
                        } else if (groupData[i].level === 'REMAJA') {
                            male_r = groupData[i].male; male_r_total = parseInt(male_r_total) + parseInt(male_r);
                            female_r = groupData[i].female; female_r_total = parseInt(female_r_total) + parseInt(female_r);
                        } else if (groupData[i].level === 'USIA NIKAH') {
                            male_unik = groupData[i].male; male_unik_total = parseInt(male_unik_total) + parseInt(male_unik);
                            female_unik = groupData[i].female; female_unik_total = parseInt(female_unik_total) + parseInt(female_unik);
                        }
                    }

                    let total_cr = parseInt(male_cr) + parseInt(female_cr);
                    let total_pr = parseInt(male_pr) + parseInt(female_pr);
                    let total_r = parseInt(male_r) + parseInt(female_r);
                    let total_unik = parseInt(male_unik) + parseInt(female_unik);

                    row += `<tr>
                    <td class="text-center">${group}</td>
                    <td class="text-center">${male_cr}</td>
                    <td class="text-center">${female_cr}</td>
                    <td class="text-center"><b>${total_cr}</b></td>
                    <td class="text-center">${male_pr}</td>
                    <td class="text-center">${female_pr}</td>
                    <td class="text-center"><b>${total_pr}</b></td>
                    <td class="text-center">${male_r}</td>
                    <td class="text-center">${female_r}</td>
                    <td class="text-center"><b>${total_r}</b></td>
                    <td class="text-center">${male_unik}</td>
                    <td class="text-center">${female_unik}</td>
                    <td class="text-center"><b>${total_unik}</b></td>
                    </tr>`;
                }

                row += `<tr>
                    <td class="text-center"><b>TOTAL</b></td>
                    <td bgcolor="#ececec" class="text-center"><b>${male_cr_total}</b></td>
                    <td bgcolor="#ececec" class="text-center"><b>${female_cr_total}</b></td>
                    <td bgcolor="#c1c0b9" class="text-center"><b>${parseInt(male_cr_total + female_cr_total)}</b></td>
                    <td bgcolor="#ececec" class="text-center"><b>${male_pr_total}</b></td>
                    <td bgcolor="#ececec" class="text-center"><b>${female_pr_total}</b></td>
                    <td bgcolor="#c1c0b9" class="text-center"><b>${parseInt(male_pr_total + female_pr_total)}</b></td>
                    <td bgcolor="#ececec" class="text-center"><b>${male_r_total}</b></td>
                    <td bgcolor="#ececec" class="text-center"><b>${female_r_total}</b></td>
                    <td bgcolor="#c1c0b9" class="text-center"><b>${parseInt(male_r_total + female_r_total)}</b></td>
                    <td bgcolor="#ececec" class="text-center"><b>${male_unik_total}</b></td>
                    <td bgcolor="#ececec" class="text-center"><b>${female_unik_total}</b></td>
                    <td bgcolor="#c1c0b9" class="text-center"><b>${parseInt(male_unik_total + female_unik_total)}</b></td>
                    </tr>`;

                  let totalAllGenerus = parseInt(male_cr_total + female_cr_total + male_pr_total + female_pr_total + male_r_total +
                  female_r_total + male_unik_total + female_unik_total);

                  row += `<tr>
                          <td colspan="2" class="text-center"> <b>TOTAL GENERUS</b> </td>
                          <td colspan="11" bgcolor="#c1c0b9" class="text-center"><b>${totalAllGenerus}</b></td>
                          </tr>`;

                table.innerHTML = row;
                
            }
        },
        error: function(response) {

        }
    });

}


</script>

@endpush