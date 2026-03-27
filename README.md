# Prompt Vault — prompt-app

A clean PHP/MySQL web app for managing and sharing AI prompts. Users can create prompts, admins manage categories and view contributors.

---

## Features

- **Role-based access** — separate experience for admins and developers
- **Prompt management** — create, edit, delete, and browse prompts
- **Category filtering** — filter prompts by category on the list page
- **Admin panel** — manage categories, view all prompts, and view top contributors ranked by prompt count
- **Secure authentication** — session-based login with hashed passwords
- **URL protection** — all pages redirect to login if accessed without a valid session

---

## Project Structure

```
prompt-app/
├── assets/
│   └── style.css              # Global stylesheet
├── auth/
│   ├── login.php              # Login page
│   ├── logout.php             # Destroys session and redirects to login
│   └── register.php           # Register new user (role: developer by default)
├── admin/
│   ├── dashboard.php          # Admin dashboard (admin only)
│   ├── categories.php         # Add / edit / delete categories (admin only)
│   ├── prompts.php            # View all prompts across all users (admin only)
│   └── top_contributors.php   # View users ranked by prompt count (admin only)
├── prompts/
│   ├── index.php              # Landing / redirect page
│   ├── prompts.php            # List all prompts with category filter (developer)
│   ├── create.php             # Add a new prompt
│   ├── edit.php               # Edit an existing prompt
│   └── delete.php             # Delete a prompt
├── includes/
│   └── designer&db.png        # Database schema diagram
├── config/
│   ├── db.php                 # PDO database connection
│   └── database.sql           # Database schema + sample data
└── README.md
```

---

## Setup

1. Import the database schema by running `config/database.sql`:
   ```
   mysql -u root -p < config/database.sql
   ```
   Or open **phpMyAdmin → Import** and select the file.
2. Open `config/db.php` and set your DB credentials:
   ```php
   $servername = "localhost";
   $port       = "3307";      // change to 3306 if using default MySQL port
   $username   = "root";
   $password   = "";
   $dbname     = "prompt_app";
   ```
3. Visit `http://localhost/autoformationphp/Prompt_Repository/prompt-app/auth/login.php`

---

## Roles

| Role        | Access                                                  |
|-------------|---------------------------------------------------------|
| `admin`     | Dashboard, manage categories, view top contributors, View prompts     |
| `developer` | View, create, edit, delete their own prompts            |

---

## Security

- All protected pages check `$_SESSION['user_id']` — direct URL access after logout redirects to login.
- Admin pages additionally check `$_SESSION['role'] === 'admin'`.
- Passwords are hashed with `password_hash()` / verified with `password_verify()`.
- All user output is escaped with `htmlspecialchars()`.
- Database queries use PDO prepared statements (no SQL injection risk).
