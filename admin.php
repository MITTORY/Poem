<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Подключение к базе данных
$conn = new mysqli('localhost', 'username', 'password', 'poems_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Добавление стиха
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_poem'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);

    $sql = "INSERT INTO poems (title, content) VALUES ('$title', '$content')";
    if ($conn->query($sql) === TRUE) {
        echo "Стих успешно добавлен!";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
}

// Удаление стиха
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM poems WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Стих успешно удален!";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
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
    <title>Админ-панель</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Админ-панель</h1>
        </div>
    </header>

    <main>
        <section class="poem">
            <h2>Добавить стих</h2>
            <form method="POST" action="">
                <label for="title">Заголовок:</label>
                <input type="text" id="title" name="title" required>
                <label for="content">Содержание:</label>
                <textarea id="content" name="content" rows="10" required></textarea>
                <button type="submit" name="add_poem">Добавить</button>
            </form>
        </section>

        <section class="poem">
            <h2>Список стихов</h2>
            <?php foreach ($poems as $poem): ?>
                <div class="poem-item">
                    <h3><?= htmlspecialchars($poem['title']) ?></h3>
                    <pre><?= htmlspecialchars($poem['content']) ?></pre>
                    <a href="?delete=<?= $poem['id'] ?>" onclick="return confirm('Вы уверены?')">Удалить</a>
                </div>
            <?php endforeach; ?>
        </section>
    </main>

    <footer>
        <p>© 2025 Админ-панель. Все права защищены.</p>
    </footer>
</body>
</html>