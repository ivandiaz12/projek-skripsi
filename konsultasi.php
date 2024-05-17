<?php

include './includes/constants.php';

$terjawab = get_terjawab();
$relasi = get_relasi($terjawab);
$kode_gejala = get_next_gejala($relasi);

$success = @$_GET['success'];
$row = $db->get_row("SELECT * FROM tb_gejala WHERE kode_gejala='$kode_gejala'");

$count = $db->get_var("SELECT COUNT(*) FROM tb_konsultasi");
    
if(!$row){
    $success = true;        
}        
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Program Sistem Pakar Diagnosa Penyakit gigi</title>
    <link href="assets/css/yeti-bootstrap.min.css" rel="stylesheet"/>
    <link href="assets/css/general.css" rel="stylesheet"/>
    <link href="assets/css/select2.min.css" rel="stylesheet"/>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>    
    <script src="assets/js/select2.min.js"></script>   
        <style type="text/css">
    .hi{
background-image: linear-gradient(rgba(0, 0, 0, 0.5),rgba(0, 0, 0, 0.5)), url('dokter.jpg');
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
    background-attachment: fixed;
  }
.dark{
  background-color: #000;
  color: #000;
}
.page-header{
    color: #fff;
}
.latar{
        background-color: #636e72;
    }
    .tambah{
        background-color:   #353b48;
    }
    .tambah:hover{
        background-color:   #718093;
        color: #fff;
    }
     .edit{
        background-color: #2f3640;
    }
    .edit:hover{
        background-color:   #718093;
        color: #fff;
    }
    .select2-container .select2-selection--single {
        height: 40px!important
    }
    .select2-selection__rendered { padding: 5px 0 }
    .select2-selection__arrow { margin: 6px 0 }

    </style>  
  </head>
  <body class="dark hi" >
<div class="page-header">
    <h1 align="center"><b>Konsultasi</b></h1>
</div>
<?php if($success) :?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><b>Riwayat Pertanyaan</b></h3>
    </div>
    <div class="list-group">
        <?php 
        $rows = $db->get_results("SELECT * FROM tb_konsultasi k INNER JOIN tb_gejala g ON g.kode_gejala=k.kode_gejala");
        foreach($rows as $row):?>
        <div class="list-group-item"><?=$row->ID?>. Apakah <?=strtolower($row->nama_gejala)?>? <strong><?=$row->jawaban?></strong></div>
        <?php endforeach?>
    </div>    
</div>
<?php include'konsultasi_hasil.php';
else:?>
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title" align="center"><b>Jawablah pertanyaan berikut ini [<?=$row->kode_gejala?>]</b></h3></div>
    <div class="panel-body" style="background-color: #535c68; color: #fff;">
        <h3 align="center"><b>Apakah <?=strtolower($row->nama_gejala)?>?</b></h3>
        <form action="aksi.php?m=konsultasi" method="post">
            <input type="hidden" name="kode_gejala" value="<?=$row->kode_gejala?>" />
            <p>&nbsp;</p>
            <p align="center">
                <select name="bobot" class="form-select form-select-lg" aria-label=".form-select-lg example">
                  <option selected>Pilih</option>
                  <?php foreach ($BOBOT as $k => $v): ?>
                      <option value="<?= $k ?>"><?= $k ?></option>
                  <?php endforeach ?>
                </select>

                <button type="submit" class="btn edit">Lanjut</button>

                <?php if($count):?>
                    <a class="btn edit" href="?m=konsultasi&success=1"><span class="glyphicon glyphicon-arrow-right"></span> Lihat Hasil</a>
                    <a class="btn edit" href="aksi.php?m=konsultasi&act=new"><span class="glyphicon glyphicon-ban-circle"></span> Batal</a>
                <?php endif?>
            </p>
        </form>
    </div>
</div>
<?php endif?>

</body></html>