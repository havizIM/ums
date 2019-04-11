<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta name="csrf-token" content="oJVKx8hnoXL22ZOMImzRqBMj084VTP0IxISsCdbg">

    <link rel="icon" href="<?= base_url(''); ?>favicon.ico" type="image/x-icon"> <!-- Favicon-->

    <title>Admin - UMS</title>

    <meta name="description" content="Lucid Laravel">

    <meta name="author" content="Lucid Laravel">

    <link rel="stylesheet" href="<?= base_url(''); ?>assets/vendor/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="<?= base_url(''); ?>assets/vendor/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?= base_url(''); ?>assets/vendor/jvectormap/jquery-jvectormap-2.0.3.min.css"/>

    <link rel="stylesheet" href="<?= base_url(''); ?>assets/vendor/morrisjs/morris.min.css" />

    <link rel="stylesheet" href="<?= base_url(''); ?>assets/css/main.css">

    <link rel="stylesheet" href="<?= base_url(''); ?>assets/css/color_skins.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css"/>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.bootstrap4.min.css"/>

    <link rel="stylesheet" href="<?= base_url('assets/vendor/toastr/toastr.min.css'); ?>">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script type="text/javascript">

      function cek_auth(){
        var session = localStorage.getItem('ums');
        var auth = JSON.parse(session);

        if(!session) {
          window.location.replace('<?= base_url().'auth' ?>');
        } else {
          if(auth.level !== 'admin'){
            window.location.replace('<?= base_url().'' ?>'+auth.level+'/');
          }
        };
      };

      cek_auth();

    </script>

    <style media="screen">

      .tombol-add {

        margin-left: 507px;

      }

      .tombol-add button {

        background-color: #49c5b6;

      }
    </style>

  </head>

  <body class="theme-cyan">

    <!-- Page Loader -->
    <div class="page-loader-wrapper">
      <div class="loader">
        <div class="m-t-30"><img src="<?= base_url(''); ?>assets/img/favicon-edit.png" width="48" height="48" alt="ums"></div>
        <p>Harap Tunggu...</p>
      </div>
    </div>

    <div id="wrapper">

      <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
          <div class="navbar-btn">
            <button type="button" class="btn-toggle-offcanvas" style="cursor: pointer;"><i class="lnr lnr-menu fa fa-bars"></i></button>
          </div>

        <div class="navbar-brand">
          <a href="#/dashboard"><img src="<?= base_url(''); ?>assets/img/logo.jpg" alt="Osella Logo" class="img-responsive logo"></a>
        </div>

        <div class="navbar-right">
          <a class="btn btn-xs btn-link btn-toggle-fullwidth" style="margin-top: 9px; margin-left: 10px;"><i class="fa fa-bars"></i></a>
          <div id="navbar-menu">
            <ul class="nav navbar-nav">
                <li>
                  <a id="btn_logout" class="icon-menu" style="cursor: pointer;"><i class="icon-login"></i></a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>

      <div id="left-sidebar" class="sidebar">
        <div class="sidebar-scroll">
          <div class="user-account">
            <img src="<?= base_url(''); ?>assets/img/user.png" class="rounded-circle user-photo" alt="User Profile Picture">
            <div class="dropdown">
              <span>Halo,</span>
              <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong class="nama"></strong></a>
              <ul class="dropdown-menu dropdown-menu-right account">
                <li><a href="profile1.html"><i class="icon-user"></i>Profil Saya</a></li>
                <li><a href="javascript:void(0);" id="btn_ganti"><i class="icon-settings"></i>Password</a></li>
              </ul>
            </div>
          </div>

          <div class="tab-content p-l-0 p-r-0" style="margin-top: -25px;">
            <div class="tab-pane active" id="menu">
              <nav id="left-sidebar-nav" class="sidebar-nav">
                <ul id="main-menu" class="metismenu">
                  <li class="">
                    <a href="#/dashboard"><i class="icon-home"></i> <span>Dashboard</span></a>
                  </li>

                  <li>
                    <a href="#/log"><i class="icon-list"></i><span>Log</span></a>
                  </li>

                  <li>
                    <a href="#/divisi"><i class="icon-briefcase"></i><span>Divisi</span></a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>

      <div id="main-content">
        <div class="container-fluid" id="content">
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal_ganti" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="title" id="defaultModalLabel">Ganti Password</h4>
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
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" id="simpan_pass" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

    <script src="<?= base_url(''); ?>assets/bundles/libscripts.bundle.js"></script>

    <script src="<?= base_url(''); ?>assets/bundles/vendorscripts.bundle.js"></script>

    <script src="<?= base_url(''); ?>assets/bundles/morrisscripts.bundle.js"></script>

    <script src="<?= base_url(''); ?>assets/bundles/jvectormap.bundle.js"></script>

    <script src="<?= base_url(''); ?>assets/bundles/knob.bundle.js"></script>

    <script src="<?= base_url(''); ?>assets/bundles/mainscripts.bundle.js"></script>

    <script src="<?= base_url('assets/vendor/moment/moment.js'); ?>"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.2/js/responsive.bootstrap4.min.js"></script>

    <!-- <script src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script> -->

    <script src="<?= base_url('assets/vendor/toastr/toastr.js'); ?>"></script>

    <script type="text/javascript">

      function load_content(link){

        $.get(`<?= base_url('admin/'); ?>${link}`, function(response){
          $('#content').html(response);
        })
      }

      $(document).ready(function(){

        toastr.options = {
          "closeButton": false,
          "debug": false,
          "newestOnTop": false,
          "progressBar": false,
          "positionClass": "toast-top-right",
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

        var link;
        var session = localStorage.getItem('ums');
        var auth = JSON.parse(session);

        $('.nama').text(auth.nama_user);

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

        $('#btn_logout').on('click', function(){
          $.ajax({
            url: '<?= base_url('api/auth/logout_user/') ?>'+auth.token,
            type: 'GET',
            dataType: 'JSON',
            success: function(response){
              localStorage.clear();
              window.location.replace('<?= base_url().'auth' ?>');
            }
          });
        });

        $('#btn_ganti').on('click', function(){
          $('#modal_ganti').modal('show');
        });

        $('#form_ganti').on('submit', function(e){
          e.preventDefault();

          var password_lama = $('#password_lama').val();
          var password_baru = $('#password_baru').val();
          var re_password = $('#re_password').val();

          if(password_lama === '' || password_baru === '') {
            toastr.warning(response.message);
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
                $('#simpan_pass').removeClass('disabled').removeAttr('disabled', 'disabled').text('Ganti');
              },
              error: function(){
                toastr.error('Tidak dapat mengakses server');
              }
            });
          }
        });

      });

    </script>

  </body>
</html>
