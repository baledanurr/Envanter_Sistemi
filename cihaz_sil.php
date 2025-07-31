<?php
include("../config/db.php");

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $conn->query("DELETE FROM devices WHERE id = $id");
}

header("Location: cihaz_ekle.php");
exit;
