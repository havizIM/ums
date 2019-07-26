<div class="row pt-2 pb-2">
    <div class="col-sm-9">
        <h4 class="page-title">Tambah Revisi</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#/revisi_absen">Pengajuan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Revisi</li>
        </ol>
    </div>
 </div>

 <div class="row">
   <div class="col-md-12">
     <div class="card">
        <div class="card-header">Formulir Revisi Absen</div>
        <div class="card-body">
            <form id="form_revisi">
                <div class="form-group row">
                    <label for="tgl_absensi" class="col-md-2 col-form-label">Tanggal Absensi</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control tgl_absensi" name="tgl_absensi" id="tgl_absensi" />        
                        <div class="invalid_tgl_absensi"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alasan" class="col-md-2 col-form-label">Alasan</label>
                    <div class="col-md-10">
                        <select name="alasan" id="alasan" class="form-control">
                            <option value="">-- Pilih Alasan --</option>
                            <option value="Tidak Finger Print">Tidak Finger Print</option>
                            <option value="Listrik Mati">Listrik Mati</option>
                            <option value="Mesin Print Rusak">Mesin Print Rusak</option>
                        </select>     
                        <div class="invalid_alasan"></div>
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
                    <label for="jam_datang" class="col-md-2 col-form-label">Jam Datang</label>
                    <div class="col-md-10">
                        <input type="time" class="form-control jam_datang" name="jam_datang" id="jam_datang" />        
                        <div class="invalid_jam_datang"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jam_pulang" class="col-md-2 col-form-label">Jam Pulang</label>
                    <div class="col-md-10">
                        <input type="time" class="form-control jam_pulang" name="jam_pulang" id="jam_pulang" />        
                        <div class="invalid_jam_pulang"></div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <a class="btn btn-danger btn-md" href="#/revisi_absen">Batal</a>
                    <button class="btn btn-info btn-md" type="submit" id="submit_add">Submit</button>
                </div>
            </form>
       </div>
     </div>
   </div>
 </div>

 <script>

    $(document).ready(function(){

        $('.tgl_absensi').datepicker({
            format: "dd-mm-yyyy",
            orientation: "auto",
            endDate: new Date(),
        });

        $('#form_revisi').validate({
            rules: {
                tgl_absensi: "required",
                alasan: "required",
                keterangan: "required",
                jam_datang: "required",
                jam_pulang: "required"
            },
            messages: {
                tgl_absensi: "Pilih jenis izin yang akan diajukan",
                alasan: "Pilih alasan revisi",
                keterangan: "Masukkan keterangan revisi",
                jam_datang: "Silahkan pilih jam datang",
                jam_pulang: "Silahkan pilih jam pulang"
            },
            errorClass: 'is-invalid',
            errorPlacement: function(error, element) {
                var name = $(element).attr("id");

                // error.appendTo(element.next());
                error.appendTo($('.invalid_'+name));
            },
            submitHandler: function(form){
                $.ajax({
                    url: `<?= base_url('api/revisi_absen/add/') ?>${auth.token}`,
                    type: 'POST',
                    data: $(form).serialize(),
                    dataType: 'JSON',
                    beforeSend: function(){
                        $('#submit_add').html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
                    },
                    success: function(response){
                        if(response.status === 200){
                            toastr.info(response.message, response.description)
                            location.hash = '#/revisi_absen';
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

