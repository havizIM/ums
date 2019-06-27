<!-- Breadcrumb-->
 <div class="row pt-2 pb-2">
    <div class="col-sm-9">
        <h4 class="page-title">Detail - Izin</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#/approval_izin">Approval Izin</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Approval - Izin</li>
        </ol>
    </div>
 </div>

 <div class="row" id="detail_content"></div>
  

 <script>

    function render_content(data){
        var content = '';
        
            content += `<div class="col-md-4">
                            <div class="card">
                                <div class="card-header" id="id_content">Detail Izin - ${data.id}</div>
                                <div class="card-body">`;

            if(data.status === 'Proses'){
                content += `<div class="text-center">
                                <div class="btn-group group-round">
                                    <button class="btn btn-sm btn-danger" id="tolak_izin" data-id="${data.id}"><i class="fa fa-close"></i> Tolak</button>
                                    <button class="btn btn-sm btn-info" id="approve_izin" data-id="${data.id}"><i class="fa fa-check"></i> Approve</button>
                                </div>
                            </div>`;
            }  else if(data.status === 'Ditolak' || data.status === 'Batal'){
                content += `<div class="text-center">
                                <h4 class="text-danger">${data.status} <i class="fa fa-close"></i></h4>
                            </div>`;
            } else {
                 content += `<div class="text-center">
                                <h4 class="text-success">${data.status} <i class="fa fa-check"></i></h4>
                            </div>`;
            }

            content += `        </div>
                            </div>

                            <div class="card">
                                <div class="card-header">Data Pemohon</div>
                                <div class="card-body">
                                    <div class="list-group">
                                        <a href="javaScript:void();" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="mb-1"><b>NIK</b></p>
                                            <small><i class="fa fa-address-card"></i></small>
                                        </div>
                                        <small class="mb-1">${data.pemohon.nik || '-'}</small>
                                        </a>
                                        <a href="javaScript:void();" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="mb-1"><b>Nama</b></p>
                                            <small><i class="fa fa-user"></i></small>
                                        </div>
                                        <small class="mb-1">${data.pemohon.nama || '-'}</small>
                                        </a>
                                        <a href="javaScript:void();" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="mb-1"><b>Jabatan</b></p>
                                            <small><i class="fa fa-server"></i></small>
                                        </div>
                                        <small class="mb-1">${data.pemohon.jabatan || '-'}</small>
                                        </a>
                                        <a href="javaScript:void();" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="mb-1"><b>Divisi</b></p>
                                            <small><i class="fa fa-university"></i></small>
                                        </div>
                                        <small class="mb-1">${data.pemohon.divisi || '-'}</small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="alert alert-icon-info alert-dismissible" role="alert">
                                <div class="alert-icon icon-part-info">
                                <i class="icon-info"></i>
                                </div>
                                <div class="alert-message">
                                <span>
                                    <strong>Perhatian</strong><br/>
                                    Dengan mengapprove Data Izin ini maka anda menyetujui pengajuan izin dari yang bersangkutan. 
                                </span>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">Detail Pengajuan</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <th>Tanggal Izin</th>
                                                <th>Jenis Cuti</th>
                                                <th>Keterangan</th>
                                            </thead>
                                            <tbody>
                                                <td>${data.tgl_izin}</td>
                                                <td>${data.jenis_izin.keperluan}</td>
                                                <td>${data.keterangan}</td>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">Approval</div>
                                <div class="card-body">`;

                                if(data.approval.length < 1){
                                    content += `<div class="text-center">Belum ada Approval</div>`;
                                } else {
                                    content += `<div class="list-group">`;
                                        $.each(data.approval, function(k, v){
                                            content += `<a href="javaScript:void();" class="list-group-item list-group-item-action flex-column align-items-start">
                                                        <div class="d-flex w-100 justify-content-between">
                                                            <p class="mb-1"><b>${v.keterangan}</b></p>
                                                            <small>${v.tgl_approval}</small>
                                                        </div>
                                                        <small class="mb-1">Oleh ${v.nama} - ${v.jabatan}</small>
                                                        </a>`;
                                        });          
                                    content += `</div>`;
                                }
                                    
                content += `                </div>
                                        </div>
                                    </div>`;

            $('#detail_content').html(content);

            
    }

    function load_data(id, render_content){
        
        $.ajax({
            url: `<?= base_url('api/approval_izin/show/') ?>${auth.token}?id=${id}`,
            type: 'GET',
            dataType: 'JSON',
            beforeSend: function(){
                $('#detail_content').html('<h4>Loading........</h4>')
            },
            success: function(response){
                if(response.data.length === 1){
                    $.each(response.data, function(k, v){
                        render_content(v);
                    });
                } else {
                    location.hash = '#/approval_izin'
                }
            },
            error: function(err){
                $('#detail_content').html('<h4>Tidak dapat mengakses server</h4>')
            }
        });
        
    }

    $(document).ready(function(){
        var id = location.hash.substr(16);

        load_data(id, render_content);

        $(document).on('click', '#tolak_izin', function(){
            var id = $(this).attr('data-id');

            swal({
                title: "Apa Anda yakin ingin membatalkan?",
                text: "Data cuti akan dibatalkan secara permanen",
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
                    url: `<?= base_url('api/approval_izin/tolak/') ?>${auth.token}?id=${id}`,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(response){
                        if(response.status === 200){
                            toastr.info(response.message, response.description)
                            location.hash = '#/approval_izin';
                            swal.close();
                        } else {
                            toastr.error(response.message, response.description)
                        }
                    },
                    error: function(){
                        toastr.error('Tidak dapat mengakses server')
                    }
                });
                }
            })
        })

        $(document).on('click', '#approve_izin', function(){
            var id = $(this).attr('data-id');

            swal({
                title: "Apa Anda yakin ingin menyetujui?",
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
                    url: `<?= base_url('api/approval_izin/approve/') ?>${auth.token}?id=${id}`,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(response){
                        if(response.status === 200){
                            toastr.info(response.message, response.description)
                            location.hash = '#/approval_izin';
                            swal.close();
                        } else {
                            toastr.error(response.message, response.description)
                        }
                    },
                    error: function(){
                        toastr.error('Tidak dapat mengakses server')
                    }
                });
                }
            })
        })
    })
 </script>