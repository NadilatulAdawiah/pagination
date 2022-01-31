<?php 
session_start();
if( !isset($_SESSION["login"]) ){
    header("Location: login.php");
    exit;
    //maksudnya adalah ketika session login tidak ada alihkan kembali ke halaman login
}

require 'functions.php';
//cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ){
     

    //ambil data dari tiap tiap elemen dalam form 
    //ada di function

    //cek apakah data berhasil di tambahkan atau tidak
    // (-1 = error) //1 ada tambahan data
    if( tambah($_POST) > 0){
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
                document.location.href = 'index.php';
            </script>
        
        ";
    } else {
        echo "<script>
                alert('Data gagal ditambahkan!');
                document.location.href = 'index.php';
            </script>
        ";
    }

}

?>

<html>
<head>
        <title> Tambah data mahasiswa </title>
</head>
<body>

    <h1> Tambah Data Mahasiswa </h1>

    <form action = "" method = "post" enctype = "multipart/form-data">
        <ul>
            <li>
                <label for="nim"> NIM : </label>
                <input type="text" name="nim" id="nim" required> <!--reuires agar saat inputan blm isis tbl submit tak bisa ditekan-->
            </li>
            <li>
                <label for="nama"> Nama : </label>
                <input type="text" name="nama" id="nama" required>
            </li>
            <li>
                <label for="jurusan"> Jurusan : </label>
                <input type="text" name="jurusan" id="jurusan" required>
            </li>
            <li>
                <label for="email"> Email : </label>
                <input type="text" name="email" id="email" required>
            </li>
            <li>
                <label for="gambar"> Gambar : </label>
                <input type="file" name="gambar" id="gambar" >
            </li>
            <li>
                <button type="submit" name="submit"> Tambah Data!</button>
            </li>
        </ul>

</body>
</html>