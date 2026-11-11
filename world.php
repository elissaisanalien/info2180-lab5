<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Read the country from the query string (empty string if not provided)
$country = $_GET['country'] ?? '';

// Prepared statement with LIKE so partial searches work ("Jam", "United", "Pa")
// An empty country becomes '%%', which matches every country
$stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
$stmt->execute([':country' => "%$country%"]);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<ul>
<?php foreach ($results as $row): ?>
  <li><?= htmlspecialchars($row['name'] . ' is ruled by ' . $row['head_of_state']); ?></li>
<?php endforeach; ?>
</ul>