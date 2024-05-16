<?php
require_once'functions.php';
 
if ($mod=='login'){
    $user = esc_field($_POST['user']);
    $pass = esc_field($_POST['pass']);
    
    $row = $db->get_row("SELECT * FROM tb_admin WHERE user='$user' AND pass='$pass'");
    if($row){
        $_SESSION['login'] = $row->user;
        redirect_js("index.php");
    } else{
        print_msg("Salah kombinasi username dan password.");
    }          
}else if ($mod=='password'){
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $pass3 = $_POST['pass3'];
    
    $row = $db->get_row("SELECT * FROM tb_admin WHERE user='$_SESSION[login]' AND pass='$pass1'");        
    
    if($pass1=='' || $pass2=='' || $pass3=='')
        print_msg('Field bertanda * harus diisi.');
    elseif(!$row)
        print_msg('Password lama salah.');
    elseif( $pass2 != $pass3 )
        print_msg('Password baru dan konfirmasi password baru tidak sama.');
    else{        
        $db->query("UPDATE tb_admin SET pass='$pass2' WHERE user='$_SESSION[login]'");                    
        print_msg('Password berhasil diubah.', 'success');
    }
} elseif($act=='logout'){
    unset($_SESSION['login']);
    header("location:index.php?m=login");
}

/** penyakit */
elseif($mod=='penyakit_tambah'){
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $solusi = $_POST['solusi'];
    if($kode=='' || $nama=='')
        print_msg("Field yang bertanda * tidak boleh kosong!");
    elseif($db->get_row("SELECT * FROM tb_penyakit WHERE kode_penyakit='$kode'"))
        print_msg("Kode sudah ada!");
    else{
        $db->query("INSERT INTO tb_penyakit (kode_penyakit, nama_penyakit, solusi) VALUES ('$kode', '$nama',  '$solusi')");                       
        redirect_js("index.php?m=penyakit");
    }
} else if($mod=='penyakit_ubah'){
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $solusi = $_POST['solusi'];
    if($kode=='' || $nama=='')
        print_msg("Field yang bertanda * tidak boleh kosong!");
    else{
        $db->query("UPDATE tb_penyakit SET nama_penyakit='$nama' , solusi='$solusi' WHERE kode_penyakit='$_GET[ID]'");
        redirect_js("index.php?m=penyakit");
    }
} else if ($act=='penyakit_hapus'){
    $db->query("DELETE FROM tb_penyakit WHERE kode_penyakit='$_GET[ID]'");
    $db->query("DELETE FROM tb_relasi WHERE kode_penyakit='$_GET[ID]'");
    header("location:index.php?m=penyakit");
} 

/** GEJALA */    
elseif($mod=='gejala_tambah'){
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $keterangan = $_POST['keterangan'];
    
    if($kode=='' || $nama=='')
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif($db->get_row("SELECT * FROM tb_gejala WHERE kode_gejala='$kode'"))
        print_msg("Kode sudah ada!");
    else{
        $db->query("INSERT INTO tb_gejala (kode_gejala, nama_gejala, keterangan) VALUES ('$kode', '$nama', '$keterangan')");                   
        redirect_js("index.php?m=gejala");
    }                    
} else if($mod=='gejala_ubah'){
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $keterangan = $_POST['keterangan'];
    
    if($kode=='' || $nama=='')
        print_msg("Field bertanda * tidak boleh kosong!");
    else{
        $db->query("UPDATE tb_gejala SET nama_gejala='$nama', keterangan='$keterangan' WHERE kode_gejala='$_GET[ID]'");
        redirect_js("index.php?m=gejala");
    }    
} else if ($act=='gejala_hapus'){
    $db->query("DELETE FROM tb_gejala WHERE kode_gejala='$_GET[ID]'");
    $db->query("DELETE FROM tb_relasi WHERE kode_gejala='$_GET[ID]'");
    header("location:index.php?m=gejala");
} 
    
/** PENGETAHUAN */ 
else if ($mod=='pengetahuan_tambah'){
    $kode_penyakit = $_POST['kode_penyakit'];
    $kode_gejala = $_POST['kode_gejala'];
    $mb = $_POST['mb'];
    $md = $_POST['md'];
    
    $kombinasi_ada = $db->get_row("SELECT * FROM tb_pengetahuan WHERE kode_penyakit='$kode_penyakit' AND kode_gejala='$kode_gejala'");
    
    if($kode_penyakit=='' || $kode_gejala=='' || $mb=='' || $md=='')
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif($kombinasi_ada)
        print_msg("Kombinasi kode_penyakit dan gejala sudah ada!");
    else{
        $db->query("INSERT INTO tb_pengetahuan (kode_penyakit, kode_gejala, mb, md) VALUES ('$kode_penyakit', '$kode_gejala', '$mb', '$md')");
        redirect_js("index.php?m=pengetahuan");
    }   
}else if ($mod=='pengetahuan_ubah'){
    $kode_penyakit = $_POST['kode_penyakit'];
    $kode_gejala = $_POST['kode_gejala'];
    $mb = $_POST['mb'];
    $md = $_POST['md'];
    
    $kombinasi_ada = $db->get_row("SELECT * FROM tb_pengetahuan WHERE kode_penyakit='$kode_penyakit' AND kode_gejala='$kode_gejala' AND ID<>'$_GET[ID]'");
    
    if($kode_penyakit=='' || $kode_gejala=='' || $mb=='' || $md=='')
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif($kombinasi_ada)
        print_msg("Kombinasi penyakit dan gejala sudah ada!");
    else{
        $db->query("UPDATE tb_pengetahuan SET kode_penyakit='$kode_penyakit', kode_gejala='$kode_gejala', mb='$mb', md='$md' WHERE ID='$_GET[ID]'");
        redirect_js("index.php?m=pengetahuan");
    }  
    header("location:index.php?m=pengetahuan");
} else if ($act=='relasi_hapus'){
    $db->query("DELETE FROM tb_pengetahuan WHERE ID='$_GET[ID]'");
    header("location:index.php?m=pengetahuan");
} else if ($act=='laporan_hapus'){
    $db->query("DELETE FROM tb_hasil WHERE id='$_GET[ID]'");
    header("location:index.php?m=laporan");
} else if ($mod=='konsultasi') {

    if($_POST['bobot']) {        
        $db->query("INSERT INTO tb_konsultasi (kode_gejala, jawaban) VALUES ('$_POST[kode_gejala]', '$_POST[bobot]')");
    } elseif($act=='new') {        
        $db->query("TRUNCATE TABLE tb_konsultasi");
    }

    header("location:index.php?m=konsultasi");
}

/** ADMIN */
elseif($mod=='admin_tambah'){
    $nama = $_POST['nama'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    

    if($user=='' || $pass=='')
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif($db->get_row("SELECT * FROM tb_admin WHERE ID='$ID'"))
        print_msg("Username sudah ada!");
    else{
        $db->query("INSERT INTO tb_admin (nama, user, pass) VALUES ('$user', '$nama', '$pass')");                   
        redirect_js("index.php?m=admin");
    }                    
} else if($mod=='admin_ubah'){
    $nama = $_POST['nama'];
    $user = $_POST['user'];
    
    
    if($nama=='' || $user=='')
        print_msg("Field bertanda * tidak boleh kosong!");
    else{
        $db->query("UPDATE tb_admin SET nama='$nama', user='$user' WHERE ID='$_GET[ID]'");
        redirect_js("index.php?m=admin");
    }    
} else if ($act=='admin_hapus'){
    $db->query("DELETE FROM tb_admin WHERE ID='$_GET[ID]'");
    header("location:index.php?m=admin");
} 


