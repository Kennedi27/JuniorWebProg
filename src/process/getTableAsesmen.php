<?php
    session_start();
    if($_SESSION['username']){
        include '../pages/koneksi.php';
        // echo $_POST['id'];
        $sql = "SELECT a.*, b.mhs_nama FROM tbl_asesmen a INNER JOIN tbl_mahasiswa b ON a.mhs_nim = b.mhs_nim WHERE a.id = '".$_POST['id']."'";
        $result = $conn->query($sql);
    ?>
        <div class="table-responsive">
            <table class="table table-bordered table-responsive" id="tableAsess">
                <thead class="bg-primary">
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Assesmen Tanggal</th>
                        <th>Assesmen Waktu</th>
                        <th>Undangan</th>
                        <th>Tempat/Link</th>
                        <th>Dosen Wali</th>
                    </tr>
                    <?php
                        while($r = $result->fetch_array()){
                    ?>
                        <tr>
                            <td><?= $r['mhs_nim'] ?></td>
                            <td><?= $r['mhs_nama'] ?></td>
                            <td><?= $r['ass_tanggal'] ?></td>
                            <td><?= $r['ass_waktu'] ?></td>
                            <td><?= $r['ass_undanga'] ?></td>
                            <td><?= $r['tempat_link'] ?></td>
                            <td><?= $r['ass_wali'] ?></td>
                        </tr>
                    <?php } ?>
                </thead>
            </table>
        </div>
    <?php
            
    }else{
        echo "Anda tidak memiliki akses ke halaman ini";
    }