<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-sign-out icon-title"></i> Data Barang Keluar
<!--
    <a class="btn btn-primary btn-social pull-right" href="?module=form_barang_keluar&form=add" title="Tambah Data" data-toggle="tooltip">
      <i class="fa fa-plus"></i> Tambah
    </a> -->
  </h1>

</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">

    <?php
    // fungsi untuk menampilkan pesan
    // jika alert = "" (kosong)
    // tampilkan pesan "" (kosong)
    if (empty($_GET['alert'])) {
      echo "";
    }
    // jika alert = 1
    // tampilkan pesan Sukses "Data Barang Keluar berhasil disimpan"
    elseif ($_GET['alert'] == 1) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data Barang Keluar berhasil disimpan.
            </div>";
    }
    ?>

      <div class="box box-primary">
        <div class="box-body">
          <!-- tampilan tabel barang -->
          <table id="dataTables1" class="table table-bordered table-striped table-hover">
            <!-- tampilan tabel header -->
            <thead>
              <tr>
                <th class="center">No.</th>
                <th class="center">ID Transaksi</th>
                <th class="center">Tanggal</th>
                <th class="center">ID Barang</th>
                <th class="center">Nama Barang</th>
                <th class="center">Jumlah Keluar</th>
                <th class="center">Sub Bagian</th>
              </tr>
            </thead>
            <!-- tampilan tabel body -->
            <tbody>
            <?php
            $no = 1;
            // fungsi query untuk menampilkan data dari tabel barang
            $query = mysqli_query($mysqli, "SELECT a.id_barang_keluar,a.tanggal_keluar,a.id_barang,a.jumlah_keluar,b.id_barang,b.nama_barang,b.id_satuan,c.id_satuan,c.nama_satuan,d.nama_user
                                            FROM is_barang_keluar as a INNER JOIN is_barang as b INNER JOIN is_satuan as c INNER JOIN is_users as d
                                            ON a.id_barang=b.id_barang AND b.id_satuan=c.id_satuan AND a.created_user=d.id_user ORDER BY id_barang_keluar DESC")
                                            or die('Ada kesalahan pada query tampil Data Barang Keluar: '.mysqli_error($mysqli));

            // tampilkan data
            while ($data = mysqli_fetch_assoc($query)) {
              $tanggal         = $data['tanggal_keluar'];
              $exp             = explode('-',$tanggal);
              $tanggal_keluar   = $exp[2]."-".$exp[1]."-".$exp[0];

              // menampilkan isi tabel dari database ke tabel di aplikasi
              echo "<tr>
                      <td width='30' class='center'>$no</td>
                      <td width='100' class='center'>$data[id_barang_keluar]</td>
                      <td width='90' class='center'>$tanggal_keluar</td>
                      <td width='80' class='center'>$data[id_barang]</td>
                      <td width='200'>$data[nama_barang]</td>
                      <td width='120'>$data[jumlah_keluar] $data[nama_satuan]</td>
                      <td width='120'>$data[nama_user]</td>
                      <div>
                      ";
          ?>
                       <!-- <a data-toggle="tooltip" data-placement="top" title="Hapus" class="btn btn-danger btn-sm" href="modules/barang-keluar/proses.php?act=delete&id=<?php echo $data['id_barang_keluar'];?>" onclick="return confirm('Anda yakin ingin menghapus barang masuk <?php echo $data['nama_barang']; ?> ?');">
                            <i style="color:#fff" class="glyphicon glyphicon-trash"></i>
                        </a> -->
          <?php
            echo "    </div>
                    </td>
                  </tr>";
            $no++;
          }
          ?>
          </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!--/.col -->
  </div>   <!-- /.row -->
</section><!-- /.content
