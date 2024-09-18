<!-- header-desktop -->
<header id="header-desktop">
  <div class="logo">
    <img src="assets/logo.png" alt="логотип Сделаем Лучше Вместе!" />
    <a href="index.php">Сделаем лучше вместе!</a>
  </div>
  <nav>
    <ul>
      <li><a href="index.php">Главная страница</a></li>
      <?php
      if (isset($_SESSION['user_id'])) {
        $html = <<<HTML
            <li><a href="user.php">Личный кабинет</a></li>
            <form
              action="auth.php"
              method="post">
              <button 
                type="submit"
                style="color: #b22222; border:none; font-size: 1rem;"
                name="logout">
              Выйти
              </button>
            </form>
            HTML;
        echo $html;
      }
      ?>
    </ul>
  </nav>
</header>

<!-- header-mobile -->
<header id="header-mobile">
  <div class="logo">
    <img src="assets/logo.png" alt="логотип Сделаем Лучше Вместе!" />
    <a href="index.php">Сделаем лучше вместе!</a>
  </div>
  <nav>
    <button type="button" id="open-nav">☰</button>
    <ul class="hidden">
      <li><a href="index.php">Главная страница</a></li>
      <?php
      if (isset($_SESSION['user_id'])) {
        $html = <<<HTML
            <li><a href="user.php">Личный кабинет</a></li>
            <form
              action="auth.php"
              method="post">
              <button 
                type="submit"
                style="color: #b22222; border:none; font-size: 1rem;"
                name="logout">
              Выйти
              </button>
            </form>
            HTML;
        echo $html;
      }
      ?>
    </ul>
  </nav>
</header>