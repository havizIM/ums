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
                 <th>Nama</th>
                 <th>NIK</th>
                 <th>Jabatan</th>
                 <th>Divisi</th>
                 <th>Level</th>
                 <th>Status</th>
                 <th>Tanggal Masuk</th>
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
        {"data": 'nama'},
        {"data": null, 'render': function(data, type, row){
          return `<a href="#/karyawan/${row.nik}" data-id="${row.nik}">${row.nik}</a>`
          }
        },
        {"data": 'jabatan'},
        {"data": 'nama_divisi'},
        {"data": 'level'},
        {"data": 'status_karyawan'},
        {"data": 'tgl_masuk'}
        
      ],
      order: [[1, 'asc']]
    })

    var pusher = new Pusher('9f324d52d4872168e514', {
     cluster: 'ap1',
     forceTLS: true
   });

   var channel = pusher.subscribe('ums');
   channel.bind('karyawan', function(data) {
     table.ajax.reload();
   });

  })

</script>
