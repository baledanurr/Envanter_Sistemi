<?php
include("../includes/header.php");
include("../config/db.php");

$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $urun_adi = $conn->real_escape_string($_POST['urun_adi']);
    $miktar = (int)$_POST['miktar'];
    $birim_fiyat = (float)$_POST['birim_fiyat'];
    $talep_tarihi = $conn->real_escape_string($_POST['talep_tarihi']);
    $durum = $conn->real_escape_string($_POST['durum']);
    $aciklama = $conn->real_escape_string($_POST['aciklama']);

    if ($urun_adi && $miktar > 0 && $birim_fiyat > 0 && $talep_tarihi) {
        $sql = "INSERT INTO satin_alma_talepleri (urun_adi, miktar, birim_fiyat, talep_tarihi, durum, aciklama)
                VALUES ('$urun_adi', $miktar, $birim_fiyat, '$talep_tarihi', '$durum', '$aciklama')";
        if ($conn->query($sql)) {
            $mesaj = "<div class='alert alert-success'>Talep başarıyla eklendi.</div>";
        } else {
            $mesaj = "<div class='alert alert-danger'>Hata: " . $conn->error . "</div>";
        }
    } else {
        $mesaj = "<div class='alert alert-warning'>Lütfen zorunlu alanları doldurun.</div>";
    }
}
?>

<div class="container mt-4">
    <h2>Yeni Satın Alma Talebi Ekle</h2>

    <?= $mesaj ?>

    <form method="POST">
        <div class="mb-3">
            <label>Ürün Adı</label>
            <input type="text" name="urun_adi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Miktar</label>
            <input type="number" name="miktar" class="form-control" min="1" required>
        </div>
        <div class="mb-3">
            <label>Birim Fiyat (₺)</label>
            <input type="number" name="birim_fiyat" class="form-control" step="0.01" min="0" required>
        </div>
        <div class="mb-3">
            <label>Talep Tarihi</label>
            <input type="date" name="talep_tarihi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Durum</label>
            <select name="durum" class="form-select" required>
                <option value="Beklemede">Beklemede</option>
                <option value="Onaylandı">Onaylandı</option>
                <option value="Reddedildi">Reddedildi</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Açıklama</label>
            <textarea name="aciklama" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Kaydet</button>
        <a href="satin_alma.php" class="btn btn-secondary ms-2">İptal</a>
    </form>
</div>

<?php include("../includes/footer.php"); ?>
