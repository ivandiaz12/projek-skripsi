<body class="latar">
<div class="page-header">
    <h1 style="color: #fff;" align="center"><b>Tambah Penyakit</b></h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if($_POST) include'aksi.php'?>
        <form method="post">
            <div class="form-group">
                <label style="color: #fff;">Kode <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="kode" value="<?=set_value('kode', kode_oto('kode_penyakit', 'tb_penyakit', 'P', 3))?>"/>
            </div>
            <div class="form-group">
                <label style="color: #fff;">Nama Penyakit <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama" value="<?=set_value('nama')?>"/>
            </div>
            <div class="form-group">
                <label style="color: #fff;">Solusi</label>
                <textarea class="form-control" name="solusi"><?=set_value('solusi')?></textarea>
            </div>
            <div class="form-group">
                <button class="btn tambah"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn edit" href="?m=penyakit"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>