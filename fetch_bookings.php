<?php
session_start(); // Start session

include('Connection/PDOcon.php');

header('Content-Type: application/json'); // Set header for JSON response

try {
    // Fetch all confirmed bookings
    $query = "SELECT id, type_of_stay, start_date, end_date FROM bookings WHERE status = 'Confirmed'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results); // Return data as JSON
} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
