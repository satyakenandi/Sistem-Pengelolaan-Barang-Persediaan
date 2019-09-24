<?php
session_start();

// Panggil koneksi database.php untuk koneksi database
require_once "../../config/database.php";

if(isset($_GET['id_nota'])) {
	$id_nota = $_GET['id_nota'];

  // fungsi query untuk menampilkan data dari tabel barang
  $query1 = mysqli_query($mysqli, "SELECT a.id_nota,a.id_barang,a.id_barang_masuk,a.jumlah_masuk,a.harga_barang, b.nama_barang,b.id_barang
                                            FROM is_barang_masuk as a INNER JOIN is_barang as b
                                            ON a.id_barang=b.id_barang WHERE a.id_nota='$id_nota'")
                                            or die('Ada kesalahan pada query tampil Data Barang: '.mysqli_error($mysqli));

  $result =[];

  while ($data = mysqli_fetch_assoc($query1)){
    $result[]=$data;
  }
  // tampilkan data
  // $data = mysqli_fetch_assoc($query1);
  // die(print_r($data));

  echo json_encode($result);

	}		
?> 