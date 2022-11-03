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
                                <h3 class="box-title"> Berkas Pelaksanaan Kegiatan MBKM </h3>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div style="min-height: 50vh;" id="dtRef">
                                <div class="table-responsive">
                                    <table id="mst_pendaftaran" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="bg-blue">
                                                <th style="width: 20px;"></th>
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
                                                $sql = "SELECT a.*, b.mhs_nama FROM tbl_berkas a INNER JOIN tbl_mahasiswa b ON a.mhs_nim = b.mhs_nim ORDER BY a.record_date DESC";
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
                                                        <a href="../../process/getZipFiles.php?id=<?= $rs['id'] ?>"class="btn btn-sm btn-warning text-white text-bold"><i class="fa fa-download"></i>&nbsp;&nbsp;Download Berkas</a>
                                                        <!-- <button id_berkas="<?= $rs['mhs_nim'] ?>" mhs_nama="<?= $rs['mhs_nama'] ?>"  onclick="showKegiatan($(this).attr('id_berkas'), $(this).attr('mhs_nama'))" class="btn btn-sm btn-success"><i class="fa fa-list"></i>&nbsp;&nbsp;Detail Kegiatan</button> -->
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

    <div class="modal fade" id="listKegiatan">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <div style="display: flex; flex-direction: row; justify-content: space-between; width: 100%;">
                        <h4 class="modal-title">Detail Kegiatan <span id="title_modal"></span> </h4>
                        <button type="button" class="close" onclick="closeListKegiatan()" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <div class="modal-body">
                    <div id="kegiatanTable">

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="closeListKegiatan()" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
        
    </div>
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
            }else if(msg == "exist"){
                swal.fire("Error!", "Anda Sudah Upload Berkas Pendaftaran", "error").then(function(){
                    window.location.href = "./pengumpulanberkas.php";
                })
            }
            $("#mst_pendaftaran").dataTable({
                "columnDefs": [{
                                "targets": 0,
                                "orderable": false
                            }],
                "order": [[1, 'asc']]
            });
            $(".datepicker").datepicker({
                format: 'mm/dd/yyyy',
            });
        })
        
        function closeListKegiatan(){
            $("#listKegiatan").modal('hide');
        }
        
        function openBukti(bukti){
            window.open("../../files/"+bukti, "_blank", 'location=yes,height=570,width=520,scrollbars=yes,status=yes');
        }

        function showKegiatan(id, nama) {
            $.ajax({
                type: "POST",
                url: "../../process/getTableAsesmen.php",
                data: {id: id},
                success: function(resp){
                    $("#title_modal").html(nama);
                    $("#kegiatanTable").html(resp);
                    $("#listKegiatan").modal('show');
                }
            })
                
        }

    </script>
<!-- Close Script JS -->
    </div>
</body>
</html>
