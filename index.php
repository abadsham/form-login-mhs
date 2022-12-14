<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "akademik";

$koneksi    = mysqli_connect($host,$user,$pass,$db);
if(!$koneksi){ //cek koneksi
    die("Tidak Bisa Terkoneksi Ke DataBase");
} else{
    echo "berhasil koneksinya";
}
$nim        ="";
$nama       ="";
$alamat     ="";
$fakultas   ="";
$sukses     ="";
$error      ="";

if(isset($_GET['op'])){
    $op = $_GET['op'];
} else{
    $op = "";
}
if($op =='delete'){
    $id     = $_GET['id'];
    $sql1   = "delete from mahasiswa where id = '$id'";
    $q1     = mysqli_query($koneksi,$sql1);
    if($sql1){
        $sukses = "Berhasil hapus data";
    } else{
        $error = "Gagal menghapus data";
    }
}

if($op == 'edit'){
    $id         = $_GET['id'];
    $sql1       = "select *from mahasiswa where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    $r1         = mysqli_fetch_array($q1);
    $nim        = $r1['nim'];
    $nama       = $r1['nama'];
    $alamat     = $r1['alamat'];
    $fakultas   = $r1['fakultas'];

    if($nim == ''){
        $error = "Data tidak ditemukan";
    }
}

if(isset($_POST['simpan'])){
    $nim        = $_POST['nim'];
    $nama       = $_POST['nama'];
    $alamat     = $_POST['alamat'];
    $fakultas   = $_POST['fakultas'];

    if($nim && $nama && $alamat && $fakultas){
        if($op == 'edit'){ //untuk update
            $sql1       = "update mahasiswa set nim = '$nim', nama = '$nama', alamat = '$alamat', fakultas = '$fakultas' where 'id'";
            $q1         = mysqli_query($koneksi,$sql1); 
            if($q1){
                $sukses = "Data berhasil diupdate";
            } else{
                $error = "Data gagal diupdate";
            }
        } else{ //untuk insert
            $sql1   = "insert into mahasiswa(nim,nama,alamat,fakultas) value('$nim','$nama','$alamat','$fakultas')";
            $q1     = mysqli_query($koneksi,$sql1);
            if($q1){
                $sukses     = "Berhasil memasukkan data baru";
            } else{
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error     = "Silahkan lengkapi data anda";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
    .mx-auto {
        width: 800px;
    }

    .card {
        margin-top: 10px
    }
    </style>
</head>

<body>
    <div class="mx-auto">
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if($error){
                ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error ?>
                </div>
                <?php
                    header("refresh: 7 ;url=http://localhost/php-mysqli/index.php");// 5 detik
                }
                ?>
                <?php 
                if($sukses){
                ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $sukses ?>
                </div>
                <?php
                    header("refresh: 5;url=http://localhost/php-mysqli/index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nim" id="nim" value="<?php echo $nim ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="alamat" id="alamat"
                                value="<?php echo $alamat ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="fakultas" class="col-sm-2 col-form-label">Fakultas</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="fakultas" id="fakultas">
                                <option value="">- Pilih Fakultas -</option>
                                <option value="UAD" <?php if($fakultas == "UAD") echo "selected"?>>UAD</option>
                                <option value="UGM" <?php if($fakultas == "UGM") echo "selected"?>>UGM</option>
                                <option value="UNS" <?php if($fakultas == "UNS") echo "selected"?>>UNS</option>
                                <option value="IDN" <?php if($fakultas == "IDN") echo "selected"?>>IDN Tercinta</option>
                                <option value="UNPAD" <?php if($fakultas == "INPAD") echo "selected"?>>UNPAD</option>
                                <option value="UI" <?php if($fakultas == "UI") echo "selected"?>>UI</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>
        <div class=" card">
            <div class="card-header text-white bg-secondary">
                Data Mahasiswa
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Fakultas</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    <tbody>
                        <?php 
                            $sql2   = "select * from mahasiswa order by id desc";
                            $q2     = mysqli_query($koneksi,$sql2);
                            $urut   = 1;
                            while($r2 = mysqli_fetch_array($q2)){
                                $id         = $r2['id'];
                                $nim        = $r2['nim'];
                                $nama       = $r2['nama'];
                                $alamat     = $r2['alamat'];
                                $fakultas   = $r2['fakultas'];

                                ?>
                        <tr>
                            <td scope="row"><?php echo $urut++ ?></td>
                            <td scope="row"><?php echo $nim ?></td>
                            <td scope="row"><?php echo $nama ?></td>
                            <td scope="row"><?php echo $alamat ?></td>
                            <td scope="row"><?php echo $fakultas ?></td>
                            <td scope="row">
                                <a href="index.php?op=edit&id=<?php echo $id?>">
                                    <button type="button" class="btn btn-warning">Edit</button>
                                </a>
                                <a href="index.php?op=delete&id=<?php echo $id?>"
                                    onclick="return confirm('Yakin mau hapus data?')">
                                    <button type="button" class="btn btn-danger">Delete</button>
                                </a>

                            </td>
                        </tr>
                        <?php
                            }
                            ?>
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</body>

</html>