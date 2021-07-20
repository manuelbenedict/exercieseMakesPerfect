<?php
    //Koneksi database
    $server = "localhost";
    $user = "root";
    $pass= "";
    $database = "dbvaksinasi";

    $koneksi = mysqli_connect($server, $user, $pass, $database) or die (mysqli_error($koneksi));

    //jika butang simpan diklik
    if(isset($_POST['bsimpan']))
    {
        //pengujian apakah data diedit atau disimpan baru
        if($_GET['hal']== "edit")
        {
            //data diedit
            $edit = mysqli_query($koneksi, "UPDATE t_vaksinasi SET
                                                nombor = '$_POST[tMyKad]',
                                                nama = '$_POST[tnama]',
                                                jantina = '$_POST[tjantina]',
                                                alamat = '$_POST[talamat]',
                                                negeri = '$_POST[tnegeri]'
                                            WHERE no = '$_GET[id]'
                                            ") ;
            if($edit) //jika edit sukses
            {
                echo "<script>
                        alert('Edit data berjaya!') ;
                        document.location='index.php';
                    </script>";
            }
            else
            {
                echo "<script>
                        alert('Edit data GAGAL!') ;
                        document.location='index.php';
                    </script>";
            }
        }
        else
        {
            //data disimpan baru
            $simpan = mysqli_query($koneksi, "INSERT INTO t_vaksinasi (nombor, nama, jantina, alamat, negeri)
                                          VALUES( '$_POST[tMyKad]', 
                                                 '$_POST[tnama]', 
                                                 '$_POST[tjantina]', 
                                                 '$_POST[talamat]', 
                                                 '$_POST[tnegeri]')
                                         ") ;
            if($simpan) //jika simpan sukses
            {
                echo "<script>
                        alert('Simpan data berjaya!') ;
                        document.location='index.php';
                    </script>";
            }
            else
            {
                echo "<script>
                        alert('Simpan data GAGAL!') ;
                        document.location='index.php';
                    </script>";
            }
        }
    }

    //Pengujian bila butang edit atau hapus diklik
    if(isset($_GET['hal']))
    {
        //pengujian edit data
        if($_GET['hal']=="edit")
        {
            //tampilkan data yang akan diedit
            $tampil = mysqli_query($koneksi, "SELECT * FROM t_vaksinasi WHERE no = '$_GET[id]' ");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                //data ditemukan dan ditampung di variabel
                $vno = $data['no'];
                $vnombor = $data['nombor'];
                $vnama = $data['nama'];
                $vjantina = $data['jantina'];
                $valamat = $data['alamat'];
                $vnegeri = $data['negeri'];
            }
        }
        else if ($_GET['hal'] == "hapus")
        {
            //hapus data
            $hapus = mysqli_query($koneksi, "DELETE FROM t_vaksinasi WHERE no = '$_GET[id]' ");
            if($hapus)
            {
                echo "<script>
                        alert('Hapus data berjaya!') ;
                        document.location='index.php';
                    </script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Vaksinasi di Hospital Lam Wah Ee, Pulau Pinang</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"
</head>
<body>
<div class="container">


    <h1 class="text-center">Daftar Vaksinasi di Hospital Lam Wah Ee</h1>
    <h2 class="text-center">Georgetown, Pulau Pinang</h2>

    <!-- Awal card form -->
    <div class="card mt-3">
        <div class="card-header bg-primary text-white">
            Borang Masukan Data Diri
        </div>
        <div class="card-body">
            <form method="post" action="">
                <div class="form-group">
                    <label>Nombor MyKad</label>
                    <input type="text" name="tMyKad" value ="<?=@$vnombor?>" class="form-control" placeholder="Masukan nombor MyKad anda!" required>
                </div>
                <div class="form-group mt-2">
                    <label>Nama</label>
                    <input type="text" name="tnama" value ="<?=@$vnama?>" class="form-control" placeholder="Masukan nama anda!" required>
                </div>
                <div class="form-group mt-2">
                    <label>Jantina</label>
                    <select class="form-control" name="tjantina">
                        <option value ="<?=@$vjantina?>"><?=@$vjantina?></option>
                        <option value="Lelaki">Lelaki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label>Alamat</label>
                    <textarea class="form-control" name="talamat" placeholder="Masukan alamat anda!" required><?=@$valamat?></textarea>
                </div>
                <div class="form-group mt-2">
                    <label>Negeri</label>
                    <select class="form-control" name="tnegeri">
                        <option value ="<?=@$vnegeri?>"><?=@$vnegeri?></option>
                        <option value="W.P. Kuala Lumpur">W.P. Kuala Lumpur</option>
                        <option value="W.P. Putrajaya">W.P. Putrajaya</option>
                        <option value="W.P. Labuan">W.P. Labuan</option>
                        <option value="Johor">Johor</option>
                        <option value="Kedah">Kedah</option>
                        <option value="Kelantan">Kelantan</option>
                        <option value="Negeri Sembilan">Negeri Sembilan</option>
                        <option value="Pahang">Pahang</option>
                        <option value="Perak">Perak</option>
                        <option value="Perlis">Perlis</option>
                        <option value="Selangor">Selangor</option>
                        <option value="Terengganu">Terengganu</option>
                        <option value="Melaka">Melaka</option>
                        <option value="Pulau Pinang">Pulau Pinang</option>
                        <option value="Sabah">Sabah</option>
                        <option value="Sarawak">Sarawak</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success mt-2" name="bsimpan">Simpan</button>
                <button type="reset" class="btn btn-danger mt-2" name="breset">Kosongkan</button>

            </form>
        </div>
    </div>
    <!-- Akhir card form -->

    <!-- Awal card tabel -->
    <div class="card mt-3">
        <div class="card-header bg-success text-white">
            Senarai Peserta Vaksinasi
        </div>
        <div class="card-body">
            
            <table class="table table-bordered table-striped">
                <tr>
                    <th>No.</th>
                    <th>Nombor MyKad</th>
                    <th>Nama</th>
                    <th>Jantina</th>
                    <th>Alamat</th>
                    <th>Negeri</th>
                    <th>Tindakan</th>
                </tr>
                <?php
                    $no = 1 ;
                    $tampil = mysqli_query($koneksi, "SELECT * FROM t_vaksinasi order by no desc");
                    while($data = mysqli_fetch_array($tampil)) :

                ?>
                <tr>
                    <td><?=$no++; ?></td>
                    <td><?=$data['nombor']?></td>
                    <td><?=$data['nama']?></td>
                    <td><?=$data['jantina']?></td>
                    <td><?=$data['alamat']?></td>
                    <td><?=$data['negeri']?></td>
                    <td>
                        <a href="index.php?hal=edit&id=<?=$data['no']?>" class="btn btn-warning">Edit</a>
                        <a href="index.php?hal=hapus&id=<?=$data['no']?>" onclick="return confirm
                           ('Adakah anda pasti akan menghapus data ini?')" class="btn btn-danger">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; //penutup perulangan ?>
            </table>

        </div>
    </div>
    <!-- Akhir card tabel -->

</div>

<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>