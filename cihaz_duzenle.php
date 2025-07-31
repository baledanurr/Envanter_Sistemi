<?php include("../includes/header.php"); ?>
<?php include("../config/db.php"); ?>

<?php
if (!isset($_GET["id"])) {
    echo "<div class='alert alert-danger text-center mt-4'>Cihaz ID bulunamadı.</div>";
    exit;
}

$id = intval($_GET["id"]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cihaz_adi = $_POST["cihaz_adi"];
    $marka = $_POST["marka"];
    $model = $_POST["model"];
    $seri_no = $_POST["seri_no"];

    $stmt = $conn->prepare("UPDATE devices SET cihaz_adi=?, marka=?, model=?, seri_no=? WHERE id=?");
    $stmt->bind_param("ssssi", $cihaz_adi, $marka, $model, $seri_no, $id);
    $stmt->execute();

    echo "<div class='alert alert-success text-center mt-3'>Cihaz başarıyla güncellendi.</div>";
}

$cihaz = $conn->query("SELECT * FROM devices WHERE id = $id")->fetch_assoc();
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">🔧 Cihaz Güncelle</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Cihaz Adı</label>
                            <input type="text" name="cihaz_adi" class="form-control" value="<?= htmlspecialchars($cihaz['cihaz_adi']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Marka</label>
                            <input type="text" name="marka" class="form-control" value="<?= htmlspecialchars($cihaz['marka']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Model</label>
                            <input type="text" name="model" class="form-control" value="<?= htmlspecialchars($cihaz['model']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Seri No</label>
                            <input type="text" name="seri_no" class="form-control" value="<?= htmlspecialchars($cihaz['seri_no']) ?>" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">💾 Güncelle</button>
                            <a href="cihaz_ekle.php" class="btn btn-secondary">İptal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>
