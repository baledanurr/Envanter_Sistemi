<?php
include("../config/db.php");

if (!isset($_GET['id'])) {
    die("ID parametresi eksik.");
}

$id = (int)$_GET['id'];

// 81 İl Listesi (aynı listeyi buraya da ekliyoruz)
$iller = [
    "Adana","Adıyaman","Afyonkarahisar","Ağrı","Amasya","Ankara","Antalya","Artvin","Aydın",
    "Balıkesir","Bilecik","Bingöl","Bitlis","Bolu","Burdur","Bursa","Çanakkale","Çankırı","Çorum",
    "Denizli","Diyarbakır","Edirne","Elazığ","Erzincan","Erzurum","Eskişehir","Gaziantep","Giresun",
    "Gümüşhane","Hakkâri","Hatay","Isparta","Mersin","İstanbul","İzmir","Kars","Kastamonu","Kayseri",
    "Kırklareli","Kırşehir","Kocaeli","Konya","Kütahya","Malatya","Manisa","Kahramanmaraş","Mardin",
    "Muğla","Muş","Nevşehir","Niğde","Ordu","Rize","Sakarya","Samsun","Siirt","Sinop","Sivas","Tekirdağ",
    "Tokat","Trabzon","Tunceli","Şanlıurfa","Uşak","Van","Yozgat","Zonguldak","Aksaray","Bayburt",
    "Karaman","Kırıkkale","Batman","Şırnak","Bartın","Ardahan","Iğdır","Yalova","Karabük","Kilis",
    "Osmaniye","Düzce"
];

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

        $sql = "UPDATE bakimlar SET 
                cihaz_id = '$cihaz_id',
                baslangic = '$baslangic',
                periyot_gun = $periyot_gun,
                musteri = '$musteri',
                tesis = '$tesis',
                yuklenici = '$yuklenici',
                il = '$il',
                sonraki_bakim = '$sonraki_bakim'
            WHERE id = $id";

        if ($conn->query($sql)) {
            header("Location: periyodik_bakim.php?msg=Guncellendi");
            exit();
        } else {
            die("Güncelleme hatası: " . $conn->error);
        }
    } else {
        echo "<div class='alert alert-warning'>Lütfen tüm alanları doldurun.</div>";
    }
} else {
    $result = $conn->query("SELECT * FROM bakimlar WHERE id = $id");
    if ($result->num_rows == 0) {
        die("Kayıt bulunamadı.");
    }
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Bakım Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
    <h2>Bakım Düzenle - ID: <?php echo $id; ?></h2>

    <form method="POST">
        <input type="text" name="cihaz_id" placeholder="Cihaz ID" required class="form-control mb-2" value="<?php echo htmlspecialchars($row['cihaz_id']); ?>">
        <input type="date" name="baslangic" required class="form-control mb-2" value="<?php echo htmlspecialchars($row['baslangic']); ?>">
        <input type="number" name="periyot_gun" placeholder="Periyot (gün)" min="1" required class="form-control mb-2" value="<?php echo htmlspecialchars($row['periyot_gun']); ?>">
        <input type="text" name="musteri" placeholder="Müşteri" required class="form-control mb-2" value="<?php echo htmlspecialchars($row['musteri']); ?>">
        <input type="text" name="tesis" placeholder="Tesis" required class="form-control mb-2" value="<?php echo htmlspecialchars($row['tesis']); ?>">
        <input type="text" name="yuklenici" placeholder="Yüklenici" required class="form-control mb-2" value="<?php echo htmlspecialchars($row['yuklenici']); ?>">

        <select name="il" required class="form-select mb-3">
            <option value="">İl Seçiniz</option>
            <?php
            foreach ($iller as $ilAdi) {
                $selected = ($row['il'] === $ilAdi) ? "selected" : "";
                echo "<option value=\"$ilAdi\" $selected>$ilAdi</option>";
            }
            ?>
        </select>

        <button type="submit" class="btn btn-primary">Güncelle</button>
        <a href="periyodik_bakim.php" class="btn btn-secondary ms-2">İptal</a>
    </form>
</div>

</body>
</html>
