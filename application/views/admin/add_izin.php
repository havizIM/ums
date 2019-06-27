<div class="row pt-2 pb-2">
    <div class="col-sm-9">
        <h4 class="page-title">Tambah Izin</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#/izin">Pengajuan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Izin</li>
        </ol>
    </div>
 </div>

 <div class="row">
   <div class="col-md-12">
     <div class="card">
        <div class="card-header">Formulir Izin</div>
        <div class="card-body">
            <form id="form_izin">
                <div class="form-group row">
                    <label for="id_izin" class="col-md-2 col-form-label">Jenis Izin</label>
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
                <div class="form-group text-center">
                    <a class="btn btn-danger btn-md" href="#/izin">Batal</a>
                    <button class="btn btn-info btn-md" type="submit" id="submit_add">Submit</button>
                </div>
            </form>
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

    function load_jizin(render_jcuti){
        $.ajax({
            url: `<?= base_url('api/jenis_izin/show/') ?>${auth.token}`,
            type: 'GET',
            dataType: 'JSON',
            success: function(response){
                if(response.data.length > 0){
                    render_jcuti(response.data)
                }
            },
            error: function(err){
                alert('Tidak dapat mengakses server');
            }
        })
    }

    $(document).ready(function(){
        load_jizin(render_jizin);

        $('.tgl_izin').datepicker({
            format: "dd-mm-yyyy",
            orientation: "auto",
            endDate: new Date(),
        });

        $('#form_izin').validate({
            rules: {
                id_izin: "required",
                tgl_izin: "required",
                keterangan: "required"
            },
            messages: {
                id_izin: "Pilih jenis izin yang akan diajukan",
                tgl_izin: "Pilih tanggal izin",
                keterangan: "Masukkan keterangan izin",
            },
            errorClass: 'is-invalid',
            errorPlacement: function(error, element) {
                var name = $(element).attr("id");

                // error.appendTo(element.next());
                error.appendTo($('.invalid_'+name));
            },
            submitHandler: function(form){
                $.ajax({
                    url: `<?= base_url('api/izin/add/') ?>${auth.token}`,
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
