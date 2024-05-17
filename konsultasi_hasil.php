<?php

include "./includes/constants.php";

$rows = $db->get_results(
    "SELECT * 
    FROM tb_konsultasi k 
    INNER JOIN tb_gejala g ON k.kode_gejala = g.kode_gejala
    INNER JOIN tb_pengetahuan pg ON g.kode_gejala = pg.kode_gejala
    INNER JOIN tb_penyakit p ON pg.kode_penyakit = p.kode_penyakit"
);

if (empty($rows)) :
    print_msg('Belum ada gejala terpilih!', 'warning');
    echo '<p><a class="btn btn-primary" href="aksi.php?m=konsultasi&act=new"><span class="glyphicon glyphicon-refresh"></span> Konsultasi Lagi</a></p>';
else :

    $diagnosis = [];

    foreach ($rows as $row) {
        if (!array_key_exists($row->kode_penyakit, $diagnosis)) {
            $diagnosis[$row->kode_penyakit] = [
                'kode_penyakit' => $row->kode_penyakit,
                'nama_penyakit' => $row->nama_penyakit,
                'solusi' => $row->solusi,
                'cf' => 0,
            ];
        }

        $cf_penyakit = &$diagnosis[$row->kode_penyakit]['cf'];
        $cf_gejala = ($row->mb - $row->md) * $BOBOT[$row->jawaban];

        if (($cf_gejala >= 0) && ($cf_penyakit >= 0)) {
            // kedua CF positif
            $cf_penyakit = $cf_penyakit + ($cf_gejala * (1 - $cf_penyakit));
        } else if (($cf_gejala < 0) && ($cf_penyakit < 0)) {
            // kedua CF negatif
            $cf_penyakit = $cf_penyakit + ($cf_gejala * (1 + $cf_penyakit));
        } else {
            // CF positif dan negatif
            $cf_penyakit = ($cf_penyakit + $cf_gejala) / (1 - min(abs($cf_penyakit), abs($cf_gejala)));
        }
    }

    // urutkan berdasarkan CF terbesar
    foreach ($diagnosis as $d) $ranks[] = $d['cf'];
    array_multisort($ranks, SORT_DESC, $diagnosis);

?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><b>Biodata Konsultasi</b></h3>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr style="background-color: #535c68; color: #fff;">
                    <th>Nama</th>
                    <th>No. Hp</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <?php
            $q = esc_field(@$_GET['q']);
            $rowss = $db->get_results("SELECT * FROM tb_hasil  order by id desc limit 1");
            $no = 0;
            foreach ($rowss as $rowd) : ?>
                <tr>
                    <td><?= $rowd->nama ?></td>
                    <td><?= $rowd->no_hp ?></td>
                    <td><?= $rowd->jk ?></td>
                    <td><?= $rowd->alamat ?></td>
                    <td><?= $rowd->tgl ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><b>Gejala Terpilih</b></h3>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr style="background-color: #535c68; color: #fff;">
                    <th>No</th>
                    <th>Nama Gejala</th>
                </tr>
            </thead>
            <?php
            $no = 1;
            foreach ($rows as $row) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row->nama_gejala ?></td>
                </tr>
            <?php endforeach;
            ?>
        </table>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><b>Hasil Analisa</b></h3>
        </div>
        <table class="table table-bordered table-hover ">
            <thead>
                <tr style="background-color: #535c68; color: #fff;">
                    <th>No</th>
                    <th>Penyakit</th>
                    <th>Kepercayaan CF</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1 ?>
                <?php foreach ($diagnosis as $d) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $d['nama_penyakit'] ?></td>
                        <td><?= $d['cf'] * 100 ?>%</td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <?php $hasil = reset($diagnosis) ?>
        <div class="panel-body">
            <table class="table table-bordered">
                <tr>
                    <td>Penyakit</td>
                    <td><b><?= $hasil['nama_penyakit'] ?></b></td>
                </tr>
                <tr>
                    <td>Solusi</td>
                    <td><?= $hasil['solusi'] ?></td>
                </tr>
            </table>

            <p>
                <a class="btn edit" href="index.php?"><span class=""></span> Konsultasi Lagi</a>
                <a class="btn edit" href="cetak.php?m=konsultasi" target="_blank"><span class=""></span> Cetak</a>
            </p>
        </div>
    </div>

<?php endif ?>

<?php
    require_once 'functions.php';
    $nama   = $rowd->nama;
    $no_hp  = $rowd->no_hp;
    $jk     = $rowd->jk;
    $alamat = $rowd->alamat;
    $tgl    = $rowd->tgl;
    $np     = $hasil['nama_penyakit'];
    $cf     = $hasil['cf'] * 100;

    $db->query("INSERT INTO tb_hasil(nama, no_hp,jk,alamat,tgl,hasil_konsultasi,kepercayaan) VALUES('$nama','$no_hp','$jk','$alamat','$tgl','$np','$cf')");
?>