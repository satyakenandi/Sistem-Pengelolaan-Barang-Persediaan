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
            $id_barang_keluar = mysqli_real_escape_string($mysqli, trim($_POST['id_barang_keluar']));
            $tanggal          = mysqli_real_escape_string($mysqli, trim($_POST['tanggal_keluar']));
            $exp              = explode('-',$tanggal);
            $tanggal_keluar   = $exp[2]."-".$exp[1]."-".$exp[0];

            $id_barang        = mysqli_real_escape_string($mysqli, trim($_POST['id_barang']));
            $jumlah_keluar    = mysqli_real_escape_string($mysqli, trim($_POST['jumlah_keluar']));
            $total_stok       = mysqli_real_escape_string($mysqli, trim($_POST['total_stok']));

            $created_user    = $_SESSION['id_user'];

            // perintah query untuk menyimpan data ke tabel barang keluar

            $query = mysqli_query($mysqli, "INSERT INTO is_barang_keluar(
                                                      id_barang_keluar,tanggal_keluar,id_barang,jumlah_keluar,created_user)
                                          VALUES      ('$id_barang_keluar','$tanggal_keluar','$id_barang','$jumlah_keluar',
                                                      '$created_user')"
                                )
                                          or die('Ada kesalahan pada query insert : '.mysqli_error($mysqli));

            // cek query
            if ($query) {
                // perintah query untuk mengubah data pada tabel barang
                $query1 = mysqli_query($mysqli, "UPDATE is_barang
                                               SET    stok      = '$total_stok'
                                               WHERE  id_barang = '$id_barang'"
                                    )
                                               or die('Ada kesalahan pada query update : '.mysqli_error($mysqli));
                // cek query
                if ($query1) {
                    // jika berhasil tampilkan pesan berhasil simpan data
                    header("location: ../../main.php?module=barang_keluar&alert=1");
                }
            }
        }
    }
    elseif ($_GET['act']=='delete') {
      if (isset($_GET['id'])) {
          $id_barang_keluar = $_GET['id'];

          // perintah query untuk menghapus data pada tabel barang
          $query = mysqli_query($mysqli, "DELETE FROM is_barang_keluar WHERE id_barang_keluar='$id_barang_keluar'")
                                          or die('Ada kesalahan pada query delete : '.mysqli_error($mysqli));

          // cek hasil query
          if ($query) {
              // jika berhasil tampilkan pesan berhasil delete data
              header("location: ../../main.php?module=barang_keluar&alert=3");
          }
      }
  }
}
?>
