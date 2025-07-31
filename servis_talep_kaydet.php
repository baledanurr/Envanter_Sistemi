<?php
include("../config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $musteri_id = $_POST['musteri_id'] ?? null;
    $tesis_id = $_POST['tesis_id'] ?? null;
    $yuklenici_id = $_POST['yuklenici_id'] ?? null;
    $durum = $_POST['durum'] ?? null;
    $talep_tarihi = $_POST['talep_tarihi'] ?? null;
    $aciklama = $_POST['aciklama'] ?? '';

    if (!$musteri_id || !$tesis_id || !$yuklenici_id || !$durum || !$talep_tarihi) {
        echo "Lütfen tüm alanları doldurun.";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO servis_talepleri (musteri_id, tesis_id, yuklenici_id, durum, talep_tarihi, aciklama) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiisss", $musteri_id, $tesis_id, $yuklenici_id, $durum, $talep_tarihi, $aciklama);

    if ($stmt->execute()) {
        header("Location: servis_talepler.php?success=1");
        exit;
    } else {
        echo "Hata oluştu: " . $stmt->error;
    }
}
?>

