# Agriman-Framer

Agriman — Agriculture Management System. A PHP/MySQL marketplace where farmers sell produce (Farmer's Market), buy supplies (Farmer's Kit), hire workers, read articles, and check the farm weather forecast.

## Run with Docker (recommended)

Requires [Docker Desktop](https://www.docker.com/products/docker-desktop/).

```bash
docker compose up -d --build
```

Then open **http://localhost:8090**

- The web container runs PHP 8.2 + Apache with the `Source Code/` app.
- The MySQL 8 container automatically imports `Database Backup/agribuzzpro.sql` into the `agrimanpro` database on first start.
- Database credentials are passed to the app via environment variables (`DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`) set in `docker-compose.yml`.

To stop:

```bash
docker compose down
```

To reset the database (re-import the SQL dump on next start):

```bash
docker compose down -v
```

## Run with WAMP/XAMPP (manual)

1. Copy the `Source Code/` folder into your web root (e.g. `C:\wamp64\www\`).
2. Create a MySQL database named `agrimanpro` and import `Database Backup/agribuzzpro.sql`.
3. Adjust DB credentials in `Source Code/config.php` if needed (defaults: host `localhost`, user `root`, empty password).
4. Open the site at `http://localhost/<folder>/index.php`.
