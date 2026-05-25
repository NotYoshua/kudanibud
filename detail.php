<?php
session_start();
require_once 'config/db.php';

// Получаем ID из URL и приводим к числу для безопасности
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ищем тур по ID
$stmt = $pdo->prepare('SELECT * FROM tours WHERE id = ?');
$stmt->execute([$id]);
$tour = $stmt->fetch();

// Если тура с таким ID нет — возвращаем в каталог
if (!$tour) {
    header('Location: catalog.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($tour['title']) ?> — КудаНибудь</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

<section class="container" style="padding: 60px 0;">
    <div style="display: flex; gap: 40px; align-items: start;">
        <img src="images/<?= htmlspecialchars($tour['image']) ?>" style="width: 50%; border-radius: 18px;">
        <div>
            <h1><?= htmlspecialchars($tour['title']) ?></h1>
            <p style="font-size: 18px; margin: 20px 0;"><?= htmlspecialchars($tour['description']) ?></p>
            <div class="price" style="font-size: 24px; font-weight: bold; color: #1976d2;">
                <?= number_format($tour['price'], 0, '.', ' ') ?> ₸
            </div>
            <br>
            <a href="catalog.php" class="btn btn-outline">Назад в каталог</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
</body>
</html>