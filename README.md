# PhotoShare

PhotoShare is a PHP and MySQL photo sharing web application built using the MVC architecture.

## Technologies

- PHP
- MySQL
- HTML5
- CSS
- JavaScript
- Bootstrap

## Main Features

- User registration and login
- Secure password hashing
- Session-based authentication
- Last login cookie
- Photo upload
- Photo listing and details
- Delete own photos
- Comments on photos
- Responsive interface
- Server-side and client-side validation

## Project Structure

```text
PhotoShare_Project/
├── config/
├── core/
├── controllers/
├── models/
├── views/
├── public/
└── database.sql
```

## Database

The project uses a MySQL database named `alzikrayat`.

Import `database.sql` into MySQL before running the application.

## Running the Project

1. Put the project inside the web server directory.
2. Create/import the `alzikrayat` database using `database.sql`.
3. Check the database settings in `config/database.php`.
4. Make sure the web server and MySQL are running.
5. Open the project's `public` directory through the local web server.

## Security

- Passwords are stored using `password_hash()`.
- SQL statements use PDO prepared statements.
- Uploaded images are checked by MIME type and file size.
- Photo deletion checks the logged-in user's ownership.
- User output should be escaped when displayed in HTML.

## Authors

PhotoShare Project Team

