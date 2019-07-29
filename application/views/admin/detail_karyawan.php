<!-- Breadcrumb-->
 <div class="row pt-2 pb-2">
   <div class="col-sm-9">
   <h4 class="page-title">Detail Karyawan</h4>
     <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
       <li class="breadcrumb-item"><a href="#/karyawan">Karyawan</a></li>
       <li class="breadcrumb-item active" aria-current="page">Detail Karyawan</li>
     </ol>
   </div>

   <div class="col-sm-3" id="render_action"></div>
 </div>

 <div class="row" id="content_detail">
    
 </div>

 <script>

    const DOM = {
        action: '#render_action',
        container: '#content_detail'
    }

    const nik = location.hash.substr(11);

    const detailKaryawanUI = (() => {
        return {
            renderAction: () => {
                let html = `
                            <div class="btn-group float-sm-right">
                                <a href="#/edit_karyawan/${nik}" class="btn btn-outline-success waves-effect waves-light"><i class="fa fa-pencil mr-1"></i> Ubah</a>
                                <button type="button" class="btn btn-outline-danger data-id="${nik}" id="hapus_karyawan" waves-effect waves-light"><i class="fa fa-close mr-1"></i> Hapus</button>
                            </div>`

                $(DOM.action).html(html);
            },
            renderNoData: () => {
                console.log('No Data....');
            },
            renderDetail: (data) => {
                let html = '';

                $.each(data, function(k, v){
                    html += `
                        <div class="col-md-7">
                            <div id="accordion3">
                                <div class="card mb-2">
                                    <div class="card-header bg-dark">
                                        <button class="btn btn-link text-white shadow-none" data-toggle="collapse" data-target="#collapse-6" aria-expanded="true" aria-controls="collapse-7">
                                            Data Personal
                                        </button>
                                    </div>
    
                                    <div id="collapse-6" class="collapse show" data-parent="#accordion3" style="">
                                        <div class="card-body">
                                            <div class="list-group">
                                                <a href="javaScript:void();" class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">NIK</h5>
                                                    <small><i class="fa fa-id-card fa-2x"></i></small>
                                                </div>
                                                <p class="mb-1">${v.nik}</p>
                                                </a>
    
                                                <a href="javaScript:void();" class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">Nama</h5>
                                                    <small><i class="fa fa-2x fa-user-o"></i></small>
                                                </div>
                                                <p class="mb-1">${v.nama}</p>
                                                </a>
                                                
                                                <a href="javaScript:void();" class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">Tempat/Tanggal Lahir</h5>
                                                    <small><i class="fa fa-2x fa-calendar"></i></small>
                                                </div>
                                                <p class="mb-1">${v.tmp_lahir}, ${v.tgl_lahir}</p>
                                                </a>

                                                <a href="javaScript:void();" class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">Jenis Kelamin</h5>
                                                    <small><i class="fa fa-2x fa-venus-mars"></i></small>
                                                </div>
                                                <p class="mb-1">${v.kelamin}</p>
                                                </a>

                                                <a href="javaScript:void();" class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">Status Perkawinan</h5>
                                                    <small><i class="fa fa-2x fa-genderless"></i></small>
                                                </div>
                                                <p class="mb-1">${v.status_kawin}</p>
                                                </a>

                                                <a href="javaScript:void();" class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">Pendidikan</h5>
                                                    <small><i class="fa fa-2x fa-graduation-cap"></i></small>
                                                </div>
                                                <p class="mb-1">${v.pendidikan}</p>
                                                </a>

                                                <a href="javaScript:void();" class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">Alamat</h5>
                                                    <small><i class="fa fa-2x fa-map-marker"></i></small>
                                                </div>
                                                <p class="mb-1">${v.alamat}</p>
                                                </a>

                                                <a href="javaScript:void();" class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">Telepon</h5>
                                                    <small><i class="fa fa-2x fa-mobile"></i></small>
                                                </div>
                                                <p class="mb-1">${v.telepon}</p>
                                                </a>

                                                <a href="javaScript:void();" class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">Tgl Masuk</h5>
                                                    <small><i class="fa fa-2x fa-calendar"></i></small>
                                                </div>
                                                <p class="mb-1">${v.tgl_masuk}</p>
                                                </a>

                                                <a href="javaScript:void();" class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">Status Karyawan</h5>
                                                    <small><i class="fa fa-2x fa-cog"></i></small>
                                                </div>
                                                <p class="mb-1">${v.status_karyawan}</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card card-primary">
                                <img src="<?= base_url() ?>doc/foto/${v.foto}" onerror="this.onerror=null;this.src='<?= base_url() ?>assets/default_user.jpg ?>';" class="card-img-top" alt="Card image cap" style="height: 350px">
                            </div>
                            <div id="accordion4">
                                <div class="card mb-2">
                                    <div class="card-header bg-dark">
                                        <button class="btn btn-link text-white shadow-none" data-toggle="collapse" data-target="#collapse-7" aria-expanded="true" aria-controls="collapse-7">
                                            Data Divisi
                                        </button>
                                    </div>
    
                                    <div id="collapse-7" class="collapse show" data-parent="#accordion4" style="">
                                        <div class="card-body">
                                            <div class="list-group">
                                                <a href="javaScript:void();" class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">ID Divisi</h5>
                                                    <small><i class="fa fa-2x fa-check"></i></small>
                                                </div>
                                                <p class="mb-1">${v.id_divisi}</p>
                                                </a>
    
                                                <a href="javaScript:void();" class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">Jabatan</h5>
                                                    <small><i class="fa fa-2x fa-caret-square-o-up"></i></small>
                                                </div>
                                                <p class="mb-1">${v.jabatan}</p>
                                                </a>
                                                
                                                <a href="javaScript:void();" class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">Divisi</h5>
                                                    <small><i class="fa fa-2x fa-bank"></i></small>
                                                </div>
                                                <p class="mb-1">${v.nama_divisi}</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="accordion5">
                                <div class="card mb-2">
                                    <div class="card-header bg-dark">
                                        <button class="btn btn-link text-white shadow-none" data-toggle="collapse" data-target="#collapse-8" aria-expanded="true" aria-controls="collapse-8">
                                            Data Akun
                                        </button>
                                    </div>
    
                                    <div id="collapse-8" class="collapse show" data-parent="#accordion5" style="">
                                        <div class="card-body">
                                            <div class="list-group">
                                                <a href="javaScript:void();" class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">Email</h5>
                                                    <small><i class="fa fa-2x fa-envelope-open"></i></small>
                                                </div>
                                                <p class="mb-1">${v.email}</p>
                                                </a>
    
                                                <a href="javaScript:void();" class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">Level</h5>
                                                    <small><i class="fa fa-2x fa-cogs"></i></small>
                                                </div>
                                                <p class="mb-1">${v.level}</p>
                                                </a>
                                                
                                                <a href="javaScript:void();" class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">Tgl Registrasi</h5>
                                                    <small><i class="fa fa-2x fa-calendar"></i></small>
                                                </div>
                                                <p class="mb-1">${v.tgl_registrasi}</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `
                })


                $(DOM.container).html(html);
            }
        }
    })();

    const detailKaryawanController = ((UI) => {
        
        const getDetail = () => {
            $.ajax({
                url: `<?= base_url('api/karyawan/show/') ?>${auth.token}?nik=${nik}`,
                type: 'GET',
                dataType: 'JSON',
                success: function(res){
                    let { status, data } = res;

                    if(status === 200){
                        if(data.length === 1){
                            UI.renderAction();
                            UI.renderDetail(data);
                        } else {
                            UI.renderNoData();
                        }
                    } else {
                        UI.renderNoData();
                    }
                    
                },
                error: function(res){
                    UI.renderNoData();
                }
            })
        }

        const clickDelete = () => {
            $(document).on('click', '#hapus_karyawan', function(){
                var nik = $(this).attr('data-id');

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
                        url: '<?= base_url('api/karyawan/delete/') ?>'+auth.token,
                        type: 'GET',
                        dataType: 'JSON',
                        success: function(response){
                        if(response.status === 200){
                        } else {
                            toastr.error(response.message)
                        }
                        },
                        error: function(){
                        toastr.error(response.message)
                        }
                    });
                    }
                })
            })
        }

        return {
            init: () => {
                getDetail();
                clickDelete();
            }
        }
    })(detailKaryawanUI);

    $(document).ready(function(){
        detailKaryawanController.init();
    })
 </script>