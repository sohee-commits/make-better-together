<?php
session_start();
require_once 'config.php';

if (isset($_POST['add'])) {
  $title = $_POST['title'];

  $stmt = $conn->prepare("INSERT INTO categories (title) VALUES (?)");
  $stmt->bind_param('s', $title);

  if (!$stmt->execute()) {
    echo '<script>alert(' . $stmt->error . ')</script>';
  } else {
    header('Location: user.php');
    exit();
  }
}

if (isset($_POST['delete'])) {
  $title = $_POST['title'];

  $stmt = $conn->prepare("DELETE FROM categories WHERE title = ?");
  $stmt->bind_param('s', $title);

  if (!$stmt->execute()) {
    echo '<script>alert("Не удалось удалить категорию.");</script>';
  } else {
    header('Location: user.php');
    exit();
  }
}