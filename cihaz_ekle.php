<?php include("../includes/header.php"); ?>
<?php include("../config/db.php"); ?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">📦 Cihaz Ekle</h2>

    <!-- Form Başlangıcı -->
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cihaz_adi = trim($_POST["cihaz_adi"]);
        $model = trim($_POST["model"]);
        $seri_no = trim($_POST["seri_no"]);
        $ek_tarih = date("Y-m-d");

        if (!empty($cihaz_adi) && !empty($model) && !empty($seri_no)) {
            $stmt = $conn->prepare("INSERT INTO devices (cihaz_adi, model, seri_no, eklenme_tarihi) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $cihaz_adi, $model, $seri_no, $ek_tarih);
            if ($stmt->execute()) {
                echo '<div class="alert alert-success">✅ Cihaz başarıyla eklendi.</div>';
            } else {
                echo '<div class="alert alert-danger">❌ Hata: ' . $stmt->error . '</div>';
            }
        } else {
            echo '<div class="alert alert-warning">❗ Lütfen tüm alanları doldurun.</div>';
        }
    }
    ?>

    <form method="POST" class="row g-3 mb-5">
        <div class="col-md-4">
            <label for="cihaz_adi" class="form-label">Cihaz Adı</label>
            <input type="text" class="form-control" id="cihaz_adi" name="cihaz_adi" required>
        </div>

        <div class="col-md-4">
            <label for="model" class="form-label">Model</label>
            <input type="text" class="form-control" id="model" name="model" required>
        </div>

        <div class="col-md-4">
            <label for="seri_no" class="form-label">Seri No</label>
            <input type="text" class="form-control" id="seri_no" name="seri_no" required>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-success w-100">➕ Cihaz Ekle</button>
        </div>
    </form>

    <!-- Cihaz Listesi -->
    <h3 class="text-center mb-3">📋 Kayıtlı Cihazlar</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Cihaz Adı</th>
                    <th>Model</th>
                    <th>Seri No</th>
                    <th>Eklenme Tarihi</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM devices ORDER BY id ASC");
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['cihaz_adi']}</td>
                            <td>{$row['model']}</td>
                            <td>{$row['seri_no']}</td>
                            <td>{$row['eklenme_tarihi']}</td>
                            <td>
                                <a href='cihaz_duzenle.php?id={$row['id']}' class='btn btn-sm btn-primary'>✏️ Düzenle</a>
                                <a href='cihaz_sil.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Silmek istediğinize emin misiniz?\")'>🗑️ Sil</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Henüz cihaz eklenmemiş.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include("../includes/footer.php"); ?>

