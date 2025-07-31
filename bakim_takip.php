<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../includes/header.php");
include("../config/db.php");

$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cihaz_id = $_POST["cihaz_id"];
    $baslangic = $_POST["baslangic"];
    $periyot_gun = $_POST["periyot_gun"];

    if (!empty($cihaz_id) && !empty($baslangic) && !empty($periyot_gun)) {
        $sonraki_bakim = date('Y-m-d', strtotime("$baslangic +$periyot_gun days"));

        $stmt = $conn->prepare("INSERT INTO bakimlar (cihaz_id, baslangic, periyot_gun, sonraki_bakim) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isis", $cihaz_id, $baslangic, $periyot_gun, $sonraki_bakim);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $mesaj = "<div class='alert alert-success'>✅ Kayıt başarıyla eklendi.</div>";
        } else {
            $mesaj = "<div class='alert alert-danger'>❌ Kayıt eklenemedi.</div>";
        }
    } else {
        $mesaj = "<div class='alert alert-warning'>❗ Lütfen tüm alanları doldurun.</div>";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="mb-4">🔧 Bakım Takip Ekle</h2>

            <?= $mesaj ?>

            <form method="POST" class="border p-4 rounded bg-light shadow">
                <div class="mb-3">
                    <label for="cihaz_id" class="form-label">Cihaz ID:</label>
                    <input type="number" name="cihaz_id" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="baslangic" class="form-label">Başlangıç Tarihi:</label>
                    <input type="date" name="baslangic" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="periyot_gun" class="form-label">Periyot (gün):</label>
                    <input type="number" name="periyot_gun" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Kaydet</button>
            </form>

            <hr class="my-5">

            <h4>🧾 Kayıtlı Bakımlar</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Cihaz ID</th>
                            <th>Başlangıç</th>
                            <th>Periyot (gün)</th>
                            <th>Sonraki Bakım</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM bakimlar ORDER BY id ASC");
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['cihaz_id']}</td>
                                    <td>{$row['baslangic']}</td>
                                    <td>{$row['periyot_gun']}</td>
                                    <td>{$row['sonraki_bakim']}</td>
                                    <td>
                                        <a href='bakim_duzenle.php?id={$row['id']}' class='btn btn-sm btn-warning me-2'>Düzenle</a>
                                        <a href='bakim_sil.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Bu kaydı silmek istediğinize emin misiniz?')\">Sil</a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>Kayıt yok</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>
