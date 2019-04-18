<!-- Breadcrumb-->
<div class="row pt-2 pb-2">
  <div class="col-sm-9">
    <h4 class="page-title">Izin</h4>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Izin</li>
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
        <h5 class="card-title">Data Izin</h5>

        <div class="table-responsive">
          <table id="table_izin" class="table table-striped table-hover js-basic-example dataTable table-custom">
            <thead>
              <tr>
                <th>Keperluan</th>
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
            <input type="text" class="form-control" id="keperluan" name="keperluan" placeholder="Keperluan">
          </div>

          <div class="form-group">
            <input type="text" class="form-control" id="keterangan_izin" name="keterangan_izin" placeholder="Keterangan">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
          <button type="submit" id="simpan_izin" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">

  $(document).ready(function(){

    $('#btn_add').on('click', function(){
      $('#modal_add').modal('show');
    })

    $('#form_add').on('submit', function(e){
      e.preventDefault();

      var keperluan = $('#keperluan').val();
      var keterangan_izin = $('#keterangan_izin').val();

      if(keperluan === ''){
        toastr.warning('Mohon isi datanya');
      } else {
        $.ajax({
          url: '<?= base_url('api/jenis_izin/add/') ?>'+auth.token,
          type: 'POST',
          dataType: 'JSON',
          beforeSend: function(){
            $('#simpan_izin').addClass('disabled').attr('disabled', 'disabled').html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
          },
          data: {
            keperluan: keperluan,
            keterangan_izin: keterangan_izin
          },
          success: function(response){
            if(response.status === 200){
              toastr.success(response.message);
              $('#form_add')[0].reset();
              $('#modal_add').modal('hide');
              table.ajax.reload();
            } else {
              toastr.error(response.message);
            }
            $('#simpan_izin').removeClass('disabled').removeAttr('disabled', 'disabled').text('Simpan');
          },
          error: function(){
            toastr.error('Tidak dapat mengakses server');
          }
        })
      }
    })

    var table = $('#table_izin').DataTable({
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
      ajax: '<?= base_url('api/jenis_izin/show/'); ?>'+auth.token,
      columns: [
        {"data": 'keperluan'},
        {"data": 'keterangan_izin'},
        {"data": null, 'render': function(data, type, row){
          return `<center><button class="btn btn-md btn-danger" id="hapus_izin" data-id="${row.id_izin}"><i class="fa fa-trash"></i></button></center>`
          }
        }
      ],
      order: [[0, 'asc']]
    });

    $(document).on('click', '#hapus_izin', function(){
      var id_izin = $(this).attr('data-id');

      swal({
        title: "Apa Anda yakin?",
        text: "Data akan terhapus permanen",
        icon: "warning",
        buttons: ["Tidak", "Ya"],
        confirmButtonColor: '#8CD4F5',
        cancelButtonColor: '#fd3550'
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: `<?= base_url('api/jenis_izin/delete/'); ?>${auth.token}?id_izin=${id_izin}`,
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
