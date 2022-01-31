<?php
//koneksikan ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);

    $rows = [];
    while ( $row =mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
} 



function tambah($data){
    global $conn;
    //pengambilan data
    $nim = htmlspecialchars($data["nim"]);
    $nama = htmlspecialchars($data["nama"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $email = htmlspecialchars($data["email"]);

   //upload gambar 
   $gambar = upload();
   if (!$gambar ){
       return false;
   }


     //query insert data
     $query = "INSERT INTO mahasiswa
     VALUES
     ('','$nama','$nim','$jurusan','$email','$gambar') "; 
     mysqli_query($conn, $query);

     return mysqli_affected_rows($conn);
}

function upload(){
    
    //ambil isi $_FILES
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gmabar yg tidak di upload
    if ($error === 4 ){
        echo "<script>
                alert('pilih gambar terlebih dahulu');
               </script> ";
        return false;
    }

    //cek apakah yg diuupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if(!in_array($ekstensiGambar, $ekstensiGambarValid)){
        echo "<script>
                 alert('yang anda upload bukan gambar');
            </script> ";
    return false;
    }

    //cek jika ukuran terlalu besar
    if($ukuranFile > 1000000 ){
        echo "<script>
                 alert('ukuran gambar terlalu besar!');
              </script> ";
    return false;
    }

    //lolos pengecekan gambar siap di upload
    //generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'image/'.$namaFileBaru);

    return $namaFileBaru;
}

function hapus($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

    return mysqli_affected_rows($conn);
}


function ubah($data){
    global $conn;

    //pengambilan data
    $id = $data["id"];
    $nim = htmlspecialchars($data["nim"]);
    $nama = htmlspecialchars($data["nama"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $email = htmlspecialchars($data["email"]);
    $gambarLama =  htmlspecialchars($data["gambarLama"]);

    //cek apakah user pilih gambar baru atau tidak
    if( $_FILES['gambar']['error'] === 4){
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }
    


     //query insert data 
     $query = "UPDATE mahasiswa SET 
                nim = '$nim',
                nama = '$nama',
                jurusan = '$jurusan',
                email = '$email',
                gambar = '$gambar' 

            WHERE id = $id
            ";
     mysqli_query($conn, $query);

     return mysqli_affected_rows($conn);
}


function cari($keyword){
    $query = "SELECT*FROM mahasiswa 
                WHERE
               nama LIKE '%$keyword%' OR
            --    masksud dari kode nama LIKE '%$keyword%' adalah untuk mempermudah pencarian meski kita lupa nama lengkap pada database
                nim LIKE '%$keyword%' OR
                jurusan LIKE '%$keyword%' OR
                email LIKE '%$keyword%
            ";

    return query($query);
}

function registrasi($data){
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    //cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if( mysqli_fetch_assoc($result) ) {
        echo "<script>
                alert('username sudah terdaftar!')
                </script>";

        return false;
    }
    //cek konfirmasi password
    if( $password !== $password2 ){
        echo "<script>
                alert('konfirmasi password tidak sesuai!');
                </script>";
        return false;
    }

    //enkripsi password (mengamankan)
    $password = password_hash($password, PASSWORD_DEFAULT);


    //tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user VALUES('', '$username','$password')");


    return mysqli_affected_rows($conn);
}

?>