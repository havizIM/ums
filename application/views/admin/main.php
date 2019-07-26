
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title>SIPACAR - Admin</title>
  <!--favicon-->
  <link rel="icon" href="<?= base_url() ?>assets/images/logo-osella.png" type="image/x-icon">
  <!--Full Calendar Css-->
  <link href="<?= base_url() ?>assets/plugins/fullcalendar/css/fullcalendar.min.css" rel='stylesheet'/>
  <!-- simplebar CSS-->
  <link href="<?= base_url() ?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>
  <!-- Bootstrap core CSS-->
  <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="<?= base_url() ?>assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="<?= base_url() ?>assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <!-- Sidebar CSS-->
  <link href="<?= base_url() ?>assets/css/sidebar-menu.css" rel="stylesheet"/>
  <!-- Custom Style-->
  <link href="<?= base_url() ?>assets/css/app-style.css" rel="stylesheet"/>

  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/plugins/jquery.steps/css/jquery.steps.css">
  <link href="<?= base_url() ?>assets/plugins/dropzone/css/dropzone.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url() ?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert/sweetalert.css') ?>">
  <link href="<?= base_url() ?>assets/plugins/fullcalendar/css/fullcalendar.min.css" rel='stylesheet'/>

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.bootstrap4.min.css"/>

  <style>
    .wizard > .content > .body {
        float: left;
        position: relative !important;
        width: 95%;
        padding: 2.5%;
    }

    .wizard > .steps > ul > li {
        width: 33.33% !important;
    }

    .custom-select.is-invalid, .form-control.is-invalid, .was-validated .custom-select:invalid, .was-validated .form-control:invalid {
      border-color: #dc3545 !important;
    }
  </style>


  <script type="text/javascript">

    var session = localStorage.getItem('ums');
    var auth = JSON.parse(session);

    if(!session) {
      window.location.replace('<?= base_url().'auth' ?>');
    } else {
      if(auth.level !== 'admin'){
        window.location.replace('<?= base_url().'' ?>'+auth.level+'/');
      }
    };

  </script>

</head>

<body>

<!-- Start wrapper-->
 <div id="wrapper">

   <!--Start sidebar-wrapper-->
   <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
     <div class="brand-logo">
      <a href="">
       <img src="<?= base_url() ?>assets/images/logo-osella.png" class="logo-icon" alt="logo icon" style="width: 10%;">
       <h5 class="logo-text"><img src="<?= base_url() ?>assets/images/logo1.jpg" class="img" alt="logo icon" style="width: 160px; height: 45px;"></h5>
     </a>
	 </div>
	 <ul class="sidebar-menu do-nicescrol">
      <li class="sidebar-header">MAIN NAVIGATION</li>
      <li>
        <a href="#/dashboard" class="waves-effect">
          <i class="icon-home"></i> <span>Dashboard</span>
        </a>
      </li>

      <li>
        <a href="#" class="waves-effect">
          <i class="icon-layers"></i> <span>Master</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="#/karyawan"><i class="fa fa-circle-o"></i> Master Karyawan</a></li>
          <li><a href="#/master_cuti"><i class="fa fa-circle-o"></i> Master Cuti</a></li>
          <li><a href="#/master_izin"><i class="fa fa-circle-o"></i> Master Izin</a></li>
          <li><a href="#/master_cuti_bersama"><i class="fa fa-circle-o"></i> Master Cuti Bersama</a></li>
        </ul>
      </li>

      <li>
        <a href="#" class="waves-effect">
          <i class="icon-layers"></i> <span>Pengajuan</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="#/cuti"><i class="fa fa-circle-o"></i> Cuti</a></li>
          <li><a href="#/izin"><i class="fa fa-circle-o"></i> Izin</a></li>
          <li><a href="#/revisi_absen"><i class="fa fa-circle-o"></i> Revisi Absen</a></li>
        </ul>
      </li>

      <li>
        <a href="#" class="waves-effect">
          <i class="icon-layers"></i> <span>Approval</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="#/approval_pengganti"><i class="fa fa-circle-o"></i> Approval Pengganti</a></li>
        </ul>
      </li>

      <li>
        <a href="#" class="waves-effect">
          <i class="icon-layers"></i> <span>Absensi</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="#/import_absensi"><i class="fa fa-circle-o"></i> Import Absensi</a></li>
          <li><a href="#/cetak_absensi"><i class="fa fa-circle-o"></i> Cetak Absensi</a></li>
        </ul>
      </li>

      <li>
        <a href="#/log" class="waves-effect">
          <i class="icon-support"></i> <span>Log</span>
        </a>
      </li>

    </ul>

   </div>
   <!--End sidebar-wrapper-->

<!--Start topbar header-->
<header class="topbar-nav">
 <nav class="navbar navbar-expand fixed-top gradient-scooter">
  <ul class="navbar-nav mr-auto align-items-center">
    <li class="nav-item">
      <a class="nav-link toggle-menu" href="javascript:void();">
       <i class="icon-menu menu-icon"></i>
     </a>
    </li>
  </ul>

  <ul class="navbar-nav align-items-center right-nav-link">
    <li class="nav-item">
      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="calendar.html#">
        <span class="user-profile"><img id="foto" class="img-circle" alt="user avatar"></span>
      </a>
      <ul class="dropdown-menu dropdown-menu-right">
       <li class="dropdown-item user-details">
        <a href="javaScript:void();">
           <div class="media">
             <div class="avatar"><img class="align-self-start mr-3" id="test" alt="user avatar"></div>
            <div class="media-body">
            <h6 class="mt-2 user-title" id="session_name"></h6>
            <p class="user-subtitle" id="session_jabatan"></p>
            </div>
           </div>
          </a>
        </li>
        <li class="dropdown-divider"></li>
        <li class="dropdown-item"><a style="width: 100%; height: 100%;" href="#/profil"><i class="zmdi zmdi-accounts-list" style="padding-right: 9px;"></i> Profil</a></li>
        <li class="dropdown-divider"></li>
        <li class="dropdown-item"><a href="javaScript:void();" id="ganti_pass" data-toggle="modal" data-target="#modal_ganti"><i class="icon-settings mr-2"></i> Ganti Password</a></li>
        <li class="dropdown-divider"></li>
        <li class="dropdown-item"><a href="javaScript:void();" id="logout"><i class="icon-power mr-2"></i> Logout</a></li>
      </ul>
    </li>
  </ul>
</nav>
</header>
<!--End topbar header-->

<div class="clearfix"></div>

  <div class="content-wrapper">
    <div class="container-fluid" id="content">


    </div>
   </div>

   <div class="modal fade" id="modal_ganti">
    <div class="modal-dialog">
      <div class="modal-content animated slideInUp">
        <div class="modal-header">
          <h5 class="modal-title"> Ganti Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form class="form-horizontal" id="form_ganti" method="post">
          <div class="modal-body form-group">
            <div class="form-group">
              <input type="password" class="form-control" id="password_lama" name="password_lama" placeholder="Password Lama">
            </div>

            <div class="form-group">
              <input type="password" class="form-control" id="password_baru" name="password_baru" placeholder="Password Baru">
            </div>

            <div class="form-group">
              <input type="password" class="form-control" id="re_password" name="re_password" placeholder="Konfirmasi Password">
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
            <button type="submit" id="simpan_pass" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->

	<!--Start footer-->
	<footer class="footer">
      <div class="container">
        <div class="text-center">
          PT. CKSM SIPACAR | By Riska
        </div>
      </div>
    </footer>
	<!--End footer-->

  </div><!--End wrapper-->
  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>

  <script src="<?= base_url() ?>assets/js/popper.min.js"></script>

  <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
  <!-- simplebar js -->
  <script src="<?= base_url() ?>assets/plugins/simplebar/js/simplebar.js"></script>
  <!-- waves effect js -->
  <script src="<?= base_url() ?>assets/js/waves.js"></script>
  <!-- sidebar-menu js -->
  <script src="<?= base_url() ?>assets/js/sidebar-menu.js"></script>
  <!-- Custom scripts -->
  <script src="<?= base_url() ?>assets/js/app-script.js"></script>

  <script src="<?= base_url() ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  <!-- Full Calendar -->
  <script src='<?= base_url() ?>assets/plugins/fullcalendar/js/moment.min.js'></script>

  <script src='<?= base_url() ?>assets/plugins/fullcalendar/js/fullcalendar.min.js'></script>

  <link href="<?= base_url() ?>assets/plugins/toastr/toastr.min.css" rel="stylesheet"/>

  <script src="<?= base_url() ?>assets/plugins/sweetalert/sweetalert.min.js"></script>

  <script src="<?= base_url() ?>assets/plugins/dropzone/js/dropzone.js"></script>
  <script src="<?= base_url() ?>assets/plugins/jquery.PrintArea.js"></script>
  <script src="<?= base_url() ?>assets/plugins/Chart.js/Chart.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/jquery.steps/js/jquery.steps.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

  <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.2/js/responsive.bootstrap4.min.js"></script>

  <script src="<?= base_url() ?>assets/plugins/toastr/toastr.js"></script>
  <script src="https://js.pusher.com/4.4/pusher.min.js"></script>

  <script type="text/javascript">

    function load_content(link){

      $.get(`<?= base_url('admin/'); ?>${link}`, function(response){
        $('#content').html(response);
      })
    }

    $(document).ready(function(){
      var link;

      toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }

      $('#session_name').text(auth.nama_user)
      $('#session_jabatan').text(auth.jabatan)
      $('#foto').attr('src', `<?= base_url() ?>doc/foto/${auth.foto}`);
      $('#test').attr('src', `<?= base_url() ?>doc/foto/${auth.foto}`);

      if(location.hash){
        link = location.hash.substr(2);
        load_content(link);
      } else {
        location.hash = '#/dashboard'
      }

      $(window).on('hashchange', function(){
        link = location.hash.substr(2);
        load_content(link);
      })

      $('#logout').on('click', function(){

        swal({
          title: "Apa Anda yakin ingin keluar?",
          icon: "warning",
          dangerMode: true,
          showCancelButton: true,
          closeOnConfirm: false,
          closeOnCancel: true,
          confirmButtonColor: "#DD6B55",
          cancelButtonText: "Tidak",
          confirmButtonText: "Ya",
          showLoaderOnConfirm: true
        }, function (isConfirm){
          if (isConfirm) {
            $.ajax({
              url: '<?= base_url('api/auth/logout_user/') ?>'+auth.token,
              type: 'GET',
              dataType: 'JSON',
              success: function(response){
                localStorage.clear();
                window.location.replace('<?= base_url().'' ?>');
              }
            });
          }
        })
      });

      $('#ganti_pass').on('click', function(){
        $('#modal_ganti').modal('show');
      })

      $('#form_ganti').on('submit', function(e){
        e.preventDefault();

        var password_lama = $('#password_lama').val();
        var password_baru = $('#password_baru').val();
        var re_password = $('#re_password').val();

        if(password_lama === '' || password_baru === '') {
          toastr.warning('Mohon isi datanya');
        } else if (password_baru !== re_password) {
          toastr.warning('Password belum sama');
        } else {
          $.ajax({
            url: '<?= base_url('api/auth/password_user/') ?>'+auth.token,
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function(){
              $('#simpan_pass').addClass('disabled').attr('disabled', 'disabled').html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
            },
            data: {
              password_lama: password_lama,
              password_baru: password_baru
            },
            success: function(response){
              if(response.status === 200){
                toastr.success(response.message);
                $('#form_ganti')[0].reset();
                $('#modal_ganti').modal('hide');
              } else {
                toastr.error('Tidak dapat mengakses server');
              }
              $('#simpan_pass').removeClass('disabled').removeAttr('disabled', 'disabled').text('Simpan');
            },
            error: function(){
              toastr.error('Tidak dapat mengakses server');
              $('#simpan_pass').removeClass('disabled').removeAttr('disabled', 'disabled').text('Simpan');
            }
          })
        }
      })


    })

  </script>

</body>
</html>
