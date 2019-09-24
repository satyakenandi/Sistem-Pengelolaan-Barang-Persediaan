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
<section class="content">
  <div class="box box-solid box-primary" >
    <div class="box-header">
      <i class="fa fa-bar-chart"></i>Grafik
    </div>
    <div class="box-body">
      <!-- Select button grafik -->
      <div class="row">
        <form role="form" class="" action="?module=grafik" method="POST">
          <div class="col-sm-2">
            <select class="form-control" name="tahun" required>
              <!-- <option value="">-- Pilih Tahun --</option> -->
              <option value="<?php echo $tahun; ?>"><?php echo $tahun; ?></option>
              <!-- ambil tahun dari database -->
              <?php
              // sql statement untuk menampilkan data dari tabel is_nota
              $query = mysqli_query($mysqli, "SELECT distinct(EXTRACT(YEAR FROM tanggal_nota)) as tahun
                                              FROM is_nota ORDER BY tahun DESC")
                                              or die('Ada kesalahan pada query tampil Data Barang Masuk: '.mysqli_error($mysqli));
              while ($data = mysqli_fetch_assoc($query)) {
                echo"<option value='".$data['tahun']."'>".$data['tahun']."</option>";
              }
              ?>
            </select>
          </div>
          <div class="col-sm-4">
            <button style="width:100px" type="submit" class="btn btn-success">
              Tampilkan
            </button>
          </div>
        </form>
      </div>
      <div class="row">
        <?php if (isset($_POST['tahun'])) { ?>
          <div class="col-md-12">
            <div class="box">
              <br>
              <div id="grafik" style="height:450px;max-width:95%;">

              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</section>
