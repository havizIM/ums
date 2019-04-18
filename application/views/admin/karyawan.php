<!-- Breadcrumb-->
 <div class="row pt-2 pb-2">
   <div class="col-sm-9">
   <h4 class="page-title">Karyawan</h4>
     <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
       <li class="breadcrumb-item active" aria-current="page">Karyawan</li>
     </ol>
   </div>

   <div class="col-sm-3">
     <div class="btn-group float-sm-right">
      <a href="#/add_karyawan" class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Tambah Baru</a>
    </div>
   </div>
 </div>

 <div class="row">
   <div class="col-md-12">
     <div class="card">
       <div class="card-body">
         <h5 class="card-title">Data Karyawan</h5>

         <div class="table-responsive">
           <table id="table_karyawan" class="table table-striped table-hover js-basic-example dataTable table-custom">
             <thead>
               <tr>
                 <th>NIK</th>
                 <th>Nama</th>
                 <th>Jabatan</th>
                 <th>Divisi</th>
                 <th>Level</th>
                 <th>Status Keaktifan</th>
                 <th>Tanggal Masuk</th>
                 <th>Foto</th>
                 <th>Tanggal Registrasi</th>
                 <th>Tempat Lahir</th>
                 <th>Tanggal Lahir</th>
                 <th>Kelamin</th>
                 <th>Status Hubungan</th>
                 <th>Pendidikan</th>
                 <th>Alamat</th>
                 <th>Telepon</th>
                 <th>Email</th>
                 <th></th>
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

    var session = localStorage.getItem('ums');
    var auth = JSON.parse(session);

    var table = $('#table_karyawan').DataTable({
      columnDefs: [{
        targets: [1],
        searchable: true
      }],
      autoWidth: false,
      language: {
        search: 'Cari Nama: _INPUT_',
        lengthMenu: 'Tampilkan: _MENU_',
        paginate: {'next': 'Berikutnya', 'previous': 'Sebelumnya'},
        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ Data',
        zeroRecords: 'Data tidak ditemukan',
        infoEmpty: 'Menampilkan 0 sampai 0 dari _TOTAL_ Data',
        loadingRecords: '<i class="fa fa-refresh fa-spin"></i>',
        processing: ' Memuat....',
        infoFiltered: ''
      },
      responsive: true,
      processing: true,
      ajax: '<?= base_url('api/karyawan/show/'); ?>'+auth.token,
      columns: [
        {"data": 'nik'},
        {"data": 'nama'},
        {"data": 'jabatan'},
        {"data": 'nama_divisi'},
        {"data": 'level'},
        {"data": 'status_karyawan'},
        {"data": 'tgl_masuk'},
        {"data": 'foto'},
        {"data": 'tgl_registrasi'},
        {"data": 'tmp_lahir'},
        {"data": 'tgl_lahir'},
        {"data": 'kelamin'},
        {"data": 'status_kawin'},
        {"data": 'pendidikan'},
        {"data": 'alamat'},
        {"data": 'telepon'},
        {"data": 'email'},
        {"data": null, 'render': function(data, type, row){
          return `<button class="btn btn-md btn-danger" id="hapus_karyawan" data-id="${row.nik}"><i class="fa fa-trash"></i></button>`
          }
        }
      ],
      order: [[1, 'desc']]
    })

    $(document).on('click', '#hapus_karyawan', function(){
      var nik = $(this).attr('data-id');

      swal({
        title: "Apa Anda yakin?",
        text: "Data akan terhapus permanen",
        icon: "warning",
        buttons: ["Tidak", "Ya"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: `<?= base_url('api/karyawan/delete/'); ?>${auth.token}?nik=${nik}`,
            type: 'GET',
            dataType: 'JSON',
            success: function(response){
              if(response.status === 200){
                table.ajax.reload();
              } else {
                toastr.error(response.message);
              }
            },
            error: function(){
              toastr.error('Tidak dapat mengakses server');
            }
          });
        }
      })
    })

  })

</script>
