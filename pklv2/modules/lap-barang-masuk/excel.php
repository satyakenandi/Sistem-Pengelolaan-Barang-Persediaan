<?php
session_start();
ob_start();

// Panggil koneksi database.php untuk koneksi database
require_once "../../config/database.php";
// panggil fungsi untuk format tanggal
include "../../config/fungsi_tanggal.php";

$hari_ini = date("d-m-Y");

// ambil data hasil submit dari form
$tgl1     = $_GET['tgl_awal'];
$explode  = explode('-',$tgl1);
$tgl_awal = $explode[2]."-".$explode[1]."-".$explode[0];

$tgl2      = $_GET['tgl_akhir'];
$explode   = explode('-',$tgl2);
$tgl_akhir = $explode[2]."-".$explode[1]."-".$explode[0];

	header("Content-Type: application/force-download");
	header("Cache-Control: no-cache, must-revalidate");
	header("content-disposition: attachment;filename=Barang_Masuk.xls");
?>
<!-- Buat Table saat di Export Ke Excel -->
	<center>
		<h3>DATA BARANG MASUK Ditjen PSDKP <br>
	    <?php
        if ($tgl_awal==$tgl_akhir) { ?>
            Tanggal <?php echo tgl_eng_to_ind($tgl1); ?>
        <?php
        } else { ?>
            Tanggal <?php echo tgl_eng_to_ind($tgl1); ?> s.d. <?php echo tgl_eng_to_ind($tgl2); ?>
        <?php
        }
        ?>
</center>
	<br>
	<table border='1'>
		<h3>
			<thead>
				<tr>
					<td align="center" valign="top" width="50">No.</td>
					<td align="center" valign="top" width="200">ID TRANSAKSI</td>
					<td align="center" valign="top" width="200">TANGGAL</td>
					<td align="center" valign="top" width="150">ID BARANG</td>
					<td align="center" valign="top" width="200">NAMA BARANG</td>
					<td align="center" valign="top" width="100">JUMLAH MASUK</td>
					<td align="center" valign="top" width="100">SATUAN</td>
				</tr>
			</thead>
		</h3>

		<tbody>
		<?php
        $no = 1;
        // fungsi query untuk menampilkan data dari tabel surat_keputusan
       $query = mysqli_query($mysqli, "SELECT a.id_barang_masuk,a.id_barang,a.id_nota,a.jumlah_masuk,a.harga_barang,b.id_barang,b.nama_barang,b.id_satuan,c.id_nota,c.tanggal_nota, d.id_satuan, d.nama_satuan
        FROM is_barang_masuk as a INNER JOIN is_barang as b INNER JOIN is_nota as c INNER JOIN is_satuan as d
        ON a.id_barang=b.id_barang AND a.id_nota=c.id_nota AND b.id_satuan=d.id_satuan
        WHERE  c.tanggal_nota BETWEEN '$tgl_awal' AND '$tgl_akhir'
        ORDER BY a.id_barang_masuk ASC")
                                    or die('Ada kesalahan pada query tampil Transaksi : '.mysqli_error($mysqli));
   		 $count  = mysqli_num_rows($query);

        // jika data ada, tampilkan data
        if ($count > 0) {
            while ($data = mysqli_fetch_assoc($query)) {
            $tanggal       = $data['tanggal_nota'];
            $exp           = explode('-',$tanggal);
            $tanggal_masuk = tgl_eng_to_ind($exp[2]."-".$exp[1]."-".$exp[0]);
            ?>
				<tr>
				    <td align="center" valign="top"><?php echo $no; ?></td>
				    <td align="center" valign="top"><?php echo $data['id_nota']; ?></td>
				    <td align="center" valign="top"><?php echo $data['tanggal_nota']; ?></td>
				    <td align="center" valign="top"><?php echo $data['id_barang']; ?></td>
				    <td align="center" valign="top"><?php echo $data['nama_barang']; ?></td>
				    <td align="center" valign="top"><?php echo $data['jumlah_masuk']; ?></td>
						<td align="center" valign="top"><?php echo $data['nama_satuan']; ?></td>
				</tr>
			<?php
				$no++;
			}
		} else { ?>
			<tr>
			    <td align="center" valign="top"></td>
			    <td valign="top">Tidak ada data yang ditemukan</td>
			    <td align="center" valign="top"></td>
			    <td align="center" valign="top"></td>
			    <td align="center" valign="top"></td>
			    <td align="center" valign="top"></td>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>

	<div style="text-align: right">
	    <h4>Jakarta Pusat, <?php echo tgl_eng_to_ind("$hari_ini"); ?></h4>
	</div>
<?php
?>
