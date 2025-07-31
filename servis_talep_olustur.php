<?php
include("../config/db.php");
include("../includes/header.php");

// Talep kaydı işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $musteri_id = $_POST['musteri_id'] ?? '';
    $tesis_id = $_POST['tesis_id'] ?? '';
    $yuklenici_id = $_POST['yuklenici_id'] ?? '';
    $durum = $_POST['durum'] ?? '';
    $talep_tarihi = $_POST['talep_tarihi'] ?? '';
    $aciklama = $_POST['aciklama'] ?? '';

    if ($musteri_id && $tesis_id && $yuklenici_id && $durum && $talep_tarihi) {
        $stmt = $conn->prepare("INSERT INTO servis_talepleri (musteri_id, tesis_id, yuklenici_id, durum, talep_tarihi, aciklama) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiisss", $musteri_id, $tesis_id, $yuklenici_id, $durum, $talep_tarihi, $aciklama);

        if ($stmt->execute()) {
            echo '<div class="alert alert-success">✅ Talep başarıyla eklendi.</div>';
        } else {
            echo '<div class="alert alert-danger">❌ Hata: ' . $stmt->error . '</div>';
        }
    } else {
        echo '<div class="alert alert-warning">❗ Lütfen tüm alanları doldurun.</div>';
    }
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">🛠️ Servis Talebi Oluştur</h2>

    <form method="POST" class="row g-3 mb-5">
        <div class="col-md-4">
            <label for="musteri_id" class="form-label">Müşteri</label>
            <select name="musteri_id" id="musteri_id" class="form-select" required>
                <option value="">Seçiniz</option>
                <?php
                $musteriler = $conn->query("SELECT id, ad FROM musteriler ORDER BY ad ASC");
                while ($row = $musteriler->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['ad']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-4">
            <label for="tesis_id" class="form-label">Tesis</label>
            <select name="tesis_id" id="tesis_id" class="form-select" required>
                <option value="">Seçiniz</option>
                <?php
                $tesisler = $conn->query("SELECT id, ad FROM tesisler ORDER BY ad ASC");
                while ($row = $tesisler->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['ad']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-4">
            <label for="yuklenici_id" class="form-label">Yüklenici</label>
            <select name="yuklenici_id" id="yuklenici_id" class="form-select" required>
                <option value="">Seçiniz</option>
                <?php
                $yukleniciler = $conn->query("SELECT id, ad FROM yukleniciler ORDER BY ad ASC");
                while ($row = $yukleniciler->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['ad']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-6">
            <label for="durum" class="form-label">Durum</label>
            <select name="durum" id="durum" class="form-select" required>
                <option value="">Seçiniz</option>
                <option value="Havuz Yüklenici">Havuz Yüklenici</option>
                <option value="Onaylı Yüklenici">Onaylı Yüklenici</option>
                <option value="Yasaklı Yüklenici">Yasaklı Yüklenici</option>
                <option value="Sözleşmeli Yüklenici">Sözleşmeli Yüklenici</option>
            </select>
        </div>

        <div class="col-md-6">
            <label for="talep_tarihi" class="form-label">Talep Tarihi</label>
            <input type="date" name="talep_tarihi" id="talep_tarihi" class="form-control" required>
        </div>

        <div class="col-12">
            <label for="aciklama" class="form-label">Açıklama</label>
            <textarea name="aciklama" id="aciklama" class="form-control" rows="4" placeholder="Talep detaylarını buraya yazın..."></textarea>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-success w-100">Talep Gönder</button>
        </div>
    </form>

    <h3 class="text-center mb-3">📋 Kayıtlı Servis Talepleri</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Müşteri</th>
                    <th>Tesis</th>
                    <th>Yüklenici</th>
                    <th>Durum</th>
                    <th>Talep Tarihi</th>
                    <th>Açıklama</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT st.id, m.ad as musteri, t.ad as tesis, y.ad as yuklenici, st.durum, st.talep_tarihi, st.aciklama
                          FROM servis_talepleri st
                          JOIN musteriler m ON st.musteri_id = m.id
                          JOIN tesisler t ON st.tesis_id = t.id
                          JOIN yukleniciler y ON st.yuklenici_id = y.id
                          ORDER BY st.id ASC";
                $result = $conn->query($query);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['musteri']}</td>
                                <td>{$row['tesis']}</td>
                                <td>{$row['yuklenici']}</td>
                                <td>{$row['durum']}</td>
                                <td>{$row['talep_tarihi']}</td>
                                <td>{$row['aciklama']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Henüz talep bulunmamaktadır.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include("../includes/footer.php"); ?>
