Lis & Relis 📚
Lis & Relis is a web-based library management application designed to help users borrow and return books, while providing administrators with tools to manage users, books, authors, and genres. The application is built using PHP with an MVC architecture, leveraging modern web technologies and tools like PHPMailer and Composer for efficient development and functionality.
Table of Contents

Features
Technologies Used
Installation
Usage
Project Structure
Screenshots
Contributing
License

Features

User Features:

Search for books by title, author, or genre.
View detailed information about books, including availability.
Borrow and return books.
Access borrowing history.
User profile management.


Admin Features:

Manage books, authors, and genres (add, edit, delete).
View user details and their borrowing history.
Send email reminders to users for book returns using PHPMailer.
Return books on behalf of users.


General Features:

Responsive design using Bootstrap.
Dark mode support for better user experience.
Landing page with login and registration options.



Technologies Used

Backend:

PHP (with MVC architecture)
MySQL (for database management)
PHPMailer (for sending email notifications)
Composer (for dependency management)


Frontend:

HTML, CSS, JavaScript
Bootstrap 5.3.5 (for responsive design)
Custom CSS with support for dark mode
Google Fonts (Dancing Script for typography)


Tools:

XAMPP (local development environment)
Git (version control)



Installation
Follow these steps to set up the project locally:

Clone the Repository:
git clone https://github.com/your-username/lis-relis.git
cd lis-relis


Set Up the Environment:

Ensure you have XAMPP (or a similar local server) installed.
Copy the project folder to C:\xampp\htdocs\ (or your server's root directory).


Configure the Database:

Create a MySQL database named lisrelis.
Import the database schema from database.sql (if available in the repository).
Update the database configuration in app/config/database.php with your credentials:define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'lisrelis');




Install Dependencies:

Ensure Composer is installed on your system.
Run the following command in the project root to install PHPMailer and other dependencies:composer install




Set Up Email Notifications:

Configure PHPMailer in app/config/email.php (or similar) with your SMTP settings (e.g., Gmail SMTP):$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'your-email@gmail.com';
$mail->Password = 'your-app-password';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;




Start the Server:

Start XAMPP (Apache and MySQL).
Open your browser and navigate to http://localhost/lisrelis/public/.



Usage

Access the Landing Page:

Visit http://localhost/lisrelis/public/ to see the landing page.
Click "Se connecter" to log in or "S'inscrire" to register.


User Role:

Log in with a user account (role 1).
Search for books, view details, and borrow available books.
Check your borrowing history in the "Historique" section.


Admin Role:

Log in with an admin account (role 0).
Manage books, authors, and genres from the respective sections.
View user details and manage their borrowings in the "Profil Admin" section.
Send email reminders to users for overdue books.



Project Structure
lis-relis/
├── app/
│   ├── config/           # Configuration files (database, email, etc.)
│   ├── controllers/      # MVC controllers (e.g., LandingController.php)
│   ├── models/           # MVC models (e.g., Livre.php, Emprunt.php)
│   └── views/            # MVC views (e.g., landing.php, accueil.php)
├── public/               # Publicly accessible files
│   ├── assets/           # Images, fonts, etc.
│   ├── css/              # CSS files (e.g., landing.css)
│   ├── js/               # JavaScript files (e.g., landing.js)
│   └── index.php         # Entry point for routing
├── composer.json         # Composer dependencies
└── README.md             # Project documentation

Screenshots
Landing Page

User Dashboard

Admin Panel

(Note: Replace the screenshot paths with actual images after adding them to your repository.)
Contributing
Contributions are welcome! To contribute:

Fork the repository.
Create a new branch (git checkout -b feature/your-feature).
Make your changes and commit them (git commit -m "Add your feature").
Push to your branch (git push origin feature/your-feature).
Open a pull request.

Please ensure your code follows the project's coding standards and includes appropriate documentation.
License
This project is licensed under the MIT License - see the LICENSE file for details.
