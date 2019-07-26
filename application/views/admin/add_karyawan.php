<!-- Breadcrumb-->
 <div class="row pt-2 pb-2">
    <div class="col-sm-9">
        <h4 class="page-title">Add Karyawan</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#/karyawan">Karyawan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Karyawan</li>
        </ol>
    </div>
 </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
            <div class="card-header text-uppercase">
              Form Pendaftaran Karyawan
            </div>
            <div class="card-body">
              <form class="form_add" id="wizard-vertical">
                    <h3>Data Pribadi</h3>
                    <section>
                        <div class="form-group">
                          <label>Nama</label>
                          <input type="text" name="nama" id="nama" class="form-control" />
                          <div class="invalid_nama"></div>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select class="form-control" name="kelamin" id="kelamin">
                              <option value=""></option>
                              <option value="Laki-laki">Laki-laki</option>
                              <option value="Perempuan">Perempuan</option>
                            </select>
                            <div class="invalid_kelamin"></div>
                        </div>
                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tmp_lahir" id="tmp_lahir" class="form-control" />
                            <div class="invalid_tmp_lahir"></div>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" />
                            <div class="invalid_tgl_lahir"></div>
                        </div>
                        <div class="form-group">
                            <label>Status Kawin</label>
                            <select class="form-control" id="status_kawin" name="status_kawin">
                              <option value=""></option>
                              <option value="Kawin">Kawin</option>
                              <option value="Belum Kawin">Belum Kawin</option>
                            </select>
                            <div class="invalid_status_kawin"></div>
                        </div>
                        <div class="form-group">
                            <label>Telepon</label>
                            <input type="text" name="telepon" id="telepon" class="form-control" />
                            <div class="invalid_telepon"></div>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="8" cols="80"></textarea>
                            <div class="invalid_alamat"></div>
                        </div>
                    </section>

                    <h3>Informasi</h3>
                    <section>
                        <div class="form-group">
                            <label>NIK</label>
                            <input type="text" name="nik" id="nik" class="form-control" />
                            <div class="invalid_nik"></div>
                        </div>
                        <div class="form-group">
                            <label>Pendidikan</label>
                            <select class="form-control" name="pendidikan" id="pendidikan">
                              <option value=""></option>
                              <option value="SD">SD</option>
                              <option value="SMP">SMP</option>
                              <option value="SMA">SMA</option>
                              <option value="SMK">SMK</option>
                              <option value="D3">D3</option>
                              <option value="S1">S1</option>
                              <option value="S2">S2</option>
                              <option value="S3">S3</option>
                            </select>
                            <div class="invalid_pendidikan"></div>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Masuk</label>
                            <input type="date" name="tgl_masuk" id="tgl_masuk" class="form-control" />
                            <div class="invalid_tgl_masuk"></div>
                        </div>
                        <div class="form-group">
                            <label>Status Karyawan</label>
                            <select class="form-control" name="status_karyawan" id="status_karyawan">
                              <option value=""></option>
                              <option value="Aktif">Aktif</option>
                              <option value="Nonaktif">Nonaktif</option>
                            </select>
                            <div class="invalid_status_karyawan"></div>
                        </div>
                        <div class="form-group">
                            <label>Jabatan</label>
                            <input type="text" name="jabatan" id="jabatan" class="form-control" />
                            <div class="invalid_jabatan"></div>
                        </div>
                        <div class="form-group">
                            <label>Divisi</label>
                            <div class="input-group">
                              <input type="hidden" name="id_divisi" id="id_divisi">
                              <input type="text" name="nama_divisi" id="nama_divisi" readonly class="form-control">
                              <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="cari_divisi"><i class="fa fa-search" ></i></button>
                              </div>
                            </div>
                            <div class="invalid_nama_divisi"></div>
                          </div>
                    </section>

                    <h3>Akun</h3>
                    <section>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" id="email" class="form-control"/>
                            <div class="invalid_email"></div>
                        </div>
                        <div class="form-group">
                            <label>Level</label>
                            <select class="form-control" name="level" id="level">
                              <option value=""></option>
                              <option value="Karyawan">Karyawan</option>
                              <option value="Kabag">Kabag</option>
                              <option value="Manager">Manager</option>
                              <option value="Admin">Admin</option>
                            </select>
                            <div class="invalid_level"></div>
                        </div>
                        <div class="form-group">
                            <label>Foto</label>
                            <input type="file" name="foto" id="foto" class="form-control"/>
                            <div class="invalid_foto"></div>
                        </div>
                        

                    </section>
                </form> <!-- End #wizard-vertical -->
            </div>
          </div>
        </div>
    </div>






 <div class="modal fade" id="modal_divisi">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="fa fa-star"></i> Lookup Divisi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="add_divisi">
            <div class="form-group">
               <div class="input-group">
                 <input type="text" name="nama_divisi" required class="form-control" placeholder="Divisi">
                 <div class="input-group-append">
                   <button class="btn btn-primary" type="submit" id="submit_divisi"><i class="fa fa-plus" ></i> Tambah</button>
                 </div>
               </div>
             </div>
          </form>

          <div class="table-responsive">
            <table class="table" id="t_divisi">
              <thead>
                <tr>
                  <th>Pilih</th>
                  <th>ID Divisi</th>
                  <th>Nama Divisi</th>
                  <th>Aksi</th>
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
  
    const addKaryawanController = (() => {
        const form = $('.form_add');

        const TABLE = $('#t_divisi').DataTable({
                            columnDefs: [{
                                targets: [0,3],
                                orderable: false
                            }],
                            autoWidth: false,
                            language: {
                                search: 'Cari Divisi: _INPUT_',
                            },
                            responsive: true,
                            processing: true,
                            ajax: '<?= base_url('api/divisi/show/'); ?>'+auth.token,
                            columns: [
                                {"data": null, 'render': function(data, type, row){
                                    return `<button type="button" class="btn btn-sm btn-success" id="pilih_divisi" data-id="${row.id_divisi}" data-nama="${row.nama_divisi}"><i class="fa fa-check"></i> Pilih</button>`
                                }
                                },
                                {"data": 'id_divisi'},
                                {"data": 'nama_divisi'},
                                {"data": null, 'render': function(data, type, row){
                                    return `<button type="button" class="btn btn-sm btn-danger" id="hapus_divisi" data-id="${row.id_divisi}"><i class="fa fa-trash"></i></button>`
                                }
                                },
                            ],
                            order: [[1, 'desc']]
                        });

        const searchDivisi = () => {
            $('#cari_divisi').on('click', function(){
                $('#modal_divisi').modal('show');
                $('#add_divisi')[0].reset();
            });
        }

        const pickDivisi = () => {
            $(document).on('click', '#pilih_divisi', function(){
                var id_divisi = $(this).attr('data-id');
                var nama_divisi = $(this).attr('data-nama');

                $('#id_divisi').val(id_divisi);
                $('#nama_divisi').val(nama_divisi);

                $('#modal_divisi').modal('hide');
            })
        }

        const deleteDivisi = () => {
            $(document).on('click', '#hapus_divisi', function(){
                var id_divisi = $(this).attr('data-id');
                $(this).addClass('disabled').html(`<i class="fa fa-spinner fa-spin"></i>`)

                $.ajax({
                    url: `<?= base_url('api/divisi/delete/') ?>${auth.token}?id_divisi=${id_divisi}`,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(response){
                    if(response.status === 200){
                        toastr.info(response.message, response.description)
                        t_divisi.ajax.reload();
                    } else {
                        $(this).removeClass('disabled').html(`<i class="fa fa-trash" ></i>`)
                        toastr.error(response.message, response.description)
                    }
                    },
                    error: function(){
                    $(this).removeClass('disabled').html(`<i class="fa fa-trash" ></i>`)
                    toastr.error('Tidak dapat mengakses server', 'Error')
                    }
                });
            });
        }

        const addDivisi = () => {
            $('#add_divisi').on('submit', function(e){
                e.preventDefault();

                $.ajax({
                    url: `<?= base_url('api/divisi/add/') ?>${auth.token}`,
                    type: 'POST',
                    data: $(this).serialize(),
                    beforeSend: function(){
                    $('#submit_divisi').addClass('disabled').html(`<i class="fa fa-spinner fa-spin"></i>`)
                    },
                    success: function(response){
                    if(response.status === 200){
                        toastr.info(response.message, response.description)
                        t_divisi.ajax.reload();
                        $('#add_divisi')[0].reset();
                    } else {
                        toastr.error(response.message, response.description)
                    }
                    $('#submit_divisi').removeClass('disabled').html(`<i class="fa fa-plus" ></i> Tambah`)
                    },
                    error: function(){
                    toastr.error('Tidak dapat mengakses server', 'Error')
                    $('#submit_divisi').removeClass('disabled').html(`<i class="fa fa-plus" ></i> Tambah`)
                    }

                })
            });
        }

        const setupValidate = () => {
          form.validate({
            rules: {
                nama: "required",
                kelamin: "required",
                tmp_lahir: "required",
                tgl_lahir: "required",
                status_kawin: "required",
                telepon: "required",
                alamat : "required",
                nik: "required",
                pendidikan: "required",
                tgl_masuk: "required",
                status_karyawan: "required",
                jabatan: "required",
                nama_divisi: "required",
                email: "required",
                level: "required",
                foto: "required",
            },
            messages: {
                nama: "Field wajib diisi",
                kelamin: "Field wajib diisi",
                tmp_lahir: "Field wajib diisi",
                tgl_lahir: "Field wajib diisi",
                status_kawin: "Field wajib diisi",
                telepon: "Field wajib diisi",
                alamat : "Field wajib diisi",
                nik: "Field wajib diisi",
                pendidikan: "Field wajib diisi",
                tgl_masuk: "Field wajib diisi",
                status_karyawan: "Field wajib diisi",
                jabatan: "Field wajib diisi",
                nama_divisi: "Field wajib diisi",
                email: "Field wajib diisi",
                level: "Field wajib diisi",
                foto: "Foto wajib diupload",
            },
            errorClass: 'is-invalid',
            errorPlacement: function(error, element) {
                var name = $(element).attr("id");

                // error.appendTo(element.next());
                error.appendTo($('.invalid_'+name));
            },
          })
        }

        const setupStep = () => {
          form.steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "fade",
                titleTemplate: '<span class="step">#index#</span> #title#',
                labels: {
                    finish: "Simpan"
                },
                onStepChanging: function (event, currentIndex, newIndex)
                {   
                    if (currentIndex > newIndex)
                    {
                        return true;
                    }

                    form.validate().settings.ignore = ":disabled,:hidden";
                    return form.valid();
                },
                onStepChanged: function (event, currentIndex, priorIndex)
                {
                    // Used to skip the "Warning" step if the user is old enough.
                    // if (currentIndex === 2 && Number($("#age-2").val()) >= 18)
                    // {
                    //     form.steps("next");
                    // }
                    // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
                    // if (currentIndex === 2 && priorIndex === 3)
                    // {
                    //     form.steps("previous");
                    // }
                },
                onFinishing: function (event, currentIndex)
                {
                    form.validate().settings.ignore = ":disabled";
                    return form.valid();
                },
                onFinished: function (event, currentIndex)
                {
                    form.submit();
                }
            })
        }

        const submitAdd = () => {
          form.on('submit', function(e){
              e.preventDefault();

              $.ajax({
                url: `<?= base_url('api/karyawan/add/') ?>${auth.token}`,
                type: 'POST',
                data: new FormData(this),
                processData:false,
                contentType:false,
                beforeSend: function(){
                  $('#submit_karyawan').addClass('disabled').html(`<i class="fa fa-spinner fa-spin"></i>`)
                },
                success: function(response){
                  if(response.status === 200){
                    toastr.info(response.message, response.description)
                    location.hash = '#/karyawan';
                  } else {
                    toastr.error(response.message, response.description)
                    $('#submit_karyawan').removeClass('disabled').html(`<i class="fa fa-check" ></i> Simpan`)
                  }
                },
                error: function(){
                  toastr.error('Tidak dapat mengakses server', 'Error')
                  $('#submit_karyawan').removeClass('disabled').html(`<i class="fa fa-check" ></i> Simpan`)
                }
              })
          })
        }

        return {
            init: () => {
                TABLE;
                pickDivisi();
                deleteDivisi();
                addDivisi();
                setupValidate();
                setupStep();
                submitAdd();
                searchDivisi();
            }
        }
    })();

    $(document).ready(function(){
        addKaryawanController.init();
    })
  </script>