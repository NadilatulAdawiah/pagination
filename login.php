<?php
session_start();
require 'functions.php';
//cek cookie
if( isset($_COOKIE['id']) &&  isset($_COOKIE['key'])  ) {
    $id = $_COOKIE['id']; 
    $key = $_COOKIE['key'];

    //ambil username berdasarkan id nya
    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    //cek cookie dan username
    if($key === hash('sha256', $row['username']) ) {
        $_SESSION['login'] = true;
    }
}
if( isset($_SESSION["login"]) ){
    header("Location: index.php");
}


//cek apakah tombol login sudah di tekan?
if( isset($_POST["login"]) ) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    //cek ada ngak username yg diinputkan dalam database
    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    // cek usernmae
    if ( mysqli_num_rows($result) === 1) {

        //cek passwordnya
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row["password"]) ){

            ///set session 
            $_SESSION["login"] = true;

            //cek remember me
            if( isset($_POST['remember']) ) {
                //buat cookie
                //untuk membuat cookie aman dan tdk mudah di retas kita buatkan enkripsi
                
                setcookie('id', $row['id'], time()+60);
                setcookie('key', hash('sha256', $row['id']), time()+60);
            }
            header("Location: index.php");
            exit;
        }

    }

    $error = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title> Halaman Login</title>
</head>
<style>
        .label{
            display: block;
        }

        h1{
            text-align: center;
        }
        li{
            text-align: left;
        }

        p {
            text-align: center;
        }

        
</style>
<body>
<table border= "2" align= "center" width="400" height="500" >
        <tr>
            <td >
    <h1>Halaman Login</h1>

    <form action="" method="post">

    <ul>
        <li>
            <label class="label" for="username">  Username: </label>
            <input type="text" name="username" id="username" size="25">
        </li>
        <li>
            <label class="label" for="password"> Password: </label>
            <input type="password" name="password" id="password " size="25">
        </li>
        <li>

            <input type="checkbox" name="remember" id="remember"> <label for="remember"> Remember Me </label>
            
        </li>
        <li>
            <button type="submit" name="login">
                Login!
            </button>
        </li>
    </ul>
    </form>
    <?php if(isset($error)) : ?>
        <p style="color: red; font-style: italic;"> username / password salah! </p>
    <?php endif; ?>
    </td>
    </tr>
    </table>
</body>
</html>