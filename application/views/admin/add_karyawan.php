<div class="block-header">
  <div class="row">
    <div class="col-md-8 col-sm-12">
      <h2>Karyawan</h2>
    </div>
  </div>
</div>


<div class="row clearfix">
  <div class="col-lg-12 col-md-12">
    <div class="card planned_task">
      <div class="header">
        <h2>Tambah Data Karyawan</h2>
      </div>

      <div class="body">
        <div id="wizard_horizontal">
          <form class="form-horizontal" id="form_add">
            <h2>1 dari 4</h2>
            <section>
              <div class="form-group">
                <input class="form-control" type="text" name="nik" id="nik" placeholder="NIK">
              </div>

              <div class="form-group">
                <input class="form-control" type="text" name="nama" id="nama" placeholder="Nama">
              </div>

              <div class="form-group">
                <input class="form-control" type="text" name="tmp_lahir" id="tmp_lahir" placeholder="Tempat Lahir">
              </div>

              <div class="form-group">
                <input class="form-control" type="date" name="tgl_lahir" id="tgl_lahir" placeholder="Tanggal Lahir">
              </div>
            </section>

            <h2>2 dari 4</h2>
            <section>
              <div class="form-group">
                <select class="form-control" name="kelamin" id="kelamin">
                  <option value="">-- Pilih Kelamin --</option>
                  <option value="Laki-laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
                </select>
              </div>

              <div class="form-group">
                <select class="form-control" name="status_kawin" id="status_kawin">
                  <option value="">-- Pilih Status Hubungan --</option>
                  <option value="Kawin">Kawin</option>
                  <option value="Belum-kawin">Belum Kawin</option>
                </select>
              </div>

              <div class="form-group">
                <select class="form-control" name="pendidikan" id="pendidikan">
                  <option value="">-- Pilih Pendidikan --</option>
                  <option value="SD">SD</option>
                  <option value="SMP">SMP</option>
                  <option value="SMA">SMA</option>
                  <option value="SMK">SMK</option>
                  <option value="D3">D3</option>
                  <option value="S1">S1</option>
                  <option value="S2">S2</option>
                  <option value="S3">S3</option>
                </select>
              </div>

              <div class="form-group">
                <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat" rows="8" cols="80"></textarea>
              </div>
            </section>

            <h2>3 dari 4</h2>
            <section>
              <div class="form-group">
                <input class="form-control" type="text" name="telepon" id="telepon" placeholder="Telepon">
              </div>

              <div class="form-group">
                <input class="form-control" type="date" name="tgl_masuk" id="tgl_masuk" placeholder="Tanggal Masuk">
              </div>

              <div class="form-group">
                <select class="form-control" name="status_karyawan" id="status_karyawan">
                  <option value="">-- Pilih Status Karyawan --</option>
                  <option value="Aktif">Aktif</option>
                  <option value="Tidak-aktif">Tidak Aktif</option>
                </select>
              </div>

              <div class="form-group">
                <input class="form-control" type="text" name="jabatan" id="jabatan" placeholder="Jabatan">
              </div>
            </section>

            <h2>4 dari 4</h2>
            <section>
              <div class="form-group">
                <input class="form-control" type="email" name="email" id="email" placeholder="Email">
              </div>

              <div class="form-group">
                <select class="form-control" name="level" id="level">
                  <option value="">-- Pilih Level --</option>
                  <option value="Karyawan">Karyawan</option>
                  <option value="Admin">Admin</option>
                  <option value="Kabag">Kabag</option>
                  <option value="Direksi">Direksi</option>
                </select>
              </div>
            </section>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
