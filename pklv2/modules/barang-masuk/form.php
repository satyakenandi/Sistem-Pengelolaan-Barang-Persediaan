<script src="assets/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<script type="text/javascript">
  function tampil_barang(input){
    var num = input.value;

    $.post("modules/barang-masuk/barang.php", {
      dataidbarang: num,
    }, function(response) {
      $('#stok').html(response)

      document.getElementById('jumlah_masuk').focus();
    });
  }

  function cek_jumlah_masuk(input) {
    jml = document.formBarangMasuk.jumlah_masuk.value;
    var jumlah = eval(jml);
    if(jumlah < 1){
      alert('Jumlah Masuk Tidak Boleh Nol !!');
      input.value = input.value.substring(0,input.value.length-1);
    }
  }

  function hitung_total_stok() {
    bil1 = document.formBarangMasuk.stok.value;
    bil2 = document.formBarangMasuk.jumlah_masuk.value;

    if (bil2 == "") {
      var hasil = "";
    }
    else {
      var hasil = eval(bil1) + eval(bil2);
    }

    document.formBarangMasuk.total_stok.value = (hasil);
  }
</script>

<?php
// fungsi untuk pengecekan tampilan form
// jika form add data yang dipilih
if ($_GET['form']=='add') {
  if (isset($_GET['id'])) {
    // fungsi query untuk menampilkan data dari tabel barang
    $query = mysqli_query($mysqli, "SELECT a.id_barang,a.nama_barang,a.id_satuan,a.stok,b.id_satuan,b.nama_satuan
                                    FROM is_barang as a INNER JOIN is_satuan as b
                                    ON a.id_satuan=b.id_satuan WHERE a.id_barang='$_GET[id]'")
                                    or die('Ada kesalahan pada query tampil Data Barang : '.mysqli_error($mysqli));
    $data  = mysqli_fetch_assoc($query);

    $id_barang   = $data['id_barang'];
    $nama_barang = $data['id_barang']." | ".$data['nama_barang'];
    $stok        = $data['stok'];
    $nama_satuan = $data['nama_satuan'];

  } else {
    $id_barang   = "";
    $nama_barang = "";
    $stok        = "";
    $nama_satuan = "";
  }
?>
  <!-- tampilan form add data -->
	<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Input Data Barang Masuk
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=home"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=barang_masuk"> Barang Masuk </a></li>
      <li class="active"> Tambah </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" action="modules/barang-masuk/proses.php?act=insert" method="POST" name="formBarangMasuk" enctype="multipart/form-data">
            <div class="box-body">
              <?php
              // fungsi untuk membuat id transaksi
              $query_id = mysqli_query($mysqli, "SELECT RIGHT(id_nota,7) as kode FROM is_nota
                                                ORDER BY id_nota DESC LIMIT 1")
                                                or die('Ada kesalahan pada query tampil id_nota : '.mysqli_error($mysqli));

              $count = mysqli_num_rows($query_id);

              if ($count <> 0) {
                  // mengambil data id_barang_masuk
                  $data_id = mysqli_fetch_assoc($query_id);
                  $kode    = $data_id['kode']+1;
              } else {
                  $kode = 1;
              }

              // buat id_barang_masuk
              $tahun           = date("Y");
              $buat_id         = str_pad($kode, 7, "0", STR_PAD_LEFT);
              $id_nota = "TM-$tahun-$buat_id";
              ?>

              <div class="form-group">
                <label class="col-sm-2 control-label">ID Transaksi</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="id_nota" value="<?php echo $id_nota; ?>" readonly required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Tanggal</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="tanggal_nota" autocomplete="off" value="<?php echo date("d-m-Y"); ?>" required>
                </div>
              </div>

              <hr>
              <div id="container-barang">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Barang</label>
                  <div class="col-sm-5">
                    <select class="chosen-select" id='select-element' name="id_barang[]" data-placeholder="-- Pilih Barang --" onchange="tampil_barang(this)" autocomplete="off" required>
                      <option value="<?php echo $id_barang; ?>"><?php echo $nama_barang; ?></option>
                      <?php
                      $query_barang = mysqli_query($mysqli, "SELECT id_barang, nama_barang FROM is_barang ORDER BY id_barang ASC")
                      or die('Ada kesalahan pada query tampil barang: '.mysqli_error($mysqli));
                      while ($data_barang = mysqli_fetch_assoc($query_barang)) {
                        echo"<option value=\"$data_barang[id_barang]\"> $data_barang[id_barang] | $data_barang[nama_barang] </option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" name="harga_barang[]"  autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" placeholder="Harga Satuan">
                  </div>
                  <div class="col-sm-1">
                    <input type="text" class="form-control" name="jumlah_masuk[]" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" onkeyup="hitung_total_stok(this)&cek_jumlah_masuk(this)" placeholder="Jumlah">
                  </div>
                  <div class="col-sm-2">
                    <button type="button" class="btn btn-info" name="button" id="btn-tambah-row">Tambah</button>
                  </div>
                </div>
              </div>

              <!-- <span id='stok'>
              <div class="form-group">
                <label class="col-sm-2 control-label">Stok</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" id="stok" name="stok" value="<?php echo $stok; ?>" readonly required>
                </div>
              </div>
              </span> -->

              <!-- <div class="form-group">
                <label class="col-sm-2 control-label">Jumlah Masuk</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" id="jumlah_masuk" name="jumlah_masuk" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" onkeyup="hitung_total_stok(this)&cek_jumlah_masuk(this)" required>
                </div>
              </div> -->

              <!-- <div class="form-group">
                <label class="col-sm-2 control-label">Total Stok</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" id="total_stok" name="total_stok" readonly required>
                </div>
              </div> -->

              <div class="form-group">
                <label class="col-sm-2 control-label">Harga Beli</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <span class="input-group-addon">Rp.</span>
                    <input type="text" class="form-control" id="harga_total" name="harga_total" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" required>
                  </div>
                </div>
              </div>

                <div class="form-group">
                   <label class="col-sm-2 control-label">Nota Pembelian</label>
                     <div class="col-sm-5">
                      <input type="file" id="foto" name="foto" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Pastikan ukuran file maksimal 1 Mb" autocomplete="off" required>
                     <span class="file-custom"></span>
                    </label>
                  </div>
            </div><!-- /.box body -->

            <div class="form-group">
              <label class="col-sm-2 control-label">Nama Pegawai</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai" autocomplete="off" required>
              </div>
            </div>

            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="Simpan">
                  <a href="?module=barang_masuk" class="btn btn-default btn-reset">Batal</a>
                </div>
              </div>
            </div><!-- /.box footer -->
          </form>
        </div><!-- /.box -->
      </div><!--/.col -->
    </div>   <!-- /.row -->
  </section><!-- /.content -->
<script type="text/javascript">
  $(document).ready(function(){
// $('[name="harga_satuan[]"]').change(function(){
//   harga_total();
// })

// $('[name="jumlah_masuk"]').change(function(){
//   harga_total();
// })


    var element_select = $('#select-element').html();
    $('#btn-tambah-row').click(function(){
      var element = '<div class="form-group input-barang"><label class="col-sm-2 control-label"></label><div class="col-sm-5">  <select class="chosen-select" name="id_barang[]" data-placeholder="-- Pilih Barang --" onchange="tampil_barang(this)" autocomplete="off" required>'+element_select+'</select></div><div class="col-sm-2"><input type="text" class="form-control" name="harga_barang[]" id="harga_barang" placeholder="Harga Satuan"></div><div class="col-sm-1"><input type="text" class="form-control" name="jumlah_masuk[]" autocomplete="off" onKeyPress="return goodchars(event,\'0123456789\',this)" onkeyup="hitung_total_stok(this)&cek_jumlah_masuk(this)" placeholder="Jumlah" required></div><div class="col-sm-2"><button type="button" onclick="hapus(this)" class="btn btn-danger" name="btn-hapus-row" id="btn-tambah-row">Hapus</button></div></div>';
      $('#container-barang').append(element);
    })
  })

  function hapus(e){
    e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
  }

  // function harga_total(){
  //   var satuan = $('[name="harga_satuan[]"]');
  //   var jumlah = $('[name="jumlah_masuk"]');
  //   console.log(satuan[0].val())
  // }
</script>
<?php
}
?>
