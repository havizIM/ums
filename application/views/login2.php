<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta name="csrf-token" content="oJVKx8hnoXL22ZOMImzRqBMj084VTP0IxISsCdbg">

    <link rel="icon" href="<?= base_url(''); ?>favicon-edit.png" type="image/png"> <!-- Favicon-->

    <title>Login | SI-UMS</title>

    <meta name="description" content="Lucid Laravel">

    <meta name="author" content="Lucid Laravel">

    <link rel="stylesheet" href="<?= base_url(''); ?>assets/vendor/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="<?= base_url(''); ?>assets/vendor/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?= base_url(''); ?>assets/css/main.css">

    <link rel="stylesheet" href="<?= base_url(''); ?>assets/css/color_skins.css">

    <link rel="stylesheet" href="<?= base_url('assets/vendor/toastr/toastr.min.css'); ?>">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script type="text/javascript">

      function cek_auth(){
        var session = localStorage.getItem('ums');
        var auth = JSON.parse(session);

        if (session) {
          window.location.replace('<?= base_url() ?>'+auth.level+'/')
        };
      };

      cek_auth();

    </script>

    <style media="screen">

      .btn-show-pass {
        font-size: 15px;
        color: #999999;

        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        align-items: center;
        position: absolute;
        height: 100%;
        top: 0;
        right: 0;
        padding-right: 5px;
        margin-right: 13px;
        cursor: pointer;
        -webkit-transition: all 0.4s;
        -o-transition: all 0.4s;
        -moz-transition: all 0.4s;
        transition: all 0.4s;
      }

      .btn-show-pass:hover {
        color: #6a7dfe;
        color: -webkit-linear-gradient(left, #21d4fd, #b721ff);
        color: -o-linear-gradient(left, #21d4fd, #b721ff);
        color: -moz-linear-gradient(left, #21d4fd, #b721ff);
        color: linear-gradient(left, #21d4fd, #b721ff);
      }

      .btn-show-pass.active {
        color: #6a7dfe;
        color: -webkit-linear-gradient(left, #21d4fd, #b721ff);
        color: -o-linear-gradient(left, #21d4fd, #b721ff);
        color: -moz-linear-gradient(left, #21d4fd, #b721ff);
        color: linear-gradient(left, #21d4fd, #b721ff);
      }

    </style>

  </head>

  <body class="theme-cyan">

    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30"><img src="<?= base_url(''); ?>assets/img/favicon-edit.png" width="48" height="48" alt="Lucid"></div>
            <p>Harap tunggu...</p>
        </div>
    </div>

    <div id="wrapper">

      <div class="vertical-align-wrap">
      	<div class="vertical-align-middle auth-main">
      		<div class="auth-box">
            <div class="top">
              <img src="<?= base_url(''); ?>assets/img/logo.jpg" alt="osella" style="border-radius: 10px;">
            </div>

      			<div class="card">
              <div class="body">
                <form class="form-auth-small" id="form_login">
                  <div class="form-group">
                    <input type="text" class="form-control" id="nik" name="nik" placeholder="NIK">
                  </div>
                  <div class="form-group">
                    <span class="btn-show-pass">
                      <i class="fa fa-fw fa-eye" style="margin-right: 15px; margin-bottom: 9px;"></i>
                    </span>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                  </div>
                  <button type="submit" class="btn btn-primary btn-lg btn-block" id="btn_login">LOGIN</button>
                </form>
              </div>
            </div>
      		</div>
      	</div>
      </div>

    </div>

    <script src="<?= base_url(''); ?>assets/bundles/libscripts.bundle.js"></script>

    <script src="<?= base_url(''); ?>assets/bundles/vendorscripts.bundle.js"></script>

    <script src="<?= base_url(''); ?>assets/bundles/mainscripts.bundle.js"></script>

    <script src="<?= base_url('assets/vendor/toastr/toastr.js'); ?>"></script>

    <script type="text/javascript">

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

        var showPass = 0;
        $('.btn-show-pass').on('click', function(){
          if(showPass == 0) {
            $('#password').attr('type', 'text');
            $(this).find('i').removeClass('fa-eye');
            $(this).find('i').addClass('fa-eye-slash');
            showPass = 1;
          } else {
            $('#password').attr('type', 'password');
            $(this).find('i').addClass('fa-eye');
            $(this).find('i').removeClass('fa-eye-slash');
            showPass = 0;
          }
        });

        $('#form_login').on('submit', function(e){
          e.preventDefault();

          var nik = $('#nik').val();
          var password = $('#password').val();

          if (nik === '' || password === ''){
            toastr.warning(response.message);
          } else {
            $.ajax({
              url: '<?= base_url('api/auth/login_user') ?>',
              type: 'POST',
              dataType: 'JSON',
              beforeSend: function(){
                $('#btn_login').addClass('disabled').attr('disabled', 'disabled').html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
              },
              data: $('#form_login').serialize(),
              success: function(response){
                if(response.status === 200){
                  localStorage.setItem('ums', JSON.stringify(response.data));
                  var link = '<?= base_url('') ?>'+response.data.level+'/'
                  window.location.replace(link);
                } else {
                  toastr.error(response.message, response.description);
                }
                $('#btn_login').removeClass('disabled').removeAttr('disabled', 'disabled').text('Masuk');
              },
              error: function(){
                toastr.error('Tidak dapat mengakses server');
                $('#btn_login').removeClass('disabled').removeAttr('disabled', 'disabled').text('Masuk');
              }
            });
          }
        });

      });

    </script>

  </body>
</html>
