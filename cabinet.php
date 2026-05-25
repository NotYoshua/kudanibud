<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$message = '';

// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_profile'])) {
    $new_name = trim($_POST['name']);
    
    if (!empty($new_name)) {
        $stmt = $pdo->prepare('UPDATE users SET name = ? WHERE id = ?');
        $stmt->execute([$new_name, $_SESSION['user_id']]);
        
        // ОБЯЗАТЕЛЬНО обновляем имя в текущей сессии
        $_SESSION['user_name'] = $new_name;
        $message = 'Данные профиля успешно обновлены!';
    } else {
        $message = 'Имя не может быть пустым.';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Личный кабинет — КудаНибудь</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

<section class="container" style="padding: 60px 0;">
    <div style="background: white; padding: 40px; border-radius: 18px; box-shadow: 0 4px 18px rgba(0,0,0,0.08);">
        <h1>Ваш профиль</h1>
        
        <?php if ($message): ?>
            <p style="color: #1976d2; font-weight: bold; margin-bottom: 20px;"><?= $message ?></p>
        <?php endif; ?>

        <form method="POST">
            <div style="margin-bottom: 20px;">
                <label>Ваше имя</label>
                <input type="text" name="name" value="<?= htmlspecialchars($_SESSION['user_name']) ?>" required style="width: 100%; padding: 10px; margin-top: 5px;">
            </div>
            <div style="margin-bottom: 20px;">
                <label>Email (нельзя изменить)</label>
                <input type="email" value="<?= htmlspecialchars($_SESSION['user_email']) ?>" disabled style="width: 100%; padding: 10px; margin-top: 5px; background: #eee;">
            </div>
            <button type="submit" name="save_profile" class="btn btn-primary">Сохранить изменения</button>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
</body>
</html>