<?php
require_once 'config.php';
?>

<!-- для админа -->
<section id="main-admin">
  <section class="row-item" id="new">
    <h2>Новые</h2>
    <?php
    $stmt = $conn->prepare("SELECT * FROM applications WHERE status = 'Ожидает'");
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
      echo <<<HTML
      <p 
        id="filler" 
        style="height: 20vh; 
        font-size: 1.15rem; 
        font-weight: 500;">
          Новых заявок пока нет 😄
      </p>
      HTML;
    } else {
      while ($application = $result->fetch_assoc()) {
        $date = date('d.m.Y', strtotime($application['date']));
        $path = str_replace("assets/applications/", "", $application["path"]);

        echo <<<HTML
        <article class="container-outlined">
          <div class="group">
            <p class="date text-faded">{$date}</p>
            <p class="category colored">{$application['category']}</p>
          </div>
          <header>
            <h3>{$application['title']}</h3>
          </header>
          <img src="assets/applications/{$application['path']}" />
          <hr />
          <form 
            action="application-manage.php" 
            method="post"
            class="container-outlined form-manage"
            enctype="multipart/form-data">
            <input 
              type="hidden" 
              name="application_id" 
              value="{$application['id']}" />
            <input 
              type="hidden" 
              name="path" 
              value="{$path}" />
            <p>Доказательства решения проблемы</p>
            <input type="file" name="proof" id="proof" />
            <span class="caption">допустимые форматы: *.jpg, *.jpeg, *.png,
              *.bmp</span>
            <button class="button-colored" type="submit" name="solve">Принять</button>
          </form>
          <hr />
          <form 
            action="application-manage.php" 
            method="post"
            class="container-outlined form-manage">
            <input 
              type="hidden" 
              name="application_id" 
              value="{$application['id']}" />
            <p>Причины отклонения заявки</p>
            <textarea name="reason" id="reason"
              placeholder="Адрес и другие подробности"></textarea>
            <button class="button-outlined" type="submit" name="decline">Отклонить</button>
          </form>
        </article>
        HTML;
      }
    }
    ?>
  </section>

  <section class="row-item" id="solved">
    <h2>Решённые</h2>
    <?php
    $stmt = $conn->prepare("SELECT * FROM applications");
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
      echo <<<HTML
      <p 
        id="filler" 
        style="height: 20vh; 
        font-size: 1.15rem; 
        font-weight: 500;">
          Нет решённых заявок 🤔
      </p>
      HTML;
    } else {
      while ($application = $result->fetch_assoc()) {
        if ($application['status'] != 'Ожидает') {
          $date = date('d.m.Y', strtotime($application['date']));
          $statusClass =
            $application['status'] === 'Отклонена'
            ? 'declined'
            : ($application['status'] === 'Решена'
              ? 'solved'
              : '');

          echo <<<HTML
        <section class="container-outlined application">
          <div class="group">
            <p class="date text-faded">{$date}</p>
            <p class="category colored">{$application['category']}</p>
          </div>
          <header>
            <h3>{$application['title']}</h3>
          </header>
          <p>{$application['description']}</p>
          <div class="group status">
            <p class="caption">Статус</p>
            <p class="{$statusClass}">{$application['status']}</p>
          </div>
        </section>
        HTML;
        }
      }
    }
    ?>
  </section>

  <section class="row-item" id="categories">
    <h2>Управление категориями</h2>
    <form
      class="container-colored"
      id="form-add"
      action="categories-manage.php"
      method="post">
      <div class="group">
        <label for="title">Название</label>
        <input
          type="text"
          name="title"
          id="title"
          placeholder="Мусор на Пушкина"
          required />
      </div>
      <button class="button-inverted" type="submit" name="add">
        Добавить
      </button>
    </form>
    <?php
    $stmt = $conn->prepare("SELECT * FROM categories");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
      echo <<<HTML
      <p 
        id="filler" 
        style="height: 20vh; 
        font-size: 1.15rem; 
        font-weight: 500;">
          Нет категорий! 😱
      </p>
      HTML;
    } else {
      while ($category = $result->fetch_assoc()) {
        echo <<<HTML
      <form 
        action="categories-manage.php" 
        method="post" 
        class="container-outlined category"
        onsubmit="return confirm('Вы уверены, что хотите удалить эту категорию?');">
        <input type="hidden" name="title" value="{$category['title']}">
        <h3>{$category['title']}</h3>
        <button type="submit" name="delete">
          Удалить категорию
        </button>
      </form>
      HTML;
      }
    }
    ?>
  </section>
</section>