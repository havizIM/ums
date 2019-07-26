<div class="row pt-2 pb-2">
    <div class="col-sm-9">
        <h4 class="page-title">Laporan Izin</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Laporan Izin</li>
        </ol>
    </div>
 </div>

 <div class="row">
   <div class="col-md-12">
     <div class="card">
        <div class="card-header">Filter Laporan Izin</div>
        <div class="card-body">
            <form id="form_filter">
                <div class="form-group row">
                    <label for="alasan" class="col-md-2 col-form-label">Pilih Bulan</label>
                    <div class="col-md-10">
                        <select name="bulan" id="bulan" class="form-control">
                            <option value="">-- Pilih Bulan --</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
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
        tahun: '#tahun',
        submit: '#submit_filter'
    }

    const laporanIzinUI = (() => {
        return {

            renderNoIzin: () => {
               console.log('No Absensi...')
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
            renderIzin: (res) => {
                let html = '';
                let bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

                
                    html = `
                        <div class="card">
                            <div class="card-header">
                                <div class="btn-group" style="float: right">
                                    <button class="btn btn-success btn-md" id="print_absen"><i class="fa fa-print"></i> Print</button>
                                </div>
                            </div>
                            <div class="card-body" id="print_area">
                                <div class="row">
                                    <div class="col-md-12 text-center" style="margin-bottom: 20px;">
                                        <h3>PT. Cipta KreasiSandang Mandiri</h3>
                                        <h4>Jl. Maju Mundur Abadi no. 3F Pluit Jaya</h4>
                                        <h5>Telp. 021-1238219 Fax. 021-1379318</h5>
                                        <hr>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <center><h5>Pengajuan Izin Periode ${bulan[res.bulan-1]} ${res.tahun}</h5></center><br>
                                    </div>
                                </div><br><br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered" style="font-size: 11px">
                                            <thead>
                                                <tr>
                                                    <th>No Pengajuan</th>
                                                    <th>Pemohon</th>
                                                    <th>Keperluan</th>
                                                    <th>Tgl Izin</th>
                                                </tr>
                                            </thead>
                                            <tbody>`

                                            $.each(res.data, function(k, v){
                                                html += `
                                                    <tr>
                                                        <td>${v.id}</td>
                                                        <td>${v.pemohon.nik} - ${v.pemohon.nama}</td>
                                                        <td>${v.jenis_izin.keperluan}</td>
                                                        <td>${v.tgl_izin}</td>
                                                    </tr>
                                                `;
                                            })
                                                
                    html +=                 `
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                
                $(DOM.content).html(html);
            }
        }
    })();

    const laporanIzinController = ((UI) => {

        const getTahun = () => {
            var currentYear = new Date().getFullYear(), years = [];
            var startYear = startYear || 2015;

            while ( startYear <= currentYear ) {
                years.push(startYear++);
            }   
            
            UI.renderTahun(years);
        }

        const submitFilter = () => {
            $(DOM.form).validate({
                rules: {
                    bulan: "required",
                    tahun: "required"
                },
                messages: {
                    bulan: "Pilih Bulan Pengajuan Cuti",
                    tahun: "Pilih Tahun Pengajuan Cuti"
                },
                errorClass: 'is-invalid',
                errorPlacement: function(error, element) {
                    var name = $(element).attr("id");

                    error.appendTo($('.invalid_'+name));
                },
                submitHandler: function(form){
                    let bulan = $('#bulan').val();
                    let tahun = $('#tahun').val();
                    
                    $.ajax({
                        url: `<?= base_url('api/izin/laporan/') ?>${auth.token}?bulan=${bulan}&tahun=${tahun}`,
                        type: 'GET',
                        dataType: 'JSON',
                        beforeSend: function(){
                            $(DOM.submit).html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
                        },
                        success: function(response){
                            if(response.status === 200){
                                if(response.data.length > 1){
                                    UI.renderIzin(response);
                                } else {
                                    UI.renderNoIzin();
                                }
                            } else {
                                UI.renderNoIzin();
                            }
                            $(DOM.submit).html('Submit');
                        },
                        error: function(err){
                            UI.renderNoIzin();
                            $(DOM.submit).html('Submit');
                            toastr.error('Tidak dapat mengakases server', 'Gagal');
                        }
                    })
                }
            })
        }

        printLaporan = () => {
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
                getTahun();
                submitFilter();
                printLaporan();
            }
        }
    })(laporanIzinUI);

    $(document).ready(function(){
        laporanIzinController.init();
    })

</script>