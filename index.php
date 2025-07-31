<?php include("includes/header.php"); ?>

<!-- Bootstrap stilleriyle entegre -->
<style>
  body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f8f9fa;
  }

  .sidebar {
    min-height: 100vh;
    background-color: #343a40;
  }

  .sidebar .nav-link {
    color: #ffffff;
  }

  .sidebar .nav-link:hover {
    background-color: #495057;
  }
</style>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
      <div class="position-sticky pt-3">
        <h5 class="text-white text-center mb-4">📋 Menü</h5>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="index.php">🏠 Ana Sayfa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/periyodik_bakim.php">🛠 Periyodik Bakımlar</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/servis_talepler.php">🔧 Servis Talepleri</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/satin_alma.php">🛒 Satınalma Talepleri</a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Main content -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="pt-4">
        <h2 class="mb-4 text-primary">👋 Hoş geldiniz!</h2>
        <p class="lead">Lütfen yapmak istediğiniz işlemi seçin:</p>
        <div class="row g-3">
          <div class="col-md-6 col-lg-4">
            <a href="pages/cihaz_ekle.php" class="btn btn-outline-primary w-100">➕ Cihaz Ekle</a>
          </div>
          <div class="col-md-6 col-lg-4">
            <a href="pages/talep_olustur.php" class="btn btn-outline-success w-100">📝 Talep Oluştur</a>
          </div>
          <div class="col-md-6 col-lg-4">
            <a href="pages/bakim_takip.php" class="btn btn-outline-warning w-100">📊 Bakım Takibi</a>
          </div>
          <div class="col-md-6 col-lg-4">
            <a href="pages/magaza_talep.php" class="btn btn-outline-info w-100">🏬 Mağaza Talepleri</a>
          </div>
          <div class="col-md-6 col-lg-4">
            <a href="pages/servis_talep_olustur.php" class="btn btn-outline-secondary w-100">🛎️ Servis Talebi Oluştur</a>
          </div>
          <div class="col-md-6 col-lg-4">
           <a href="pages/servis_talepler.php" class="btn btn-outline-dark w-100">📋 Servis Talepleri</a>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<?php include("includes/footer.php"); ?>
