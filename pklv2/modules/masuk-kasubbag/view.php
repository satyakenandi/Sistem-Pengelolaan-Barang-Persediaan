<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-sign-in icon-title"></i> Data Barang Masuk

    <!-- <a class="btn btn-primary btn-social pull-right" href="?module=form_barang_masuk&form=add" title="Tambah Data" data-toggle="tooltip">
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
    // tampilkan pesan Sukses "Data Barang Masuk berhasil disimpan"
    elseif ($_GET['alert'] == 1) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data Barang Masuk berhasil disimpan.
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
                <th class="center">No Kwitansi</th>
                <th class="center">Tanggal</th>
                <th class="center">Harga Total</th>
                <th class="center">Foto</th>
                <th class="center">Sub Bagian</th>
                <th class="center">Nama Pegawai</th>
                <th></th>
              </tr>
            </thead>
            <!-- tampilan tabel body -->
            <tbody>
            <?php
            $no = 1;
            // fungsi query untuk menampilkan data dari tabel barang
            $query = mysqli_query($mysqli, "SELECT a.id_nota,a.tanggal_nota,a.harga_total,a.foto,a.nama_pegawai,b.id_user,b.nama_user
                                            FROM is_nota as a INNER JOIN is_users as b
                                            ON a.created_user=b.id_user ORDER BY id_nota DESC")
                                            or die('Ada kesalahan pada query tampil Data Barang Masuk: '.mysqli_error($mysqli));

            // tampilkan data
            while ($data = mysqli_fetch_assoc($query)) {
              $tanggal         = $data['tanggal_nota'];
              $exp             = explode('-',$tanggal);
              $tanggal_masuk   = $exp[2]."-".$exp[1]."-".$exp[0];
              $id_nota         = $data['id_nota'];
              $id              = explode('-', $id_nota);
              $id              = $id[2];

              // menampilkan isi tabel dari database ke tabel di aplikasi
              echo "<tr>
                      <td width='30' class='center'>$no</td>
                      <td width='90' class='center'>$data[id_nota]</td>
                      <td width='90' class='center'>$data[tanggal_nota]</td>
                      <td width='80' class='center'>Rp. $data[harga_total]</td>
                      <td width='80' class='center'> <a href=images/barang_masuk/$data[foto] target=_blank> Buka </a></td>
                      <td width='120'class='center'>$data[nama_user]</td>
                      <td width='120'class='center'>$data[nama_pegawai]</td>
                      <td class='center' width='40'>
                        <div>
                        "; ?>

                          <!-- <a data-toggle="tooltip" data-placement="top" title="Hapus" class="btn btn-danger btn-sm" href="modules/barang-masuk/proses.php?act=delete&id=<?php echo $data['id_nota'];?>" onclick="return confirm('Anda yakin ingin menghapus barang masuk <?php echo $data['id_nota']; ?> ?');">
                              <i style="color:#fff" class="glyphicon glyphicon-trash"></i>
                          </a> -->

                          <button type="button" onclick="getmodaldata('<?=$data['id_nota'];?>')"  class="btn btn-primary" data-toggle="modal">
                            Detail
                          </button>

                          <?php
              echo "    </div></td></tr>";
              $no++;  ?>
                          <?php }; ?>
            </tbody>
          </table>
           <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                           <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">NOTA BARANG</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                 <div class="box box-primary">
                                  <div class="box-body">
                                    <!-- tampilan tabel barang -->
                                    <table id="dataTables1" class="table table-bordered table-striped table-hover">
                                      <!-- tampilan tabel header -->
                                      <thead>
                                        <tr>
                                          <th class="center">No Kwitansi</th>
                                          <th class="center">Id Barang</th>
                                          <th class="center">Nama Barang</th>
                                          <th class="center">Harga</th>
                                          <th class="center">Jumlah</th>
                                        </tr>
                                      </thead>
                                      <tbody id="isi">

                                      </tbody>
                                    </table>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!--/.col -->
  </div>   <!-- /.row -->
  <script type="text/javascript">
    function getmodaldata(value){
      // alert(value)
      $.ajax ({
      method:'GET',
      url:'http://localhost/pklv2/modules/masuk-kasubbag/modal.php',
      dataType:'JSON',
      data:{id_nota:value},
      success:function(data){
        // console.log(data)
        element = $('#isi')
        element.html('')
        $.each(data,function(index,value){
        var isi_element='<tr><td>'+value.id_nota+'</td><td>'+value.id_barang_masuk+'</td><td>'+value.nama_barang+'</td><td>'+value.harga_barang+'</td><td>'+value.jumlah_masuk+'</td></tr>'
        element.append(isi_element)
        })
        $('#modal-detail').modal('show');
      },error:function(error){
        // console.log(error)
      },
      // request.fail(function(jqXHR, textStatus) {
      //   alert( "Request failed: " + textStatus );
      // });
    })
    }


  </script>
</section>
