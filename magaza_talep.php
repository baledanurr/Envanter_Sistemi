<?php include("../includes/header.php"); ?>
<?php include("../config/db.php"); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">🏬 Mağaza Talep Formu</h2>

    <?php
    // Form gönderildiyse
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cihaz_id = $_POST["cihaz_id"];
        $magaza_adi = $_POST["magaza_adi"];
        $talep_miktar = $_POST["talep_miktar"];
        $talep_tarihi = date("Y-m-d");

        $stmt = $conn->prepare("INSERT INTO magaza_talepleri (cihaz_id, magaza_adi, talep_miktar, talep_tarihi) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isis", $cihaz_id, $magaza_adi, $talep_miktar, $talep_tarihi);

        if ($stmt->execute()) {
            echo '<div class="alert alert-success">✅ Talep başarıyla kaydedildi.</div>';
        } else {
            echo '<div class="alert alert-danger">❌ Hata: ' . $stmt->error . '</div>';
        }
        $stmt->close();
    }

    // Mevcut talepleri çek
    $result = $conn->query("SELECT * FROM magaza_talepleri ORDER BY id DESC");
    ?>

    <!-- Talep Formu -->
    <form method="POST" class="row g-3 mb-5">
        <div class="col-md-4">
            <label for="cihaz_id" class="form-label">Cihaz ID</label>
            <input type="number" class="form-control" id="cihaz_id" name="cihaz_id" required>
        </div>

        <div class="col-md-4">
            <label for="magaza_adi" class="form-label">Mağaza Adı</label>
            <input type="text" class="form-control" id="magaza_adi" name="magaza_adi" required>
        </div>

        <div class="col-md-4">
            <label for="talep_miktar" class="form-label">Talep Miktarı</label>
            <input type="number" class="form-control" id="talep_miktar" name="talep_miktar" required>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary w-100">➕ Talep Oluştur</button>
        </div>
    </form>

    <!-- Mevcut Talepler Tablosu -->
    <h3 class="text-center mb-3">📋 Mevcut Talepler</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Cihaz ID</th>
                    <th>Mağaza Adı</th>
                    <th>Talep Miktarı</th>
                    <th>Talep Tarihi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['cihaz_id']}</td>
                            <td>{$row['magaza_adi']}</td>
                            <td>{$row['talep_miktar']}</td>
                            <td>{$row['talep_tarihi']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Henüz talep yok.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include("../includes/footer.php"); ?>
