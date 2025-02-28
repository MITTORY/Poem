<?php
// Подключение к базе данных
$conn = new mysqli('localhost', 'username', 'password', 'poems_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение списка стихов
$poems = [];
$result = $conn->query("SELECT * FROM poems ORDER BY created_at DESC");
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $poems[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои стихотворения</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Мои стихотворения</h1>
            <p>Здесь хранятся мои мысли, чувства и переживания, выраженные в стихах.</p>
        </div>
    </header>

    <main>
        <?php foreach ($poems as $poem): ?>
            <section class="poem">
                <h2><?= htmlspecialchars($poem['title']) ?></h2>
                <pre><?= htmlspecialchars($poem['content']) ?></pre>
            </section>
        <?php endforeach; ?>
    </main>

    <footer>
        <p>© 2025 Мои стихотворения. Все права защищены.</p>
    </footer>
</body>
</html>