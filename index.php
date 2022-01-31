 <?php
//tag php untuk menyiapkan data yg akan ditampilkan ke dalam
//tabel dibawahnya 
session_start();
if( !isset($_SESSION["login"]) ){
    header("Location: login.php");
    exit;
    //maksudnya adalah ketika session login tidak ada alihkan kembali ke halaman login
}
require 'functions.php'; //pemanggilan file functions

// pagination
//konfigurasi
$jumlahDataPerhalaman = 2;
$jumlahData = count(query("SELECT * FROM mahasiswa"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
//menggunakan operator ternary
$halamanAktif = (isset($_GET["halaman"]) ) ? $_GET["halaman"] : 1;
$awalData = ( $jumlahDataPerhalaman * $halamanAktif ) - $jumlahDataPerhalaman;
$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awalData, $jumlahDataPerhalaman ");

// tombol cari di klik
if(isset ($_POST["cari"])){
    $mahasiswa = cari($_POST["keyword"]); //maksudnya variabel mahasiswa akan berisi sesuai dengan dari function cari, function cari menampilkan apapun yag diketikkan oleh usernya
 }
?>

<html>
    <head>
        <title>Halaman Admin</title>
    </head>
    <body>
    
    <a href="logout.php"> Logout</a>
    <h1>Daftar Mahasiswa</h1>
    <a href="tambah.php">Tambah data mahasiswa</a> 
    <br></br>

    <form action="" method="post">
        <input type="text" name="keyword" size="40" autofocus placeholder="Masukkan keyword pencarian..."
        autocomplete ="off">
        <button type="submit" name="cari"> Cari!</button>
        
        <!-- autofocus adalah tag untuk membuat menu serachhing auto aktif saat masuk halaman
            placeholder adalah tag untuk memasukkan kata pada button 
            autocomplete untuk menghilangkan histori pencarian user-->
    </form>

    <!-- navigasi -->
    <?php if( $halamanAktif > 1) : ?>
        <a href="?halamam=<?= $halamanAktif - 1; ?>">&laquo;</a>
    <?php endif; ?>

    <?php for($i = 1; $i <= $jumlahHalaman; $i++ ) : ?>
        <?php if( $i == $halamanAktif ) : ?>
            <a href="?halaman=<?= $i; ?>" style="font-weight: bold; color: red;"><?= $i; ?></a>
        <?php else: ?>
            <a href="?halaman=<?= $i; ?>"><?= $i; ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if( $halamanAktif < $jumlahHalaman) : ?>
        <a href="?halamam=<?= $halamanAktif + 1; ?>">&raquo;</a>
    <?php endif; ?>


    <br><br>
    <table border="1" cellpadding="10" cellspacing="0">
     
    <tr>
        <th>No. </th>
        <th>Aksi </th>
        <th>Gambar </th>
        <th>NIM </th>
        <th>Nama</th>
        <th>Jurusan</th>
        <th>Email</th>
    </tr>
    <?php $i = 1; ?>
    <?php foreach ($mahasiswa as $row ) : ?>
    <tr>
        <td> <?= $i; ?> </td>
        <td>
            <a href="ubah.php?id=<?= $row["id"] ?>"> ubah </a> |
            <a href="hapus.php?id=<?= $row["id"]; ?>" 
                onclick="return confirm('Apakah anda yakin ingin menghapus data?');"> hapus </a> 
        </td>
        <td><img src="image/<?= $row["gambar"]; ?>"
        width="40"</td>
        <td> <?= $row["nim"]; ?> </td>
        <td> <?= $row["nama"]; ?></td>
        <td> <?= $row["jurusan"]; ?></td>
        <td> <?= $row["email"]; ?></td>
    </tr>
    <?php $i++ ?>
    <?php endforeach; ?>

    </body>
</html>