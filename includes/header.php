<header>
  <div class="container navbar">
    <div class="logo"><a href="index.php" style="text-decoration: none; color: #1976d2;">КудаНибудь</a></div>

    <ul class="menu">
      <li><a href="index.php">Главная</a></li>
      <li><a href="catalog.php">Туры</a></li>
      <li><a href="#">О нас</a></li>
      <li><a href="#">Отзывы</a></li>
      <li><a href="#">Контакты</a></li>
    </ul>

    <div class="buttons">
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="cabinet.php" class="btn btn-outline">Кабинет (<?= htmlspecialchars($_SESSION['user_name']) ?>)</a>
        <a href="logout.php" class="btn btn-primary" style="background: #dc3545; border-color: #dc3545;">Выйти</a>
      <?php else: ?>
        <a href="login.php" class="btn btn-outline">Войти</a>
        <a href="register.php" class="btn btn-primary">Регистрация</a>
      <?php endif; ?>
    </div>
  </div>
</header>