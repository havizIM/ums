<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="oJVKx8hnoXL22ZOMImzRqBMj084VTP0IxISsCdbg">
    <link rel="icon" href="<?= base_url(''); ?>favicon.ico" type="image/x-icon"> <!-- Favicon-->
    <title>Login | SI-UMS</title>
    <meta name="description" content="Lucid Laravel">
    <meta name="author" content="Lucid Laravel">



    <link rel="stylesheet" href="<?= base_url(''); ?>assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url(''); ?>assets/vendor/font-awesome/css/font-awesome.min.css">

    <!-- Custom Css -->
    <link rel="stylesheet" href="<?= base_url(''); ?>assets/css/main.css">
    <link rel="stylesheet" href="<?= base_url(''); ?>assets/css/color_skins.css">

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
            <div class="m-t-30"><img src="<?= base_url(''); ?>assets/img/logo-icon.svg" width="48" height="48" alt="Lucid"></div>
            <p>Please wait...</p>
        </div>
    </div>

    <div id="wrapper">

      <div class="vertical-align-wrap">
      	<div class="vertical-align-middle auth-main">
      		<div class="auth-box">
            <div class="top">
                <img src="<?= base_url(''); ?>assets/img/logo-white.svg" alt="Lucid">
            </div>

      			<div class="card">
              <div class="body">
                <form class="form-auth-small" action="https://thememakker.com/templates/lucid/laravel/public/dashboard/analytical">
                  <div class="form-group">
                    <label for="signin-email" class="control-label sr-only">NIP</label>
                    <input type="email" class="form-control" id="nip" placeholder="NIP">
                  </div>
                  <div class="form-group">
                    <span class="btn-show-pass">
                      <i class="fa fa-fw fa-eye" style="margin-right: 15px; margin-bottom: 9px;"></i>
                    </span>
                    <label for="signin-password" class="control-label sr-only">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password">
                  </div>
                  <button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
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

    <script type="text/javascript">

      $(document).ready(function(){

        var showPass = 0;
        $('.btn-show-pass').on('click', function(){
          if(showPass == 0) {
            $(this).next('input').attr('type', 'text');
            $(this).find('i').removeClass('fa-eye');
            $(this).find('i').addClass('fa-eye-slash');
            showPass = 1;
          } else {
            $(this).next('input').attr('type', 'password');
            $(this).find('i').addClass('fa-eye');
            $(this).find('i').removeClass('fa-eye-slash');
            showPass = 0;
          }
        });

      });

    </script>

  </body>
</html>
