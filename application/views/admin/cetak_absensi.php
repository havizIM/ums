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
            <form id="form_revisi">
                <div class="form-group row">
                    <label for="alasan" class="col-md-2 col-form-label">Pilih Karyawan</label>
                    <div class="col-md-10">
                        <select name="alasan" id="alasan" class="form-control">
                            <option value="">-- Pilih Karyawan --</option>
                            <option value="Alasan 1">Alasan 1</option>
                            <option value="Alasan 2">Alasan 2</option>
                            <option value="Alasan 3">Alasan 3</option>
                        </select>
                        <div class="invalid_alasan"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alasan" class="col-md-2 col-form-label">Pilih Bulan</label>
                    <div class="col-md-10">
                        <select name="alasan" id="alasan" class="form-control">
                            <option value="">-- Pilih Bulan --</option>
                            <option value="Alasan 1">Alasan 1</option>
                            <option value="Alasan 2">Alasan 2</option>
                            <option value="Alasan 3">Alasan 3</option>
                        </select>
                        <div class="invalid_alasan"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alasan" class="col-md-2 col-form-label">Pilih Tahun</label>
                    <div class="col-md-10">
                        <select name="alasan" id="alasan" class="form-control">
                            <option value="">-- Pilih Tahun --</option>
                            <option value="Alasan 1">Alasan 1</option>
                            <option value="Alasan 2">Alasan 2</option>
                            <option value="Alasan 3">Alasan 3</option>
                        </select>
                        <div class="invalid_alasan"></div>
                    </div>
                </div>
                <div class="form-group text-right">
                    <a class="btn btn-danger btn-md" href="#/revisi_absen">Batal</a>
                    <button class="btn btn-info btn-md" type="submit" id="submit_add">Submit</button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Absensi 12345 - Riska Anggela
                <div class="btn-group" style="float: right">
                    <button class="btn btn-success btn-sm">Excel</button>
                    <button class="btn btn-danger btn-sm">PDF</button>
                    <button class="btn btn-info btn-sm">Print</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 text-center" style="margin-bottom: 20px;">
                        <h3>PT. Cipta KreasiSandang Mandiri</h3>
                        <h4>Jl. Maju Mundur Abadi no. 3F Pluit Jaya</h4>
                        <h5>Telp. 021-1238219 Fax. 021-1379318</h5>
                        <hr>
                    </div>
                    
                    <div class="col-md-12">
                        <center><h5>Absensi Periode Juni 2019</h5></center><br>
                    </div>

                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th>NIK</th>
                                <td>12345</td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>Riska Anggela</td>
                            </tr>
                            <tr>
                                <th>Jabatan</th>
                                <td>Admin</td>
                            </tr>
                            <tr>
                                <th>Divisi</th>
                                <td>Finance</td>
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
                            <tbody>
                                <tr>
                                    <td>01-06-2019</td>
                                    <td>08:30</td>
                                    <td>17:30</td>
                                    <td>N</td>
                                    <td>-</td>
                                    <td>N</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>02-06-2019</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>Y</td>
                                    <td>Cuti Tahunan</td>
                                    <td>N</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>03-06-2019</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>Y</td>
                                    <td>Cuti Tahunan</td>
                                    <td>N</td>
                                    <td>-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>