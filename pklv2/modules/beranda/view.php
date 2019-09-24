<?php
if (isset($_POST['tahun'])) {
  $tahun = $_POST['tahun'];
} else {
  $tahun = "";
}

if (isset($_POST['tahun'])) {
  // query Grafik
  $query = mysqli_query($mysqli, "SELECT EXTRACT(YEAR FROM tanggal_nota) as tahun,
                                EXTRACT(MONTH FROM tanggal_nota) as bulan,
                                SUM(harga_total) as harga_total
                                FROM is_nota
                                WHERE EXTRACT(YEAR FROM tanggal_nota) = '$tahun'
                                GROUP BY EXTRACT(MONTH FROM tanggal_nota)")
                                or die('Ada kesalahan pada query: '.mysqli_error($mysqli));

  // Ambil BULAN & HARGA TOTAL yang ada di database
  $i = 0;
  $dummy = "";
  $array_data_db = array();
  while ($data = mysqli_fetch_assoc($query)) {
    $dummy = implode("_", $data);
    $array_data_db[$i] = $dummy;
    $i++;
  }
  // Masukkan data db ke dalam array data grafik
  $j = 0;
  $nmax = sizeof($array_data_db);
  // Biar aman klo data nya kosong
  if ($nmax != 0) {
    $nmax = $nmax - 1;
  } else {
    $nmax = 0;
  }
  $data_grafik = array();
  for ($i=0; $i<12; $i++) {
    $data_db = explode("_", $array_data_db[$j]);
    // 0 = tahun, 1 = bulan, 2 = harga_total
    $data_bulan_db = $data_db[1];
    if ($data_bulan_db == ($i+1)) {
      $data_harga_total_db = $data_db[2];
      $data_grafik[$i] = $data_harga_total_db;
      if ($j != $nmax) {
        $j++;
      }
    } else {
      $data_grafik[$i] = 0;
    }
  }
}

?>
  <!-- Content Header (Page header) -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="assets/plugins/highcharts/jquery.min.js"></script>
<script src="assets/plugins/highcharts/highcharts.js"></script>

<!-- grafik -->
<script type="text/javascript">
var chart1; // globally available
$(document).ready(function() {
    chart1 = new Highcharts.Chart({
        chart: {
            renderTo: 'grafik',
            type: 'line'
        },
        title: {
            text: 'Grafik Harga Total Tahun <?php echo $tahun; ?>'
        },
        xAxis: {
            categories: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']
        },
        yAxis: {
            title: {
               text: 'Jumlah'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            //fungsi tooltip, ini opsional, kegunaan dari fungsi ini
            //akan menampikan data di titik tertentu di grafik saat mouseover
            formatter: function() {
                    return '<b>Bulan: '+ this.x +'</b><br/>'+'Jumlah : Rp. '+ this.y;
            }
        },
            series:
            [{
                name: 'Pembelian',
                data: [<?php for ($i=0; $i<12; $i++) {
                  echo $data_grafik[$i];
                  echo ","; //biar ke data selanjutnya
                } ?>]
            }]
      });
   });
</script>

<!-- grafik -->

  <section class="content-header">
    <h1>
      <i class="fa fa-home icon-title"></i> Beranda
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=home"><i class="fa fa-home"></i> Beranda</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-lg-12 col-xs-12">
        <div class="alert alert-info alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <p style="font-size:15px">
            <i class="icon fa fa-user"></i> Selamat datang <strong><?php echo $_SESSION['nama_user']; ?></strong> di Sistem Pengelolaan Barang Persediaan Ditjen PSDKP.
          </p>
        </div>
      </div>
    </div>

    <!-- Small boxes (Stat box) -->
    <div class="row">
    <?php
    if ($_SESSION['hak_akses']=='Admin') { ?>
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div style="background-color:#00c0ef;color:#fff" class="small-box">
          <div class="inner">
            <?php
            // fungsi query untuk menampilkan data dari tabel barang
            $query = mysqli_query($mysqli, "SELECT COUNT(id_barang) as jumlah FROM is_barang")
                                            or die('Ada kesalahan pada query tampil Data Barang: '.mysqli_error($mysqli));

            // tampilkan data
            $data = mysqli_fetch_assoc($query);
            ?>
            <h3><?php echo $data['jumlah']; ?></h3>
            <p>Data Barang</p>
          </div>
          <div class="icon">
            <i class="fa fa-folder"></i>
          </div>
          <a href="?module=form_barang&form=add" class="small-box-footer" title="Tambah Data" data-toggle="tooltip"><i class="fa fa-plus"></i></a>
        </div>
      </div><!-- ./col -->

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div style="background-color:#00a65a;color:#fff" class="small-box">
          <div class="inner">
            <?php
            // fungsi query untuk menampilkan data dari tabel barang masuk
            $query = mysqli_query($mysqli, "SELECT COUNT(id_barang_masuk) as jumlah FROM is_barang_masuk")
                                            or die('Ada kesalahan pada query tampil Data Barang Masuk: '.mysqli_error($mysqli));

            // tampilkan data
            $data = mysqli_fetch_assoc($query);
            ?>
            <h3><?php echo $data['jumlah']; ?></h3>
            <p>Barang Masuk</p>
          </div>
          <div class="icon">
            <i class="fa fa-sign-in"></i>
          </div>
          <a href="?module=form_barang_masuk&form=add" class="small-box-footer" title="Tambah Data" data-toggle="tooltip"><i class="fa fa-plus"></i></a>
        </div>
      </div><!-- ./col -->

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div style="background-color:#f39c12;color:#fff" class="small-box">
          <div class="inner">
            <?php
            // fungsi query untuk menampilkan data dari tabel barang Keluar
            $query = mysqli_query($mysqli, "SELECT COUNT(id_barang_keluar) as jumlah FROM is_barang_keluar")
                                            or die('Ada kesalahan pada query tampil Data Barang Keluar: '.mysqli_error($mysqli));

            // tampilkan data
            $data = mysqli_fetch_assoc($query);
            ?>
            <h3><?php echo $data['jumlah']; ?></h3>
            <p>Barang Keluar</p>
          </div>
          <div class="icon">
            <i class="fa fa-sign-out"></i>
          </div>
          <a href="?module=form_barang_keluar&form=add" class="small-box-footer" title="Tambah Data" data-toggle="tooltip"><i class="fa fa-plus"></i></a>
        </div>
      </div><!-- ./col -->

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div style="background-color:#dd4b39;color:#fff" class="small-box">
          <div class="inner">
            <?php
            // fungsi query untuk menampilkan data dari tabel user
            $query = mysqli_query($mysqli, "SELECT COUNT(id_user) as jumlah FROM is_users")
                                            or die('Ada kesalahan pada query tampil Data User: '.mysqli_error($mysqli));

            // tampilkan data
            $data = mysqli_fetch_assoc($query);
            ?>
            <h3><?php echo $data['jumlah']; ?></h3>
            <p>User</p>
          </div>
          <div class="icon">
            <i class="fa fa-user"></i>
          </div>
          <a href="?module=form_user&form=add" class="small-box-footer" title="Tambah Data" data-toggle="tooltip"><i class="fa fa-plus"></i></a>
        </div>
      </div><!-- ./col -->

      </div><!-- /.row -->
      <div class="box box-solid box-primary" >
        <div class="box-header">
          <i class="fa fa-info"></i>Informasi
        </div>
        <div class="box-body">
          <h4>Hak Akses sebagai Admin</h4>
          <li>Mengelola Data Pegawai (User) </li>
          <li>Mengelola Data Barang Masuk & Barang Keluar</li>
          <li>Mencetak dan Mendownload Laporan Barang Masuk & Barang Keluar</li>
        </div>
      </div>

      <div>
    <?php
  } elseif ($_SESSION['hak_akses']=='SubAdmin') { ?>
      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div style="background-color:#00c0ef;color:#fff" class="small-box">
          <div class="inner">
            <?php
            // fungsi query untuk menampilkan data dari tabel barang
            $query = mysqli_query($mysqli, "SELECT COUNT(id_barang) as jumlah FROM is_barang")
                                            or die('Ada kesalahan pada query tampil Data Barang: '.mysqli_error($mysqli));

            // tampilkan data
            $data = mysqli_fetch_assoc($query);
            ?>
            <h3><?php echo $data['jumlah']; ?></h3>
            <p>Data Barang</p>
          </div>
          <div class="icon">
            <i class="fa fa-folder"></i>
          </div>
          <a href="?module=form_barang&form=add" class="small-box-footer" title="Tambah Data" data-toggle="tooltip"><i class="fa fa-plus"></i></a>
        </div>
      </div><!-- ./col -->

      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div style="background-color:#00a65a;color:#fff" class="small-box">
          <div class="inner">
            <?php
            // fungsi query untuk menampilkan data dari tabel barang masuk
            $query = mysqli_query($mysqli, "SELECT COUNT(id_barang_masuk) as jumlah FROM is_barang_masuk")
                                            or die('Ada kesalahan pada query tampil Data Barang Masuk: '.mysqli_error($mysqli));

            // tampilkan data
            $data = mysqli_fetch_assoc($query);
            ?>
            <h3><?php echo $data['jumlah']; ?></h3>
            <p>Barang Masuk</p>
          </div>
          <div class="icon">
            <i class="fa fa-sign-in"></i>
          </div>
          <a href="?module=form_barang_masuk&form=add" class="small-box-footer" title="Tambah Data" data-toggle="tooltip"><i class="fa fa-plus"></i></a>
        </div>
      </div><!-- ./col -->

      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div style="background-color:#f39c12;color:#fff" class="small-box">
          <div class="inner">
            <?php
            // fungsi query untuk menampilkan data dari tabel barang Keluar
            $query = mysqli_query($mysqli, "SELECT COUNT(id_barang_keluar) as jumlah FROM is_barang_keluar")
                                            or die('Ada kesalahan pada query tampil Data Barang Keluar: '.mysqli_error($mysqli));

            // tampilkan data
            $data = mysqli_fetch_assoc($query);
            ?>
            <h3><?php echo $data['jumlah']; ?></h3>
            <p>Barang Keluar</p>
          </div>
          <div class="icon">
            <i class="fa fa-sign-out"></i>
          </div>
          <a href="?module=form_barang_keluar&form=add" class="small-box-footer" title="Tambah Data" data-toggle="tooltip"><i class="fa fa-plus"></i></a>
        </div>
      </div><!-- ./col -->

    </div><!-- /.row -->
      <div class="box box-solid box-primary" >
      <div class="box-header">
      <i class="fa fa-info"></i>Informasi
    </div>
    <div class="box-body">
      <h4>Hak Akses sebagai Sub Admin</h4>
      <li>Mengelola Data Barang Masuk & Barang Keluar</li>
      <li>Mencetak dan Mendownload Laporan Barang Masuk & Barang Keluar</li>
    </div>

    <?php
  } elseif ($_SESSION['hak_akses']=='Kasubbag') { ?>
      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div style="background-color:#00c0ef;color:#fff" class="small-box">
          <div class="inner">
            <?php
            // fungsi query untuk menampilkan data dari tabel barang
            $query = mysqli_query($mysqli, "SELECT COUNT(id_barang) as jumlah FROM is_barang")
                                            or die('Ada kesalahan pada query tampil Data Barang: '.mysqli_error($mysqli));

            // tampilkan data
            $data = mysqli_fetch_assoc($query);
            ?>
            <h3><?php echo $data['jumlah']; ?></h3>
            <p>Data Barang</p>
          </div>
          <div class="icon">
            <i class="fa fa-folder"></i>
          </div>
        </div>
      </div><!-- ./col -->

      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div style="background-color:#00a65a;color:#fff" class="small-box">
          <div class="inner">
            <?php
            // fungsi query untuk menampilkan data dari tabel barang masuk
            $query = mysqli_query($mysqli, "SELECT COUNT(id_barang_masuk) as jumlah FROM is_barang_masuk")
                                            or die('Ada kesalahan pada query tampil Data Barang Masuk: '.mysqli_error($mysqli));

            // tampilkan data
            $data = mysqli_fetch_assoc($query);
            ?>
            <h3><?php echo $data['jumlah']; ?></h3>
            <p>Barang Masuk</p>
          </div>
          <div class="icon">
            <i class="fa fa-sign-in"></i>
          </div>
        </div>
      </div><!-- ./col -->

      <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div style="background-color:#f39c12;color:#fff" class="small-box">
          <div class="inner">
            <?php
            // fungsi query untuk menampilkan data dari tabel barang Keluar
            $query = mysqli_query($mysqli, "SELECT COUNT(id_barang_keluar) as jumlah FROM is_barang_keluar")
                                            or die('Ada kesalahan pada query tampil Data Barang Keluar: '.mysqli_error($mysqli));

            // tampilkan data
            $data = mysqli_fetch_assoc($query);
            ?>
            <h3><?php echo $data['jumlah']; ?></h3>
            <p>Barang Keluar</p>
          </div>
          <div class="icon">
            <i class="fa fa-sign-out"></i>
          </div>
        </div>
      </div><!-- ./col -->

    </div><!-- /.row -->
      <div class="box box-solid box-primary" >
      <div class="box-header">
      <i class="fa fa-info"></i>Informasi
    </div>
    <div class="box-body">
      <h4>Hak Akses sebagai Kasubbag</h4>
      <li>Melihat dashboard data barang</li>
      <li>Melihat Informasi detail data barang masuk & keluar</li>
    </div>
    <?php
    }
    ?>

  </div>
    <br>

    <div class="row">
      <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-info-circle icon-title"></i> Stok Barang telah mencapai batas minimum</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
              </button>
              <button class="btn btn-box-tool" data-widget="remove">
                <i class="fa fa-times"></i>
              </button>
            </div>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <!-- tampilan tabel barang -->
              <table class="table no-margin">
                <!-- tampilan tabel header -->
                <thead>
                  <tr>
                    <th class="center">No.</th>
                    <th class="center">ID Barang</th>
                    <th>Nama Barang</th>
                    <th>Jenis Barang</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                  </tr>
                </thead>
                <!-- tampilan tabel body -->
                <tbody>
                <?php
                $no = 1;
                // fungsi query untuk menampilkan data dari tabel barang
                $query = mysqli_query($mysqli, "SELECT a.id_barang,a.nama_barang,a.id_jenis,a.id_satuan,a.stok,b.id_jenis,b.nama_jenis,c.id_satuan,c.nama_satuan
                                                FROM is_barang as a INNER JOIN is_jenis_barang as b INNER JOIN is_satuan as c
                                                ON a.id_jenis=b.id_jenis AND a.id_satuan=c.id_satuan
                                                WHERE a.stok<='10' ORDER BY id_barang DESC")
                                                or die('Ada kesalahan pada query tampil Data Barang: '.mysqli_error($mysqli));

                // tampilkan data
                while ($data = mysqli_fetch_assoc($query)) {
                  // menampilkan isi tabel dari database ke tabel di aplikasi
                  echo "<tr>
                          <td width='20' class='center'>$no</td>
                          <td width='80' class='center'>$data[id_barang]</td>
                          <td width='150'>$data[nama_barang]</td>
                          <td width='100'>$data[nama_jenis]</td>
                          <td width='80'>$data[stok]</td>
                          <td width='100'>$data[nama_satuan]</td>
                        </tr>";
                  $no++;
                }
                ?>
                </tbody>
              </table>
            </div>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div>
    </div>
  </section><!-- /.content -->
