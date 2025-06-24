<?php
    // Создаём класс
    class Vacancy{
        // Свойство класса
        private $employeId;
        // Конструктор класса
        public function __construct($employeId = 1740)
        {
            $this->employeId = $employeId;
        }
        //Метод дя получения всех вакансий
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
        // Метод получения вакансии по её ID
        public function getVacancyId($vacancyId){
            $url =  "https://api.hh.ru/vacancies/" . $vacancyId;
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_USERAGENT, 'HH-Parse/1.0');
            $response = curl_exec($curl);
            curl_close($curl);
            return json_decode($response, true);
        }
    }
?>