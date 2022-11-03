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
    $sql = "SELECT * FROM tbl_mahasiswa WHERE mhs_status = 'setuju' AND mhs_nim = '".$_SESSION['username']."' LIMIT 0, 2";
    $result = $conn->query($sql);
    $rowNone = $result->num_rows;
?>
<title>Pengumpulan Berkas - Kampus Merdeka</title>
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
    form input[type="file"] {
        border: none !important ;
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
                        <div class="card-header bg-primary">
                            <div style="display: flex; flex-direction: row; justify-content: space-between;">
                                <h3 class="box-title"> Pengumpulan Berkas Pelaksanaan Kegiatan MBKM </h3>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div style="min-height: 50vh;" id="dtRef">
                                <?php
                                    if($rowNone > 0){ ?>
                                        <div style="margin-bottom: 10px;">
                                            <button type="button" class="btn btn-success mb-2" id="addData"><span class="fa fa-upload"></span> Upload Berkas MBKM</button>
                                        </div>
                                    <?php }
                                ?>
                                <div class="table-responsive">
                                    <table id="mst_pendaftaran" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="bg-blue">
                                                <th>No</th>
                                                <th>NIM</th>
                                                <th>Nama</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Tanggal Selesai</th>
                                                <th>Setifikat Kegiatan</th>
                                                <th>Laporan Kegiatan</th>
                                                <th>Luaran Kegiatan</th>
                                                <th>Dokumentasi</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $no = 1;
                                                $sql = "SELECT a.*, b.mhs_nama FROM tbl_berkas a INNER JOIN tbl_mahasiswa b ON a.mhs_nim = b.mhs_nim WHERE a.mhs_nim = '".$_SESSION['username']."' ORDER BY a.record_date DESC";
                                                $result = $conn->query($sql);
                                                while($rs = $result->fetch_array()){
                                            ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= $rs['mhs_nim'] ?></td>
                                                    <td><?= $rs['mhs_nama'] ?></td>
                                                    <td><?= $rs['brk_start_date'] ?></td>
                                                    <td><?= $rs['brk_end_date'] ?></td>
                                                    <td class="text-center">
                                                        <button filenames="<?= $rs['brk_sertif'] ?>" class="btn btn-sm btn-info" onclick="openBukti($(this).attr('filenames'))"><i class="fa fa-file"></i>&nbsp;&nbsp;Lihat File</button>
                                                    </td>
                                                    <td class="text-center">
                                                        <button filenames="<?= $rs['brk_laporan'] ?>" class="btn btn-sm btn-info" onclick="openBukti($(this).attr('filenames'))"><i class="fa fa-file"></i>&nbsp;&nbsp;Lihat File</button>
                                                    </td>
                                                    <td class="text-center">
                                                        <button filenames="<?= $rs['brk_luaran'] ?>" class="btn btn-sm btn-info" onclick="openBukti($(this).attr('filenames'))"><i class="fa fa-file"></i>&nbsp;&nbsp;Lihat File</button>
                                                    </td>
                                                    <td class="text-center">
                                                        <button filenames="<?= $rs['brk_dokumentasi'] ?>" class="btn btn-sm btn-info" onclick="openBukti($(this).attr('filenames'))"><i class="fa fa-file"></i>&nbsp;&nbsp;Lihat File</button>
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-info" onclick="editBerkas(<?= $rs['id'] ?>)"><i class="fa fa-edit"> Edit</i></button>
                                                        <a href="../../process/getZipFiles.php?id=<?= $rs['id'] ?>"class="btn btn-sm btn-warning text-white text-bold"><i class="fa fa-download"></i>&nbsp;&nbsp;Download Berkas</a>
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
            </div>
        </section>
    </div>

<!-- ======================================================================================Modal Add Data failure Location=============================================== -->
    <div class="modal fade" id="modalAddData" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <div style="display: flex; flex-direction: row; justify-content: space-between; width: 100%">
                        <h4 class="modal-title">Upload Berkas Kegiatan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form action="../../process/uploadberkasProcess.php" id='addNewData' method="post" enctype="multipart/form-data">
                    <input type="hidden" value="<?= $_SESSION['token'] ?>" id="daftar_token" name="daftar_token">
                    <div class="modal-body">
                        
                        <div class="form-group">
                            <label for="add_sertif">Sertifikat Kegiatan : </label>
                            <input type="file" class="form-control" style="border: none;" name="add_sertif" id="add_sertif" accept=".pdf" required>
                        </div>

                        <div class="form-group">
                            <label for="add_laporan">Laporan Kegiatan : </label>
                            <input type="file" class="form-control" name="add_laporan" id="add_laporan" accept=".pdf" required>
                        </div>

                        <div class="form-group">
                            <label for="add_luaran">Luaran Kegiatan : </label>
                            <input type="file" class="form-control" name="add_luaran" id="add_luaran" accept=".pdf" required>
                        </div>

                        <div class="form-group">
                            <label for="add_startdate">Tanggal Mulai : </label>
                            <input type="text" class="form-control datepicker" placeholder="mm/dd/yyyy" name="add_startdate" id="add_startdate" accept=".pdf" required>
                        </div>

                        <div class="form-group">
                            <label for="add_enddate">Tanggal Berakhir : </label>
                            <input type="text" class="form-control datepicker" placeholder="mm/dd/yyyy" name="add_enddate" id="add_enddate" accept=".pdf" required>
                        </div>

                        <div class="form-group">
                            <label for="add_dockumentasi">Dokumentasi : </label>
                            <input type="file" class="form-control" name="add_dockumentasi" id="add_dockumentasi" accept=".pdf" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Upload Berkas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditData" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <div style="display: flex; flex-direction: row; justify-content: space-between; width: 100%">
                        <h4 class="modal-title">Update Berkas Kegiatan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div id="modalContentEditBerkas">

                </div>
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
                    window.location.href = "./pengumpulanberkas.php";
                })
            }else if(msg == "success"){
                swal.fire("Success!", "Berhasil Melakukan Pendaftaran", "success").then(function(){
                    window.location.href = "./pengumpulanberkas.php";
                })
            }else if(msg == "wrongext"){
                swal.fire("Error!", "Maaf, Bukti Pendaftaran harus pdf", "error").then(function(){
                    window.location.href = "./pengumpulanberkas.php";
                })
            }else if(msg == "error"){
                swal.fire("Error!", "Maaf, Terjadi Kesalahan Sistem", "error").then(function(){
                    window.location.href = "./pengumpulanberkas.php";
                })
            }
            $("#mst_pendaftaran").dataTable();
            $(".datepicker").datepicker({
                format: 'mm/dd/yyyy',
            });
        })
        $("#addData").on("click",function(){
            $("#modalAddData").modal('show');
        })
        
        function openBukti(bukti){
            window.open("../../files/"+bukti, "_blank", 'location=yes,height=570,width=520,scrollbars=yes,status=yes');
        }

        function editBerkas(id){
            $.ajax({
                type: 'POST',
                url: 'modalUpdateBerkas.php',
                data: {id:id},
                success: function(resp){
                    $("#modalContentEditBerkas").html(resp);
                    $("#modalEditData").modal('show');
                }
            })
            
        }

    </script>
<!-- Close Script JS -->
    </div>
</body>
</html>
