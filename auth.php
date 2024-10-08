<?php
require_once 'config.php';

// вход
if (isset($_POST['button-login'])) {
  // получение данных из формы входа
  $login = htmlspecialchars($_POST['login']);
  $password = htmlspecialchars($_POST['password']);

  // получение данных из бд
  $stmt = $conn->prepare('SELECT * FROM users WHERE login = ?');
  $stmt->bind_param('s', $login);
  $stmt->execute();
  $result = $stmt->get_result();

  // если юзер существует
  if ($result->num_rows === 1) {
    // получение данных юзера
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      // сохранение id юзера в сессии
      $_SESSION['user_id'] = $user['id'];
      // перекидываем юзера в профиль
      header('Location: user.php');
      exit();
    } else {
      echo <<<HTML
      <script>
        if (confirm("Неверный пароль")) window.location.href = "index.php";
      </script>
      HTML;
      exit();
    }
  } else {
    echo <<<HTML
    <script>
      if (confirm("Пользователь не найден")) window.location.href = "index.php";
    </script>
    HTML;
    exit();
  }
}

// регистрация
if (isset($_POST['button-register'])) {
  // получение данных из формы регистрации
  $name = htmlspecialchars($_POST['name']);
  $login_new = htmlspecialchars($_POST['login_new']);
  $email = htmlspecialchars($_POST['email']);
  $password_new = htmlspecialchars($_POST['password_new']);
  $password_repeat = htmlspecialchars($_POST['password_repeat']);

  // проверка совпадения паролей
  if ($password_new !== $password_repeat) {
    echo <<<HTML
    <script>
      if (confirm("Пароли не совпадают")) window.location.href = "index.php";
    </script>
    HTML;
    exit();
  }

  // проверка, занят ли логин
  $stmt = $conn->prepare('SELECT * FROM users WHERE login = ?');
  $stmt->bind_param('s', $login_new);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    echo <<<HTML
    <script>
      if (confirm("Логин уже занят")) window.location.href = "index.php";
    </script>
    HTML;
    exit();
  }

  // шифрование пароля
  $hashed_password = password_hash($password_new, PASSWORD_BCRYPT);

  // вставляем нового юзера в бд
  $stmt = $conn->prepare('INSERT INTO users (name, login, email, password) VALUES (?, ?, ?, ?)');
  $stmt->bind_param('ssss', $name, $login_new, $email, $hashed_password);

  if ($stmt->execute()) {
    // получаение id нового пользователя
    $new_user_id = $stmt->insert_id;

    // сохранение id юзера в сессии
    $_SESSION['user_id'] = $new_user_id;

    // перекидываем юзера в профиль
    header('Location: user.php');
    exit();
  } else {
    echo <<<HTML
    <script>
      if (confirm("Что-то пошло не так")) window.location.href = "index.php";
    </script>
    HTML;
    exit();
  }
}

// выход
if (isset($_POST['logout'])) {
  session_destroy();
  header("Location: index.php");
  exit();
}