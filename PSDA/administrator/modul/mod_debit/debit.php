<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/mod_debit/aksi_debit.php";
switch($_GET[act]){
  // Tampil Bentuk Bendung
  default:
    echo "<div class='well'>
  <div class='navbar navbar-inverse'>
<div class='navbar-inner'>
<div class='container'>
<ul class='nav'>
<li><div style='color:white; padding-top:9px; text-align:left;'><i class='icon-film icon-white'></i> Debit Harian</div></li>
</ul>
</div>
</div>
</div><h6>
<input type=button value='Tambah Debit Harian' onclick=location.href='?module=debit&act=tambahdebit' class='btn btn-success pull-right'><br />
          <table class='table table-condensed' width=100%>
          <thead><tr><th>No</th><th>Limpas</th><th>Hasil Limpas</th><th>Masuk Kiri</th><th>Hasil Kiri</th><th>Masuk Kanan</th><th>Hasil Kiri</th><th>Total</th></tr></thead>";

    $p      = new Paging;
    $batas  = 15;
    $posisi = $p->cariPosisi($batas);

    $tampil = mysql_query("SELECT * FROM debit ORDER BY id_debit ASC LIMIT $posisi,$batas");
  
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){
      echo "<tbody><tr><td>$no</td>
                <td>$r[limpas]</td>
                <td>$r[hlimpas]</td>
                <td>$r[masukkiri]</td>
                <td>$r[hmasukiri]</td>
                <td>$r[masukkanan]</td>
                <td>$r[hmasukkanan]</td>
                <td>$r[total]</td>
        <td><div class='btn-group drodown pull-right'>
  <button class='btn btn-info'><i class='icon-pencil icon-white'></i></button>
  <button class='btn btn-info dropdown-toggle' data-toggle='dropdown'>
    <span class='caret'></span>
  </button>
  <ul class='dropdown-menu'>
    <li><a href=?module=debit&act=editlimpas&id_debit=$r[id_debit]><i class='icon-pencil icon'></i> Edit Data</a></li>
    <li><a href=\"$aksi?module=debit&act=hapus&id_debit=$r[id_debit]\" onClick=\"return confirm('Apakah Anda benar-benar mau menghapusnya?')\"><i class='icon-trash icon'></i> Hapus Data</a></li>

  </ul>
</div></td>
            </tr></tbody>";
      $no++;
    }
    echo "</table>";

    $jmldata = mysql_num_rows(mysql_query("SELECT * FROM debit"));
  
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div></h6></div>";
 
    break;
  
  case "tambahdebit":
    echo "<div class='well'>
  <div class='navbar navbar-inverse'>
<div class='navbar-inner'>
<div class='container'>
<ul class='nav'>
<li><div style='color:white; padding-top:9px; text-align:left;'><i class='icon-film icon-white'></i> Tambah Rumus Bentuk Bendung</div></li>
</ul>
</div>
</div>
</div>
          <form method=POST action='$aksi?module=debit&act=input' enctype='multipart/form-data'>
      <div class='row-fluid'>
      <div class='span12'>
      <label>Limpas / Sungai</label>
      <input type=text name='limpas' class='span12' placeholder='Limpas / Sungai (Anggka/Decimal) ...'>
      <label>Masuk / Irigasi Kiri</label>
      <input type=text name='masukkiri' class='span12' placeholder='Number dan Decimal!...'>
       <label>Masuk / Irigasi Kanan</label>
      <input type=text name='masukkanan' class='span12' placeholder='Number dan Decimal!...'>
     
      </div>
      
          
         <div class='pull-right'><input type=submit value=Simpan class='btn btn-primary'> <input type=button value=Batal onclick=self.history.back() class='btn btn-danger'></div>
          
      </div></form></div>";
     break;
    
  case "editbentukbendung":
    $edit = mysql_query("SELECT * FROM bentukbendung WHERE id_bentukbendung='$_GET[id_bentukbendung]'");
    $r    = mysql_fetch_array($edit);
echo "<div class='well'>
  <div class='navbar navbar-inverse'>
<div class='navbar-inner'>
<div class='container'>
<ul class='nav'>
<li><div style='color:white; padding-top:9px; text-align:left;'><i class='icon-film icon-white'></i> Edit Ranting / Pengamat / UPTD</div></li>
</ul>
</div>
</div>
</div>
          <form method=POST action='$aksi?module=bentukbendung&act=update' enctype='multipart/form-data'>
                <input type=hidden name=id_bentukbendung value=$r[id_bentukbendung]>
      <div class='row-fluid'>
      <div class='span12'>
      <label>Nama Bentuk Bendung</label>
      <input type=text name='nm_bentukbendung' class='span12' value='$r[nm_bentukbendung]'>
      <label>Rumus Limpas/Sungai</label>
      <input type=text name='rumushitunganL' class='span12' value='$r[rumushitunganL]'>
      <label>Rumus Masuk/Irigasi</label>
      <input type=text name='rumushitunganM' class='span12' value='$r[rumushitunganM]'>
      
      
      
      </div>
          
         <div class='pull-right'><input type=submit value=Update class='btn btn-primary'> <input type=button value=Batal onclick=self.history.back() class='btn btn-danger'></div>
          
      </div></form></div>";
    break;  
}
}
?>
