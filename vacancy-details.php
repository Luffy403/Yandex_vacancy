<?php 
    //Подключение к файлу
    require_once 'vacancy.php';
    //Получаем ID вакансии
    if(!isset($_GET['id']) || empty(['id'])){
        die ('id не получен');
    }
    //Создаём переменную для хранения id вакансии
    $vacancyId = $_GET['id'];
    // Создаём объект класса 
    $fetchers  = new Vacancy();
    // Создаём массив с данными о вакансии
    $vacancy = $fetchers->getVacancyId($vacancyId);
    // проверка на пустоту массива
    if(!$vacancy){
        die('Вакансия не найдена');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="svg/Bleach.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title><?= htmlspecialchars($vacancy['name']) ?></title>
</head>
<body>
    <section class="hero-details">
        <!-- Название вакансии -->
        <h1> <?= htmlspecialchars($vacancy['name'])?></h1>
        <?php  
            // Форматируем зарплату
            $salary = 'Не указана';
            if ($vacancy['salary']) {
                $s = $vacancy['salary'];
                $from = $s['from'] ?? null;
                $to = $s['to'] ?? null;
                $currency = $s['currency'] ?? 'RUR';
                // Распределение зарплаты
                if ($from && $to) {
                    $salary = "$from-$to $currency";
                } elseif ($from) {
                    $salary = "от $from $currency";
                } elseif ($to) {
                    $salary = "до $to $currency";
                }
            }
        ?>
        <p><strong>Зарплата:</strong><?= htmlspecialchars($salary) ?></p>
        <!--  Проверка на существование описания -->
        <?php if(isset($vacancy['description'])): ?>
            <div class="description">
                <h2>Описание</h2>
                <?= strip_tags($vacancy['description'], '<p><strong><em><ul><ol><li><br>') ?>
            </div>
        <?php endif; ?>
        <!-- Проверка на существования опыта -->
        <?php if(isset($vacancy['experience'])):?>
            <div class="experience">
                <p><strong>Требуемый опыт:</strong> <?= htmlspecialchars($vacancy['experience']['name']) ?></p>
            </div>
        <?php endif; ?>
        <!-- Проверка на сущетсования навыков -->
        <?php if(isset($vacancy['key_skills']) && !empty($vacancy['key_skills'])) :?>
            <div class="key_skills">
                <strong>Ключевые навыки:</strong>
                <ul>
                    <?php foreach($vacancy['key_skills'] as $skill): ?>
                        <li><?= htmlspecialchars($skill['name']) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <!-- Ссылки на обратную страницу и на ваканисию hh-->
        <div class="links">
            <a href="index.php">Назад к списку вакансий</a>
            <a href= "<?php echo htmlspecialchars($vacancy['alternate_url']) ?>" target="_blank">Вакансия на hh</a>
        </div>
    </section>
</body>
</html>