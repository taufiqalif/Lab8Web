<?php 
error_reporting(E_ALL);
include_once 'koneksi/koneksi.php';

// mengambil id di URL
$id = $_GET['id_barang'];

// query data barang
$barang = query("SELECT * FROM data_barang WHERE id_barang = $id")[0];




if (isset($_POST['submit'])) {
  $id = $_POST['id_barang'];
  $nama = htmlspecialchars($_POST['nama']);
  $kategori = htmlspecialchars($_POST['kategori']);
  $harga_jual = htmlspecialchars($_POST['harga_jual']);
  $harga_beli = htmlspecialchars($_POST['harga_beli']);
  $stok = htmlspecialchars($_POST['stok']);
  $file_gambar = $_POST['file_gambar'];
  $gambar = null;
  if ($file_gambar['error'] == 0) {
    $filename = str_replace(' ', '_',$file_gambar['name']);
    $destination = dirname(__FILE__) .'/gambar/' . $filename;
      if(move_uploaded_file($file_gambar['tmp_name'], $destination)){
        $gambar =  $filename;
      }
  }
  $query = "UPDATE data_barang SET 
          kategori = '$kategori', 
          nama = '$nama', 
          gambar = '$gambar', 
          harga_beli = '$harga_beli', 
          harga_jual = '$harga_jual', 
          stok = '$stok' 
          WHERE id_barang = $id";
  mysqli_query($conn, $query);

  if (mysqli_affected_rows($conn) > 0) {
    echo "
      <script>
        alert('Data berhasil diubah');
        document.location.href = 'index.php';
      </script>
    ";
  }else{
    echo "
      <script>
        alert('Data gagal diubah');
        document.location.href = 'index.php';
      </script>
    ";
  }

  // header('location: index.php');
}

function is_select($var, $val) { 
  if ($var == $val) return 'selected="selected"'; 
  return false; }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Document</title>
</head>

<body>
  <div class="container">
    <h1>Update Barang</h1>
    <a href="index.php" class="data">Data Barang</a>
    <div class="main">
      <form method="post" action="ubah.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $barang["id_barang"]; ?>" />
        <div class="input">

          <label>Nama Barang</label>
          <input type="text" name="nama" required value="<?= $barang["nama"]; ?>" />

          <label>Kategori</label>
          <select name="kategori">
            <option value="Komputer" <?php if( $barang["kategori"]== 'Komputer') echo 'selected';?>>Komputer</option>
            <option value="Elektronik" <?php if( $barang["kategori"]== 'Elektronik') echo 'selected';?>>Elektronik
            </option>
            <option value="HandPhone" <?php if( $barang["kategori"]== 'HandPhone') echo 'selected';?>>Hand Phone
            </option>
          </select>

          <label>Harga Jual</label>
          <input type="number" name="harga_jual" required value="<?= $barang["harga_jual"]; ?>" />

          <label>Harga Beli</label>
          <input type="number" name="harga_beli" required value="<?= $barang["harga_beli"]; ?>" />

          <label>Stok</label>
          <input type="number" name="stok" required value="<?= $barang["stok"]; ?>" />

          <label>File Gambar</label>
          <input type="file" name="file_gambar" required value="<?= $barang["gambar"]; ?>" />
        </div>
        <div class="submit">
          <button type="submit" name="submit" class="button">Update Barang</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>