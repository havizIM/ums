<div class="row pt-2 pb-2">
    <div class="col-sm-9">
        <h4 class="page-title">Edit Cuti</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#/cuti">Pengajuan</a></li>
            <li class="breadcrumb-item active id-page" aria-current="page">Edit Cuti</li>
        </ol>
    </div>
 </div>

 <div class="row">
   <div class="col-md-12">
     <div class="card">
        <div class="card-header id-page">Formulir Cuti</div>
        <div class="card-body">
            <form id="form_cuti">
                <div class="form-group row">
                    <label for="id_cuti" class="col-md-2 col-form-label">Jenis Cuti</label>
                    <div class="col-md-10">
                        <select name="id_cuti" id="id_cuti" class="form-control">
                            <option value="">-- Pilih Jenis Cuti --</option>
                        </select>
                        <div class="invalid_id_cuti"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tgl_mulai" class="col-md-2 col-form-label">Tanggal Cuti</label>
                    <div class="col-md-10">
                        <div id="dateragne-picker">
                            <div class="input-daterange input-group">
                                <input type="text" class="form-control tgl_mulai" id="periode_tgl" name="tgl_mulai" id="tgl_mulai" />
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Sampai</span>
                                </div>
                                <input type="text" class="form-control tgl_selesai" id="periode_tgl" name="tgl_selesai" id="tgl_selesai" />
                            </div>
                            <div class="invalid_periode_tgl"></div>
                        </div> 
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alamat" class="col-md-2 col-form-label">Alamat</label>
                    <div class="col-md-10">
                        <textarea name="alamat" id="alamat" rows="5" class="form-control"></textarea>
                        <div class="invalid_alamat"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="telepon" class="col-md-2 col-form-label">Telepon</label>
                    <div class="col-md-10">
                        <input type="number" name="telepon" id="telepon" class="form-control">
                        <div class="invalid_telepon"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pengganti" class="col-md-2 col-form-label">Pengganti</label>
                    <div class="col-md-10">
                        <div class="input-group mb-3">
                            <input type="hidden" id="pengganti" name="pengganti">
                            <input type="text" class="form-control" readonly id="nama_pengganti" name="nama_pengganti">
                            <div class="input-group-append">
                                <span class="input-group-text" id="lookup_karyawan"><i class="fa fa-user-o"></i></span>
                            </div>
                        </div>
                        <div class="invalid_nama_pengganti" style="margin-top: -15px"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jumlah_cuti" class="col-md-2 col-form-label">Jumlah Cuti</label>
                    <div class="col-md-10">
                        <input type="number" name="jumlah_cuti" id="jumlah_cuti" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group text-center">
                    <a class="btn btn-danger btn-md" href="#/cuti">Batal</a>
                    <button class="btn btn-info btn-md" type="submit" id="submit_add">Submit</button>
                </div>
            </form>
       </div>
     </div>
   </div>
 </div>

 <div class="modal fade" id="modal_karyawan">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="fa fa-star"></i> Cari Karyawan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table" id="t_karyawan">
              <thead>
                <tr>
                  <th>Pilih</th>
                  <th>NIK</th>
                  <th>Nama</th>
                  <th>Telepon</th>
                  <th>Email</th>
                  <th>Jabatan</th>
                  <th>Divisi</th>
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

 <script>
    function render_jcuti(data){
        var content = '';

        $.each(data, function(k, v){
            content += `<option value="${v.id_cuti}">${v.nama_cuti}</option>`;
        })

        $('#id_cuti').append(content);
    }

    function load_detail(id){
        
        $.ajax({
            url: `<?= base_url('api/cuti/show/') ?>${auth.token}?id=${id}`,
            type: 'GET',
            dataType: 'JSON',
            success: function(response){
                if(response.data.length === 1){
                    $.each(response.data, function(k, v){
                        $('.id-page').append(` ${v.id}`)
                        $('#id_cuti').val(v.jenis_cuti.id_cuti);
                        $('.tgl_mulai').datepicker('setDate', new Date(v.tgl_mulai))
                        $('.tgl_selesai').datepicker('setDate', new Date(v.tgl_selesai))
                        $('#alamat').val(v.alamat);
                        $('#telepon').val(v.telepon);
                        $('#pengganti').val(v.pengganti.nik);
                        $('#nama_pengganti').val(v.pengganti.nama);
                    });
                } else {
                    location.hash = '#/cuti';
                }
            },
            error: function(err){
                location.hash = '#/cuti';
            }
        });
        
    }

    function load_jcuti(id, render_jcuti, load_detail){
        $.ajax({
            url: `<?= base_url('api/jenis_cuti/show/') ?>${auth.token}`,
            type: 'GET',
            dataType: 'JSON',
            success: function(response){
                if(response.data.length > 0){
                    render_jcuti(response.data)
                    load_detail(id)
                }
            }, 
            error: function(err){
                alert('Tidak dapat mengakses server');
            }
        })
    }

    $(document).ready(function(){
        var id = location.hash.substr(12);

        load_jcuti(id, render_jcuti, load_detail)

        var t_karyawan = $('#t_karyawan').DataTable({
            columnDefs: [{
                targets: [0,3],
                orderable: false
            }],
            autoWidth: false,
            language: {
                search: 'Cari Karyawan: _INPUT_',
            },
            responsive: true,
            processing: true,
            ajax: {   
               url: `<?= base_url('api/cuti/cari_pengganti/'); ?>${auth.token}?id_divisi=${auth.id_divisi}`,
               dataSrc: function(response){
                  var filter = [];

                  $.each(response.data, function(k,v){
                     if(v.status_karyawan === 'Aktif' && v.level.toLowerCase() === auth.level){
                        filter.push(v);
                     }
                  })

                  return filter;
               }
         },
            columns: [
                {"data": null, 'render': function(data, type, row){
                    return `<button type="button" class="btn btn-sm btn-success pilih" data-id="${row.nik}" data-nama="${row.nama}"><i class="fa fa-check"></i> Pilih</button>`
                }
                },
                {"data": 'nik'},
                {"data": 'nama'},
                {"data": 'telepon'},
                {"data": 'email'},
                {"data": 'jabatan'},
                {"data": 'nama_divisi'}
            ],
            order: [[1, 'desc']]
        });

        $('.tgl_mulai').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            orientation: "auto",
            startDate: new Date(),
        }).on('changeDate', function (selected) {
                var minDate = new Date(selected.date.valueOf());
                $('.tgl_selesai').datepicker('setStartDate', minDate);

                var start = $(".tgl_mulai").datepicker("getDate");
                var end = $(".tgl_selesai").datepicker("getDate");
                var days = parseInt((end - start) / (1000 * 60 * 60 * 24) + 1);
                $("#jumlah_cuti").val(days);
                
        });
        
        $(".tgl_selesai").datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
        }).on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf());
            $('#startdate').datepicker('setEndDate', maxDate);

            var start = $(".tgl_mulai").datepicker("getDate");
            var end = $(".tgl_selesai").datepicker("getDate");
            var days = parseInt((end - start) / (1000 * 60 * 60 * 24) + 1);
            $("#jumlah_cuti").val(days);
        });

        $(document).on('click', '.pilih', function(){
            var nik = $(this).data('id');
            var nama = $(this).data('nama');

            $('#pengganti').val(nik);
            $('#nama_pengganti').val(nama);

            $('#modal_karyawan').modal('hide');
        })

        $('#lookup_karyawan').on('click', function(){
            $('#modal_karyawan').modal('show');
        });

        $('#form_cuti').validate({
            rules: {
                id_cuti: "required",
                tgl_mulai: "required",
                tgl_selesai: "required",
                alamat: "required",
                telepon: "required",
                nama_pengganti: "required"
            },
            messages: {
                id_cuti: "Pilih jenis cuti yang akan diambil",
                tgl_mulai: "Pilih periode cuti",
                tgl_selesai: "Pilih periode cuti",
                alamat: "Masukkan alamat tujuan cuti",
                telepon: "Masukkan telepon darurat saat cuti",
                nama_pengganti: "Pilih pengganti pekerjaan"
            },
            errorClass: 'is-invalid',
            errorPlacement: function(error, element) {
                var name = $(element).attr("id");

                // error.appendTo(element.next());
                error.appendTo($('.invalid_'+name));
            },
            submitHandler: function(form){
                $.ajax({
                    url: `<?= base_url('api/cuti/edit/') ?>${auth.token}?id_pcuti=${id}`,
                    type: 'POST',
                    data: $(form).serialize(),
                    dataType: 'JSON',
                    beforeSend: function(){
                        $('#submit_add').html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
                    },
                    success: function(response){
                        if(response.status === 200){
                            toastr.info(response.message, response.description)
                            location.hash = '#/cuti';
                        } else {
                             $('#submit_add').html('Submit');
                            toastr.error(response.message, response.description)
                        }
                    },
                    error: function(err){
                         $('#submit_add').html('Submit');
                        toastr.error('Tidak dapat mengakases server', 'Gagal');
                    }
                })
            }
        })
    });
 </script>

