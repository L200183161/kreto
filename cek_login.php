<?php
// mengaktifkan session pada php
session_start();
if (!isset($_SESSION['admin']) or empty($_SESSION['user'])) {
	// menghubungkan php dengan koneksi database
	include 'koneksi.php';

	// menangkap data yang dikirim dari form login
	$username = htmlspecialchars(mysqli_escape_string($koneksi, $_POST['username']));
	$password = htmlentities(mysqli_escape_string($koneksi, $_POST['password']));


	// menyeleksi data user dengan username dan password yang sesuai
	$login = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' and password='$password'");
	// menghitung jumlah data yang ditemukan
	$cek = mysqli_num_rows($login);

	// cek apakah username dan password di temukan pada database
	if ($cek > 0) {

		$data = mysqli_fetch_assoc($login);

		// cek jika user login sebagai admin
		if ($data['level'] == "admin") {
			$_SESSION['admin'] = array(
				'username' => $data['username'],
				'password' => $data['password'],
				'nama' => $data['nama'],
				'level' => $data['level']
			);
			echo "<script>window.location='admin/';</script>";
			// buat session login dan username
			// $_SESSION['username'] = $username;
			// $_SESSION['level'] = "admin";
			// alihkan ke halaman dashboard admin
			// header("location:admin/admin.php");

			// cek jika user login sebagai user
		} else if ($data['level'] == "user") {
			if ($data['status'] == "0") {
				$_SESSION['user'] = array(
					'username' => $data['username'],
					'password' => $data['password'],
					'nama' => $data['nama'],
					'level' => $data['level']
				);

				echo "<script>window.location='user/';</script>";
			} else if ($data['status'] == "1") {
				$_SESSION['user'] = array(
					'username' => $data['username'],
					'password' => $data['password'],
					'nama' => $data['nama'],
					'level' => $data['level']
				);
				echo "<script>window.location='user/';</script>";
			} else {
				echo "<script>window.location='./login.php?pesan=blacklist';</script>";
			}
		} else {

			// alihkan ke halaman login kembali
			echo "window.location='./login.php?pesan=gagal';</script>";
		}
	} else {
		echo "<script>window.location='./login.php?pesan=gagal';</script>";
	}
} else {
	if (isset($_SESSION['admin'])) {
		echo "<script>window.location='admin/';</script>";
	} elseif (isset($_SESSION['user'])) {
		echo "<script>window.location='user/';</script>";
	}
}
