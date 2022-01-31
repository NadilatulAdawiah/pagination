<?php 
session_start();
if( !isset($_SESSION["login"]) ){
    header("Location: login.php");
    exit;
    //maksudnya adalah ketika session login tidak ada alihkan kembali ke halaman login
}

require 'functions.php';

//ambildata di url
$id = $_GET["id"];

//query data mahasiswa berdasarkan idnya
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];

//cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ){

    //ambil data dari tiap tiap elemen dalam form 
    //ada di function

    //cek apakah data berhasil di ubah atau tidak
    if( ubah($_POST) > 0 ) {
        echo "
            <script>
                alert('Data berhasil diubah!');
                document.location.href = 'index.php';
            </script>
        
        ";
    } else {
        echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'index.php';
            </script>
        ";
    }

}

?>

<html>
<head>
        <title> Ubah data mahasiswa </title>
</head>
<body>

    <h1> Ubah Data Mahasiswa </h1>

    <form action = "" method = "post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $mhs["id"]; ?>">
        <input type="hidden" name="gambarLama" value="<?= $mhs["gambar"]; ?>">
        <ul>
            <li>
                <label for="nim"> NIM : </label>
                <input type="text" name="nim" id="nrp" 
                value="<?= $mhs["nim"]; ?>"> 
            </li>
            <li>
                <label for="nama"> Nama : </label>
                <input type="text" name="nama" id="nama"  
                value="<?= $mhs["nama"]; ?>">
            </li>
            <li>
                <label for="jurusan"> Jurusan : </label>
                <input type="text" name="jurusan" id="jurusan"
                value="<?= $mhs["jurusan"]; ?>">
            </li>
            <li>
                <label for="email"> Email : </label>
                <input type="text" name="email" id="email" 
                value="<?= $mhs["email"]; ?>">
            </li>
            <li>
                <label for="gambar"> Gambar : </label> <br>
                <img src="image/<?= $mhs['gambar']; ?>" width = "40"> 
                <br>
                <input type="file" name="gambar" id="gambar" >
            </li>
            <li>
                <button type="submit" name="submit"> Ubah Data!</button>
            </li>
        </ul>

</body>
</html>