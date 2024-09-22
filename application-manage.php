<?php
session_start();
require_once 'config.php';

// юзер отправляет заявку
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
    $path = date('YmdHis') . "_" . uniqid() . "." . pathinfo($_FILES["path"]["name"], PATHINFO_EXTENSION);

    if (!move_uploaded_file($_FILES["path"]["tmp_name"], "assets/applications/" . $path)) {
      echo '<script>alert("Ошибка при сохранении файла.");</script>';
      exit();
    }
  } else {
    if ($_FILES["path"]["error"] != UPLOAD_ERR_OK) {
      echo '<script>alert("Ошибка при загрузке файла: ' . $_FILES["path"]["error"] . '");</script>';
    } else {
      echo '<script>alert("Ошибка загрузки файла. Убедитесь, что файл имеет соответствующее расширение: jpg, jpeg, png, bmp.");</script>';
    }
    exit();
  }

  // Подготовка SQL-запроса
  $stmt = $conn->prepare("INSERT INTO applications (user_id, title, description, category, path) VALUES (?, ?, ?, ?, ?)");

  if ($stmt === false) {
    echo '<script>alert("Ошибка подготовки запроса: ' . $conn->error . '");</script>';
    exit();
  }

  // Связывание параметров
  $stmt->bind_param('issss', $user_id, $title, $description, $category, $path);

  // Выполнение запроса
  if (!$stmt->execute()) {
    echo '<script>alert("Ошибка выполнения SQL: ' . $stmt->error . '");</script>';
  } else {
    echo '<script>alert("Заявка успешно отправлена!");</script>';
    header('Location: user.php');
  }

  // Закрытие запроса
  $stmt->close();
}

// юзер удаляет заявку
if (isset($_POST["application-delete"])) {
  $application_id = intval($_POST["application_id"]);

  $stmt = $conn->prepare("DELETE FROM applications where id = ?");
  $stmt->bind_param('i', $application_id);

  if (!$stmt->execute()) {
    echo '<script>alert("Не удалось удалить заявку.");</script>';
  } else {
    header('Location: user.php');
  }
}

// сортировка заявок у юзера в лк
// см. scripts/user_user.js
if (isset($_POST["sort"])) {
  header('Content-Type: application/json');

  $sort = $_POST['sort'];
  $userId = $_SESSION['user_id'];

  // определяем сортировку
  switch ($sort) {
    case 'Ожидают':
      $query = "SELECT * FROM applications WHERE user_id = ? AND status = 'Ожидает'";
      break;
    case 'Отклонённые':
      $query = "SELECT * FROM applications WHERE user_id = ? AND status = 'Отклонена'";
      break;
    case 'Решённые':
      $query = "SELECT * FROM applications WHERE user_id = ? AND status = 'Решена'";
      break;
    default:
      $query = "SELECT * FROM applications WHERE user_id = ?";
      break;
  }

  $stmt = $conn->prepare($query);
  $stmt->bind_param('i', $userId);
  $stmt->execute();
  $result = $stmt->get_result();

  $applications = [];
  while ($row = $result->fetch_assoc()) {
    $applications[] = [
      'id' => $row['id'],
      'title' => $row['title'],
      'description' => $row['description'],
      'category' => $row['category'],
      'date' => date('d.m.Y', strtotime($row['date'])),
      'status' => $row['status']
    ];
  }

  echo json_encode($applications);
}

// отклонение заявки админом
if (isset($_POST["decline"])) {
  $reason = $_POST["reason"];
  $application_id = intval($_POST["application_id"]);
  $status = 'Отклонена';

  $stmt = $conn->prepare("UPDATE applications SET status = ?, reason = ? WHERE id = ?");
  $stmt->bind_param('ssi', $status, $reason, $application_id);

  if (!$stmt->execute()) {
    echo '<script>alert("Ошибка при обновлении заявки: ' . $stmt->error . '");</script>';
  }

  header('Location: user.php');
}

// решение заявки админом
if (isset($_POST["solve"])) {
  $application_id = intval($_POST["application_id"]);
  $path = $_POST["path"]; // имя.тип
  $status = 'Решена';
  $allowed_extensions = array('jpg', 'jpeg', 'png', 'bmp');

  // Проверка на загрузку файла
  if (isset($_FILES["proof"]) && $_FILES["proof"]["error"] == UPLOAD_ERR_OK &&
    in_array(pathinfo($_FILES["proof"]["name"], PATHINFO_EXTENSION), $allowed_extensions)) {

    // Сохранение файла в папку solved с именем из path
    if (!move_uploaded_file($_FILES["proof"]["tmp_name"], "assets/applications/solved/" . $path)) {
      echo '<script>alert("Ошибка при сохранении файла.");</script>';
      exit();
    }
  } else {
    if ($_FILES["proof"]["error"] != UPLOAD_ERR_OK) {
      echo '<script>alert("Ошибка при загрузке файла: ' . $_FILES["proof"]["error"] . '");</script>';
    } else {
      echo '<script>alert("Ошибка загрузки файла. Убедитесь, что файл имеет соответствующее расширение: jpg, jpeg, png, bmp.");</script>';
    }
    exit();
  }

  // Обновление статуса в базе данных
  $stmt = $conn->prepare("UPDATE applications SET status = ? WHERE id = ?");
  $stmt->bind_param('si', $status, $application_id);

  if (!$stmt->execute()) {
    echo '<script>alert("Ошибка SQL: ' . $stmt->error . '");</script>';
  } else {
    header('Location: user.php');
  }

  // Закрытие запроса
  $stmt->close();
}
