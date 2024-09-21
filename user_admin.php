<?php
require_once 'config.php';
?>

<!-- для админа -->
<section class="row-item" id="new">
  <h2>Новые</h2>
  <?php
  $stmt = $conn->prepare("SELECT * FROM applications");
  $stmt->bind_param('i', $_SESSION["user_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  while ($application = $result->fetch_assoc()) {
  }

  ?>
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
    <form action="application-manage.php" method="post"
      class="container-outlined form-manage">
      <p>Доказательства решения проблемы</p>
      <input type="file" name="proof" id="proof" />
      <span class="caption">допустимые форматы: *.jpg, *.jpeg, *.png,
        *.bmp</span>
      <button class="button-colored" type="submit">Принять</button>
    </form>
    <hr />
    <form action="application-manage.php" method="post"
      class="container-outlined form-manage">
      <p>Причины отклонения заявки</p>
      <textarea name="reason" id="reason"
        placeholder="Адрес и другие подробности"></textarea>
      <button class="button-outlined" type="submit">Отклонить</button>
    </form>
  </article>
</section>