# DriveN School 🚗

A modern driving school website built to help students explore driving lessons, compare packages, read reviews, and book driving lessons online.

## ✨ Features

- Premium, responsive website design
- Home page with driving school information
- About Us page
- Driving lessons and services
- Driving lesson packages
- Customer reviews
- Online lesson booking form
- Student login and Admin login
- PHP backend with MySQL database
- JavaScript and jQuery interactions
- Bootstrap responsive layout

## 🛠️ Technologies Used

- HTML5
- CSS3
- Bootstrap 5+
- JavaScript
- jQuery
- PHP 8+
- MySQL
- XAMPP (local development)

## 📁 Project Structure

```text
drivenschool/
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── config/
│   └── db.php
├── database/
│   └── drivenschool.sql
├── includes/
├── index.php
├── about.php
├── services.php
├── packages.php
├── reviews.php
├── booking.php
├── login.php
├── admin.php
├── logout.php
└── README.md
```

*Note: The structure above is illustrative. Actual files may differ.*

## ⚙️ Installation and Setup

### 1. Install XAMPP

Install XAMPP with Apache, PHP, and MySQL/MariaDB.

### 2. Copy the Project

Place the project folder inside:

```text
C:\xampp\htdocs\drivenschool
```

If XAMPP is installed on another drive, use your actual project path.

### 3. Start XAMPP

Start these services in the XAMPP Control Panel:

- Apache
- MySQL

### 4. Create the Database

1. Open `http://localhost/phpmyadmin/`
2. Create a database named `drivenschool`.
3. Open the database and select **Import**.
4. Choose `database/drivenschool.sql`.
5. Click **Import** or **Go** to run the SQL file.

### 5. Configure the Database Connection

Check `config/db.php` and update the database host, database name, username, and password to match your local MySQL configuration.

Never commit real database passwords or private credentials to GitHub.

### 6. Run the Website

Open:

```text
http://localhost/drivenschool/
```

## 🗄️ Database Backup

The database backup is available at:

`database/drivenschool.sql`

Import this file into your local `drivenschool` database to restore the included database structure and any included data.

**Security:** Use only sample or non-sensitive data in a public repository. Do not upload real student information, credentials, or private records.

## 🔐 Admin Setup

Follow the project's local admin setup process, if provided, and use a strong password. Do not publish default credentials. Disable or remove any temporary admin setup script after creating the administrator account.

## 🚀 Future Improvements

- Enhanced booking management
- Improved student dashboard
- Appointment status tracking
- Stronger form validation and security
- Production deployment with HTTPS

## 👩‍💻 Author

DriveN School — Driving School Website Project

## 📄 License

Add a license file if you intend to specify how others may use or modify this project.
