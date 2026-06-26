# User-Authentication-system

A simple full-stack user authentication system built with PHP and MySQL. Users can register an account, log in, view a protected dashboard, and log out. Built as a learning project to practice PHP, MySQL, sessions, and basic web security concepts.

## Features

- User registration with first name, last name, email, age, and gender
- Server-side form validation (required fields, name format, valid email, age range, password match)
- Passwords hashed with PHP's `password_hash()` (bcrypt) — never stored in plain text
- Duplicate email check on registration
- Login with email and password, verified using `password_verify()`
- Session-based authentication using native PHP sessions
- Protected dashboard page, accessible only when logged in
- Logout that fully destroys the session
- Centralized auth check (`auth.php`) reused across protected pages

## Tech Stack

- **Backend:** PHP (mysqli)
- **Database:** MySQL
- **Frontend:** HTML, CSS (no frameworks)

## Project Structure

```
user-authentication-system/
├── includes/
│   ├── db.php          # Database connection (mysqli)
│   └── auth.php        # Login-check helper functions
├── index.php            # Landing page (links to register/login)
├── register.php         # Registration form + handling
├── login.php             # Login form + handling
├── dashboard.php         # Protected page, requires login
├── logout.php            # Destroys session, redirects to login
├── style.css             # Shared styling for all pages
└── README.md
```

## Database Schema

```sql
CREATE DATABASE userauthentication;
USE userauthentication;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    age INT NOT NULL,
    gender ENUM('male', 'female') NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Setup & Installation

1. **Clone or download** this project into your local server's web root (e.g. `htdocs` for XAMPP, or any PHP-served folder).

2. **Create the database** using the schema above, either through SQLTools, phpMyAdmin, or the MySQL CLI:
   ```bash
   mysql -u root -p < schema.sql
   ```

3. **Configure the database connection** in `includes/db.php`:
   ```php
   $servername = 'localhost';
   $username = 'root';
   $password = 'your_password';
   $database = 'userauthentication';
   ```

4. **Start your local server** (e.g. `php -S localhost:8000`, or via XAMPP/WAMP/Laragon) and make sure MySQL is running.

5. Open `index.php` in your browser and start registering accounts.

## Usage

- **Register:** fill out the form on `register.php` to create an account.
- **Login:** enter your email and password on `login.php`.
- **Dashboard:** once logged in, you're redirected to `dashboard.php`, which greets you by name.
- **Logout:** click the logout link to end your session and return to the login page.

## Known Limitations / Roadmap

This is a learning project and intentionally incremental. Current known gaps:

- [ ] Queries currently use `mysqli_query()` with directly interpolated variables rather than prepared statements — **not safe for production**, planned as a follow-up security pass
- [ ] No rate limiting on login attempts
- [ ] No "remember me" or password reset functionality yet
- [ ] No CSRF protection on forms

## License

This project is for personal learning purposes.
