# Название вашего проекта

## Развертывание с использованием Docker

### Предварительные требования

- Docker
- Docker Compose

### Шаги по развертыванию

1. Клонируйте репозиторий:
   git clone https://github.com/KalyaginVasiliy/TigratikaTest.git
   cd TigratikaTest


2. Скопируйте файл .env.example в .env и настройте переменные окружения:

cp .env.example .env


Откройте файл .env и настройте переменные окружения, особенно те, которые связаны с базой данных.

3. Соберите и запустите Docker-контейнеры:

docker-compose up -d --build


4. Установите зависимости PHP через Composer:

docker-compose exec app composer install


5. Установите зависимости JavaScript и соберите фронтенд:

docker-compose exec app npm install
docker-compose exec app npm run build


6. Выполните миграции базы данных:

docker-compose exec app php artisan migrate


7. Сгенерируйте ключ приложения:

docker-compose exec app php artisan key:generate


8. Очистите кэш конфигурации:

docker-compose exec app php artisan config:cache


9. Приложение будет доступно по адресу http://localhost:8000

### Остановка приложения

Чтобы остановить и удалить контейнеры, сети и тома, выполните:

docker-compose down -v


### Полезные команды

- Просмотр логов: `docker-compose logs`
- Перезапуск контейнеров: `docker-compose restart`
- Выполнение команды в контейнере приложения: `docker-compose exec app your-comma
