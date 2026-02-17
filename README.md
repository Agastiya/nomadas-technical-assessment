## Loan Request Management (Laravel + Backpack)

This is a small Laravel 12 application (with Backpack admin) for managing loan requests.

You can:
- Create loan requests for users
- View all loan requests in an admin panel
- Update the status of a loan (for example: pending, approved, rejected)

The project is meant as a simple, complete example for a loan workflow.

---

## Requirements

Make sure these are installed on your machine:

- PHP ^8.2
- Composer (latest version)
- A database supported by Laravel (for this case I use MySQL)

---

## 1. Clone or download the project

```bash
git clone <this-repo-url>
cd nomadas-technical-assessment
```
---

## 2. Install PHP dependencies

```bash
composer install
```

If you get an error like `composer` is not recognized, install Composer from https://getcomposer.org and make sure it is added to your PATH (then reopen the terminal).

---

## 3. Configure environment

Copy the example environment file and generate the app key:

```bash
cp .env.example .env
php artisan key:generate
```

Then update the database section in `.env` with your database name, user and password.

Example (MySQL):

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=loan_app
DB_USERNAME=root
DB_PASSWORD=your_password
```

Create that database manually in your DB client if it does not exist.

---

## 4. Run migrations and seeders

This will create the tables and insert some sample data (users and loan requests if seeders are configured):

```bash
php artisan migrate --seed
```

---

## 6. Run the application

Start the local development server:

```bash
php artisan serve
```

By default the app will be available at:

- http://127.0.0.1:8000

If Backpack admin is configured, you can usually access it at something like:

- http://127.0.0.1:8000/admin

Log in with the seeded admin user (check the seeders or database for the exact email/password) or create a user manually.

---

## Summary

1. Install PHP and Composer
2. Clone project and run `composer install`
3. Copy `.env` and configure database
4. Run `php artisan migrate --seed`
5. Run `php artisan serve` and open the URL shown in the terminal

After these steps, you should have a working loan request management app running locally.
