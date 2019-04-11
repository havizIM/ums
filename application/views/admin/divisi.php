<div class="block-header">
  <div class="row">
    <div class="col-lg-5 col-md-8 col-sm-12">
      <h2>Divisi</h2>
    </div>

    <div class="tombol-add">
      <button type="button" id="btn_modal_add" class="btn btn-md">Tambah Divisi</button>
    </div>
  </div>
</div>


<div class="row clearfix">
  <div class="col-lg-12 col-md-12">
    <div class="card planned_task">

      <div class="body">
        <h4>Selamat Datang</h4>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="modal_add" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="title" id="defaultModalLabel">Tambah Divisi</h4>
      </div>

      <form class="form-horizontal" id="form_add" method="post">
        <div class="modal-body form-group">
          <div class="form-group">
            <input type="text" class="form-control" id="nama_divisi" name="nama_divisi" placeholder="Nama Divisi">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
          <button type="submit" id="simpan_add" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">

  $(document).ready(function(){

    var session = localStorage.getItem('ums');
    var auth = JSON.parse(session);

    $('#btn_modal_add').on('click', function(){
      $('#modal_add').modal('show');
    });

    $('#form_add').on('submit', function(e){
      e.preventDefault();

      var nama_divisi = $('#nama_divisi').val();

      if(nama_divisi === '') {
        toastr.warning(response.message);
      } else {
        $.ajax({
          url: '<?= base_url('api/divisi/add/') ?>'+auth.token,
          type: 'POST',
          dataType: 'JSON',
          beforeSend: function(){
            $('#simpan_add').addClass('disabled').attr('disabled', 'disabled').html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
          },
          data: {
            nama_divisi: nama_divisi
          },
          success: function(response){
            if(response.status === 200){
              toastr.success(response.message);
              $('#form_add')[0].reset();
              $('#modal_add').modal('hide');
            } else {
              toastr.error('Tidak dapat mengakses server');
            }
            $('#simpan_add').removeClass('disabled').removeAttr('disabled', 'disabled').text('Simpan');
          },
          error: function(){
            toastr.error('Tidak dapat mengakses server');
          }
        });
      }
    });

  });

</script>
