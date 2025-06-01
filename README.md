# API справочника организаций

2. Создание env файла `.env.example` в `.env`:
```bash
cp .env.example .env
```

3. В `.env` необходимо добавить API_KEY:
```bash
API_KEY=api_ключ
```

5. Запустить контейнеры:
```bash
docker-compose up -d
```

6. Выполнить миграции и добавить тестовые данные:
```bash
docker-compose exec app php artisan migrate --seed
```

7. Swagger UI:
```
http://localhost:80/api/documentation
```

8. Обновить swagger:
```bash
docker-compose exec app php artisan l5-swagger:generate
```

## Как пользоваться API
Для всех запросов нужен заголовок `X-API-Key` с ключом из `.env`.
