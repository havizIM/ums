<div class="row pt-2 pb-2">
  <div class="col-sm-9">
    <h4 class="page-title">Master Cuti Bersama</h4>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Master Cuti Bersama</li>
    </ol>
  </div>

  <div class="col-sm-3">
   <div class="btn-group float-sm-right">
     <a class="btn btn-outline-primary waves-effect waves-light" id="btn_add" data-toggle="modal" data-target="#modal_add"><i class="fa fa-plus mr-1"></i> Tambah Baru</a>
   </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Data Cuti Bersama</h5>

        <div class="table-responsive">
          <table id="table_cutibersama" class="table table-striped table-hover js-basic-example dataTable table-custom">
            <thead>
              <tr>
                <th>Keterangan</th>
                <th>Tanggal Cuti Bersama</th>
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
        <h5 class="modal-title"> Tambah Cuti Bersama</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form class="form-horizontal" id="form_add" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label>Keterangan</label>
            <input type="text" class="form-control" id="keterangan" name="keterangan">
            <div class="invalid_keterangan"></div>
          </div>

          <div class="form-group">
            <label>Tanggal</label>
            <input type="date" class="form-control" id="tgl_cuti_bersama" name="tgl_cuti_bersama">
            <div class="invalid_tgl_cuti_bersama"></div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
          <button type="submit" id="submit_add" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>   

    const DOM = {
        form_add: '#form_add',
        submit_add: '#submit_add',
        delete_data: '.delete_data',
        modal_add: '#modal_add'
    };

    const cutiBersamaController = (() => {

        const TABLE = $('#table_cutibersama').DataTable({
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
            ajax: '<?= base_url('api/cuti_bersama/show/'); ?>'+auth.token,
            columns: [
                {"data": 'keterangan'},
                {"data": 'tgl_cuti_bersama'},
                {"data": null, 'render': function(data, type, row){
                        return `<center><button class="btn btn-md btn-danger delete_data" data-id="${row.id_cuti_bersama}"><i class="fa fa-trash"></i></button></center>`
                    }
                }
            ],
            order: [[0, 'asc']]
        });

        const submitAdd = () => {
            $(DOM.form_add).validate({
                rules: {
                    keterangan: "required",
                    tgl_cuti_bersama: "required"
                },
                messages: {
                    keterangan: "Masukkan keterangan",
                    tgl_cuti_bersama: "Pilih tanggal cuti"
                },
                errorClass: 'is-invalid',
                errorPlacement: function(error, element) {
                    var name = $(element).attr("id");

                    error.appendTo($('.invalid_'+name));
                },
                submitHandler: function(form){
                    $.ajax({
                        url: `<?= base_url('api/cuti_bersama/add/') ?>${auth.token}`,
                        type: 'POST',
                        data: $(form).serialize(),
                        dataType: 'JSON',
                        beforeSend: function(){
                            $(DOM.submit_add).html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
                        },
                        success: function(response){
                            if(response.status === 200){
                                toastr.info(response.message, response.description)
                                $(DOM.modal_add).modal('hide');
                                TABLE.ajax.reload();
                            } else {
                                toastr.error(response.message, response.description)
                            }
                            $(DOM.submit_add).html('Simpan');
                        },
                        error: function(err){
                            $(DOM.submit_add).html('Simpan');
                            toastr.error('Tidak dapat mengakases server', 'Gagal');
                        }
                    })
                }
            })
        }

        const deleteData = () => {

            $(document).on('click', DOM.delete_data, function(){
                const id_cuti_bersama = $(this).attr('data-id');
                
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
                        url: `<?= base_url('api/cuti_bersama/delete/') ?>${auth.token}?id_cuti_bersama=${id_cuti_bersama}`,
                        type: 'GET',
                        dataType: 'JSON',
                        success: function(response){
                            if(response.status === 200){
                                swal.close();
                                toastr.success(response.message)
                                TABLE.ajax.reload();
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
        }

        return {
            init: () => {
                TABLE;
                submitAdd();
                deleteData();
            }
        }
    })();

    $(document).ready(function(){
        cutiBersamaController.init();
    })

</script>