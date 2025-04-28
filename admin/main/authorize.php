<?php
include('../../../Connection/PDOcon.php');
$isLoggedIn = isset($_SESSION['user_id']);
if ($isLoggedIn) {
    $stmt2 = $pdo->prepare("SELECT * FROM `users` WHERE id = ?");
    $stmt2->execute([$_SESSION['user_id']]);
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

    if ($row2) {
        $roleCheck = $row2["role_as"];

        if ($roleCheck == 1) {
        } else {
            header("Location: ../../../AuthAndStatusPages/401.php");
            exit();
        }
    } else {
        header("Location: ../../../AuthAndStatusPages/401.php");
        exit();
    }
} else {
    header("Location: ../../../AuthAndStatusPages/401.php");
    exit();
}