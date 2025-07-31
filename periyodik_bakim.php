<?php
include("../config/db.php");

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cihaz_id = $conn->real_escape_string($_POST['cihaz_id']);
    $baslangic = $conn->real_escape_string($_POST['baslangic']);
    $periyot_gun = (int)$_POST['periyot_gun'];
    $musteri = $conn->real_escape_string($_POST['musteri']);
    $tesis = $conn->real_escape_string($_POST['tesis']);
    $yuklenici = $conn->real_escape_string($_POST['yuklenici']);
    $il = $conn->real_escape_string($_POST['il']);

    if ($cihaz_id && $baslangic && $periyot_gun > 0 && $musteri && $tesis && $yuklenici && $il) {
        $sonraki_bakim = date('Y-m-d', strtotime("$baslangic +$periyot_gun days"));
        $sql = "INSERT INTO bakimlar (cihaz_id, baslangic, periyot_gun, musteri, tesis, yuklenici, il, sonraki_bakim)
                VALUES ('$cihaz_id', '$baslangic', $periyot_gun, '$musteri', '$tesis', '$yuklenici', '$il', '$sonraki_bakim')";
        if ($conn->query($sql)) {
            $msg = "<div class='alert alert-success'>✔️ Kayıt başarıyla eklendi.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>❌ Hata: " . $conn->error . "</div>";
        }
    } else {
        $msg = "<div class='alert alert-warning'>⚠️ Lütfen tüm alanları eksiksiz doldurun.</div>";
    }
}

$iller = [ "Adana","Adıyaman","Afyonkarahisar","Ağrı","Amasya","Ankara","Antalya","Artvin","Aydın",
    "Balıkesir","Bilecik","Bingöl","Bitlis","Bolu","Burdur","Bursa","Çanakkale","Çankırı","Çorum",
    "Denizli","Diyarbakır","Edirne","Elazığ","Erzincan","Erzurum","Eskişehir","Gaziantep","Giresun",
    "Gümüşhane","Hakkâri","Hatay","Isparta","Mersin","İstanbul","İzmir","Kars","Kastamonu","Kayseri",
    "Kırklareli","Kırşehir","Kocaeli","Konya","Kütahya","Malatya","Manisa","Kahramanmaraş","Mardin",
    "Muğla","Muş","Nevşehir","Niğde","Ordu","Rize","Sakarya","Samsun","Siirt","Sinop","Sivas","Tekirdağ",
    "Tokat","Trabzon","Tunceli","Şanlıurfa","Uşak","Van","Yozgat","Zonguldak","Aksaray","Bayburt",
    "Karaman","Kırıkkale","Batman","Şırnak","Bartın","Ardahan","Iğdır","Yalova","Karabük","Kilis",
    "Osmaniye","Düzce"
];
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Periyodik Bakımlar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container">
    <div class="mb-4">
        <h2 class="text-primary">📅 Periyodik Bakım Kayıtları</h2>
        <?php echo $msg; ?>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-secondary text-white">
            <strong>➕ Yeni Bakım Ekle</strong>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="cihaz_id" placeholder="Cihaz ID" required class="form-control">
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="baslangic" required class="form-control">
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="periyot_gun" placeholder="Periyot (gün)" min="1" required class="form-control">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="musteri" placeholder="Müşteri" required class="form-control">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="tesis" placeholder="Tesis" required class="form-control">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="yuklenici" placeholder="Yüklenici" required class="form-control">
                    </div>
                    <div class="col-md-4">
                        <select name="il" required class="form-select">
                            <option value="">İl Seçiniz</option>
                            <?php
                            foreach ($iller as $ilAdi) {
                                echo "<option value=\"$ilAdi\">$ilAdi</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-success">💾 Kaydet</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <strong>🗂 Kayıtlı Bakımlar</strong>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th><th>Cihaz ID</th><th>Başlangıç</th><th>Periyot (gün)</th><th>Sonraki Bakım</th>
                            <th>Müşteri</th><th>Tesis</th><th>Yüklenici</th><th>İl</th><th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM bakimlar ORDER BY id ASC");
                        if ($result && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $id = (int)$row['id'];
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($id) . "</td>";
                                echo "<td>" . htmlspecialchars($row['cihaz_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['baslangic']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['periyot_gun']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['sonraki_bakim']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['musteri']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['tesis']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['yuklenici']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['il']) . "</td>";
                                echo "<td>
                                    <a href='bakim_duzenle.php?id=$id' class='btn btn-sm btn-primary'>Düzenle</a>
                                    <a href='bakim_sil.php?id=$id' class='btn btn-sm btn-danger' onclick=\"return confirm('Silmek istediğinize emin misiniz?')\">Sil</a>
                                </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10' class='text-center'>🛑 Kayıt bulunamadı.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>
