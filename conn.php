<?php
  $conn = new mysqli("localhost", "root", "root", "db_lpjbos");
  
  if ($conn->connect_error){
    die("Koneksi Gagal: " . $conn->connect_error);
  }
?>