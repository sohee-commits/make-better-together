<?php
session_start();
require_once 'config.php';

$stmt = $conn->prepare("SELECT COUNT(*) as count FROM applications WHERE status = 'Решена'");
$stmt->execute();
$result = $stmt->get_result();

$data = $result->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($data);