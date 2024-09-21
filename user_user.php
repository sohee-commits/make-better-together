<?php
require_once 'config.php';
?>

<!-- для юзера -->
<form action="application-manage.php" class="container-colored"
  id="form-application-manage" method="post">
  <div class="group">
    <label for="title">Название</label>
    <input type="text" name="title" id="title" placeholder="Мусор на Пушкина"
      required />
  </div>
  <div class="group">
    <label for="description">Описание</label>
    <textarea name="description" id="description"
      placeholder="Адрес и другие подробности" required></textarea>
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
    <label for="path">Фото, демонстрирующее проблему</label>
    <input type="file" name="path" id="path" accept=".jpg,.jpeg,.png,.bmp" />
    <span class="caption">допустимые форматы: *.jpg, *.jpeg, *.png,
      *.bmp</span>
  </div>
  <button class="button-inverted" name="send-application"
    type="submit">Отправить заявку</button>
</form>
<form action="sort.php" method="post" class="container-outlined"
  id="form-sort">
  <select name="sort" id="sort">
    <option value="В порядке добавления" selected>В порядке добавления</option>
    <option value="Ожидают">Ожидают</option>
    <option value="Отклонённые">Отклонённые</option>
    <option value="Решённые">Решённые</option>
  </select>
</form>
<section id="applications">
  <?php
  $stmt = $conn->prepare("SELECT * FROM applications WHERE user_id = ?");
  $stmt->bind_param('i', $_SESSION["user_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  while ($application = $result->fetch_assoc()) {
    $date = date('d.m.Y', strtotime($application["date"]));
    $status_class = ($application["status"] == "Отклонена") ? "declined" : (($application["status"] == "Решена") ? "solved" : "");

    if ($application["status"] == "Ожидает") {
      echo <<<HTML
      <form 
        action="application-manage.php" 
        method="post" 
        class="container-outlined">
      HTML;
    } else {
      echo <<<HTML
      <section class="container-outlined">
      HTML;
    }

    echo <<<HTML
    <div class="group">
        <p class="date text-faded">{$date}</p>
        <p class="category colored">{$application["category"]}</p>
    </div>
    <header>
        <h3>{$application["title"]}</h3>
    </header>
    <p>{$application["description"]}</p>
    <div class="group status">
        <p class="caption">Статус</p>
        <p class="{$status_class}">{$application["status"]}</p>
    </div>
    HTML;

    if ($application["status"] == "Ожидает") {
      echo <<<HTML
      <button type="submit" name=>Удалить заявку</button>
      </form>
      HTML;
    } else {
      echo <<<HTML
      </section>
      HTML;
    }
  }
  ?>
</section>