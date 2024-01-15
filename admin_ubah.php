<?php
    $row = $db->get_row("SELECT nama,user FROM tb_admin WHERE ID='$_GET[ID]'"); 
?>
<body class="latar">
<div class="page-header">
    <h1 style="color: #fff;" align="center"><b>Ubah Admin</b></h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if($_POST) include'aksi.php'?>
        <form method="post">
            <div class="form-group">
                <label style="color: #fff;">Nama Admin <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama"  value="<?=set_value('nama', $row->nama)?>"/>
            </div>
            <div class="form-group">
                <label style="color: #fff;">Username <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="user" value="<?=set_value('user', $row->user)?>"/>
            </div>
            <div class="form-group">
                <button class="btn edit"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn edit" href="?m=admin"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>