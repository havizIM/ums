<div class="row pt-2 pb-2">
  <div class="col-sm-9">
    <h4 class="page-title">Import Absensi</h4>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Import Absensi</li>
    </ol>
  </div>
</div>

<div class="row">
   <div class="col-md-12">
     <div class="card">
        <div class="card-header">Import Absensi</div>
        <div class="card-body">
            <form action="#" class="dropzone" id="import_absen" enctype="multipart/form-data">
                <div class="dz-message" data-dz-message><span>Import Absen dengan format .xls xlsx</span></div>
                <div class="fallback">
                  <input name="file" type="file" id="file">
                </div>

                <button type="submit" class="btn btn-info btn-md" id="submit_import" style="float: right"> Import</button>
              </form>
        </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12" id="">
        <form id="preview_absen"></form>
    </div>
</div>


<script>

    const DOM = {
        import_absen: '#import_absen',
        submit_import: '#submit_import',
        submit_upload: '#submit_upload',
        file: '#file',
        preview: '#preview_absen'

    }

    const importUI = (() => {
        return {
            renderNoData: () => {
                console.log('No data found...')
            },
            renderAbsen: (data) => {
                var html = `
                    <div class="card">
                        <div class="card-header">Absensi</div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>NIK</th>
                                            <th>Tanggal</th>
                                            <th>Jam Masuk</th>
                                            <th>Jam Keluar</th>
                                        </tr>
                                    </thead>
                                    <tbody>`

                                    $.each(data, function(k, v){
                                        html += `
                                            <tr>
                                                <td>
                                                    ${v.nik}
                                                    <input type="hidden" name="nik[]" value="${v.nik}">
                                                </td>
                                                <td>
                                                    ${v.tgl_absen}
                                                    <input type="hidden" name="tgl_absen[]" value="${v.tgl_absen}">
                                                </td>
                                                <td>
                                                    ${v.jam_masuk}
                                                    <input type="hidden" name="jam_masuk[]" value="${v.jam_masuk}">
                                                </td>
                                                <td>
                                                    ${v.jam_keluar}
                                                    <input type="hidden" name="jam_keluar[]" value="${v.jam_keluar}">
                                                </td>
                                            </tr>
                                        `;
                                    })

                html += `   
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-success btn-md" id="submit_upload" style="float: right">Upload</button>
                            </div>
                        </div>
                    </div>
                `;

               $(DOM.preview).html(html);
            }
        }
    })();

    const importController = ((UI) => {

        const submitImport = () => {

            $(DOM.import_absen).submit(function(e){
                e.preventDefault();


                if($(DOM.file).val() === ''){
                    toastr.error('Pilih file yang akan di upload');
                } else {
                    $.ajax({
                        url: `<?= base_url('api/absensi/preview_absen/') ?>${auth.token}`,
                        type: 'POST',
                        dataType: 'JSON',
                        data: new FormData(this),
                        processData:false,
                        contentType:false,
                        beforeSend: function(){
                            $(DOM.submit_import).addClass('disabled').html('<i class="fa fa-spinner fa-spin"></i>');
                            
                        }, 
                        success: function(res){
                            if(res.status === 200) {
                                if(res.data.length === 0){
                                    UI.renderNoData();
                                } else {
                                    UI.renderAbsen(res.data)
                                }
                            } else {
                                 UI.renderNoData();
                            }
                            $(DOM.submit_import).removeClass('disabled').html('Import');
                        },
                        error: function(err){
                            $(DOM.submit_import).removeClass('disabled').html('Import');
                        }
                    })
                }
            })
        }

        const submitUpload = () => {
            $(DOM.preview).submit(function(e){
                e.preventDefault();

                $.ajax({
                    url: `<?= base_url('api/absensi/import_absen/') ?>${auth.token}`,
                    type: 'POST',
                    dataType: 'JSON',
                    data: $(this).serialize(),
                    beforeSend: function(){
                        $(DOM.submit_upload).addClass('disabled').html('<i class="fa fa-spinner fa-spin"></i>'); 
                    }, 
                    success: function(res){
                        if(res.status === 200) {
                            toastr.success(res.message);
                            location.hash = '#/cetak_absensi';
                        } else {
                            toastr.error(res.message);
                        }
                        $(DOM.submit_upload).removeClass('disabled').html('Upload');
                    },
                    error: function(err){
                        $(DOM.submit_upload).removeClass('disabled').html('Upload');
                    }
                })
            })
        }
        

        return {
            init: () => {
                submitImport();
                submitUpload();
            }
        }
    })(importUI);

    $(document).ready(function(){
        importController.init();
    })
</script>