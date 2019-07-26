<div class="row pt-2 pb-2">
   <div class="col-sm-9">
   <h4 class="page-title">Profil</h4>
   <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
       <li class="breadcrumb-item active" aria-current="page"><a href="">Profil</a></li>
    </ol>
</div>
</div>

<div class="row">
  <div class="col-lg-4">
   <div class="profile-card-3">
    <div class="card">
		 <div class="user-fullimage">
		   <img id="pp" alt="user avatar" class="card-img-top">
		    <div class="details">
		      <h5 class="mb-1 text-white ml-3" id="nama"></h5>
				  <h6 class="text-white ml-3" id="nik"></h6>
			  </div>
		  </div>

      <div class="card-body text-center">
        <p id="jabatan"></p>
  		  <div class="row">
  		    <div class="col-md-6 p-2">
    				<h5 class="mb-0 line-height-5">Divisi</h5>
    				<small class="mb-0 font-weight-bold" id="nama_divisi"></small>
  				</div>


					<div class="col-md-6 p-2">
  					<h5 class="mb-0 line-height-5">Status</h5>
  					<small class="mb-0 font-weight-bold" id="status_keaktifan"></small>
					</div>
			  </div>
      </div>
     </div>
		</div>
  </div>

  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
          <li class="nav-item">
            <a href="javascript:void();" data-target="#profile" data-toggle="pill" class="nav-link active"><i class="icon-user"></i> <span class="hidden-xs">Profil</span></a>
          </li>

          <li class="nav-item">
            <a href="javascript:void();" data-target="#edit" data-toggle="pill" class="nav-link"><i class="icon-note"></i> <span class="hidden-xs">Edit</span></a>
          </li>
        </ul>

        <div class="tab-content p-3">
          <div class="tab-pane" id="profile">
            <h5 class="mb-3">Profil Anda</h5>
              <div class="row">
                <div class="col-md-6">
                  <h6><i class="ti-calendar"></i> Tanggal Masuk</h6>
                  <p id="tgl_masuk" class="m-b-10"></p><br>

                  <h6><i class="ti-time"></i> Tanggal Registrasi</h6>
                  <p id="tgl_regis"></p><br>

                  <h6><i class="ti-location-pin"></i> Tempat Lahir</h6>
                  <p id="tmp_lahir"></p><br>

                  <h6><i class="ti-calendar"></i> Tanggal Lahir</h6>
                  <p id="tgl_lahir"></p><br>

                  <h6><i class="fa fa-intersex"></i> Kelamin</h6>
                  <p id="kelamin"></p><br>
                </div>
                <div class="col-md-6">
                  <h6><i class="ti-location-pin"></i> Alamat</h6>
                  <p id="alamat"></p><br>

                  <h6><i class="ti-control-play"></i> Status</h6>
                  <p id="status"></p><br>

                  <h6><i class="fa fa-graduation-cap"></i> Pendidikan</h6>
                  <p id="pendidikan"></p><br>

                  <h6><i class="ti-mobile"></i> Telepon</h6>
                  <p id="telepon"></p><br>

                  <h6><i class="ti-email"></i> Email</h6>
                  <p id="email"></p><br>
                </div>
              </div>
              <!--/row-->
            </div>

            <div class="tab-pane" id="edit">
              <form id="form_edit">
                <div class="form-group row">
                  <label class="col-lg-3 col-form-label form-control-label">Email</label>
                  <div class="col-lg-9">
                    <input class="form-control" type="email" id="edit_email" name="email">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-3 col-form-label form-control-label">Status</label>
                  <div class="col-lg-9">
                    <select class="form-control" id="edit_status" name="status_kawin">
                      <option value=""></option>
                      <option value="Kawin">Kawin</option>
                      <option value="Belum Kawin">Belum Kawin</option>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-3 col-form-label form-control-label">Pendidikan</label>
                  <div class="col-lg-9">
                    <select class="form-control" id="edit_pendidikan" name="pendidikan">
                      <option value=""></option>
                      <option value="SD">SD</option>
                      <option value="SMP">SMP</option>
                      <option value="SMA">SMA</option>
                      <option value="SMK">SMK</option>
                      <option value="D3">D3</option>
                      <option value="S1">S1</option>
                      <option value="S2">S2</option>
                      <option value="S3">S3</option>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-3 col-form-label form-control-label">Alamat</label>
                  <div class="col-lg-9">
                    <textarea class="form-control" name="alamat" id="edit_alamat" rows="8" cols="80"></textarea>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-3 col-form-label form-control-label">Telepon</label>
                  <div class="col-lg-9">
                    <input class="form-control" type="text" id="edit_telepon" name="telepon">
                  </div>
                </div>

                <br>
                <div class="form-group row">
                  <div class="col-lg-12">
                    <center><button type="submit" class="btn btn-md btn-info" id="submit_edit">Simpan</button></center>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

<script type="text/javascript">

function load_profile(){
  $.ajax({
      url: '<?= base_url('api/auth/profile/') ?>'+auth.token,
      type: 'GET',
      dataType: 'JSON',
      success: function(response){
        $.each(response.data, function(k, v){
          $('#nama').text(v.nama)
          $('#nik').text(v.nik)
          $('#level').text(v.level)
          $('#id_divisi').text(v.id_divisi)
          $('#nama_divisi').text(v.nama_divisi)
          $('#jabatan').text(v.jabatan)
          $('#status_keaktifan').text(v.status_karyawan)
          $('#tgl_masuk').text(v.tgl_masuk)
          $('#tgl_regis').text(v.tgl_registrasi)
          $('#tmp_lahir').text(v.tmp_lahir)
          $('#tgl_lahir').text(v.tgl_lahir)
          $('#alamat').text(v.alamat)
          $('#kelamin').text(v.kelamin)
          $('#status').text(v.status_kawin)
          $('#pendidikan').text(v.pendidikan)
          $('#telepon').text(v.telepon)
          $('#email').text(v.email)
          $('#edit_email').val(v.email)
          $('#edit_status').val(v.status_kawin)
          $('#edit_pendidikan').val(v.pendidikan)
          $('#edit_alamat').val(v.alamat)
          $('#edit_telepon').val(v.telepon)
          $('#pp').attr('src', `<?= base_url('doc/foto/') ?>${v.foto}`)
        })
      }
    })
}



  $(document).ready(function(){

    $('#profile').addClass('active');

    load_profile();

    $('#form_edit').on('submit', function(e){
      e.preventDefault();

      var email = $('#edit_email').val();
      var status = $('#edit_status').val();
      var pendidikan = $('#edit_pendidikan').val();
      var alamat = $('#edit_alamat').val();
      var telepon = $('#edit_telepon').val();

      if (email === '' || status === '' || pendidikan === '' || alamat === '' || telepon === '') {
        toastr.warning('Data belum lengkap');
      } else {
        $.ajax({
          url: '<?= base_url('api/auth/edit_profile/') ?>'+auth.token,
          type: 'POST',
          dataType: 'JSON',
          beforeSend: function(){
            $('#submit_edit').addClass('disabled').attr('disabled', 'disabled').html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
          },
          data: {
            email: email,
            status_kawin: status,
            pendidikan: pendidikan,
            alamat: alamat,
            telepon: telepon
          },
          success: function(response){
            if (response.status === 200) {
              toastr.success(response.message);
              $('#form_edit')[0].reset();
              load_data();
              $('#edit').removeClass('active')
              $('#profile').addClass('active')
            } else {
              toastr.error(response.message)
            }
            $('#submit_edit').removeClass('disabled').removeAttr('disabled', 'disabled').text('Simpan')
          },
          error: function(){
            toastr.error('Tidak dapat mengakses server');
            $('#submit_edit').removeClass('disabled').removeAttr('disabled', 'disabled').text('Simpan')
          }
        })
      }
    })

  })

</script>
