<!-- Breadcrumb-->
 <div class="row pt-2 pb-2">
    <div class="col-sm-9">
    <h4 class="page-title">Ubah Karyawan</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="#/karyawan">Karyawan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Ubah Karyawan</li>
     </ol>
 </div>
 </div>

 <div class="row">
   <div class="col-md-12">
     <div class="card">
       <div class="card-body">
         <h5 class="card-title">Form Karyawan</h5>
         <form id="form_edit">
           <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" id="nama" name="nama">
           </div>

           <div class="form-group">
            <label>Tempat Lahir</label>
            <input type="text" class="form-control" id="tmp_lahir" name="tmp_lahir">
           </div>

           <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir">
           </div>

           <div class="form-group">
             <label>Jenis Kelamin</label>
             <select class="form-control" id="kelamin" name="kelamin">
               <option value=""></option>
               <option value="Laki-laki">Laki-laki</option>
               <option value="Perempuan">Perempuan</option>
             </select>
           </div>

           <div class="form-group">
            <label>Tanggal Masuk</label>
            <input type="date" class="form-control" id="tgl_masuk" name="tgl_masuk">
           </div>

           <div class="form-group">
             <label>Status</label>
             <select class="form-control" id="status" name="status_karyawan">
               <option value=""></option>
               <option value="Aktif">Aktif</option>
               <option value="Nonaktif">Nonaktif</option>
             </select>
           </div>

           <div class="form-group">
            <label>Jabatan</label>
            <input type="text" class="form-control" id="jabatan" name="jabatan">
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

           <div class="form-group">
             <label>Level</label>
             <select class="form-control" id="level" name="level">
               <option value=""></option>
               <option value="Karyawan">Karyawan</option>
               <option value="Admin">Admin</option>
               <option value="Kabag">Kabag</option>
               <option value="Direksi">Direksi</option>
             </select>
           </div>

           <div class="form-group">
             <input type="hidden" name="nik" id="edit_id">
            <button type="submit" id="submit_edit" class="btn btn-primary shadow-primary px-5"> Simpan</button>
          </div>
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

   $(document).ready(function(){

     var nik = location.hash.substr(16);

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

     $.ajax({
      url: `<?= base_url('api/karyawan/show/') ?>${auth.token}?nik=${nik}`,
      type: 'GET',
      dataType: 'JSON',
      success: function(response){
        $.each(response.data, function(k, v){
          $('#nama').val(v.nama);
          $('#tmp_lahir').val(v.tmp_lahir);
          $('#tgl_lahir').val(v.tgl_lahir);
          $('#kelamin').val(v.kelamin);
          $('#tgl_masuk').val(v.tgl_masuk);
          $('#status').val(v.status_karyawan);
          $('#jabatan').val(v.jabatan);
          $('#id_divisi').val(v.id_divisi);
          $('#nama_divisi').val(v.nama_divisi);
          $('#level').val(v.level);
        })
      },
      error: function(){
        toastr.error('Tidak dapat mengakses server');
      }
    });

    $('#form_edit').on('submit', function(e){
      e.preventDefault();

      var nama = $('#nama').val();
      var tmp_lahir = $('#tmp_lahir').val();
      var tgl_lahir = $('#tgl_lahir').val();
      var kelamin = $('#kelamin').val();
      var tgl_masuk = $('#tgl_masuk').val();
      var status = $('#status').val();
      var jabatan = $('#jabatan').val();
      var id_divisi = $('#id_divisi').val();
      var nama_divisi = $('#nama_divisi').val();
      var level = $('#level').val();

      if(nama === '' || tmp_lahir === '' || tgl_lahir === '' || kelamin === '' || tgl_masuk === '' || status === '' || jabatan === '' || id_divisi === '' || nama_divisi === '' || level === ''){
        toastr.warning('Data belum lengkap');
      } else {
        $.ajax({
          url: `<?= base_url('api/karyawan/edit/') ?>${auth.token}?nik=${nik}`,
          type: 'POST',
          dataType: 'JSON',
          beforeSend: function(){
            $('#submit_edit').addClass('disabled').attr('disabled', 'disabled').html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
          },
          data: $(this).serialize(),
          success: function(response){
            if(response.status === 200){
              toastr.success(response.message);
              $('#form_edit')[0].reset();
              location.hash = '#/karyawan';
              table.ajax.reload();
            } else {
              toastr.error(response.message);
            }
            $('#submit_edit').removeClass('disabled').removeAttr('disabled', 'disabled').text('Simpan')
          },
          error: function(){
            toastr.error('Tidak dapat mengakses server');
            $('#submit_edit').removeClass('disabled').removeAttr('disabled', 'disabled').text('Simpan')
          }
        });
      }
    })

   })
 </script>
