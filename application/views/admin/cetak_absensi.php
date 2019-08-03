<div class="row pt-2 pb-2">
    <div class="col-sm-9">
        <h4 class="page-title">Cetak Absensi</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cetak Absensi</li>
        </ol>
    </div>
 </div>

 <div class="row">
   <div class="col-md-12">
     <div class="card">
        <div class="card-header">Filter Absensi</div>
        <div class="card-body">
            <form id="form_filter">
                <div class="form-group row">
                    <label for="alasan" class="col-md-2 col-form-label">Pilih Karyawan</label>
                    <div class="col-md-10">
                        <select name="nik" id="nik" class="form-control"></select>
                        <div class="invalid_nik"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alasan" class="col-md-2 col-form-label">Pilih Bulan</label>
                    <div class="col-md-10">
                        <select name="bulan" id="bulan" class="form-control">
                            
                        </select>
                        <div class="invalid_bulan"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alasan" class="col-md-2 col-form-label">Pilih Tahun</label>
                    <div class="col-md-10">
                        <select name="tahun" id="tahun" class="form-control"></select>
                        <div class="invalid_tahun"></div>
                    </div>
                </div>
                <div class="form-group text-right">
                    <button class="btn btn-info btn-md" type="submit" id="submit_filter">Submit</button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <div class="col-md-12" id="content_absen">
        
    </div>
</div>

<script>
    const DOM = {
        content: '#content_absen',
        form: '#form_filter',
        nik: '#nik',
        tahun: '#tahun',
        bulan: '#bulan',
        submit: '#submit_filter'
    }

    const cetakAbsenUI = (() => {
        return {
            renderNoKaryawan: () => {
                let html = `
                    <option value="">-- Pilih Karyawan --</option>
                `;

                $(DOM.nik).html(html);
            },

            renderNoAbsen: () => {
               console.log('No Absensi...')
            },
            renderKaryawan: (data) => {
                let html = `
                    <option value="">-- Pilih Karyawan --</option>
                `

                $.each(data, function(k,v){
                    html += `
                        <option value="${v.nik}">${v.nik} - ${v.nama}</option>
                    `;
                })

                $(DOM.nik).html(html);
            },
            renderTahun: (data) => {
                let html = `
                    <option value="">-- Pilih Tahun --</option>
                `

                $.each(data, function(k,v){
                    html += `
                        <option value="${v}">${v}</option>
                    `;
                })

                $(DOM.tahun).html(html);
            },
            renderBulan: (data) => {
                var monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
                let html = `
                    <option value="">-- Pilih Bulan --</option>
                `
                $.each(data, function(k,v){
                    html += `
                        <option value="${parseInt(v+1)}">${monthNames[v]}</option>
                    `;
                })

                $(DOM.bulan).html(html);
            },
            renderAbsensi: (data) => {
                let html = '';
                let bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

                $.each(data, function(k, v){

                    html = `
                        <div class="card">
                            <div class="card-header">
                                Absensi ${v.nik} - ${v.nama}
                                <div class="btn-group" style="float: right">
                                    <button class="btn btn-success btn-md" id="print_absen"><i class="fa fa-print"></i> Print</button>
                                </div>
                            </div>
                            <div class="card-body" id="print_area">
                                <div class="row">
                                    <div class="col-md-12 text-center" style="margin-bottom: 20px;">
                                        <h3>PT. Cipta KreasiSandang Mandiri</h3>
                                        <h4>Gang Jangkung No. II PP, Penjaringan Jakarta Utara 14450</h4>
                                        <h5>Telp. 0622-16619187 Fax. 0622-16619187</h5>
                                        <hr>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <center><h5>Absensi Periode ${bulan[v.bulan-1]} ${v.tahun}</h5></center><br>
                                    </div>

                                    <div class="col-md-6">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>NIK</th>
                                                <td>${v.nik}</td>
                                            </tr>
                                            <tr>
                                                <th>Nama</th>
                                                <td>${v.nama}</td>
                                            </tr>
                                            <tr>
                                                <th>Jabatan</th>
                                                <td>${v.jabatan}</td>
                                            </tr>
                                            <tr>
                                                <th>Divisi</th>
                                                <td>${v.divisi}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div><br><br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Jam Masuk</th>
                                                    <th>Jam Pulang</th>
                                                    <th>Cuti</th>
                                                    <th>Keterangan Cuti</th>
                                                    <th>Izin</th>
                                                    <th>Keterangan Izin</th>
                                                </tr>
                                            </thead>
                                            <tbody>`

                                            if(v.absensi.length === 0){
                                                 html += `
                                                        <tr>
                                                            <td colspan="7"><center>Tidak ada absensi</center></td>
                                                        </tr>
                                                    `;
                                            } else {
                                                $.each(v.absensi, function(k2, v2){
                                                    html += `
                                                        <tr>
                                                            <td>${v2.tgl}</td>
                                                            <td>${v2.jam_m !== '-' ? v2.jam_m : '-'}</td>
                                                            <td>${v2.jam_k !== '-' ? v2.jam_k : '-'}</td>
                                                            <td>${v2.ket_cuti !== '-' ? 'Y' : 'T'}</td>
                                                            <td>${v2.ket_cuti !== '-' ? v2.ket_cuti : 'T'}</td>
                                                            <td>${v2.ket_izin !== '-' ? 'Y' : 'T'}</td>
                                                            <td>${v2.ket_izin !== '-' ? v2.ket_izin : 'T'}</td>
                                                        </tr>
                                                    `;
                                                })
                                            }
                                                
                    html +=                 `
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                })
                
                $(DOM.content).html(html);
            }
        }
    })();

    const cetakAbsenController = ((UI) => {

        const getKaryawan = () => {
            $.ajax({
                url: `<?= base_url('api/karyawan/show/') ?>${auth.token}`,
                type: 'GET',
                dataType: 'JSON',
                success: function(res){
                    if(res.status === 200){
                        if(res.data.length === 0){
                            UI.renderNoKaryawan();
                        } else {
                            UI.renderKaryawan(res.data)
                        }
                    }else {
                        UI.renderNoKaryawan();
                    }
                },
                error: function(err){
                    UI.renderNoKaryawan();
                }
            })
        }

        const getTahun = () => {
            var currentYear = new Date().getFullYear(), years = [];
            var startYear = startYear || 2015;

            while ( startYear <= currentYear ) {
                years.push(startYear++);
            }   
            
            UI.renderTahun(years);
        }

        const getBulan = () => {
            var today = new Date();
            var last3Months = []

            for (i = 0; i < 3; i++) {
                last3Months.push((today.getMonth() - i));
            }

            UI.renderBulan(last3Months);
        }

        const submitFilter = () => {
            $(DOM.form).validate({
                rules: {
                    nik: "required",
                    bulan: "required",
                    tahun: "required"
                },
                messages: {
                    nik: "Pilih NIK Karyawan",
                    bulan: "Pilih Bulan Absensi",
                    tahun: "Pilih Tahun Absensi"
                },
                errorClass: 'is-invalid',
                errorPlacement: function(error, element) {
                    var name = $(element).attr("id");

                    error.appendTo($('.invalid_'+name));
                },
                submitHandler: function(form){
                    let nik = $('#nik').val();
                    let bulan = $('#bulan').val();
                    let tahun = $('#tahun').val();
                    
                    $.ajax({
                        url: `<?= base_url('api/absensi/show/') ?>${auth.token}?nik=${nik}&bulan=${bulan}&tahun=${tahun}`,
                        type: 'GET',
                        dataType: 'JSON',
                        beforeSend: function(){
                            $(DOM.submit).html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
                        },
                        success: function(response){
                            if(response.status === 200){
                                if(response.data.length === 1){
                                    UI.renderAbsensi(response.data);
                                } else {
                                    UI.renderNoAbsen();
                                }
                            } else {
                                UI.renderNoAbsen();
                            }
                            $(DOM.submit).html('Submit');
                        },
                        error: function(err){
                            UI.renderNoAbsen();
                            $(DOM.submit).html('Submit');
                            toastr.error('Tidak dapat mengakases server', 'Gagal');
                        }
                    })
                }
            })
        }

        printAbsen = () => {
            $(document).on('click', '#print_absen', function(){
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode,
                    popClose: close
                };

                $('#print_area').printArea(options);
            })
        }

        return {
            init: () => {
                getKaryawan();
                getTahun();
                submitFilter();
                printAbsen();
                getBulan();
            }
        }
    })(cetakAbsenUI);

    $(document).ready(function(){
        cetakAbsenController.init();
    })

</script>