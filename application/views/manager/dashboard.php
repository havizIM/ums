<!-- Breadcrumb-->
 <div class="row pt-2 pb-2">
    <div class="col-sm-9">
    <h4 class="page-title">Dashboard</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
     </ol>
 </div>
 </div>

 <div class="row mt-3">
        <div class="col-12 col-md-4">
          <div class="card bg-pattern-primary">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-white"  id="count_app_cuti">0</h4>
                <span class="text-white">Approval Cuti</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle bg-contrast">
                <i class="icon-basket-loaded text-white"></i></div>
             </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="card bg-pattern-danger">
            <div class="card-body">
              <div class="media">
               <div class="media-body text-left">
                <h4 class="text-white" id="count_app_izin">0</h4>
                <span class="text-white">Approval Izin</span>
              </div>
               <div class="align-self-center w-circle-icon rounded-circle bg-contrast">
                <i class="icon-wallet text-white"></i></div>
            </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-4">
          <div class="card bg-pattern-success">
            <div class="card-body">
              <div class="media">
               <div class="media-body text-left">
                <h4 class="text-white" id="count_app_revisi">0</h4>
                <span class="text-white">Approval Revisi Absen</span>
              </div>
               <div class="align-self-center w-circle-icon rounded-circle bg-contrast">
                <i class="icon-wallet text-white"></i></div>
            </div>
            </div>
          </div>
        </div>

      </div>

        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Pengajuan Chart</h3>
                        <canvas id="pengajuanChart" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Cuti Chart</h3>
                        <canvas id="cutiChart" height="295"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Divisi Chart</h3>
                        <canvas id="divisiChart" height="130"></canvas>
                    </div>
                </div>
            </div>
        </div>
      

      <script>

        const dashboardController = ((UI) => {
            const PENGAJUAN_CHART = new Chart(document.getElementById('pengajuanChart').getContext('2d'),{
                type: 'line',
                data: {
                labels:[
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec',
                ],
                datasets:[{
                    label: 'Cuti',
                    data: [],
                    borderColor: "rgba(0, 176, 228, 0.75)",
                    backgroundColor: "transparent",
                    pointBorderColor: "rgba(0, 176, 228, 0)",
                    pointBackgroundColor: "rgba(0, 176, 228, 0.9)",
                    pointBorderWidth: 1,
                },{
                    label: 'Izin',
                    data: [],
                    borderColor: "rgba(255, 178, 43, 0.75)",
                    backgroundColor: "transparent",
                    pointBorderColor: "rgba(255, 178, 43, 0)",
                    pointBackgroundColor: "rgba(255, 178, 43, 0.9)",
                    pointBorderWidth: 1,
                },{
                    label: 'Koreksi Absen',
                    data: [],
                    borderColor: "rgba(252, 75, 108, 0.75)",
                    backgroundColor: "transparent",
                    pointBorderColor: "rgba(252, 75, 108, 0)",
                    pointBackgroundColor: "rgba(252, 75, 108, 0.9)",
                    pointBorderWidth: 1,
                }],
                },
                options:{
                responsive : true,
                legend : {
                    display : true,
                },
                },
            });

            const CUTI_CHART = new Chart(document.getElementById('cutiChart').getContext('2d'),{
                type : 'doughnut',
                data : {
                labels : [],
                datasets: [{
                    data : [],
                    backgroundColor: []
                }],
                },

                options : {
                legend : {
                    display : true,
                },
                responsive : true,
                tooltips: {
                    enabled: true,
                }
                }
            });

            const DIVISI_CHART = new Chart(document.getElementById('divisiChart').getContext('2d'),{
                type : 'pie',
                data : {
                labels : [],
                    datasets: [{
                        data : [],
                        backgroundColor: []
                    }],
                },

                options : {
                legend : {
                    display : true,
                },
                responsive : true,
                tooltips: {
                    enabled: true,
                }
                }
            });
          
            const getStatistic = () => {
                $.ajax({
                    url: `<?= base_url('api/absensi/statistic/') ?>${auth.token}`,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(res){
                        console.log(res);
                        let { data } = res;

                        PENGAJUAN_CHART.data.datasets[0].data = data.cuti.count;
                        PENGAJUAN_CHART.data.datasets[1].data = data.izin.count;
                        PENGAJUAN_CHART.data.datasets[2].data = data.revisi.count;

                        PENGAJUAN_CHART.update();
                    },
                    error: function(err){
                        console.log(err);
                    }
                })
            }

            const getAppCuti = () => {
                 $.ajax({
                    url: `<?= base_url('api/approval_cuti/show/'); ?>${auth.token}`,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(res){
                        let { data } = res;
                        let filter = [];

                        $.each(data, function(k,v){
                            if((v.pemohon.id_divisi !== auth.id_divisi && v.status === 'Approve 2') || (v.pemohon.id_divisi === auth.id_divisi && v.status === 'Approve 1')){
                                filter.push(v);
                            }
                        })

                        $('#count_app_cuti').text(filter.length)
                        
                    },
                    error: function(err){
                        console.log(err);
                    }
                })
            }

            const getAppRevisi = () => {
                 $.ajax({
                    url: `<?= base_url('api/approval_revisi/show/'); ?>${auth.token}`,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(res){
                        let { data } = res;
                        let filter = [];

                        $.each(data, function(k,v){
                            if((v.pemohon.id_divisi === auth.id_divisi && v.status === 'Proses')){
                                filter.push(v);
                            }
                        })

                        $('#count_app_revisi').text(filter.length)
                        
                    },
                    error: function(err){
                        console.log(err);
                    }
                })
            }

            const getRandomColor = () => {
                var letters = '0123456789ABCDEF';
                var color = '#';
                for (var i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }

            const getByCuti = () => {
                $.ajax({
                    url: `<?= base_url('api/cuti/by_master_cuti/'); ?>${auth.token}`,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(res){
                        let { data } = res;

                        if(data.length !== 0){
                            $.each(data, function(k,v){
                                let color = getRandomColor();

                                CUTI_CHART.data.labels.push(v.nama_cuti);
                                CUTI_CHART.data.datasets[0].data.push(v.jml_cuti);
                                CUTI_CHART.data.datasets[0].backgroundColor.push(color);
                            })

                            CUTI_CHART.update();
                        }
                    },
                    error: function(err){
                        console.log(err);
                    }
                })
            }

            const getByDivisi = () => {
                $.ajax({
                    url: `<?= base_url('api/divisi/by_divisi/'); ?>${auth.token}`,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(res){
                        let { data } = res;

                        if(data.length > 1){
                            $.each(data, function(k,v){
                                let color = getRandomColor();

                                DIVISI_CHART.data.labels.push(v.nama_divisi);
                                DIVISI_CHART.data.datasets[0].data.push(v.jml_karyawan);
                                DIVISI_CHART.data.datasets[0].backgroundColor.push(color);
                            })

                            DIVISI_CHART.update();
                        }
                    },
                    error: function(err){
                        console.log(err);
                    }
                })
            }

            const getAppIzin = () => {
                 $.ajax({
                    url: `<?= base_url('api/approval_izin/show/'); ?>${auth.token}`,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(res){
                        let { data } = res;
                        let filter = [];

                        $.each(data, function(k,v){
                            if((v.pemohon.id_divisi !== auth.id_divisi && v.status === 'Approve 1') || (v.pemohon.id_divisi === auth.id_divisi && v.status === 'Proses')){
                                filter.push(v);
                            }
                        })

                        $('#count_app_izin').text(filter.length)
                        
                    },
                    error: function(err){
                        console.log(err);
                    }
                })
            }
            
          return {
            init: () => {
              PENGAJUAN_CHART;
              CUTI_CHART;
              DIVISI_CHART;
              getStatistic();
              getAppCuti();
              getAppRevisi();
              getAppIzin();
              getByCuti();
              getByDivisi();
            }
          }
        })();

        $(document).ready(function(){
            dashboardController.init();
        })
        
        
      
      </script>

      
