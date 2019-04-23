<!-- Breadcrumb-->
 <div class="row pt-2 pb-2">
    <div class="col-sm-9">
    <h4 class="page-title">Add Karyawan</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="#/karyawan">Karyawan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Karyawan</li>
     </ol>
 </div>
 </div>

 <div class="row">
   <div class="col-md-12">
     <div class="card">
       <div class="card-body">
         <h5 class="card-title">Form Karyawan</h5>
         <form id="add_karyawan">
             <div class="wizards">
                 <div class="progressbar">
                     <div class="progress-line" data-now-value="33.00" data-number-of-steps="3" style="width: 33%;"></div> <!-- 19.66% -->
                 </div>
                 <div class="form-wizard active">
                     <div class="wizard-icon"><i class="fa fa-user"></i></div>
                     <p>Data Pribadi</p>
                 </div>
                 <div class="form-wizard">
                     <div class="wizard-icon"><i class="fa fa-key"></i></div>
                     <p>Informasi</p>
                 </div>
                 <div class="form-wizard">
                     <div class="wizard-icon"><i class="fa fa-globe"></i></div>
                     <p>Account</p>
                 </div>
             </div>

             <fieldset>
                 <h5>Data Pribadi</h5>
                 <div class="form-group">
                   <label>Nama</label>
                   <input type="text" name="nama" class="form-control" />
                 </div>
                 <div class="form-group">
                     <label>Jenis Kelamin</label>
                     <select class="form-control" name="kelamin">
                       <option value=""></option>
                       <option value="Laki-laki">Laki-laki</option>
                       <option value="Perempuan">Perempuan</option>
                     </select>
                 </div>
                 <div class="form-group">
                     <label>Tempat Lahir</label>
                     <input type="text" name="tmp_lahir" class="form-control" />
                 </div>
                 <div class="form-group">
                     <label>Tanggal Lahir</label>
                     <input type="date" name="tgl_lahir" class="form-control" />
                 </div>
                 <div class="form-group">
                     <label>Status Kawin</label>
                     <select class="form-control" name="status_kawin">
                       <option value=""></option>
                       <option value="Kawin">Kawin</option>
                       <option value="Belum Kawin">Belum Kawin</option>
                     </select>
                 </div>
                 <div class="form-group">
                     <label>Telepon</label>
                     <input type="text" name="telepon" class="form-control" />
                 </div>
                 <div class="form-group">
                     <label>Alamat</label>
                     <textarea name="alamat" class="form-control" rows="8" cols="80"></textarea>
                 </div>
                 <div class="wizard-buttons">
                     <button type="button" class="btn btn-next">Next</button>
                 </div>
             </fieldset>
             <fieldset>
                 <h5>Informasi</h5>
                 <div class="form-group">
                     <label>NIK</label>
                     <input type="text" name="nik" class="form-control" />
                 </div>
                 <div class="form-group">
                     <label>Pendidikan</label>
                     <select class="form-control" name="pendidikan">
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
                 <div class="form-group">
                     <label>Tanggal Masuk</label>
                     <input type="date" name="tgl_masuk" class="form-control" />
                 </div>
                 <div class="form-group">
                     <label>Status Karyawan</label>
                     <select class="form-control" name="status_karyawan">
                       <option value=""></option>
                       <option value="Aktif">Aktif</option>
                       <option value="Nonaktif">Nonaktif</option>
                     </select>
                 </div>
                 <div class="form-group">
                     <label>Jabatan</label>
                     <input type="text" name="jabatan" class="form-control" />
                 </div>
                 <div class="form-group">
              		  <label>Divisi</label>
              			<div class="input-group">
                      <input type="hidden" name="id_divisi" id="id_divisi">
              			  <input type="text" name="nama_divisi" id="nama_divisi" readonly class="form-control">
              			  <div class="input-group-append">
                        <button class="btn btn-primary" type="button" id="cari_divisi"><i class="fa fa-search" ></i></button>
              			  </div>
              			</div>
              		</div>
                 <div class="wizard-buttons">
                     <button type="button" class="btn btn-previous">Previous</button>
                     <button type="button" class="btn btn-next">Next</button>
                 </div>
             </fieldset>
             <fieldset>
                     <h5>Account</h5>
                     <div class="form-group">
                         <label>Email</label>
                         <input type="email" name="email" class="form-control"/>
                     </div>
                     <div class="form-group">
                         <label>Level</label>
                         <select class="form-control" name="level">
                           <option value=""></option>
                           <option value="Karyawan">Karyawan</option>
                           <option value="Kabag">Kabag</option>
                           <option value="Direksi">Direksi</option>
                           <option value="Admin">Admin</option>
                         </select>
                     </div>
                 <div class="wizard-buttons">
                   <button type="button" class="btn btn-previous">Previous</button>
                   <button type="submit" name="save" id="submit_karyawan" class="btn btn-primary btn-submit"><i class="fa fa-check"></i>Simpan</button>
                 </div>
             </fieldset>

         </form>
       </div>
     </div>
   </div>
 </div>

 <div class="modal fade" id="modal_divisi">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="fa fa-star"></i> Lookup Divisi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="add_divisi">
            <div class="form-group">
               <div class="input-group">
                 <input type="text" name="nama_divisi" required class="form-control" placeholder="Divisi">
                 <div class="input-group-append">
                   <button class="btn btn-primary" type="submit" id="submit_divisi"><i class="fa fa-plus" ></i> Tambah</button>
                 </div>
               </div>
             </div>
          </form>

          <div class="table-responsive">
            <table class="table" id="t_divisi">
              <thead>
                <tr>
                  <th>Pilih</th>
                  <th>ID Divisi</th>
                  <th>Nama Divisi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

 <script type="text/javascript">

   function scroll_to_class(element_class, removed_height) {
     var scroll_to = $(element_class).offset().top - removed_height;
     if($(window).scrollTop() != scroll_to) {
       $('html, body').stop().animate({scrollTop: scroll_to}, 0);
     }
   }
   function bar_progress(progress_line_object, direction) {
     var number_of_steps = progress_line_object.data('number-of-steps');
     var now_value = progress_line_object.data('now-value');
     var new_value = 0;
     if(direction == 'right') {
       new_value = now_value + ( 100 / number_of_steps );
     }
     else if(direction == 'left') {
       new_value = now_value - ( 100 / number_of_steps );
     }
     progress_line_object.attr('style', 'width: ' + new_value + '%;').data('now-value', new_value);
   }

   $(document).ready(function(){

     var t_divisi = $('#t_divisi').DataTable({
       columnDefs: [{
         targets: [0,3],
         orderable: false
       }],
       autoWidth: false,
       language: {
         search: 'Cari Divisi: _INPUT_',
       },
       responsive: true,
       processing: true,
       ajax: '<?= base_url('api/divisi/show/'); ?>'+auth.token,
       columns: [
         {"data": null, 'render': function(data, type, row){
             return `<button type="button" class="btn btn-sm btn-success" id="pilih_divisi" data-id="${row.id_divisi}" data-nama="${row.nama_divisi}"><i class="fa fa-check"></i> Pilih</button>`
           }
         },
         {"data": 'id_divisi'},
         {"data": 'nama_divisi'},
         {"data": null, 'render': function(data, type, row){
             return `<button type="button" class="btn btn-sm btn-danger" id="hapus_divisi" data-id="${row.id_divisi}"><i class="fa fa-trash"></i></button>`
           }
         },
       ],
       order: [[1, 'desc']]
     });

     $('form fieldset:first').fadeIn('slow');

     $('form input[type="text"], form input[type="password"], form textarea, form select').on('focus', function() {
     	$(this).removeClass('input-error');
     });

     $('form .btn-next').on('click', function() {
     	var parent_fieldset = $(this).parents('fieldset');
     	var next_step = true;
     	var current_active_step = $(this).parents('form').find('.form-wizard.active');
     	var progress_line = $(this).parents('form').find('.progress-line');

     	parent_fieldset.find('input[type="text"], input[type="password"], input[type="username"], input[type="email"], input[type="tel"], input[type="url"], textarea, select, input[type="hidden"]').each(function() {
     		if( $(this).val() == "" ) {
     			$(this).addClass('input-error');
     			next_step = false;
     		}
     		else {
     			$(this).removeClass('input-error');
     		}
     	});

     	if( next_step ) {
     		parent_fieldset.fadeOut(400, function() {
     			current_active_step.removeClass('active').addClass('activated').next().addClass('active');
     			bar_progress(progress_line, 'right');
 	    		$(this).next().fadeIn();
     			scroll_to_class( $('form'), 20 );
 	    	});
     	}

     });

     // previous step
     $('form .btn-previous').on('click', function() {
     	var current_active_step = $(this).parents('form').find('.form-wizard.active');
     	var progress_line = $(this).parents('form').find('.progress-line');

     	$(this).parents('fieldset').fadeOut(400, function() {
     		current_active_step.removeClass('active').prev().removeClass('activated').addClass('active');
     		bar_progress(progress_line, 'left');
     		$(this).prev().fadeIn();
 			scroll_to_class( $('form'), 20 );
     	});
     });

     $('#cari_divisi').on('click', function(){
       $('#modal_divisi').modal('show');
       $('#add_divisi')[0].reset();
     });

     $(document).on('click', '#pilih_divisi', function(){
       var id_divisi = $(this).attr('data-id');
       var nama_divisi = $(this).attr('data-nama');

       $('#id_divisi').val(id_divisi);
       $('#nama_divisi').val(nama_divisi);

       $('#modal_divisi').modal('hide');
     })

     $(document).on('click', '#hapus_divisi', function(){
       var id_divisi = $(this).attr('data-id');
       $(this).addClass('disabled').html(`<i class="fa fa-spinner fa-spin"></i>`)

       $.ajax({
         url: `<?= base_url('api/divisi/delete/') ?>${auth.token}?id_divisi=${id_divisi}`,
         type: 'GET',
         dataType: 'JSON',
         success: function(response){
           if(response.status === 200){
             toastr.info(response.message, response.description)
             t_divisi.ajax.reload();
           } else {
             $(this).removeClass('disabled').html(`<i class="fa fa-trash" ></i>`)
             toastr.error(response.message, response.description)
           }
         },
         error: function(){
           $(this).removeClass('disabled').html(`<i class="fa fa-trash" ></i>`)
           toastr.error('Tidak dapat mengakses server', 'Error')
         }
       });
     });

     $('#add_divisi').on('submit', function(e){
       e.preventDefault();

       $.ajax({
         url: `<?= base_url('api/divisi/add/') ?>${auth.token}`,
         type: 'POST',
         data: $(this).serialize(),
         beforeSend: function(){
           $('#submit_divisi').addClass('disabled').html(`<i class="fa fa-spinner fa-spin"></i>`)
         },
         success: function(response){
           if(response.status === 200){
             toastr.info(response.message, response.description)
             t_divisi.ajax.reload();
             $('#add_divisi')[0].reset();
           } else {
             toastr.error(response.message, response.description)
           }
           $('#submit_divisi').removeClass('disabled').html(`<i class="fa fa-plus" ></i> Tambah`)
         },
         error: function(){
           toastr.error('Tidak dapat mengakses server', 'Error')
           $('#submit_divisi').removeClass('disabled').html(`<i class="fa fa-plus" ></i> Tambah`)
         }

       })
     });

     $('#add_karyawan').on('submit', function(e) {
       e.preventDefault();
     	$(this).find('input[type="text"], input[type="password"], input[type="username"], input[type="email"], input[type="tel"], input[type="url"], textarea, select, input[type="hidden"]').each(function() {
     		if( $(this).val() == "" ) {
     			$(this).addClass('input-error');
          toastr.warning('Masih ada field yang belum terisi', 'Warning');
     		}
     		else {
     			$(this).removeClass('input-error');
     		}
     	});

      $.ajax({
        url: `<?= base_url('api/karyawan/add/') ?>${auth.token}`,
        type: 'POST',
        data: $(this).serialize(),
        beforeSend: function(){
          $('#submit_karyawan').addClass('disabled').html(`<i class="fa fa-spinner fa-spin"></i>`)
        },
        success: function(response){
          if(response.status === 200){
            toastr.info(response.message, response.description)
            location.hash = '#/karyawan';
          } else {
            toastr.error(response.message, response.description)
            $('#submit_karyawan').removeClass('disabled').html(`<i class="fa fa-check" ></i> Simpan`)
          }
        },
        error: function(){
          toastr.error('Tidak dapat mengakses server', 'Error')
          $('#submit_karyawan').removeClass('disabled').html(`<i class="fa fa-check" ></i> Simpan`)
        }

      })
     });
   })
   
 </script>
