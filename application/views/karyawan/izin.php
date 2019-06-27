<!-- Breadcrumb-->
 <div class="row pt-2 pb-2">
    <div class="col-sm-9">
        <h4 class="page-title">Pengajuan - Izin</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pengajuan - Izin</li>
        </ol>
    </div>
    <div class="col-sm-3">
      <div class="btn-group float-sm-right">
        <a href="#/add_izin" class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Tambah Baru</a>
      </div>
    </div>
 </div>

  <div class="row">
   <div class="col-md-12">
     <div class="card">
       <div class="card-body">
         <h5 class="card-title">Data Izin</h5>

         <div class="table-responsive">
           <table id="table_cuti" class="table table-striped table-hover js-basic-example dataTable table-custom">
             <thead>
               <tr>
                 <th>Tanggal</th>
                 <th>ID Izin</th>
                 <th>Keperluan</th>
                 <th>Tanggal Izin</th>
                 <th>Keterangan</th>
                 <th>Status</th>
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

     var table = $('#table_cuti').DataTable({
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
       ajax: '<?= base_url('api/izin/show/'); ?>'+auth.token,
       columns: [
         {"data": 'tgl_input'},
         {"data": null, 'render': function(data, type, row){
          return `<a href="#/izin/${row.id}">${row.id}</a>`
          }
         },
         {"data": 'jenis_izin.keperluan'},
         {"data": 'tgl_izin'},
         {"data": 'keterangan'},
         {"data": null, 'render': function(data, type, row){
            if(row.status === 'Proses'){
                return `<span class="badge badge-warning">Menunggu Approval</span>`;
            } else  if(row.status === 'Ditolak' || row.status === 'Batal'){
                return `<span class=" badge badge-danger">${row.status}</span>`;
            } else {
                return `<span class="badge badge-success">${row.status}</span>`;
            }
          }
         }
       ],
       order: [[0, 'desc']]
     });

     var pusher = new Pusher('9f324d52d4872168e514', {
      cluster: 'ap1',
      forceTLS: true
    });

    var channel = pusher.subscribe('ums');
    channel.bind('log', function(data) {
      table.ajax.reload();
    });

   });

 </script>
