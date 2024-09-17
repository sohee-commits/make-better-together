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
    <link rel="stylesheet" href="css/user.css" />
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

 <!-- <main class="container">
      новые
      <section class="row-item" id="new">
        <h2>Новые</h2>
        <article class="container-outlined">
          <div class="group">
            <p class="date text-faded">13.09.2024</p>
            <p class="category colored">Ремонт дорог</p>
          </div>
          <header>
            <h3>Дорога на Пушкина</h3>
          </header>
          <img src="assets/Rectangle2.png" />
          <hr />
          <form
            action="application-manage.php"
            method="post"
            class="container-outlined form-manage"
          >
            <p>Доказательства решения проблемы</p>
            <input type="file" name="proof" id="proof" />
            <span class="caption">
              допустимые форматы: *.jpg, *.jpeg, *.png, *.bmp
            </span>
            <button class="button-colored" type="submit">Принять</button>
          </form>
          <hr />
          <form
            action="application-manage.php"
            method="post"
            class="container-outlined form-manage"
          >
            <p>Причины отклонения заявки</p>
            <textarea
              name="reason"
              id="reason"
              placeholder="Адрес и другие подробности"
            ></textarea>
            <button class="button-outlined" type="submit">Отклонить</button>
          </form>
        </article>
      </section>
      решенные
      <section class="row-item" id="container-solved">
        <h2>Решённые</h2>
        <article class="container-outlined item-solved">
          <div class="group">
            <p class="date text-faded">13.09.2024</p>
            <p class="category colored">Ремонт дорог</p>
          </div>
          <header>
            <h3>Дорога на Пушкина</h3>
          </header>
          <p>
            Ни пройти, ни проехать на такой дороге... Адрес ул. Пушкина, 107а
          </p>
          <div class="group status">
            <p class="caption">Статус</p>
            <p class="declined">Отклонена</p>
          </div>
        </article>
        <article class="container-outlined item-solved">
          <div class="group">
            <p class="date text-faded">13.09.2024</p>
            <p class="category colored">Уборка мусора</p>
          </div>
          <header>
            <h3>Мусор на Пушкина</h3>
          </header>
          <p>Адрес ул. Пушкина, 107а . Мусор на входе — безобразие!</p>
          <div class="group status">
            <p class="caption">Статус</p>
            <p class="solved">Решена</p>
          </div>
        </article>
      </section>
      управление категориями
      <section class="row-item" id="categories-manage-container">
        <h2>Управление категориями</h2>
        <form
          action="category-add.php"
          method="post"
          class="container-colored"
          id="form-category-add"
        >
          <div class="group">
            <label for="title">Название</label>
            <input
              type="text"
              name="title"
              id="title"
              placeholder="Ремонт дорог"
              required
            />
          </div>
          <button type="submit" class="button-inverted">Добавить</button>
        </form>
        <form class="container-outlined category">
          <header>
            <h3>Ремонт дорог</h3>
          </header>
          <button type="submit">Удалить категорию</button>
        </form>
        <form class="container-outlined category">
          <header>
            <h3>Уборка мусора</h3>
          </header>
          <button type="submit">Удалить категорию</button>
        </form>
        <form class="container-outlined category">
          <header>
            <h3>Ремонт площадки</h3>
          </header>
          <button type="submit">Удалить категорию</button>
        </form>
        <form class="container-outlined category">
          <header>
            <h3>Ремонт здания</h3>
          </header>
          <button type="submit">Удалить категорию</button>
        </form>
      </section>
    </main> -->

    <main>
      <form
        action="application-add.php"
        class="container-colored"
        id="form-application-add"
        method="post"
      >
        <div class="group">
          <label for="title">Название</label>
          <input
            type="text"
            name="title"
            id="title"
            placeholder="Мусор на Пушкина"
            required
          />
        </div>
        <div class="group">
          <label for="description">Описание</label>
          <textarea
            name="description"
            id="description"
            placeholder="Адрес и другие подробности"
            required
          ></textarea>
        </div>
        <div class="group">
          <label for="category">Категория</label>
          <select name="category" id="category">
            <option value="Ремонт дорог" selected>Ремонт дорог</option>
            <option value="Уборка мусора">Уборка мусора</option>
            <option value="Ремонт площадки">Ремонт площадки</option>
            <option value="Ремонт здания">Ремонт здания</option>
          </select>
        </div>
        <div class="group">
          <label for="picture">Фото, демонстрирующее проблему</label>
          <input type="file" name="picture" id="picture" />
          <span class="caption"
            >допустимые форматы: *.jpg, *.jpeg, *.png, *.bmp</span
          >
        </div>
        <button class="button-inverted" type="submit">Отправить заявку</button>
      </form>
      <form
        action="sort.php"
        method="post"
        class="container-outlined"
        id="form-sort"
      >
        <select name="sort" id="sort">
          <option value="В порядке добавления" selected>
            В порядке добавления
          </option>
          <option value="Ожидают">Ожидают</option>
          <option value="Отклонённые">Отклонённые</option>
          <option value="Решённые">Решённые</option>
        </select>
      </form>
      <section id="applications">
        <form
          action="application-delete.php"
          method="post"
          class="container-outlined"
        >
          <div class="group">
            <p class="date text-faded">13.09.2024</p>
            <p class="category colored">Ремонт дорог</p>
          </div>
          <header>
            <h3>Дорога на Пушкина</h3>
          </header>
          <p>
            Ни пройти, ни проехать на такой дороге... Адрес ул. Пушкина, 107а
          </p>
          <div class="group status">
            <p class="caption">Статус</p>
            <p>Ожидает</p>
          </div>
          <button type="submit">Удалить заявку</button>
        </form>
        <form
          action="application-delete.php"
          method="post"
          class="container-outlined"
        >
          <div class="group">
            <p class="date text-faded">13.09.2024</p>
            <p class="category colored">Уборка мусора</p>
          </div>
          <header>
            <h3>Мусор на Пушкина</h3>
          </header>
          <p>Адрес ул. Пушкина, 107а . Мусор на входе — безобразие!</p>
          <div class="group status">
            <p class="caption">Статус</p>
            <p class="declined">Отклонена</p>
          </div>
        </form>
        <form
          action="application-delete.php"
          method="post"
          class="container-outlined"
        >
          <div class="group">
            <p class="date text-faded">13.09.2024</p>
            <p class="category colored">Ремонт площадки</p>
          </div>
          <header>
            <h3>Площадка на Пушкина</h3>
          </header>
          <p>
            Адрес ул. Пушкина, 107а — детям играть негде, площадка на божьем
            слове держится(((
          </p>
          <div class="group status">
            <p class="caption">Статус</p>
            <p class="solved">Решена</p>
          </div>
        </form>
        <form
          action="application-delete.php"
          method="post"
          class="container-outlined"
        >
          <div class="group">
            <p class="date text-faded">13.09.2024</p>
            <p class="category colored">Ремонт дорог</p>
          </div>
          <header>
            <h3>Дорога на Пушкина</h3>
          </header>
          <p>
            Ни пройти, ни проехать на такой дороге... Адрес ул. Пушкина, 107а
          </p>
          <div class="group status">
            <p class="caption">Статус</p>
            <p class="solved">Решена</p>
          </div>
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
