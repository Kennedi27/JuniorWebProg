<?php
    include "../../template/header.php";
    include "../../template/navigasi.php";
    include "../koneksi.php";
    
    if($_SESSION['level'] != '1'){
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
    $sql2 = "SELECT a.* FROM tbl_berkas a INNER JOIN tbl_mahasiswa b ON a.mhs_nim = b.mhs_nim WHERE a.mhs_nim = '".$_SESSION['username']."' AND b.mhs_status ='setuju' LIMIT 0, 2";
    $result2 = $conn->query($sql2);
    $rowData = $result2->num_rows;
    $sql = "SELECT * FROM tbl_mahasiswa WHERE mhs_status = 'tolak' AND mhs_nim = '".$_SESSION['username']."' LIMIT 0, 2";
    $result = $conn->query($sql);
    $rowTolak = $result->num_rows;
    $sql1 = "SELECT * FROM tbl_mahasiswa WHERE mhs_status = 'setuju' AND mhs_nim = '".$_SESSION['username']."' LIMIT 0, 2";
    $result1 = $conn->query($sql1);
    $rowAccept = $result1->num_rows;

?>
<title>Mahasiswa - Kampus Merdeka</title>
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
            <div class="col-md-12">
                <?php if($rowAccept >= 1 AND $rowData <= 0){ ?>
                    <div class="alert mt-2" style="background-color: #cce5ff; color: #004085;" role="alert">
                        <div style="display: flex; flex-direction: row; justify-content: space-between">
                            <h4 class="alert-heading">Berhasil!!!</h4>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <p>Status Pendaftaran MBKM Anda Sudah Diperbaharui. Silahkan upload berkas kegiatan MBKM melalui link di bawah ini</p>
                        <hr>
                        <p class="mb-0">Kumpul Berkas MBKM <a href="./pengumpulanberkas.php" style="color: #004085;"><b>disini</b></a></p>
                    </div>
                <?php } ?>
                <?php if($rowTolak >= 1){ ?>
                    <div class="alert mt-2" style="background-color: #f8d7da; color: #721c24;" role="alert">
                        <div style="display: flex; flex-direction: row; justify-content: space-between">
                            <h4 class="alert-heading">Berhasil!!!</h4>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <p>Status Pendaftaran MBKM Anda Sudah Diperbaharui. Silahkan upload berkas kegiatan MBKM melalui link di bawah ini</p>
                        <hr>
                        <p class="mb-0">Kumpul Berkas MBKM <a href="./pengumpulanberkas.php" style="color: #004085;"><b>disini</b></a></p>
                    </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-2" style="min-height: 100vh;">
                        <div class="card-header bg-primary">
                            <div style="display: flex; flex-direction: row; justify-content: space-between;">
                                <h3 class="box-title"> Pendaftaran Merdeka Belajar Kampus Merdeka (MBKM) </h3>
                                <div>
                                    <button type="button" class="btn btn-success" id="addData"><span class="fa fa-plus"></span> Daftar MBKM</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div style="min-height: 50vh;" id="dtRef">
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $no = 1;
                                            $sql = "SELECT * FROM(SELECT * FROM tbl_mahasiswa WHERE mhs_nim = '".$_SESSION['username']."' AND mhs_status <> 'none' UNION ALL SELECT * FROM tbl_mahasiswa_history WHERE mhs_nim = '".$_SESSION['username']."' AND mhs_status <> 'none') as v ORDER BY record_date desc";
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
                                                    <button status="<?= $rs['mhs_status'] ?>" class='btn <?php if($rs['mhs_status'] == "pending"){ echo "badge badge-warning";}else if($rs['mhs_status'] == "setuju"){ echo "badge badge-success"; }else{ echo "badge badge-danger";} ?>' onclick="uploadBerkas($(this).attr('status'))"><?= ucfirst($rs['mhs_status']); ?></button>
                                                </td>
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
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <div style="display: flex; flex-direction: row; justify-content: space-between; width: 100%;">
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
            $("#mst_pendaftaran").dataTable();
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

        function uploadBerkas(status){
            var username = "<?= $_SESSION['username'] ?>";
            if(status == "setuju"){
                window.location.href = "./pengumpulanberkas.php";
            }else if(status == "pending"){
                swal.fire("Warning!","Status masih belum di verifikasi mohon menunggu","warning");
            }else{
                swal.fire("Warning!","Pendaftaran Anda di Tolak","error");
            }
        }
        function openBukti(bukti){
            window.open("../../files/"+bukti, "_blank", 'location=yes,height=570,width=520,scrollbars=yes,status=yes');
        }
    </script>
<!-- Close Script JS -->
    </div>
</body>
</html>
