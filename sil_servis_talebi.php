<?php
include("../config/db.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM servis_talepleri WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: servis_talepleri.php");
        exit();
    } else {
        echo "Silme işlemi sırasında hata oluştu: " . $stmt->error;
    }
} else {
    echo "Geçersiz istek.";
}
?>
