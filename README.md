ЗАДАЧА
-------------------

Необходимо сделать на фреймворке Yii2 + MySQL каталог книг. Книга может иметь несколько авторов.

1. Книга - название, год выпуска, описание, isbn, фото главной страницы.
2. Авторы - ФИО.

Права на доступ:
1. Гость - только просмотр + подписка на новые книги автора.
2. Юзер - просмотр, добавление, редактирование, удаление.

Отчет - ТОП 10 авторов выпустивших больше книг за какой-то год.

ПЛЮСОМ БУДЕТ
Уведомление о поступлении книг из подписки должно отправляться на смс гостю.

https://smspilot.ru/
там "Для тестирования можно использовать ключ эмулятор (реальной отправки SMS не происходит)."


INSTALLATION
------------

### Install with Docker

Update your vendor packages

    docker-compose run --rm php composer update --prefer-dist
    
Run the installation triggers (creating cookie validation code)

    docker-compose run --rm php composer install    
    
Start the container

    docker-compose up -d

Накатить миграции

    docker-compose run php php yii migrate

#### Under Linux additionally:
Yii2 requires permissions to write to some folders. 
Assuming that we are making a quick installation for development needs without strict security requirements, we use the simplest way to grant these permissions:

```bash
chmod -R 777 web
chmod -R 777 runtime
```
    
You can then access the application through the following URL:

    http://127.0.0.1:8000

CONFIGURATION
-------------

Все конфигурации закоммичены прямо в гит, вместе с их секретными паролями и ключами. Правда удобно?