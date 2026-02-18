<?php
session_start();
require_once '../includes/db-connection.php';
require_once '../includes/session-check.php';

requireAdmin();

$id = (int)($_GET['id'] ?? 0);
$action = $_GET['action'] ?? '';

if ($id <= 0 || !in_array($action, ['approve', 'reject'])) {
    header('Location: ../admin-dashboard.php?error=Invalid request');
    exit();
}

$new_status = ($action === 'approve') ? 'verified' : 'rejected';

$stmt = $pdo->prepare("UPDATE users SET verification_status = ? WHERE user_id = ?");
$stmt->execute([$new_status, $id]);

$message = ($action === 'approve') ? 'User approved successfully' : 'User rejected';
header("Location: ../admin-dashboard.php?success=" . urlencode($message));
exit();
?>
