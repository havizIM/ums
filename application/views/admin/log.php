<!-- Breadcrumb-->
 <div class="row pt-2 pb-2">
    <div class="col-sm-9">
      <h4 class="page-title">Log</h4>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Log</li>
      </ol>
   </div>
 </div>

 <div class="row">
   <div class="col-md-12">
     <div class="card">
       <div class="card-body">
         <h5 class="card-title">Data Log</h5>

         <div class="table-responsive">
           <table id="table_log" class="table table-striped table-hover js-basic-example dataTable table-custom">
             <thead>
               <tr>
                 <th>Tanggal</th>
                 <th>NIK</th>
                 <th>Nama</th>
                 <th>Keterangan</th>
                 <th>ID Referensi</th>
                 <th>Kategori</th>
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

     var table = $('#table_log').DataTable({
       columnDefs: [{
         targets: [0, 1, 2, 3, 4, 5],
         searchable: true
       }],
       autoWidth: false,
       language: {
         search: 'Cari: _INPUT_',
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
       ajax: '<?= base_url('api/log/show/'); ?>'+auth.token,
       columns: [
         {"data": 'tgl_log'},
         {"data": 'nik'},
         {"data": 'nama'},
         {"data": 'keterangan'},
         {"data": 'id_ref'},
         {"data": 'kategori'}
       ],
       order: [[0, 'desc']]
     });

   });

 </script>
