<?php
include("../includes/header.php");
include("../config/db.php");

$result = $conn->query("SELECT * FROM satin_alma_talepleri ORDER BY id ASC");
?>

<div class="container mt-4">
    <h2>Satın Alma Talepleri</h2>
    <a href="satin_alma_ekle.php" class="btn btn-success mb-3">Yeni Talep Ekle</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ürün Adı</th>
                <th>Miktar</th>
                <th>Birim Fiyat</th>
                <th>Toplam Fiyat</th>
                <th>Talep Tarihi</th>
                <th>Durum</th>
                <th>Açıklama</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
        <?php if($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['urun_adi']) ?></td>
                    <td><?= htmlspecialchars($row['miktar']) ?></td>
                    <td><?= number_format($row['birim_fiyat'], 2) ?> ₺</td>
                    <td><?= number_format($row['toplam_fiyat'], 2) ?> ₺</td>
                    <td><?= htmlspecialchars($row['talep_tarihi']) ?></td>
                    <td><?= htmlspecialchars($row['durum']) ?></td>
                    <td><?= htmlspecialchars($row['aciklama']) ?></td>
                    <td>
                        <a href="satin_alma_duzenle.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Düzenle</a>
                        <a href="satin_alma_sil.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="9" class="text-center">Kayıt bulunamadı.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include("../includes/footer.php"); ?>
