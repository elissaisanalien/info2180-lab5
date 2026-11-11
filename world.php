<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Read request variables (defaults: empty search, country lookup)
$country = $_GET['country'] ?? '';
$lookup  = $_GET['lookup'] ?? 'country';

// An empty country becomes '%%', which matches everything
$like = "%$country%";

if ($lookup === 'cities') {
    // Exercise 5: JOIN countries and cities to get the cities of matching countries
    $stmt = $conn->prepare(
        "SELECT c.name, c.district, c.population
         FROM cities c
         JOIN countries cs ON c.country_code = cs.code
         WHERE cs.name LIKE :country
         ORDER BY c.population DESC"
    );
    $headers = ['Name', 'District', 'Population'];
    $columns = ['name', 'district', 'population'];
} else {
    // Exercise 3/4: country information
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $headers = ['Name', 'Continent', 'Independence', 'Head of State'];
    $columns = ['name', 'continent', 'independence_year', 'head_of_state'];
}

$stmt->execute([':country' => $like]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<table>
  <thead>
    <tr>
<?php foreach ($headers as $header): ?>
      <th><?= htmlspecialchars($header); ?></th>
<?php endforeach; ?>
    </tr>
  </thead>
  <tbody>
<?php foreach ($results as $row): ?>
    <tr>
<?php foreach ($columns as $column): ?>
      <td><?= htmlspecialchars($row[$column] ?? ''); ?></td>
<?php endforeach; ?>
    </tr>
<?php endforeach; ?>
  </tbody>
</table>