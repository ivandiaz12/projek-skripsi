<body class="latar">
<div class="page-header">
    <h1 style="color: #fff;" align="center"><b>Admin</b></h1>
</div>
<div class="panel panel-default">
    <div class="panel-heading" align="right">
        <form class="form-inline">
            <input type="hidden" name="m" value="admin" />
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Pencarian. . ." name="q" value="<?=@$_GET['q']?>" />
            </div>
            <div class="form-group">
                <button class="btn tambah"><span class="glyphicon glyphicon-search"></span></button>
            </div>
            <span class="pull-left">
            <div class="form-group">
                <a class="btn tambah" href="?m=admin_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah Data</a>
            </div></span>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover ">
            <thead><tr class="nw">
                <th>No</th>
                <th>nama</th>
                <th>username</th>
                <th>Aksi</th>
            </tr></thead>
            <?php
            $q = esc_field(@$_GET['q']);
            $rows = $db->get_results("SELECT * FROM tb_admin 
                WHERE nama LIKE '%$q%' OR user LIKE '%$q%'  
                ORDER BY ID");
            $no=0;            
            foreach($rows as $row):?>
            <tr>
                <td><?=++$no ?></td>
                <td><?=$row->nama?></td>
                <td><?=$row->user?></td>
                
                <td class="nw">
                    <a class="btn btn-xs edit" href="?m=admin_ubah&ID=<?=$row->ID?>"><span class="glyphicon glyphicon-pencil"></span></a>
                    <a class="btn btn-xs edit" href="aksi.php?act=admin_hapus&ID=<?=$row->ID?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
    </div>
</div>
</body>