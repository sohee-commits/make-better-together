<?php
require_once 'config.php';
?>

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
    <?php require_once '_header.php'; ?>

    <main>
      <section class="container" id="summary">
        <?php
        $stmt = $conn->prepare("SELECT * FROM applications");
        $stmt->execute();
        $result = $stmt->get_result();

        // просто сохраняем все заявки в массив
        $applications = [];
        while ($application = $result->fetch_assoc()) {
          $applications[] = $application;
        }

        // считаем решенные заявки
        $countSolved = 0;
        foreach ($applications as $application) {
          if ($application["status"] == 'Решена') {
            $countSolved++;
          }
        }

        echo <<<HTML
        <!-- счетчик -->
        <article id="container-counter">
          <p class="colored" id="counter-solved">{$countSolved}</p>
          <p>Решённых заявок</p>
        </article>
        <!-- последние три решённые заявки -->
        HTML;

        $count = 0;
        foreach ($applications as $application) {
          if ($application["status"] == 'Решена' && $count < 3) {
            $date = date('d.m.Y', strtotime($application["date"]));
            $path = str_replace("assets/applications/", "", $application["path"]);

            echo <<<HTML
            <article class="container-outlined">
              <div class="group">
                <p class="date text-faded">{$date}</p>
                <p class="category colored">{$application["category"]}</p>
              </div>
              <header>
                <h3>{$application["title"]}</h3>
              </header>
              <div class="content">
                <div class="content-after">
                  <img src="assets/applications/solved/{$path}" alt="После" />
                  <p class="text-faded">После</p>
                </div>
                <div class="content-before">
                  <img src="assets/applications/{$path}" alt="До" />
                  <p class="text-faded">До</p>
                </div>
              </div>
            </article>
            HTML;

            $count++;
          }
        }
        ?>
      </section>

      <?php
      if (!isset($_SESSION['user_id'])) {
        $html = <<<HTML
          <section class="container" id="auth">
          <!-- вход -->
          <form
            class="container-outlined"
            id="form-login"
            action="auth.php"
            method="post">
            <h3>Уже с нами? Войдите в личный кабинет!</h3>
            <div class="group">
              <label for="login">Логин</label>
              <input
                type="text"
                name="login"
                id="login"
                pattern="[A-Za-z]+"
                placeholder="exampleLogin"
                required />
            </div>
            <div class="group">
              <label for="password">Пароль</label>
              <input
                type="password"
                name="password"
                id="password"
                placeholder="********"
                autocomplete="current-password"
                required />
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
            method="post">
            <h3>А если нет — присоединяйтесь!</h3>
            <div class="group">
              <label for="name">ФИО</label>
              <input
                type="text"
                name="name"
                id="name"
                placeholder="Фамилия Имя Отчество"
                autocomplete="name"
                pattern="[А-Яа-яЁё\s]+"
                required />
            </div>
            <div class="group">
              <label for="login_new">Логин</label>
              <input
                type="text"
                name="login_new"
                id="login_new"
                pattern="[A-Za-z]+"
                placeholder="Только латиница"
                required />
            </div>
            <div class="group">
              <label for="email">E-mail</label>
              <input
                type="text"
                name="email"
                id="email"
                placeholder="example@email.ru"
                autocomplete="email"
                required />
            </div>
            <div class="group">
              <label for="password_new">Пароль</label>
              <input
                type="password"
                name="password_new"
                id="password_new"
                placeholder="Не менее 8 символов"
                required />
            </div>
            <div class="group">
              <label for="password_repeat">Повтор пароля</label>
              <input
                type="password"
                name="password_repeat"
                id="password_repeat"
                placeholder="Введённое значение должно совпадать с паролем"
                autocomplete="new-password"
                required />
            </div>
            <div class="group">
              <input
                type="checkbox"
                name="agreement"
                id="agreement"
                checked
                disabled
                required />
              <label for="agreement">Я согласен на обработку данных</label>
            </div>
            <button class="button-inverted" type="submit" name="button-register">
              Зарегистрироваться
            </button>
          </form>
        </section>
        HTML;
        echo $html;
      } else {
        echo <<<HTML
        <div id="filler" style="height: 40vh;"></div>
        HTML;
      }
      ?>
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