# Валидатор ИНН

## Описание
Валидирует ИНН (идентификационный номер налогоплательщика) как физлица (12 цифр), так и юрлица (10 цифр). Осуществляет
проверку того, что ИНН удовлетворяет следующим условиям (см [википедию]( https://ru.wikipedia.org/wiki/%D0%98%D0%B4%D0%B5%D0%BD%D1%82%D0%B8%D1%84%D0%B8%D0%BA%D0%B0%D1%86%D0%B8%D0%BE%D0%BD%D0%BD%D1%8B%D0%B9_%D0%BD%D0%BE%D0%BC%D0%B5%D1%80_%D0%BD%D0%B0%D0%BB%D0%BE%D0%B3%D0%BE%D0%BF%D0%BB%D0%B0%D1%82%D0%B5%D0%BB%D1%8C%D1%89%D0%B8%D0%BA%D0%B0)):

* состоит из 10 или 12 символов
* состоит только из цифр
* имеет правильную котрольную сумму

### Установка с помощью composer
````
composer require devsergeev/inn-validator
````
### Пример использования

````
use \devsergeev\validators\InnValidator;

try {
    InnValidator::check($inn);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage();
    echo $e->getCode();
}
````

Метод `InnValidator::check(string $inn)` возвращает `true`, если строка `$inn` является валидным ИНН. В противном случае
будет выброшено исключение с соответствующим сообщением об ошибке. 

Несмотря на то, что валидатор имеет встроенные сообщения об ошибках ИНН, вы можете задать свои сообщения:
````
use \devsergeev\validators\InnValidator;

InnValidator::$messageInvalidLenght   = 'Ваше сообщение о недопустимой длине ИНН';
InnValidator::$messageOnlyDigits      = 'Ваше сообщение о том, что ИНН должен состоять только из цифр';
InnValidator::$messageInvalidChecksum = 'Ваше сообщение о неправильной контрольной сумме';

try {
    InnValidator::check($inn);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage();
}
````
Пример использования кодов исключения и альтернативная реализация своих сообщений:
````
use \devsergeev\validators\InnValidator;

try {
    InnValidator::check($inn);
} catch (InvalidArgumentException $e) {
    switch ($e->getCode()) {
        case InnValidator::CODE_INVALID_LENGHT:
            $message = 'Ваше сообщение о недопустимой длине ИНН';
            break;
        case InnValidator::CODE_NOT_ONLY_DIGITS:
            $message = 'Ваше сообщение о том, что ИНН должен состоять только из цифр';
            break;
        case InnValidator::CODE_INVALID_CHECKSUM:
            $message = 'Ваше сообщение о неправильной контрольной сумме';
            break;
    }
    echo $message;
}
````

## Docker-compose для разработки

Создать docker-compose
````
docker-compose -f ./docker/docker-compose.yml --env-file ./docker/.env up
````
Запустить bash
````
docker-compose -f ./docker/docker-compose.yml --env-file ./docker/.env run --rm php-cli bash
````

Установить зависимости
````
composer install
````

Запустить тесты
````
vendor/bin/phpunit
````
