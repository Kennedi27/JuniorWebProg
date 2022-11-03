<?php
    include "../../template/header.php";
    include "../../template/navigasi.php";
    include "../koneksi.php";
    if($_SESSION['level'] == '1'){
        echo "Anda tidak di izinkan ke halaman ini";
        exit;
    }
    if(isset($_SESSION['token'])){
        $token = $_SESSION['token'];
    }else{
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }
    $msg = "";
    if(isset($_GET['msg'])){
        $msg = $_GET['msg'];
    }

?>
<title>Pegawai - Kampus Merdeka</title>
<style>
    .js_row {
        display: flex;
        flex-direction: row;
    }
    .js_column {
        display: flex;
        flex-direction: column;
        width: 50%;
    }
    .form_mr-3 {
        margin-right: 3px;
    }
    .form_ml-3 {
        margin-left: 3px;
    }
    table td {
        font-weight: normal;
    }
    #dtRef {
        zoom: 0.8;
    }
</style>
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid bg-green">
                
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-5" style="min-height: 100vh;">
                        <div class="card-header bg-primary" style="display: flex; flex-direction: row;">
                            <div class="col-md-9">
                                <h3 class="card-title">List Pendaftar MBKM</h3>
                            </div>
                            <div class="col-md-3">
                                <select name="changeFilter" class="form-control selectpicker" id="changeFilter">
                                    <!-- <option value=""></option> -->
                                    <option value="all">Show All Status</option>
                                    <?php
                                        $sql = "SELECT DISTINCT mhs_status FROM tbl_mahasiswa WHERE mhs_status <> 'none'";
                                        $rs = $conn->query($sql);
                                        while($dt = $rs->fetch_array()){
                                            echo "<option value='".$dt['mhs_status']."'>".ucfirst($dt['mhs_status'])."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div style="min-height: 50vh;" class="table-responsive" id="dtRef">
                                <table id="mst_pendaftaran" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="bg-blue">
                                            <th>No</th>
                                            <th>NIM</th>
                                            <th>Nama</th>
                                            <th>Prodi</th>
                                            <th>Angkatan</th>
                                            <th>Program yang diikuti</th>
                                            <th>Jenis MBKM</th>
                                            <th>Tempat Kegiatan</th>
                                            <th>Bukti Penerimaan</th>
                                            <th>Mata Kuliah Klaim</th>
                                            <th>Semester Klaim</th>
                                            <th>Status</th>
                                            <?php if($_SESSION['level'] == '4'){ ?>
                                                <th>Action</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $no = 1;
                                            $sql = "SELECT * FROM tbl_mahasiswa WHERE mhs_status <> 'none' ORDER BY record_date DESC";
                                            $result = $conn->query($sql);
                                            while($rs = $result->fetch_array()){
                                        ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $rs['mhs_nim'] ?></td>
                                                <td><?= $rs['mhs_nama'] ?></td>
                                                <td><?= $rs['mhs_prodi'] ?></td>
                                                <td><?= $rs['mhs_angkatan'] ?></td>
                                                <td><?= $rs['mhs_program_ikuti'] ?></td>
                                                <td><?= $rs['mhs_jns_mbkm'] ?></td>
                                                <td><?= $rs['mhs_tmp_kegiatan'] ?></td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-success" bukti="<?= $rs['mhs_bukti_peneriamaan'] ?>" onclick="openBukti($(this).attr('bukti'))">Lihat</button>
                                                </td>
                                                <td>
                                                    <?php
                                                        $kd = $rs['mhs_klaim_matkul'];
                                                        $arrkd = explode(',', $kd);
                                                        $inkd = "'".join("','", $arrkd)."'";
                                                        $sql = "SELECT mtk_name as nama FROM tbl_matkul WHERE mtk_kode IN($inkd)";
                                                        $respn = $conn->query($sql);
                                                        while($resp = $respn->fetch_array()){
                                                            echo $resp['nama'].",";
                                                        }
                                                    ?>
                                                </td>
                                                <td><?= $rs['mhs_semester'] ?></td>
                                                <td>
                                                    <span class='<?php if($rs['mhs_status'] == "pending"){ echo "badge badge-warning";}else if($rs['mhs_status'] == "setuju"){ echo "badge badge-success"; }else{ echo "badge badge-danger";} ?>' ><?= ucfirst($rs['mhs_status']); ?></span>
                                                </td>
                                                <?php if($_SESSION['level'] == '4'){ ?>
                                                    <td>
                                                        <div style="display: flex; flex-direction: row;">
                                                            <button mhs_nim="<?= $rs['mhs_nim'] ?>" class="btn btn-sm btn-success mr-2" onclick="verifyStatus('setuju', $(this).attr('mhs_nim'))">Setuju</button>
                                                            <button mhs_nim="<?= $rs['mhs_nim'] ?>" class="btn btn-sm btn-danger" onclick="verifyStatus('tolak', $(this).attr('mhs_nim'))">Tolak</button>
                                                        </div>
                                                        
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

<!-- ======================================================================================Modal Add Data failure Location=============================================== -->
    <div class="modal fade" id="modalAddData" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <div style="display: flex; flex-direction: row; justify-content: space-between;">
                        <h4 class="modal-title">Tambah Data Baru</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form action="../../process/pendaftaranProcess.php" id='addNewData' method="post" enctype="multipart/form-data">
                    <input type="hidden" value="<?= $_SESSION['token'] ?>" id="daftar_token" name="daftar_token">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="add_nama">Nama : </label>
                            <input type="text" class="form-control" name="add_nama" id="add_nama" value="<?= $_SESSION['namaLogin'] ?>" readonly autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="add_nim">NIM : </label>
                            <input type="text" class="form-control" name="add_nim" id="add_nim" value="<?= $_SESSION['username'] ?>" readonly autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <div class="js_row" style="width: 100%;">
                                <div class="js_column form_mr-3">
                                    <label for="add_jurusan">Jurusan : </label>
                                    <select name="add_jurusan" class="form-control selectpicker" id="add_jurusan" required>
                                        <option value=""></option>
                                        <?php
                                            $sql = "SELECT DISTINCT jrs_kode as kode, jrs_nama as nama FROM tbl_jurusan ORDER BY jrs_nama ASC";
                                            // echo $sql;
                                            $result = $conn->query($sql);
                                            while ($rs = $result->fetch_array()) {
                                                echo "<option value='".$rs['kode']."'>".$rs['nama']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="js_column form_ml-3">
                                    <label for="add_prodi">Prodi : </label>
                                    <select name="add_prodi" class="form-control selectpicker" id="add_prodi" data-size="5" data-live-search="true" required>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_semesterKlaim">Semester Klaim : </label>
                            <input type="number" class="form-control" name="add_semesterKlaim" id="add_semesterKlaim" placeholder="Semester" required>
                        </div>
                        <div class="form-group">
                            <label for="add_matkul">Mata Kuliah : </label>
                            <select name="add_matkul[]" id="add_matkul" class="form-control selectpicker" multiple data-live-search="true" required>
                            
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="add_angkatan">Angkatan : </label>
                            <input type="number" class="form-control" name="add_angkatan" id="add_angkatan" value="<?= date('Y') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="add_program">Program yang di ikuti : </label>
                            <textarea name="add_program" class="form-control" id="add_program" placeholder="Program yang di Ikuti" cols="30" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="add_jenisMbkm">Jenis MBKM : </label>
                            <textarea name="add_jenisMbkm" class="form-control" id="add_jenisMbkm" placeholder="Jenis MBKM yang Di ikuti" cols="30" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="add_tempatKegiatan">Tempat Kegiatan : </label>
                            <input type="text" name="add_tempatKegiatan" class="form-control" id="add_tempatKegiatan" placeholder="Tempat Kegiatan" required>
                        </div>
                        <div class="form-group">
                            <label for="add_buktiPenerimaan">Bukti Penerimaan : </label>
                            <input type="file" class="form-control" name="add_buktiPenerimaan" id="add_buktiPenerimaan" accept=".pdf" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Tambah Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- ======================================================================================Close Modal Add Failure Location================================================== -->
<?php
    include "../../template/footer.php";
?>

<!-- Script JS -->
    <script>
        $(document).ready(function(){
            $("#mst_pendaftaran").dataTable();
            var msg = "<?= $msg ?>";
            if(msg == "auth"){
                swal.fire("Error!", "Maaf, pendaftaran anda tidak dapat kami process", "error").then(function(){
                    window.location.href = "./index.php";
                })
            }else if(msg == "success"){
                swal.fire("Success!", "Berhasil Melakukan Pendaftaran", "success").then(function(){
                    window.location.href = "./index.php";
                })
            }else if(msg == "wrongext"){
                swal.fire("Error!", "Maaf, Bukti Pendaftaran harus pdf", "error").then(function(){
                    window.location.href = "./index.php";
                })
            }else if(msg == "error"){
                swal.fire("Error!", "Maaf, Terjadi Kesalahan Sistem", "error").then(function(){
                    window.location.href = "./index.php";
                })
            }
            $(".selectpicker").selectpicker();
        })
        $("#addData").on("click",function(){
            $("#modalAddData").modal('show');
        })

        $("#add_jurusan").on("change", function(){
            var jurusan = $(this).val();
            $.ajax({
                type: "POST",
                url: "../../process/changeFilter.php",
                data: {
                        jurusan: jurusan,
                        type: 'getprodi'
                    },
                success: function(resp){
                    var optChooise = "<option value='' selected></option>";
                    optChooise += resp;
                    $("#add_prodi").html(optChooise);
                    $("#add_prodi").selectpicker('refresh');
                }
            })
        })

        $("#changeFilter").on('change', function(){
            var value = $(this).val();
            $.ajax({
                type: 'POST',
                url: './filterDataPendaftar.php',
                data: { value: value},
                success: function(resp){
                    $("#dtRef").html(resp);
                }
            })
        })

        $("#add_semesterKlaim").on("input", function(){
            var jurusan = $("#jurusan").val();
            var prodi = $("#add_prodi").val();
            var semester = $("#add_semesterKlaim").val();
            $.ajax({
                type: "POST",
                url: "../../process/changeFilter.php",
                data: {
                        jurusan: jurusan,
                        prodi: prodi,
                        type: 'getmatkul',
                        semester: semester
                    },
                success: function(resp){
                    $("#add_matkul").html(resp);
                    $("#add_matkul").selectpicker('refresh');
                }
            })
        })

        function verifyStatus(status, nim){
            swal.fire({
                title: 'Apakah Anda Yakin?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Tidak',
                confirmButtonText: 'Ya',
                showLoaderOnConfirm: true,
                preConfirm: function(){
                    $.ajax({
                        url: '../../process/changeStatus.php',
                        type: 'POST',
                        data: {status: status, mhs_nim: nim},
                        success: function(msg){
                            if(msg == "success"){
                                swal.fire("Success!", "Status diperbaharui", "success").then(() => {
                                    window.location.href = "./index.php";
                                });
                            }else{
                                swal.fire("Error!", "Status Gagal diperbaharui", "error").then(() => {
                                    window.location.href = "./index.php";
                                });
                            }
                        }
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            })
        }

        function openBukti(bukti){
            window.open("../../files/"+bukti, "_blank", 'location=yes,height=570,width=520,scrollbars=yes,status=yes');
        }
    </script>
<!-- Close Script JS -->
    </div>
</body>
</html>
