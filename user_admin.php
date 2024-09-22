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
          <img src="{$application['path']}" />
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
    ?>
  </section>
</section>