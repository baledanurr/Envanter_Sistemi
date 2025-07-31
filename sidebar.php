<!-- includes/sidebar.php -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
  body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', sans-serif;
  }

  #sidebar {
    height: 100vh;
    width: 250px;
    background-color: #1e1e2f;
    position: fixed;
    top: 0;
    left: 0;
    overflow-x: hidden;
    transition: width 0.3s ease;
    z-index: 1000;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
  }

  #sidebar.collapsed {
    width: 70px;
  }

  #sidebar .nav-link {
    color: #fff;
    padding: 14px 20px;
    display: flex;
    align-items: center;
    transition: background-color 0.2s ease;
    font-size: 15px;
  }

  #sidebar .nav-link:hover {
    background-color: #2c2c40;
    text-decoration: none;
  }

  #sidebar .nav-link i {
    margin-right: 10px;
    font-size: 18px;
  }

  #sidebar .nav-link span {
    display: inline;
    white-space: nowrap;
  }

  #sidebar.collapsed .nav-link span {
    display: none;
  }

  #content {
    margin-left: 250px;
    transition: margin-left 0.3s ease;
    padding: 20px;
  }

  #sidebar.collapsed ~ #content {
    margin-left: 70px;
  }

  .toggle-btn {
    position: fixed;
    top: 15px;
    left: 260px;
    background-color: #1e1e2f;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    z-index: 1100;
    transition: left 0.3s ease;
  }

  #sidebar.collapsed + .toggle-btn {
    left: 80px;
  }
</style>

<div id="sidebar">
  <a class="nav-link" href="/EnvanterSistemi/index.php">
    <i class="bi bi-house-door-fill"></i><span>Anasayfa</span>
  </a>
  <a class="nav-link" href="/EnvanterSistemi/pages/cihaz_ekle.php">
    <i class="bi bi-plus-circle"></i><span>Cihaz Ekle</span>
  </a>
  <a class="nav-link" href="/EnvanterSistemi/pages/talep_olustur.php">
    <i class="bi bi-pencil-square"></i><span>Talep Oluştur</span>
  </a>
  <a class="nav-link" href="/EnvanterSistemi/pages/bakim_takip.php">
    <i class="bi bi-tools"></i><span>Bakım Takibi</span>
  </a>
  <a class="nav-link" href="/EnvanterSistemi/pages/magaza_talepleri.php">
    <i class="bi bi-shop"></i><span>Mağaza Talepleri</span>
  </a>
  <a class="nav-link" href="/EnvanterSistemi/pages/servis_talep_olustur.php">
    <i class="bi bi-plus-square-dotted"></i><span>Servis Talebi Oluştur</span>
  </a>
  <a class="nav-link" href="/EnvanterSistemi/pages/servis_talepler.php">
    <i class="bi bi-list-check"></i><span>Servis Talepleri</span>
  </a>
  <a class="nav-link" href="/EnvanterSistemi/pages/satin_alma.php">
    <i class="bi bi-cart-check"></i><span>Satınalma Talepleri</span>
  </a>
</div>

<button class="toggle-btn btn btn-sm" onclick="toggleSidebar()">☰</button>

<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('collapsed');
  }
</script>
