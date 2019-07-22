<!-- Breadcrumb-->
 <div class="row pt-2 pb-2">
    <div class="col-sm-9">
    <h4 class="page-title">Dashboard</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
     </ol>
 </div>
 </div>
<div class="row">
            <div class="col-6 col-md-3">
			  <div class="card text-center border-bottom-sm border-top-sm border-primary">
			    <div class="card-body">
				  <h6>Karyawan</h6>
				  <h4 class="text-primary" id="count_karyawan">0</h4>
				</div>
			  </div>
			</div>
			<div class="col-6 col-md-3">
			  <div class="card text-center border-bottom-sm border-top-sm border-danger">
			    <div class="card-body">
				  <h6>Cuti</h6>
				  <h4 class="text-danger" id="count_master_cuti">0</h4></div>
			  </div>
			</div>
			<div class="col-6 col-md-3">
			  <div class="card text-center border-bottom-sm border-top-sm border-success">
			    <div class="card-body">
				  <h6>Izin</h6>
				  <h4 class="text-success" id="count_master_izin">0</h4></div>
			  </div>
			</div>
			<div class="col-6 col-md-3">
			  <div class="card text-center border-bottom-sm border-top-sm border-warning">
			    <div class="card-body">
				  <h6>Cuti Bersama</h6>
				  <h4 class="text-warning" id="count_cuti_bersama">0</h4></div>
			  </div>
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
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Calendar Cuti</h4>
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Sisa Cuti</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="t_sisa_cuti">
                                <thead>
                                    <tr>
                                        <th>Nama Cuti</th>
                                        <th>Sisa Cuti</th>
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

              console.log(auth.kelamin);

              $.each(data, (k, v) => {
                if(auth.kelamin === 'Laki-laki'){
                  if(v.keterangan === 'Laki-laki' && v.keterangan === 'Semua'){
                    html += `
                      <tr>
                          <td>${v.nama_cuti}</td>
                          <td>${v.sisa_cuti} hari</td>
                      </tr>
                    `;
                  }
                } else {
                  if(v.keterangan === 'Perempuan' && v.keterangan === 'Semua'){
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

          const getKaryawan = () => {
            $.ajax({
              url: `<?= base_url('api/karyawan/show/') ?>${auth.token}`,
              type: 'GET',
              dataType: 'JSON',
              success: function(res){
                if(res.status === 200){
                  if(res.data.length !== 0){
                    $('#count_karyawan').text(res.data.length);
                  }
                } else {
                  $('#count_karyawan').text(0);
                }
              },
              error: function(err){
                $('#count_karyawan').text(0);
              }
            })
          }

          const getMasterCuti = () => {
             $.ajax({
              url: `<?= base_url('api/jenis_cuti/show/') ?>${auth.token}`,
              type: 'GET',
              dataType: 'JSON',
              success: function(res){
                if(res.status === 200){
                  if(res.data.length !== 0){
                    $('#count_master_cuti').text(res.data.length);
                  }
                } else {
                  $('#count_master_cuti').text(0);
                }
              },
              error: function(err){
                $('#count_master_cuti').text(0);
              }
            })
          }

          const getMasterIzin = () => {
            $.ajax({
              url: `<?= base_url('api/jenis_izin/show/') ?>${auth.token}`,
              type: 'GET',
              dataType: 'JSON',
              success: function(res){
                if(res.status === 200){
                  if(res.data.length !== 0){
                    $('#count_master_izin').text(res.data.length);
                  }
                } else {
                  $('#count_master_izin').text(0);
                }
              },
              error: function(err){
                $('#count_master_izin').text(0);
              }
            })
          }

          const getCutiBersama = () => {
            $.ajax({
              url: `<?= base_url('api/cuti_bersama/show/') ?>${auth.token}`,
              type: 'GET',
              dataType: 'JSON',
              success: function(res){
                if(res.status === 200){
                  if(res.data.length !== 0){
                    $('#count_cuti_bersama').text(res.data.length);
                  }
                } else {
                  $('#count_cuti_bersama').text(0);
                }
              },
              error: function(err){
                $('#count_cuti_bersama').text(0);
              }
            })
          }

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
              getKaryawan();
              getMasterCuti();
              getMasterIzin();
              getCutiBersama();
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
        
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultDate: '2018-03-12',
            navLinks: true, // can click day/week names to navigate views
            selectable: true,
            selectHelper: true,
            select: function(start, end) {
                var title = prompt('Event Title:');
                var eventData;
                if (title) {
                eventData = {
                    title: title,
                    start: start,
                    end: end
                };
                $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
                }
                $('#calendar').fullCalendar('unselect');
            },
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [
                {
                title: 'All Day Event',
                start: '2018-03-01'
                },
                {
                title: 'Long Event',
                start: '2018-03-07',
                end: '2018-03-10'
                },
                {
                id: 999,
                title: 'Repeating Event',
                start: '2018-03-09T16:00:00'
                },
                {
                id: 999,
                title: 'Repeating Event',
                start: '2018-03-16T16:00:00'
                },
                {
                title: 'Conference',
                start: '2018-03-11',
                end: '2018-03-13'
                },
                {
                title: 'Meeting',
                start: '2018-03-12T10:30:00',
                end: '2018-03-12T12:30:00'
                },
                {
                title: 'Lunch',
                start: '2018-03-12T12:00:00'
                },
                {
                title: 'Meeting',
                start: '2018-03-12T14:30:00'
                },
                {
                title: 'Happy Hour',
                start: '2018-03-12T17:30:00'
                },
                {
                title: 'Dinner',
                start: '2018-03-12T20:00:00'
                },
                {
                title: 'Birthday Party',
                start: '2018-03-13T07:00:00'
                },
                {
                title: 'Click for Google',
                url: 'http://google.com/',
                start: '2018-03-28'
                }
            ]
            });
      
      </script>

      
