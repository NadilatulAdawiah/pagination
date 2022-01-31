<?php
require 'functions.php';
//jika tombol register apakah sdh di klik atau tdk

if( isset($_POST["register"])){

    if( registrasi($_POST) > 0) {
        echo"<script>
                alert('user baru berhasil ditambahkan!')
            </script> 
            ";
    }else {
        echo mysqli_error($conn);
    }
}



?>
<!DOCTYPE html>
<html>
<head>
    <title> Halaman Registrasi </title>
    <style>
        label{
            display: block;
        }

        h1{
            text-align: center;
        }
        li{
            text-align: left;
        }

        
    </style>
</head>
<body>
    <table border= "2" align= "center" width="400" height="500" >
        <tr>
            <td >
    <h1>Halaman Registrasi</h1>

    <form action="" method="post">

    <ul>
        <li>
            <label for="username">username: </label>
            <input type="text" name="username" id="username" size="25">
        </li>
        <li>
            <label for="password">password: </label>
            <input type="password" name="password" id="password " size="25">
        </li>
        <li>
            <label for="password2">konfirmasi password: </label>
            <input type="password" name="password2" id="password2" size="25">
        </li>
        <li>
            <button type="submit" name="register">
                Daftar!
            </button>
        </li>
    </ul>
    </form>
    </td>
    </tr>
    </table>

</body>
</html>