<!-- Breadcrumb-->
<div class="row pt-2 pb-2">
  <div class="col-sm-9">
    <h4 class="page-title">Master Cuti</h4>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Master Cuti</li>
    </ol>
  </div>

  <div class="col-sm-3">
   <div class="btn-group float-sm-right">
     <a href="" class="btn btn-outline-primary waves-effect waves-light" id="btn_add" data-toggle="modal" data-target="#modal_add"><i class="fa fa-plus mr-1"></i> Tambah Baru</a>
   </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Data Cuti</h5>

        <div class="table-responsive">
          <table id="table_cuti" class="table table-striped table-hover js-basic-example dataTable table-custom">
            <thead>
              <tr>
                <th>Nama Cuti</th>
                <th>Jumlah Cuti</th>
                <th>Format Cuti</th>
                <th>Keterangan</th>
                <th style="width: 10%;"></th>
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

 <div class="modal fade" id="modal_add">
  <div class="modal-dialog">
    <div class="modal-content animated slideInUp">
      <div class="modal-header">
        <h5 class="modal-title"> Tambah Izin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form class="form-horizontal" id="form_add" method="post">
        <div class="modal-body form-group">
          <div class="form-group">
            <label for="">Nama Cuti</label>
            <input type="text" class="form-control" id="nama_cuti" name="nama_cuti">
          </div>

          <div class="form-group">
            <label for="">Banyak Cuti </label>
            <input type="number" class="form-control" id="banyak_cuti" name="banyak_cuti">
          </div>

          <div class="form-group">
            <label for="">Butuh Lampiran</label>
             <select class="form-control" id="lampiran" name="lampiran">
              <option value="">-- Pilih Lampiran --</option>
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>

          <div class="form-group">
            <label for="">Keterangan</label>
            <select class="form-control" id="keterangan" name="keterangan">
              <option value="">-- Pilih Keterangan --</option>
              <option value="Semua">Semua</option>
              <option value="Laki-laki">Laki-laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
          <button type="submit" id="simpan_cuti" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>



<script type="text/javascript">
  $(document).ready(function(){
    

    $('#btn_add').on('click', function(){
      $('#modal_add').modal('show');
    });

    $('#form_add').on('submit', function(e){
      e.preventDefault();
      var nama_cuti = $('#nama_cuti').val();
      var banyak_cuti = $('#banyak_cuti').val();
      var lampiran = $('#lampiran').val();
      var keterangan = $('#keterangan').val();

      if(nama_cuti === '' || banyak_cuti === '' || keterangan === ''){
        toastr.warning('Mohon isi datanya');
      } else {
        $.ajax({
          url: '<?= base_url('api/jenis_cuti/add/') ?>'+auth.token,
          type: 'POST',
          dataType: 'JSON',
          beforeSend: function(){
            $('#simpan_cuti').addClass('disabled').attr('disabled', 'disabled').html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
          },
          data: $(this).serialize(),
          success: function(response){
            if(response.status === 200){
              toastr.success(response.message);
              $('#form_add')[0].reset();
              $('#modal_add').modal('hide');
            } else {
              toastr.error(response.message);
            }
            $('#simpan_cuti').removeClass('disabled').removeAttr('disabled', 'disabled').text('Simpan');
          },
          error: function(){
            toastr.error('Tidak dapat mengakses server');
            $('#simpan_cuti').removeClass('disabled').removeAttr('disabled', 'disabled').text('Simpan');
          }
        })
      }
    });

    var table = $('#table_cuti').DataTable({
      columnDefs: [{
        targets: [0],
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
      ajax: '<?= base_url('api/jenis_cuti/show/'); ?>'+auth.token,
      columns: [
        {"data": 'nama_cuti'},
        {"data": 'banyak_cuti'},
        {"data": 'lampiran'},
        {"data": 'keterangan'},
        {"data": null, 'render': function(data, type, row){
          return `<center><button class="btn btn-md btn-danger" id="hapus_cuti" data-id="${row.id_cuti}"><i class="fa fa-trash"></i></button></center>`
          }
        }
      ],
      order: [[0, 'asc']]
    });

    $(document).on('click', '#hapus_cuti', function(){
      var id_cuti = $(this).attr('data-id');
      swal({
        title: "Apa Anda yakin ingin hapus?",
        text: "Data akan terhapus secara permanen",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        closeOnConfirm: false,
        closeOnCancel: true,
        confirmButtonColor: "#DD6B55",
        cancelButtonText: "Tidak",
        confirmButtonText: "Ya",
        showLoaderOnConfirm: true
      }, function (isConfirm){
        if (isConfirm) {
          $.ajax({
            url: `<?= base_url('api/jenis_cuti/delete/') ?>${auth.token}?id_cuti=${id_cuti}`,
            type: 'GET',
            dataType: 'JSON',
            success: function(response){
              if(response.status === 200){
                swal.close();
                toastr.success(response.message)
              } else {
                toastr.error(response.message)
              }
            },
            error: function(){
              toastr.error('Tidak dapat mengakses server')
            }
          });
        }
      })
    })

    var pusher = new Pusher('9f324d52d4872168e514', {
      cluster: 'ap1',
      forceTLS: true
    });

    var channel = pusher.subscribe('ums');
      channel.bind('jenis_cuti', function(data) {
      table.ajax.reload();
   });

  })
</script>