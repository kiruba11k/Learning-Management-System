# Learning Management System (LMS)
## Overview
This Learning Management System (LMS) is a web application built using PHP and MySQL designed to manage and deliver educational courses. The system allows for course creation, user management, lesson management, and more.

## Features
- Course Management: Create, update, and manage courses.
- User Management: User registration, login, and role-based access control (admin, student, etc.).
- Lesson Management: Add, update, and organize lessons within courses.
- Authentication: Secure login and registration system.
- Responsive Design: User-friendly and responsive interface using Bootstrap.
## Installation Guide
### Prerequisites
- PHP: 7.4 or higher
- MySQL: 5.7 or higher
- Apache/Nginx: Web server of your choice
- Composer (for dependency management)
### Steps to Install
1. Clone the Repository:
```
git clone https://github.com/kiruba11k/Learning-Management-System.git 

```


2. Navigate to the Project Directory:

```

cd Learning-Management-System
```
3. Install Dependencies:

Ensure you have Composer installed. Then, run:

```
composer install
```
4. Configure the Environment:

Copy the .env.example file to .env and update the database credentials:

```

cp .env.example .env
```
Open the .env file and set your database connection details:

makefile
```
DB_HOST=localhost
DB_NAME=lms
DB_USER=root
DB_PASS=password
```
5. Set Up the Database:

Create a database named lms (or use the name you specified in the .env file) and import the database schema:


-- Database schema SQL file (replace with actual file)
source path/to/database-schema.sql;

6. Run Migrations (if applicable):

If you are using a migration tool, run:

```
php artisan migrate
Set Up Permissions:
```
Ensure that the web server has the appropriate permissions to read/write necessary directories (e.g., storage and uploads directories).

7. Start the Web Server:

If you are using Apache or Nginx, configure your virtual host to point to the public directory of your project. For a quick development server, you can use:

```
php -S localhost:8000 -t public
```
Access the Application:

Open your web browser and navigate to http://localhost:8000 (or the URL configured in your web server).

## Usage
- Admin Panel: Access the admin dashboard to manage courses, users, and settings.
- User Registration: Users can register and log in to access courses and lessons.
- Course Creation: Admins can create and manage courses, including adding lessons and assigning them to specific users.
## Contributing
If you want to contribute to this project, please fork the repository, create a new branch, and submit a pull request with your changes. Ensure that you have tested your changes thoroughly before submitting.

## License
This project is licensed under the MIT License - see the LICENSE file for details.

## Contact
For any questions or issues, please contact kiruba11geo@gmail.com
