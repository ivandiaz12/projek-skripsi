<body class="latar">
<div class="page-header">
    <h1 style="color: #fff;" align="center"><b>Tambah Admin</b></h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if($_POST) include'aksi.php'?>
        <form method="post">
            <div class="form-group">
                <label style="color: #fff;">nama <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama" value="<?=set_value('nama')?>"/>
            </div>
            <div class="form-group">
                <label style="color: #fff;">username <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="user" value="<?=set_value('user')?>"/>
            </div>
            
            <div class="form-group">
                <label style="color: #fff;">pass <span class="text-danger">*</span></label>
                <input class="form-control" type="password" name="pass" value="<?=set_value('pass')?>"/>
            </div>
            
            <div class="form-group">
                <button class="btn tambah"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn edit" href="?m=admin"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>