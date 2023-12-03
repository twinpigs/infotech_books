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

СПАСИБО
-------------------
За то что задание было в RTF, а не в DOCX, это правильно.

INSTALLATION
------------

### Install with Docker
    
Подтянуть либы

    docker-compose run --rm php composer install    
    
Start the container

    docker-compose up -d

Накатить миграции

    docker-compose run php php yii migrate

#### Под линуксом дополнительно:
Будет полезно дать права на папки: для ассетов, обложек и очередей. В первую очередь для ассетов, потому что папка
web создается под юзером хоста, а ассеты создаются уже под контейнером и сразу валится сайт, потому что не может же создать
остальное просто для удобства уже до кучи там широко охвачено.
```bash
chmod -R 777 web
chmod -R 777 runtime
```
    
Теперь можно лицезреть:

    http://127.0.0.1:8000

Логин:пароль от "юзера" (в терминах задачи) admin:admin
По задаче, чтобы подписаться на автора под "гостем", необходимо выйти из "юзера".

Чтобы заработали чудо-очереди, перед тем, как апдейтить/создавать книги с авторами, на которых есть подписки:

    docker-compose run php php yii queue/listen

Потом смотреть лог, с понатыканым туда "дебагом" (смс же не отправляются).

CONFIGURATION
-------------

Все конфигурации закоммичены прямо в гит, вместе с их секретными паролями и ключами. Правда удобно? )))