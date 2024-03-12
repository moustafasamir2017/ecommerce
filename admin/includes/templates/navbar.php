<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="#"><?= lang('DASHBOARD_ADMIN'); ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="app-nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="#"><?= lang('HOME_ADMIN'); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><?= lang('CATEGORIES'); ?></a>
        </li>
      </ul>

      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Moustafa
            </a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="members.php?do=Edit&userid=<?= $_SESSION['ID'] ?>">Edit Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
        </ul>
        </li>
      </ul>


    </div>
  </div>
</nav>
<div class="container">