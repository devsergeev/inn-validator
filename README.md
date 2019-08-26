# Валидатор ИНН
Валидирует ИНН (идентификационный номер налогоплательщика) как физлица (12 цифр), так и юрлица (10 цифр). Осуществляет
проверку того, что ИНН удовлетворяет следующим условиям (см [википедию]( https://ru.wikipedia.org/wiki/%D0%98%D0%B4%D0%B5%D0%BD%D1%82%D0%B8%D1%84%D0%B8%D0%BA%D0%B0%D1%86%D0%B8%D0%BE%D0%BD%D0%BD%D1%8B%D0%B9_%D0%BD%D0%BE%D0%BC%D0%B5%D1%80_%D0%BD%D0%B0%D0%BB%D0%BE%D0%B3%D0%BE%D0%BF%D0%BB%D0%B0%D1%82%D0%B5%D0%BB%D1%8C%D1%89%D0%B8%D0%BA%D0%B0)):

* состоит из 10 или 12 символов
* состоит только из цифр
* имеет правильную котрольную сумму

При неудовлетворении какого-либо из условий выбрасывает исключение `InvalidArgumentException` с соответствующим сообщением в `InvalidArgumentException::$message`.

### Установка с помощью composer
````
composer require devsergeev/inn-validator
````
### Пример использования

````
try {
    \devsergeev\validators\InnValidator::check($inn);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage();
}
````