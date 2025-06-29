<?php
include('../koneksi.php');
session_start();
if (!isset($_SESSION['username'])) {
header('location:login.php');
exit;
}
$id = $_POST['id_gallery'];
$judul = mysqli_real_escape_string($db, $_POST['judul']);
$foto = $_FILES['foto']['name'];
$tmp = $_FILES['foto']['tmp_name'];
// Pastikan folder 'images' tersedia
$folder = '../images/';
$target = $folder . basename($foto);
// Validasi upload dan simpan ke database
if (empty($judul) || empty($foto)) {
	echo "Judul dan foto tidak boleh kosong.";
	exit;
} else {
	// Proses upload file
	if (move_uploaded_file($tmp, $target)) {
		// Update data di database
		$query = "UPDATE gallery SET judul='$judul', foto='$foto' WHERE id_gallery='$id'";
		if (mysqli_query($db, $query)) {
			echo "Data gallery berhasil diupdate.";
			header('Location: gallery.php');
			exit;
		} else {
			echo "Gagal mengupdate data: " . mysqli_error($db);
		}
	} else {
		echo "Gagal mengupload file.";
	}
}
?>
    