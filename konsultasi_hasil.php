<?php
$rows = $db->get_results("SELECT * FROM tb_gejala WHERE kode_gejala IN (SELECT kode_gejala FROM tb_konsultasi WHERE jawaban='Ya')");
if( !$rows ) :
    print_msg('Belum ada gejala terpilih!', 'warning');
    echo '<p><a class="btn btn-primary" href="aksi.php?m=konsultasi&act=new"><span class="glyphicon glyphicon-refresh"></span> Konsultasi Lagi</a></p>';
else:

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
            </tr></thead>
            <?php
            $q = esc_field(@$_GET['q']);
            $rowss = $db->get_results("SELECT * FROM tb_hasil  order by id desc limit 1");
            $no=0;
            foreach($rowss as $rowd):?>
            <tr>
                <td><?=$rowd->nama ?></td>
                <td><?=$rowd->no_hp?></td>
                <td><?=$rowd->jk?></td>
                <td><?=$rowd->alamat?></td>
                <td><?=$rowd->tgl?></td>
            </tr>
            <?php endforeach;?>
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
    $no=1;
    foreach($rows as $row):?>
    <tr>
        <td><?=$no++?></td>
        <td><?=$row->nama_gejala?></td>
    </tr>
    <?php endforeach;
    ?>
    </table>
</div>
<?php
$rows = $db->get_results("SELECT * 
    FROM tb_relasi r INNER JOIN tb_penyakit d ON d.kode_penyakit = r.kode_penyakit      
    WHERE r.kode_gejala IN (SELECT kode_gejala FROM tb_konsultasi WHERE jawaban='Ya') ORDER BY r.kode_penyakit, r.kode_gejala");

foreach($rows as $row){
   @$diagnosa[$row->kode_penyakit]['mb'] = $diagnosa[$row->kode_penyakit]['mb'] + $row->mb * (1 - $diagnosa[$row->kode_penyakit]['mb']);

    @$diagnosa[$row->kode_penyakit]['md'] = $diagnosa[$row->kode_penyakit]['md'] + $row->md * (1 - $diagnosa[$row->kode_penyakit]['md']);
    
    @$diagnosa[$row->kode_penyakit]['cf'] = $diagnosa[$row->kode_penyakit]['mb'] -  $diagnosa[$row->kode_penyakit]['md'];     
}
?>
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
    <?php
    $no=1;
    function ranking($array){
        $new_arr = array();
        foreach($array as $key => $value) {
            $new_arr[$key] = $value['cf'];
        }
        arsort($new_arr);
                $result = array();    
        foreach($new_arr as $key => $value){
            @$result[$key] = ++$no;
        }    
        return $result;
    }
    $rank = ranking($diagnosa);

    foreach($rank as $key => $value):?>
    <tr class="<?=($value==1) ? 'text-primary' : ''; ?>">
        <td><?=$no++; ?></td>
        <td><b><?=$DIAGNOSA[$key]->nama_penyakit; ?></b></td>
        <td><?=$diagnosa[$key]['cf']*100; ?>%</td>
    </tr>
    <?php endforeach;
    reset($rank);
    ?>
    </table>

    <div class="panel-body">
        <table class="table table-bordered">
            <tr>
                <td>Penyakit</td>
                <td><b><?=$DIAGNOSA[key($rank)]->nama_penyakit; ?></b></td>
            </tr>
            <tr>
                <td>Solusi</td>
                <td><?=$DIAGNOSA[key($rank)]->solusi; ?></td>
            </tr>
        </table>

        <p>
            <a class="btn edit" href="index.php?"><span class=""></span> Konsultasi Lagi</a>
            <a class="btn edit" href="cetak.php?m=konsultasi" target="_blank"><span class=""></span> Cetak</a>
        </p>       
    </div>
</div>

<?php endif;?>
<div class="page-header">
    <?php
    require_once 'functions.php';
    $nama =$rowd->nama;
    $no_hp =$rowd->no_hp;
    $jk=$rowd->jk;
    $alamat =$rowd->alamat;
    $tgl =$rowd->tgl;
    $hasildiagnosa=$DIAGNOSA[key($rank)]->nama_penyakit;

    $mmk=$diagnosa[$key]['cf'] * 100;

    $db->query("INSERT INTO tb_hasil(nama, no_hp,jk,alamat,tgl,hasil_konsultasi,kepercayaan) VALUES('$nama','$no_hp','$jk','$alamat','$tgl','$hasildiagnosa','$mmk')");

    ?>

