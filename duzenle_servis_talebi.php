<?php
include("../config/db.php");
include("../includes/header.php");

// 1. ID kontrolü
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Geçersiz istek.";
    exit;
}

$id = intval($_GET['id']);

// 2. Güncelleme işlemi (POST geldiyse)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $musteri_id = $_POST['musteri_id'];
    $tesis_id = $_POST['tesis_id'];
    $yuklenici_id = $_POST['yuklenici_id'];
    $durum = $_POST['durum'];
    $talep_tarihi = $_POST['talep_tarihi'];
    $aciklama = $_POST['aciklama'];

    $sql = "UPDATE servis_talepleri SET musteri_id=?, tesis_id=?, yuklenici_id=?, durum=?, talep_tarihi=?, aciklama=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiisssi", $musteri_id, $tesis_id, $yuklenici_id, $durum, $talep_tarihi, $aciklama, $id);

    if ($stmt->execute()) {
    header("Location: /EnvanterSistemi/pages/servis_talepleri.php?success=1");
    exit;
    } else {
        echo "Güncelleme sırasında hata oluştu: " . $stmt->error;
    }
}

// 3. Güncelleme değilse (sayfa ilk açıldığında), mevcut veriyi getir
$sql = "SELECT * FROM servis_talepleri WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "Kayıt bulunamadı.";
    exit;
}
$row = $result->fetch_assoc();

// 4. Dropdown verilerini çek
$musteriler = $conn->query("SELECT id, ad FROM musteriler ORDER BY ad ASC");
$tesisler = $conn->query("SELECT id, ad FROM tesisler ORDER BY ad ASC");
$yukleniciler = $conn->query("SELECT id, ad FROM yukleniciler ORDER BY ad ASC");
?>

<div class="container mt-4">
    <h2>Servis Talebi Düzenle (ID: <?= $id ?>)</h2>

    <!-- 5. Form: action ile ID korundu -->
    <form method="POST" action="duzenle_servis_talebi.php?id=<?= $id ?>">

        <label>Müşteri:</label>
        <select name="musteri_id" required>
            <option value="">Seçiniz</option>
            <?php while ($musteri = $musteriler->fetch_assoc()): ?>
                <option value="<?= $musteri['id'] ?>" <?= ($row['musteri_id'] == $musteri['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($musteri['ad']) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Tesis:</label>
        <select name="tesis_id" required>
            <option value="">Seçiniz</option>
            <?php while ($tesis = $tesisler->fetch_assoc()): ?>
                <option value="<?= $tesis['id'] ?>" <?= ($row['tesis_id'] == $tesis['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($tesis['ad']) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Yüklenici:</label>
        <select name="yuklenici_id" required>
            <option value="">Seçiniz</option>
            <?php while ($yuklenici = $yukleniciler->fetch_assoc()): ?>
                <option value="<?= $yuklenici['id'] ?>" <?= ($row['yuklenici_id'] == $yuklenici['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($yuklenici['ad']) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Durum:</label>
        <select name="durum" required>
            <option value="beklemede" <?= ($row['durum'] == 'beklemede') ? 'selected' : '' ?>>Beklemede</option>
            <option value="tamamlandi" <?= ($row['durum'] == 'tamamlandi') ? 'selected' : '' ?>>Tamamlandı</option>
            <option value="iptal" <?= ($row['durum'] == 'iptal') ? 'selected' : '' ?>>İptal</option>
        </select><br><br>

        <label>Talep Tarihi:</label>
        <input type="date" name="talep_tarihi" value="<?= $row['talep_tarihi'] ?>" required><br><br>

        <label>Açıklama:</label><br>
        <textarea name="aciklama" rows="4" cols="50"><?= htmlspecialchars($row['aciklama']) ?></textarea><br><br>

        <button type="submit" class="btn btn-primary">Güncelle</button>
        <a href="servis_talepleri.php" class="btn btn-secondary">İptal</a>
    </form>
</div>

<?php include("../includes/footer.php"); ?>
