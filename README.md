<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Тестовый проект API</h1>
</p>

Базируется на фреймворке [Yii 2](https://www.yiiframework.com/)
REQUIREMENTS
------------

Минимальные требования: 
- PHP 7.4
- composer v2
- MySQL 5.7
- Apache 2.4 или Nginx 1.18

Установка
------------

### Предварительная настройка

#### Устанавливаем переменные окружения
- `DB_EXAMPLE_HOST` - хост базы данных
- `DB_EXAMPLE_NAME` - имя базы данных
- `DB_EXAMPLE_USER` - пользователь базы данных
- `DB_EXAMPLE_PASSWORD` - пароль базы данных
- `EXAMPLE_SECRET_KEY` - секретный ключ для сигнатуры

Пример установки переменных окружения:
```bash
export DB_EXAMPLE_HOST=localhost
export DB_EXAMPLE_NAME=example
export DB_EXAMPLE_USER=root
export DB_EXAMPLE_PASSWORD=1234
export EXAMPLE_SECRET_KEY=secret
```

### Клонируем репозиторий
```bash
git clone
```

### Переходим в проект и устанавливаем зависимости
```bash
cd example
composer install
```

### Для Apache настраиваем виртуальный хост
```apacheconfig
<VirtualHost *:80>
    ServerName example.local
    DocumentRoot /path/to/example/web
    <Directory /path/to/example/web>
        AllowOverride All
        Order Allow,Deny
        Allow from all
    </Directory>
</VirtualHost>
```

### Для Nginx настраиваем виртуальный хост (но это не точно)
```nginxconfig
server {
    charset utf-8;
    client_max_body_size 128M;

    listen 80; ## listen for ipv4
    #listen [::]:80 default_server ipv6only=on; ## listen for ipv6

    server_name example.local;
    root        /path/to/example/web;
    index       index.php;

    access_log  /path/to/example/log/access.log;
    error_log   /path/to/example/log/error.log;

    location / {
        # Redirect everything that isn't a real file to index.php
        try_files $uri $uri/ /index.php$is_args$args;
    }

    # uncomment to avoid processing of calls to non-existing static files by Yii
    #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
    #    try_files $uri =404;
    #}
    #error_page 404 /404.html;

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        #fastcgi_pass
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        try_files $uri =404;
    }
    
    location ~ /\.(ht|svn|git) {
        deny all;
    }
}
```

### Создаем схему базы данных и пользователя (при необходимости)
```mysql
CREATE DATABASE IF NOT EXISTS `example` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;


CREATE USER IF NOT EXISTS 'example'@'localhost' IDENTIFIED BY '1234';
GRANT ALL PRIVILEGES ON `example`.* TO 'example'@'localhost';
FLUSH PRIVILEGES;
```

### Применяем миграции
```bash
./yii migrate
```

### Примеры работы с API в Postman
[![Run in Postman](https://run.pstmn.io/button.svg)](https://api.getpostman.com/collections/31845340-c6559c78-b4f1-45f0-8e68-0b6df3dcc6df)

### Документация по API (OpenAPI) смотреть в файле `readmi-api.json`

### Внимание! Тесты не реализованы, мусор в проекте не убран (Асеты). Конфиг не оптимален.