# TigratikaTest

## Установка

1. Клонируйте репозиторий:
    ```bash
    git clone https://github.com/KalyaginVasiliy/TigratikaTest.git
    ```

2. Перейдите в директорию проекта:
    ```bash
    cd TigratikaTest
    ```

3. Установите зависимости через Composer:
    ```bash
    composer install
    ```

4. Скопируйте файл `.env.example` в `.env`:
    ```bash
    cp .env.example .env
    ```

5. Сгенерируйте ключ приложения:
    ```bash
    php artisan key:generate
    ```

6. Настройте параметры базы данных в файле `.env`.

7. Запустите миграции:
    ```bash
    php artisan migrate
    ```

## Запуск

1. Установите зависимости Node.js:
    ```bash
    npm install
    ```

2. Скомпилируйте файлы Vue.js:
    ```bash
    npm run dev
    ```

3. Запустите локальный сервер разработки Laravel:
    ```bash
    php artisan serve
    ```

4. Перейдите в браузере по адресу:
    ```
    http://localhost:8000
    ```

## Дополнительно

Для запуска тестов выполните команду:
```bash
php artisan test
