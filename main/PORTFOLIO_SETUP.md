# Portfolio Laravel Setup

## Run locally

```bash
cd E:\xampp\htdocs\Tech_Profile_VP-main\laravel_build
php artisan serve --host=127.0.0.1 --port=8000
```

Open:

- Portfolio: http://127.0.0.1:8000
- Admin panel: http://127.0.0.1:8000/vpadmin

## Default admin login

- Username: `admin`
- Password: `admin123`

After login, open Settings and change the admin username/password.

## Admin features

- Edit portfolio content and SEO title/description/keywords.
- View portfolio popularity count.
- Read contact form messages submitted from the frontend.

## Database

The project uses SQLite:

```text
database/database.sqlite
```

If you move the project, run:

```bash
composer install
php artisan key:generate
php artisan migrate
```
