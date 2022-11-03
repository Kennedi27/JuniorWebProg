<?php
    include "../koneksi.php";
    $value = $_POST['value'];
?>
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
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $no = 1;
            if($value == "all"){
                $sql = "SELECT * FROM tbl_mahasiswa WHERE mhs_status <> 'none' ORDER BY record_date DESC";
            }else{
                $sql = "SELECT * FROM tbl_mahasiswa WHERE mhs_status = '$value' ORDER BY record_date DESC";
            }
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
                <td>
                    <div style="display: flex; flex-direction: row;">
                        <button mhs_nim="<?= $rs['mhs_nim'] ?>" class="btn btn-sm btn-success mr-2" onclick="verifyStatus('setuju', $(this).attr('mhs_nim'))">Setuju</button>
                        <button mhs_nim="<?= $rs['mhs_nim'] ?>" class="btn btn-sm btn-danger" onclick="verifyStatus('tolak', $(this).attr('mhs_nim'))">Tolak</button>
                    </div>
                    
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(function(){
        $("#mst_pendaftaran").dataTable();
    })
</script>