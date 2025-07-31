<?php include("../includes/header.php"); ?>
<?php
include("../config/db.php");

$talepler = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cihaz_id = $_POST["cihaz_id"];
    $aciklama = $_POST["aciklama"];
    $tarih = date("Y-m-d");

    $stmt = $conn->prepare("INSERT INTO talepler (cihaz_id, talep_aciklama, talep_tarihi) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $cihaz_id, $aciklama, $tarih);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Talep başarıyla kaydedildi.</div>";
    } else {
        echo "<div class='alert alert-danger'>Hata oluştu: " . $stmt->error . "</div>";
    }
}

$cihazlar = $conn->query("SELECT id, cihaz_adi FROM devices");

$sonTalepler = $conn->query("
    SELECT d.cihaz_adi, t.talep_aciklama, t.talep_tarihi 
    FROM talepler t
    JOIN devices d ON t.cihaz_id = d.id
    ORDER BY t.id DESC
");

if ($sonTalepler && $sonTalepler->num_rows > 0) {
    while ($row = $sonTalepler->fetch_assoc()) {
        $talepler[] = $row;
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">📌 Talep Oluştur</h2>
            <form method="POST" action="" class="border p-4 rounded bg-light shadow">
                <div class="mb-3">
                    <label for="cihaz_id" class="form-label">Cihaz Seç:</label>
                    <select name="cihaz_id" class="form-select" required>
                        <option value="">-- Cihaz Seçin --</option>
                        <?php while ($row = $cihazlar->fetch_assoc()): ?>
                            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['cihaz_adi']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="aciklama" class="form-label">Açıklama:</label>
                    <textarea name="aciklama" class="form-control" rows="4" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Talep Gönder</button>
            </form>

            <?php if (!empty($talepler)): ?>
                <hr>
                <h4 class="mt-4">📄 Gönderilen Talepler</h4>
                <?php foreach ($talepler as $talep): ?>
                    <div class="border p-3 mb-3 bg-white rounded shadow-sm">
                        <strong><?= htmlspecialchars($talep['cihaz_adi']) ?></strong><br>
                        <em><?= htmlspecialchars($talep['talep_aciklama']) ?></em><br>
                        <small><strong>Tarih:</strong> <?= $talep['talep_tarihi'] ?></small>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>
