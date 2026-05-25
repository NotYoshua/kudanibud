<?php
session_start();
require_once 'config/db.php';

// 1. Получаем параметры из URL
$search = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? 'price_asc';

// 2. Формируем SQL-запрос
$sql = "SELECT * FROM tours";
$params = [];

// Добавляем поиск, если введен текст
if (!empty($search)) {
    $sql .= " WHERE title LIKE ?";
    $params[] = "%$search%";
}

// Добавляем сортировку
$allowed_sort = [
    'price_asc' => 'price ASC',
    'price_desc' => 'price DESC'
];
$sort_sql = $allowed_sort[$sort] ?? 'price ASC';
$sql .= " ORDER BY $sort_sql";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$tours = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Каталог туров — КудаНибудь</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

<section class="container" style="padding: 40px 0;">
    <h1>Каталог туров</h1>
    
    <form method="GET" action="catalog.php" style="margin: 20px 0; display: flex; gap: 10px;">
        <input type="text" name="search" placeholder="Поиск по названию..." value="<?= htmlspecialchars($search) ?>" style="padding: 10px; flex: 1;">
        
        <select name="sort" style="padding: 10px;">
            <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Сначала дешевые</option>
            <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Сначала дорогие</option>
        </select>
        
        <button type="submit" class="btn btn-primary">Найти</button>
    </form>

    <div class="cards" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
        <?php if (empty($tours)): ?>
            <p>Туров по вашему запросу не найдено.</p>
        <?php else: ?>
            <?php foreach ($tours as $tour): ?>
                <div class="card">
                    <img src="images/<?= htmlspecialchars($tour['image']) ?>" alt="<?= htmlspecialchars($tour['title']) ?>" style="width: 100%;">
                    <div class="card-body">
                        <h3><?= htmlspecialchars($tour['title']) ?></h3>
                        <p><?= htmlspecialchars($tour['description']) ?></p>
                        <div class="price" style="margin: 10px 0; font-weight: bold;">
                            от <?= number_format($tour['price'], 0, '.', ' ') ?> ₸
                        </div>
                        <a href="detail.php?id=<?= $tour['id'] ?>" class="btn btn-primary" style="display: block; text-align: center; text-decoration: none;">Подробнее</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
</body>
</html>