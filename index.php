<?php
    //Подключение к файлу
    require_once 'vacancy.php';
    //Создаём объект класса
    $fetcher = new Vacancy();
    //Переводим объект класса в массив
    $vacancies = $fetcher->getVacancy();
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
    <title>Яндекс вакансии</title>
</head>
<body>
    <section class="hero">
        <h1>Яндекс вакансии</h1>
        <?php
            // Вывод списка йоу
            echo '<ul class = "vacancy-list">';
            foreach ($vacancies['items'] as $vacancy) {
                // Форматируем зарплату
                $salary = 'Не указана';
                if ($vacancy['salary']) {
                    $s = $vacancy['salary'];
                    $from = $s['from'] ?? null;
                    $to = $s['to'] ?? null;
                    $currency = $s['currency'] ?? 'RUR';
                    
                    if ($from && $to) {
                        $salary = "$from-$to $currency";
                    } elseif ($from) {
                        $salary = "от $from $currency";
                    } elseif ($to) {
                        $salary = "до $to $currency";
                    }
                }
                // Выводим пункт списка
                echo '<li>';
                echo '<h2>' . htmlspecialchars($vacancy['name']) . '</h2>';
                echo '<p><strong>Зарплата: </strong>' . htmlspecialchars($salary) . '</p>';
                echo '<div class = "links-main">';
                echo '<a href="vacancy-details.php?id=' . htmlspecialchars($vacancy['id']) . '">Подробнее о вакансии</a>';
                echo '<a href="'. $vacancy['alternate_url'] . '" target="_blank">Вакансия на hh.ru</a>';
                echo '</div>';
                echo '</li>';
            }
            echo '</ul>';
        ?>
    </section>
</body>
</html>