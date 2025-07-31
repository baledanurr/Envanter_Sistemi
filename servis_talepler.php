<?php
include("../includes/header.php");
include("../config/db.php");

// Kayıtları çek
$sql = "SELECT st.id, m.ad AS musteri_adi, t.ad AS tesis_adi, y.ad AS yuklenici_adi, st.durum, st.talep_tarihi, st.aciklama
        FROM servis_talepleri st
        LEFT JOIN musteriler m ON st.musteri_id = m.id
        LEFT JOIN tesisler t ON st.tesis_id = t.id
        LEFT JOIN yukleniciler y ON st.yuklenici_id = y.id
        ORDER BY st.id ASC";
$result = $conn->query($sql);
?>

<div class="container mt-4">
    <h2>Servis Talepleri</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Müşteri</th>
                <th>Tesis</th>
                <th>Yüklenici</th>
                <th>Durum</th>
                <th>Talep Tarihi</th>
                <th>Açıklama</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['musteri_adi']) ?></td>
                        <td><?= htmlspecialchars($row['tesis_adi']) ?></td>
                        <td><?= htmlspecialchars($row['yuklenici_adi']) ?></td>
                        <td><?= htmlspecialchars($row['durum']) ?></td>
                        <td><?= htmlspecialchars($row['talep_tarihi']) ?></td>
                        <td><?= htmlspecialchars($row['aciklama']) ?></td>
                        <td>
                            <a href="duzenle_servis_talebi.php?id=<?= urlencode($row['id']) ?>" class="btn btn-primary btn-sm me-1">Düzenle</a>
                            <a href="sil_servis_talebi.php?id=<?= urlencode($row['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">Kayıt bulunamadı.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include("../includes/footer.php"); ?>
