<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
      Сделаем лучше вместе! — Городской портал «Сделаем лучше вместе!» по приему
      заявок на устранение проблем в городе: ямочный ремонт дорог, ремонт
      детских площадок, зданий сооружений.
    </title>
    <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="css/index.css" />
    <link rel="stylesheet" href="css/main.css" />
    <script src="scripts/main.js" defer></script>
  </head>
  <body>
    <!-- header-desktop -->
    <header id="header-desktop">
      <div class="logo">
        <img src="assets/logo.png" alt="логотип Сделаем Лучше Вместе!" />
        <a href="index.php">Сделаем лучше вместе!</a>
      </div>
      <nav>
        <ul>
          <li><a href="index.php">Главная страница</a></li>
          <li><a href="user.php">Личный кабинет</a></li>
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
          <li><a href="user.php">Личный кабинет</a></li>
        </ul>
      </nav>
    </header>

    <main>
      <section class="container" id="summary">
        <!-- счетчик -->
        <article id="container-counter">
          <p class="colored" id="counter-solved">2</p>
          <p>Решённых заявок</p>
        </article>
        <!-- последние три решённые заявки -->
        <!-- 1 -->
        <article class="container-outlined">
          <div class="group">
            <p class="date text-faded">13.09.2024</p>
            <p class="category colored">Ремонт дорог</p>
          </div>
          <header>
            <h3>Дорога на Пушкина</h3>
          </header>
          <div class="content">
            <div class="content-after">
              <img src="assets/Rectangle2.png" alt="После" />
              <p class="text-faded">После</p>
            </div>
            <div class="content-before">
              <img src="assets/Rectangle2.png" alt="После" />
              <p class="text-faded">До</p>
            </div>
          </div>
        </article>
        <!-- 2 -->
        <article class="container-outlined">
          <div class="group">
            <p class="date text-faded">13.09.2024</p>
            <p class="category colored">Ремонт площадки</p>
          </div>
          <header>
            <h3>Площадка на Пушкина</h3>
          </header>
          <div class="content">
            <div class="content-after">
              <img src="assets/Rectangle2.png" alt="После" />
              <p class="text-faded">После</p>
            </div>
            <div class="content-before">
              <img src="assets/Rectangle2.png" alt="После" />
              <p class="text-faded">До</p>
            </div>
          </div>
        </article>
        <!-- 3 -->
        <article class="container-outlined">
          <div class="group">
            <p class="date text-faded">13.09.2024</p>
            <p class="category colored">Уборка мусора</p>
          </div>
          <header>
            <h3>Мусор на Пушкина</h3>
          </header>
          <div class="content">
            <div class="content-after">
              <img src="assets/Rectangle2.png" alt="После" />
              <p class="text-faded">После</p>
            </div>
            <div class="content-before">
              <img src="assets/Rectangle2.png" alt="После" />
              <p class="text-faded">До</p>
            </div>
          </div>
        </article>
      </section>

      <section class="container" id="auth">
        <!-- вход -->
        <form
          class="container-outlined"
          id="form-login"
          action="auth.php"
          method="post"
        >
          <h3>Уже с нами? Войдите в личный кабинет!</h3>
          <div class="group">
            <label for="login">Логин</label>
            <input
              type="text"
              name="login"
              id="login"
              placeholder="exampleLogin"
              required
            />
          </div>
          <div class="group">
            <label for="password">Пароль</label>
            <input
              type="password"
              name="password"
              id="password"
              placeholder="********"
              autocomplete="current-password"
              required
            />
          </div>
          <button class="button-colored" type="submit" name="button-login">
            Войти
          </button>
        </form>
        <!-- регистрация -->
        <form
          class="container-colored"
          id="form-register"
          action="auth.php"
          method="post"
        >
          <h3>А если нет — присоединяйтесь!</h3>
          <div class="group">
            <label for="name">ФИО</label>
            <input
              type="text"
              name="name"
              id="name"
              placeholder="Фамилия Имя Отчество"
              required
            />
          </div>
          <div class="group">
            <label for="login_new">Логин</label>
            <input
              type="text"
              name="login_new"
              id="login_new"
              placeholder="Только латиница"
              required
            />
          </div>
          <div class="group">
            <label for="email">E-mail</label>
            <input
              type="text"
              name="email"
              id="email"
              placeholder="example@email.ru"
              autocomplete="email"
              required
            />
          </div>
          <div class="group">
            <label for="password_new">Пароль</label>
            <input
              type="password"
              name="password_new"
              id="password_new"
              placeholder="Не менее 8 символов"
              required
            />
          </div>
          <div class="group">
            <label for="password_repeat">Повтор пароля</label>
            <input
              type="password"
              name="password_repeat"
              id="password_repeat"
              placeholder="Введённое значение должно совпадать с паролем"
              autocomplete="new-password"
              required
            />
          </div>
          <div class="group">
            <input
              type="checkbox"
              name="agreement"
              id="agreement"
              checked
              disabled
              required
            />
            <label for="agreement">Я согласен на обработку данных</label>
          </div>
          <button class="button-inverted" type="submit" name="button-register">
            Зарегистрироваться
          </button>
        </form>
      </section>
    </main>

    <footer>
      <div class="logo">
        <img src="assets/logo.png" alt="логотип Сделаем Лучше Вместе!" />
        <a href="index.php">Сделаем лучше вместе!</a>
      </div>
      <p>
        “Сделаем лучше вместе” — городской портал по приёму заявок на устранение
        проблем в городе
      </p>
      <p>2024</p>
    </footer>
  </body>
</html>
