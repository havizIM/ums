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
                <h4 class="text-white"  id="count_pengajuan_cuti">0</h4>
                <span class="text-white">Pengajuan Cuti</span>
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
                <h4 class="text-white" id="count_pengajuan_izin">0</h4>
                <span class="text-white">Pengajuan Izin</span>
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
                <h4 class="text-white" id="count_koreksi_absen">0</h4>
                <span class="text-white">Koreksi Absen</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle bg-contrast">
                <i class="icon-pie-chart text-white"></i></div>
            </div>
            </div>
          </div>
        </div>
      </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Calendar Cuti</h4>
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Sisa Cuti</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="t_sisa_cuti" style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th style="width: 50%">Nama Cuti</th>
                                        <th style="width: 50%">Sisa Cuti</th>
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

        const renderUI = (() => {
          return {
            renderNoData: () => {
              
              let html = `
                <tr>
                  <td colspan="2">Tidak ada data cuti</td>
                </tr>
              `;

              $('#t_sisa_cuti tbody').html(html);
            },
            renderSisaCuti: (data) => {
              let html = '';

              $.each(data, function(k, v){
                if(auth.kelamin === 'Laki-laki'){
                  if(v.keterangan === 'Semua' || v.keterangan === 'Laki-laki'){
                    html += `
                      <tr>
                          <td>${v.nama_cuti}</td>
                          <td>${v.sisa_cuti} hari</td>
                      </tr>
                    `;
                  }
                } else {
                  if(v.keterangan === 'Perempuan' || v.keterangan === 'Semua'){
                    html += `
                      <tr>
                          <td>${v.nama_cuti}</td>
                          <td>${v.sisa_cuti} hari</td>
                      </tr>
                    `;
                  }
                }
                
              })

              $('#t_sisa_cuti tbody').html(html);
            }
          }
        })();

        const dashboardController = ((UI) => {

          const CALENDAR = $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            defaultDate: moment().format("YYYY-MM-DD"),
            editable: false,
            eventLimit: true,
            droppable: false,
            events: {
              url: `<?= base_url('api/cuti/show/'); ?>${auth.token}`,
                error: function(){
                    alert('Tidak dapat mengakses server');
                },
                success: function(response){
                    var events_array = [];

                    $.each(response.data, function(k, v){
                        if(v.status === 'Approve 3'){
                             var obj = {
                                title: v.jenis_cuti.nama_cuti,
                                start: v.tgl_mulai+' 01:00:00',
                                end: `${v.tgl_selesai} 23:59:00`,
                                className: 'bg-info'
                            };
                            events_array.push(obj); 
                        } 
                    });

               
                    return events_array;
                }
            }
        });

          const getPengajuanCuti = () => {
            $.ajax({
              url: `<?= base_url('api/cuti/show/') ?>${auth.token}`,
              type: 'GET',
              dataType: 'JSON',
              success: function(res){
                if(res.status === 200){
                  if(res.data.length !== 0){
                    $('#count_pengajuan_cuti').text(res.data.length);
                  }
                } else {
                  $('#count_pengajuan_cuti').text(0);
                }
              },
              error: function(err){
                $('#count_pengajuan_cuti').text(0);
              }
            })
          }

          const getPengajuanIzin = () => {
            $.ajax({
              url: `<?= base_url('api/izin/show/') ?>${auth.token}`,
              type: 'GET',
              dataType: 'JSON',
              success: function(res){
                if(res.status === 200){
                  if(res.data.length !== 0){
                    $('#count_pengajuan_izin').text(res.data.length);
                  }
                } else {
                  $('#count_pengajuan_izin').text(0);
                }
              },
              error: function(err){
                $('#count_pengajuan_izin').text(0);
              }
            })
          }

          const getRevisiAbsen = () => {
            $.ajax({
              url: `<?= base_url('api/revisi_absen/show/') ?>${auth.token}`,
              type: 'GET',
              dataType: 'JSON',
              success: function(res){
                if(res.status === 200){
                  if(res.data.length !== 0){
                    $('#count_koreksi_absen').text(res.data.length);
                  }
                } else {
                  $('#count_koreksi_absen').text(0);
                }
              },
              error: function(err){
                $('#count_koreksi_absen').text(0);
              }
            })
          }

          const getSisaCuti = () => {
            $.ajax({
                url: `<?= base_url('api/cuti/sisa_cuti/') ?>${auth.token}`,
                type: 'GET',
                dataType: 'JSON',
                success: function(res){
                    if(res.status === 200){
                        if(res.data.length !== 0){
                          UI.renderSisaCuti(res.data);
                        } else {
                          UI.renderNoData();
                        }
                    } else {
                        UI.renderNoData();
                    }
                }, 
                error: function(err){
                    UI.renderNoData();
                }
            })
          }
          return {
            init: () => {
              CALENDAR;
              getPengajuanCuti();
              getPengajuanIzin();
              getRevisiAbsen();
              getSisaCuti();
            }
          }
        })(renderUI);

        $(document).ready(function(){
            dashboardController.init();
        })
        
        
      
      </script>

      
