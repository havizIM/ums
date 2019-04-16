
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title>UMS - Login</title>
  <!--favicon-->
  <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
  <!-- Bootstrap core CSS-->
  <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="<?= base_url() ?>assets/plugins/toastr/toastr.min.css" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="<?= base_url() ?>assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="<?= base_url() ?>assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <!-- Custom Style-->
  <link href="<?= base_url() ?>assets/css/app-style.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <script type="text/javascript">
    var session = localStorage.getItem('lion_membership');
    var auth = JSON.parse(session);

    if(session){
      window.location.replace(`<?= base_url() ?>${auth.level}/`)
    }
  </script>

</head>

<body style="background-image: url('<?= base_url('assets/images/login.jpg') ?>'); background-size: cover;">
 <!-- Start wrapper-->
 <div id="wrapper">
	   <div class="card-authentication2 mx-auto my-5">
	    <div class="card-group">
	    	<div class="card mb-0">
	    	   <div class="bg-signin2"></div>
	    		<div class="card-img-overlay rounded-left my-5">
                 <!-- <h2 class="text-white">User Management System</h2> -->
                 <h1 class="text-white">User Management System</h1>
                 <p class="card-text text-white pt-3">PT. Cipta Kreasi Sandang Mandiri</p>
             </div>
	    	</div>

	    	<div class="card mb-0 ">
	    		<div class="card-body">
	    			<div class="card-content p-3">
	    				<div class="text-center">
					 		<img src="<?= base_url() ?>assets/images/logo-login.png" style="width: 70%;">
					 	</div>
					 <div class="card-title text-uppercase text-center py-3">Log In</div>
					   <form id="form_login">
						  <div class="form-group">
						   <div class="position-relative has-icon-left">
							   <label for="nik" class="sr-only">Username</label>
								 <input type="text" id="nik" name="nik" class="form-control" placeholder="NIK">
								 <div class="form-control-position">
									<i class="icon-user"></i>
								</div>
						   </div>
						  </div>
						  <div class="form-group">
						   <div class="position-relative has-icon-left">
							  <label for="password" class="sr-only">Password</label>
							  <input type="password" id="password" name="password" class="form-control" placeholder="Password">
							  <div class="form-control-position">
								  <i class="icon-lock"></i>
							  </div>
						   </div>
						  </div>
						  <div class="form-row mr-0 ml-0">
						  <div class="form-group col-6">
							  <div class="">
				               <input type="checkbox" id="show_pass" />
				               <label for="user-checkbox">Show Password</label>
							 </div>
							</div>
							<div class="form-group col-6 text-right">
							 <a href="javascript:void()" id="forgot_pass">Forgot Password?</a>
							</div>
						</div>
						<button type="submit" class="btn btn-outline-primary btn-block waves-effect waves-light" id="btn_login">Log In</button>

					</form>
				 </div>
				</div>
	    	</div>
	     </div>
	    </div>

    <!--End Back To Top Button-->
	</div><!--wrapper-->

  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
  <script src="<?= base_url() ?>assets/js/popper.min.js"></script>
  <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>

  <script src="<?= base_url() ?>assets/plugins/toastr/toastr.js"></script>
  <script type="text/javascript">

    $(document).ready(function(){
      toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-full-width",
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

      $('#show_pass').click(function(){
        if($(this).is(':checked')){
          $('#password').attr('type','text');
        }else{
          $('#password').attr('type','password');
        };
      });

      $('#form_login').on('submit', function(e){
        e.preventDefault();

        var nik = $('#nik').val();
        var password = $('#password').val();

        if (nik === '' || password === ''){
          toastr.warning('Field harus diisi dengan lengkap', 'Warning')
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
                toastr.error(response.message, response.description)
                $('#btn_login').removeClass('disabled').removeAttr('disabled', 'disabled').text('Log In');
              }

            },
            error: function(){
              toastr.error('Tidak dapat mengakses server', 'Failed')
              $('#btn_login').removeClass('disabled').removeAttr('disabled', 'disabled').text('Log In');
            }
          });
        }
      });
    });
  </script>
</body>
</html>
