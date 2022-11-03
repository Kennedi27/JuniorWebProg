    <?php
        session_start();
        include "../koneksi.php";
        $id = $_POST['id'];
        $sql = "SELECT * FROM tbl_berkas WHERE id = '$id'";
        $exeSql = $conn->query($sql);
        $data = $exeSql->fetch_array();
    ?>
    <form action="../../process/editberkasProcess.php" id='editNewData' method="post" enctype="multipart/form-data">
        <input type="hidden" value="<?= $_SESSION['token'] ?>" id="daftar_token" name="daftar_token">
        <input type="hidden" value="<?= $id ?>" id="ids" name="id">
        <div class="modal-body">
            <div class="form-group">
                <label for="edit_sertif">Sertifikat Kegiatan : </label>
                <input type="file" class="form-control" style="border: none;" name="edit_sertif" id="edit_sertif" accept=".pdf" required>
            </div>

            <div class="form-group">
                <label for="edit_laporan">Laporan Kegiatan : </label>
                <input type="file" class="form-control" name="edit_laporan" id="edit_laporan" accept=".pdf" required>
            </div>

            <div class="form-group">
                <label for="edit_luaran">Luaran Kegiatan : </label>
                <input type="file" class="form-control" name="edit_luaran" id="edit_luaran" accept=".pdf" required>
            </div>

            <div class="form-group">
                <label for="edit_startdate">Tanggal Mulai : </label>
                <input type="text" class="form-control datepicker" value="<?= $data['brk_start_date'] ?>" name="edit_startdate" id="edit_startdate" accept=".pdf" required>
            </div>

            <div class="form-group">
                <label for="edit_enddate">Tanggal Berakhir : </label>
                <input type="text" class="form-control datepicker" value="<?= $data['brk_end_date'] ?>" name="edit_enddate" id="edit_enddate" accept=".pdf" required>
            </div>

            <div class="form-group">
                <label for="edit_dockumentasi">Dokumentasi : </label>
                <input type="file" class="form-control" name="edit_dockumentasi" id="edit_dockumentasi" accept=".pdf" required>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-success">Update Berkas</button>
        </div>
    </form>