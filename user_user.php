<?php
require_once 'config.php';
?>

<!-- добавить заявку -->
<form
  action="application-manage.php"
  class="container-colored"
  id="form-application-manage" method="post"
  enctype="multipart/form-data">
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
  <button
    class="button-inverted"
    name="send-application"
    type="submit">
    Отправить заявку
  </button>
</form>
<!-- сортировка -->
<form method="post" class="container-outlined" id="form-sort">
  <select name="sort" id="sort" onchange="fetchSortedApplications(this.value)">
    <option value="В порядке добавления" selected>В порядке добавления</option>
    <option value="Ожидают">Ожидают</option>
    <option value="Отклонённые">Отклонённые</option>
    <option value="Решённые">Решённые</option>
  </select>
</form>
<section id="applications">
  <!-- отображение заявок php & fetch js -->
  <!-- см. файл user_user и manage-applications.php -->
</section>