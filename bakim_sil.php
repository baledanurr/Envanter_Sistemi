<?php
include("../config/db.php");

if (!isset($_GET['id'])) {
    die("ID parametresi eksik.");
}

$id = (int)$_GET['id'];

$sql = "DELETE FROM bakimlar WHERE id = $id";

if ($conn->query($sql)) {
    header("Location: periyodik_bakim.php?msg=Silindi");
    exit();
} else {
    die("Silme hatası: " . $conn->error);
}

