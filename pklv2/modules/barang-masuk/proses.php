<?php
session_start();

// Panggil koneksi database.php untuk koneksi database
require_once "../../config/database.php";

// fungsi untuk pengecekan status login user
// jika user belum login, alihkan ke halaman login dan tampilkan pesan = 1
if (empty($_SESSION['username']) && empty($_SESSION['password'])){
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
}
// jika user sudah login, maka jalankan perintah untuk insert, update, dan delete
else {
    if ($_GET['act']=='insert') {
        if (isset($_POST['simpan'])) {
            // ambil data hasil submit dari form
            $id_nota         = mysqli_real_escape_string($mysqli, trim($_POST['id_nota']));
            $tanggal         = mysqli_real_escape_string($mysqli, trim($_POST['tanggal_nota']));
            $exp             = explode('-',$tanggal);
            $tanggal_nota    = $exp[2]."-".$exp[1]."-".$exp[0];
            $id_barang       = $_POST['id_barang'];
            $harga_barang    = $_POST['harga_barang'];
             // die(print_r($harga_barang));
            $jumlah_masuk    = $_POST['jumlah_masuk'];
            // die(print_r($jumlah_masuk));
            // di db masih tulisan harga_barang
            $harga_total        = mysqli_real_escape_string($mysqli, trim($_POST['harga_total']));
            $nama_pegawai       = mysqli_real_escape_string($mysqli, trim($_POST['nama_pegawai']));
            $nama_file          = $_FILES['foto']['name'];
            $ukuran_file        = $_FILES['foto']['size'];
            $tipe_file          = $_FILES['foto']['type'];
            $tmp_file           = $_FILES['foto']['tmp_name'];

                // tentuka extension yang diperbolehkan
            $allowed_extensions = array('jpg','jpeg','png');

                // Set path folder tempat menyimpan gambarnya
            $path_file          = "../../images/barang_masuk/".$nama_file;

                // check extension
            $file               = explode(".", $nama_file);
            $extension          = array_pop($file);
            $created_user    = $_SESSION['id_user'];
            // jika foto tidak diubah
                      // Cek apakah tipe file yang diupload sesuai dengan allowed_extensions
                if (in_array($extension, $allowed_extensions)) {
                        // Jika tipe file yang diupload sesuai dengan allowed_extensions, lakukan :
                        if($ukuran_file <= 1000000) { // Cek apakah ukuran file yang diupload kurang dari sama dengan 1MB
                            // Jika ukuran file kurang dari sama dengan 1MB, lakukan :
                            // Proses upload
                            if(move_uploaded_file($tmp_file, $path_file)) { // Cek apakah gambar berhasil diupload atau tidak
                                // Jika gambar berhasil diupload, Lakukan :

            // perintah query untuk mengubah data pada tabel users
           $id_user =  $_SESSION['id_user'];
           $query = mysqli_query($mysqli, "INSERT INTO is_nota(id_nota,tanggal_nota,harga_total,foto,created_user,nama_pegawai)
                                          VALUES('$id_nota','$tanggal_nota','$harga_total','$path_file',$id_user,'$nama_pegawai')")
                                          or die('Ada kesalahan pada query insert : '.mysqli_error($mysqli));
            for($i=0;$i<sizeof($id_barang);$i++){
                $query2 = mysqli_query($mysqli, "INSERT INTO is_barang_masuk(id_nota,id_barang,harga_barang,jumlah_masuk)
                                          VALUES('$id_nota', (SELECT id_barang FROM is_barang WHERE id_barang ='$id_barang[$i]'),'$harga_barang[$i]','$jumlah_masuk[$i]')");
                $query3 = mysqli_query($mysqli, "UPDATE is_barang SET stok = stok + '$jumlah_masuk[$i]', updated_date = NOW(), updated_user = '$id_user' WHERE id_barang = '$id_barang[$i]'");
            }
            // die(print_r(mysqli_error($mysqli)));
            // cek query
                               if ($query) {
                // perintah query untuk mengubah data pada tabel barang
                                $query1 = mysqli_query($mysqli, "UPDATE is_barang SET stok      = '$total_stok'
                                    WHERE id_barang = '$id_barang'")
                                or die('Ada kesalahan pada query update : '.mysqli_error($mysqli));

                // cek query
                                if ($query1) {
                    // jika berhasil tampilkan pesan berhasil simpan data
                                    header("location: ../../main.php?module=barang_masuk&alert=1");
                                }
                            }
                        }
                    }
                }
            }
}

    // elseif ($_GET['act']=='update') {
    //     if (isset($_POST['simpan'])) {
    //         if (isset($_POST['id_barang'])) {
    //             // ambil data hasil submit dari form
    //             $id_barang_masuk = mysqli_real_escape_string($mysqli, trim($_POST['id_barang_masuk']));

    //             $tanggal         = mysqli_real_escape_string($mysqli, trim($_POST['tanggal_masuk']));
    //             $exp             = explode('-',$tanggal);
    //             $tanggal_masuk   = $exp[2]."-".$exp[1]."-".$exp[0];

    //             $id_barang       = mysqli_real_escape_string($mysqli, trim($_POST['id_barang']));
    //             $harga_barang    = mysqli_real_escape_string($mysqli, trim($_POST['harga_barang']));
    //             $jumlah_masuk    = mysqli_real_escape_string($mysqli, trim($_POST['jumlah_masuk']));
    //             $total_stok      = mysqli_real_escape_string($mysqli, trim($_POST['total_stok']));

    //             $nama_file          = $_FILES['foto']['name'];
    //             $ukuran_file        = $_FILES['foto']['size'];
    //             $tipe_file          = $_FILES['foto']['type'];
    //             $tmp_file           = $_FILES['foto']['tmp_name'];

    //             // tentuka extension yang diperbolehkan
    //             $allowed_extensions = array('jpg','jpeg','png');

    //             // Set path folder tempat menyimpan gambarnya
    //             $path_file          = "../../images/barang_masuk/".$nama_file;

    //             // check extension
    //             $file               = explode(".", $nama_file);
    //             $extension          = array_pop($file);

    //             $updated_user = $_SESSION['id_user'];

    //             // perintah query untuk mengubah data pada tabel barang
    //             $query = mysqli_query($mysqli, "UPDATE is_barang_masuk SET
    //                                                                  tanggal_masuk    = '$tanggal_masuk',
    //                                                                  id_barang        = '$id_barang',
    //                                                                  harga_barang     = '$harga_barang',
    //                                                                  jumlah_masuk     = '$jumlah_masuk'
    //                                                                  foto             = '$foto'
    //                                                            WHERE id_barang_masuk      = '$id_barang_masuk'")
    //                                             or die('Ada kesalahan pada query update : '.mysqli_error($mysqli));

    //             // cek query
    //             if ($query) {
    //                 // jika berhasil tampilkan pesan berhasil update data
    //                 header("location: ../../main.php?module=barang_masuk&alert=2");
    //             }
    //         }
    //     }
    // }

      elseif ($_GET['act']=='delete') {
        if (isset($_GET['id'])) {
            $id_nota = $_GET['id'];

            // perintah query untuk menghapus data pada tabel barang
            $query = mysqli_query($mysqli, "DELETE FROM is_nota WHERE id_nota='$id_nota'")
                                            or die('Ada kesalahan pada query delete : '.mysqli_error($mysqli));

            // cek hasil query
            if ($query) {
                // jika berhasil tampilkan pesan berhasil delete data
                header("location: ../../main.php?module=barang_masuk&alert=3");
            }
        }
    }
}
            ?>
