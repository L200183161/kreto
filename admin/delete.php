<?php
include("../koneksi.php");

function delete($username)
{
    global $koneksi;
    mysqli_query($koneksi, "DELETE FROM pemesanan WHERE username = '$username'");
    $query =  mysqli_affected_rows($koneksi);
    return $query;
}
if (delete($_GET["username"]) > 0) {
    echo "<script>document.location.href='./daftar.php?pesan=deletesukses';</script>";
} else {
    echo "<script>document.location.href='./daftar.php?pesan=deletegagal';</script>";
    // echo 'Error :';
    // echo '<pre>';
    // print_r($query->errorInfo());
    // print_r($query->debugDumpParams());
    // echo '</pre>';;
}
