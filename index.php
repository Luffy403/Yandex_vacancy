<?php
    // Старый код без ООП

    // URL для JSON
    // $url = "https://api.hh.ru/vacancies?employer_id=1740";

    // // Инициализация cURL
    // $curl = curl_init($url);
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($curl, CURLOPT_USERAGENT, 'HH-Parser/1.0');

    // // Получаем данные
    // $response = curl_exec($curl);
    // curl_close($curl);

    // // Декодируем JSON
    // $data = json_decode($response, true);


    //Код с ООП
    // Создаём класс
    class Vacancy{
        // Свойство класса
        private $employeId;
        // Конструктор класса
        public function __construct($employeId = 1740)
        {
            $this->employeId = $employeId;
        }
        //Метод класса
        public function getVacancy(){
            //URL для JSON
            $url = "https://api.hh.ru/vacancies?employer_id=" . $this->employeId;
            // Инициализация cURL
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_USERAGENT, 'HH-Parser/1.0');
            // Получаем данные
            $response = curl_exec($curl);
            curl_close($curl);
            // Декодируем JSON
            return json_decode($response, true);
        }
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
    <title>Яндекс вакансии</title>
</head>
<body>
    <section class="hero">
        <h1>Яндекс вакансии</h1>
        <?php
            //Создаём объект класса
            $fetcher = new Vacancy();
            //Переводим объект класса в массив
            $vacancies = $fetcher->getVacancy();
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
                echo '<p><strong>Зарплата: </stong>' . htmlspecialchars($salary) . '</p>';
                echo '<a href="'. $vacancy['alternate_url'] . '" target="_blank">Вакансия на hh.ru</a>';
                echo '</li>';
            }
            echo '</ul>';
        ?>
    </section>
</body>
</html>