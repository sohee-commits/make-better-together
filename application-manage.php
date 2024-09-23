<?php
require_once 'config.php';

// юзер отправляет заявку
if (isset($_POST["send-application"])) {
  $title = htmlspecialchars($_POST["title"]);
  $description = htmlspecialchars($_POST["description"]);
  $category = htmlspecialchars($_POST["category"]);
  $user_id = htmlspecialchars($_SESSION["user_id"]);
  $path = "";
  $allowed_extensions = array('jpg', 'jpeg', 'png', 'bmp');

  if (isset($_FILES["path"])) {
    // Проверка на ошибки загрузки
    if ($_FILES["path"]["error"] != UPLOAD_ERR_OK) {
      echo '<script>alert("Ошибка при загрузке файла: ' . $_FILES["path"]["error"] . '");</script>';
      exit();
    }

    // Проверка размера файла
    if ($_FILES["path"]["size"] > 10 * 1024 * 1024) {
      echo '<script>alert("Размер файла не должен превышать 10 МБ.");</script>';
      exit();
    }

    // Проверка расширения файла
    if (!in_array(pathinfo($_FILES["path"]["name"], PATHINFO_EXTENSION), $allowed_extensions)) {
      echo '<script>alert("Ошибка загрузки файла. Убедитесь, что файл имеет соответствующее расширение: jpg, jpeg, png, bmp.");</script>';
      exit();
    }

    // Генерация имени файла и перемещение
    $path = date('YmdHis') . "_" . uniqid() . "." . pathinfo($_FILES["path"]["name"], PATHINFO_EXTENSION);
    if (!move_uploaded_file($_FILES["path"]["tmp_name"], "assets/applications/" . $path)) {
      echo '<script>alert("Ошибка при сохранении файла.");</script>';
      exit();
    }
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

  $sort = htmlspecialchars($_POST['sort']);
  $userId = htmlspecialchars($_SESSION['user_id']);

  // определяем сортировку
  switch ($sort) {
    case 'Ожидают':
      $query = "SELECT * FROM applications WHERE user_id = ? AND status = 'Ожидает' ORDER BY id DESC";
      break;
    case 'Отклонённые':
      $query = "SELECT * FROM applications WHERE user_id = ? AND status = 'Отклонена' ORDER BY id DESC";
      break;
    case 'Решённые':
      $query = "SELECT * FROM applications WHERE user_id = ? AND status = 'Решена' ORDER BY id DESC";
      break;
    default:
      $query = "SELECT * FROM applications WHERE user_id = ? ORDER BY id DESC";
      break;
  }

  $stmt = $conn->prepare($query);
  $stmt->bind_param('i', $userId);
  $stmt->execute();
  $result = $stmt->get_result();

  $applications = [];
  while ($row = $result->fetch_assoc()) {
    $applications[] = [
      'id' => htmlspecialchars($row['id']),
      'title' => htmlspecialchars($row['title']),
      'description' => htmlspecialchars($row['description']),
      'category' => htmlspecialchars($row['category']),
      'date' => date('d.m.Y', strtotime(htmlspecialchars($row['date']))),
      'status' => htmlspecialchars($row['status'])
    ];
  }

  echo json_encode($applications);
}


// решение заявки админом
if (isset($_POST["solve"])) {
  $application_id = intval(htmlspecialchars($_POST["application_id"]));
  $path = htmlspecialchars($_POST["path"]); // имя.тип
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
