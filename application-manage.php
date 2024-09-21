<?php
session_start();
require_once 'config.php';

if (isset($_POST["send-application"])) {
  $title = $_POST["title"];
  $description = $_POST["description"];
  $category = $_POST["category"];
  $user_id = $_SESSION["user_id"];
  $path = "";
  $allowed_extensions = array('jpg', 'jpeg', 'png', 'bmp');

  if (
    isset($_FILES["path"]) &&
    $_FILES["path"]["error"] == UPLOAD_ERR_OK &&
    in_array(pathinfo($_FILES["path"]["name"], PATHINFO_EXTENSION), $allowed_extensions)
  ) {
    $path = "assets/applications/" . date('YmdHis') . "_" . uniqid() . "." . pathinfo($_FILES["path"]["name"], PATHINFO_EXTENSION);

    // Если не удалось переместить файл в нужную папку
    if (!move_uploaded_file($_FILES["path"]["tmp_name"], $path)) {
      echo '<script>alert("Ошибка при сохранении файла");</script>';
      exit();
    }
  } else {
    // Ошибка или у файла не тот тип
    echo '<script>alert("Ошибка загрузки файла. Убедитесь, что файл имеет соответствующее расширение: jpg, jpeg, png, bmp.");</script>';
  }

  $stmt = $conn->prepare("INSERT INTO applications (user_id, title, description, category, path) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param('issss', $user_id, $title, $description, $category, $path);

  if (!$stmt->execute()) {
    echo '<script>alert("Не удалось выполнить sql-запрос.");</script>';
  }

  header('Location: user.php');

  $stmt->close();
}