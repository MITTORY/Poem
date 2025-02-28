<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Простая проверка (в реальном проекте используйте хеширование паролей)
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin'] = true;
        header('Location: admin.php');
        exit();
    } else {
        echo "Неверный логин или пароль!";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Вход в админ-панель</h1>
        </div>
    </header>

    <main>
        <section class="poem">
            <h2>Авторизация</h2>
            <form method="POST" action="">
                <label for="username">Логин:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Войти</button>
            </form>
        </section>
    </main>

    <footer>
        <p>© 2025 Вход в админ-панель. Все права защищены.</p>
    </footer>
</body>
</html>