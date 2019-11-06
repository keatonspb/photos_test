**Установка**

`composer install`

`docker-compose up -d`

`docker-compose exec app php yii migrate`

Открываем http://127.0.0.1


**Заметки**

Отправка почты реализовано через filetransport. Результать можно посмотреть в debugbarе

Реализован простейший graphQL запрос для получения списка фоток
