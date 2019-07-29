<div class="row pt-2 pb-2">
    <div class="col-sm-9">
        <h4 class="page-title">Edit Izin</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#/izin">Pengajuan</a></li>
            <li class="breadcrumb-item active id-page" aria-current="page">Edit Izin</li>
        </ol>
    </div>
 </div>

 <div class="row">
   <div class="col-md-12">
     <div class="card">
        <div class="card-header id-page">Formulir Cuti</div>
        <div class="card-body">
            <form id="form_cuti" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="id_cuti" class="col-md-2 col-form-label">Jenis Cuti</label>
                    <div class="col-md-10">
                        <select name="id_izin" id="id_izin" class="form-control">
                            <option value="">-- Pilih Jenis Izin --</option>
                        </select>
                        <div class="invalid_id_izin"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tgl_izin" class="col-md-2 col-form-label">Tanggal Izin</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control tgl_izin" name="tgl_izin" id="tgl_izin" />        
                        <div class="invalid_tgl_izin"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="keterangan" class="col-md-2 col-form-label">Keterangan</label>
                    <div class="col-md-10">
                        <textarea name="keterangan" id="keterangan" rows="5" class="form-control"></textarea>
                        <div class="invalid_keterangan"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tgl_izin" class="col-md-2 col-form-label">Lampiran</label>
                    <div class="col-md-10">
                        <select name="lampiran" id="lampiran" class="form-control">
                            <option value="T">T</option>
                            <option value="Y">Y</option>
                        </select>        
                        <div class="invalid_lampiran"></div>
                    </div>
                </div>
                <div class="form-group row row_lampiran" style="display: none">
                    <label for="tgl_izin" class="col-md-2 col-form-label">Nama Lampiran</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control nama_lampiran" name="nama_lampiran" id="nama_lampiran" />        
                        <div class="invalid_nama_lampiran"></div>
                    </div>
                </div>
                <div class="form-group row row_lampiran" style="display: none">
                    <label for="tgl_izin" class="col-md-2 col-form-label">File</label>
                    <div class="col-md-10">
                        <input type="file" class="form-control lampiran_izin" name="lampiran_izin" id="lampiran_izin" />        
                        <div class="invalid_lampiran_izin"></div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <a class="btn btn-danger btn-md" href="#/izin">Batal</a>
                    <button class="btn btn-info btn-md" type="submit" id="submit_add">Simpan</button>
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
    function render_jizin(data){
        var content = '';

        $.each(data, function(k, v){
            content += `<option value="${v.id_izin}">${v.keperluan}</option>`;
        })

        $('#id_izin').append(content);
    }

    function load_detail(id){
        
        $.ajax({
            url: `<?= base_url('api/izin/show/') ?>${auth.token}?id=${id}`,
            type: 'GET',
            dataType: 'JSON',
            success: function(response){
                if(response.data.length === 1){
                    $.each(response.data, function(k, v){
                        $('.id-page').append(` ${v.id}`)
                        $('#id_izin').val(v.jenis_izin.id_izin);
                        $('.tgl_izin').datepicker('setDate', new Date(v.tgl_izin))
                        $('#keterangan').val(v.keterangan);

                        if(v.lampiran.length === 0){
                            $('#lampiran').val('T').trigger('change');
                        } else {
                            $('#lampiran').val('Y').trigger('change');

                            $.each(v.lampiran, function(k1, v1){
                                $('#nama_lampiran').val(v1.nama_lampiran);
                            })
                        }
                    });
                } else {
                    location.hash = '#/izin';
                }
            },
            error: function(err){
                location.hash = '#/izin';
            }
        });
        
    }

    function load_jizin(id, render_jizin, load_detail){
        $.ajax({
            url: `<?= base_url('api/jenis_izin/show/') ?>${auth.token}`,
            type: 'GET',
            dataType: 'JSON',
            success: function(response){
                if(response.data.length > 0){
                    render_jizin(response.data)
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

        load_jizin(id, render_jizin, load_detail)

        $('#lampiran').on('change', function(){
            var myval = $(this).val();
            if(myval === 'Y'){
                $('.row_lampiran').show()
            } else {
                $('.row_lampiran').hide()
            }
        })

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
               url: `<?= base_url('api/karyawan/show/'); ?>${auth.token}?id_divisi=${auth.id_divisi}`,
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
                id_izin: "required",
                tgl_izin: "required",
                keterangan: "required",
                nama_lampiran: {
                    required: function(element){
                        return ($('#lampiran').val() === 'Y')
                    }
                }
            },
            messages: {
                id_izin: "Pilih jenis izin yang akan diajukan",
                tgl_izin: "Pilih tanggal izin",
                keterangan: "Masukkan keterangan izin",
                nama_lampiran: {
                    required: "File harus diisi"
                }
            },
            errorClass: 'is-invalid',
            errorPlacement: function(error, element) {
                var name = $(element).attr("id");

                // error.appendTo(element.next());
                error.appendTo($('.invalid_'+name));
            },
            submitHandler: function(form){
                $.ajax({
                    url: `<?= base_url('api/izin/edit/') ?>${auth.token}?id_pizin=${id}`,
                    type: 'POST',
                    data: $(form).serialize(),
                    dataType: 'JSON',
                    beforeSend: function(){
                        $('#submit_add').html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
                    },
                    success: function(response){
                        if(response.status === 200){
                            toastr.info(response.message, response.description)
                            location.hash = '#/izin';
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

