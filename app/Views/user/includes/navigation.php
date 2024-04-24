<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
      <a class="navbar-brand" href="#">Rally</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav me-auto">
          <li class="nav-item">
          <a class="nav-link active" href="<?= base_url('/'); ?>">Home
              <span class="visually-hidden">(current)</span>
          </a>
          </li>
          <?php if (isset($_SESSION['id'])) { ?>
            <div class="nav-item">
                <a href="<?= base_url('user/events'); ?>" class="nav-link">
                    Events
                </a>
            </div>
            <!-- <li class="nav-item">
                <a href="<?= base_url('user/scan') ?>" class="nav-link">
                    Scan
                </a>
            </li> -->
            <li class="nav-item">
                <a href="<?= base_url('user/profile') ?>" class="nav-link">
                Profile
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('logout') ?>" class="nav-link">
                    Logout
                </a>
            </li>
          <?php } else { ?>
            <li class="nav-item">
                <a href="<?= base_url('login') ?>" class="nav-link">
                    Login
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('register') ?>" class="nav-link">
                    Register
                </a>
            </li>
          <?php } ?>
          <!-- <li class="nav-item">
          <a class="nav-link" href="#">Features</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="#">Pricing</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="#">About</a>
          </li> -->

      </ul>
      <!-- <form class="d-flex">
          <input class="form-control me-sm-2" type="search" placeholder="Search">
          <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
      </form> -->
      </div>
  </div>
</nav>