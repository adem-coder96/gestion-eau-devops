<?php
header('Content-Type: application/json');

mysqli_report(MYSQLI_REPORT_OFF);

$servername = getenv('DB_HOST') ?: '127.0.0.1';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$dbname = getenv('DB_NAME') ?: 'depot_eau';

$conn = @new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_errno) {
    http_response_code(503);
    echo json_encode(['status' => 'unhealthy']);
    exit;
}
echo json_encode([
    'status' => 'healthy',
    'version' => 'step-5-test'
]);
$conn->close();
?>
