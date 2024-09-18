# Job Portal Website

Welcome to the **Job Portal**, a platform built using Laravel that connects employers with job seekers. The site provides a seamless experience for both employers looking to post job opportunities and candidates searching for jobs.

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=Laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=PHP&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=MySQL&logoColor=white)
![HTML](https://img.shields.io/badge/HTML-E34F26?style=for-the-badge&logo=HTML5&logoColor=white)
  ![CSS](https://img.shields.io/badge/CSS-1572B6?style=for-the-badge&logo=CSS3&logoColor=white)
  ![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
   ![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=Bootstrap&logoColor=white)
   ![jQuery](https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jQuery&logoColor=white)
## Features

- **Job Listings**: Employers can create and manage job postings.
- **Job Search**: Job seekers can browse and apply to available job listings.
- **User Authentication**: Separate login for job seekers and employers.
- **Profile Management**: Job seekers can upload resumes and manage profiles.
- **Application Tracking**: Employers can review and track job applications.
- **Responsive Design**: Fully optimized for mobile and desktop devices.

## Demo

A live demo of the site can be accessed [here](#).

## Installation

### Prerequisites
- PHP >= 7.3
- Composer
- MySQL
- Node.js & npm (for frontend assets)

### Steps

1. **Clone the Repository**
   ```bash
   git clone https://github.com/YuriiLohvynenko/Laravel-jobsite.git
   cd Laravel-jobsite

2. **Install Dependencies**
   ```bash
   composer install
   npm install

3. **Environment Setup** Copy the .env.example file to create your .env configuration:
   ```bash
   cp .env.example .env

Update the .env file with your database and other configurations:
   ```bash
   APP_NAME=JobPortal
   APP_URL=http://localhost
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password

4. **Generate Application Key**
   ```bash
   php artisan key:generate

5. **Run Migrations** Run the database migrations to set up the required tables:
   ```bash
   php artisan migrate

6. **Seed the Database** (Optional) Populate the database with sample data using the seeders:
   ```bash
   php artisan db:seed

7. **Compile Frontend Assets**
   ```bash
   npm run dev

8. **Start the Application**
   ```bash
   php artisan serve

*Visit the application at http://localhost:8000.*

### Usage
- **Job Seekers:** Register, complete your profile, and start applying for jobs.
- **Employers:** Register, post job listings, and manage applications from your dashboard.

### Technology Stack
- **Backend:** Laravel 8 (PHP)
- **Database:** MySQL
- **Frontend:** Blade, Bootstrap
- **Authentication:** Laravel Breeze
- **Email Notifications:** Laravel Mail (configured with SMTP)
- **API Integration:** REST API for job applications

### Contributing
Contributions are welcome! Please follow the contribution guidelines.
   1. Fork the repository.
   2. Create a new branch (git checkout -b feature/your-feature).
   3. Commit your changes (git commit -am 'Add some feature').
   4. Push to the branch (git push origin feature/your-feature).
   5. Create a new Pull Request.

## License
This project is open-source and licensed under the MIT License.

Thank you for using the Job Portal! If you find this project useful, please consider giving it a ⭐ on GitHub!