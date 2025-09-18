# ApplyBox

ApplyBox is an application tracking system designed to help job seekers manage their job applications, keep track of important documents, and stay organized during the job search process.

## Motivation

Job hunting can be an overwhelming and complex process. As someone who has experienced this firsthand, I found myself struggling to keep track of all my applications across multiple companies, different stages of the hiring process, and various documents (resumes, cover letters, etc.) customized for each position.

I created ApplyBox to solve these challenges:

- **Organization**: Say goodbye to scattered spreadsheets, notes, and documents. ApplyBox provides a central hub for all your job search activities.
- **Visibility**: Get a clear picture of your application status with a comprehensive dashboard that shows where you stand in each process.
- **Documentation**: Store all application-related files in one place, making it easy to retrieve the specific resume version or cover letter you sent to a company.
- **Follow-up**: Never miss an opportunity by tracking which applications need follow-up and when.
- **Data-Driven Strategy**: Analyze your job search patterns to improve your approach, understand which industries you're targeting most, and see conversion rates at each application stage.

Whether you're actively looking for your next role or simply building a system to track future career opportunities, ApplyBox helps transform the chaotic job search process into a structured, manageable journey.

## Features

- Track job applications with detailed information (position, status, notes)
- Store company details including industry, contact info, and website
- Manage HR contacts for each company
- Upload and manage application-related documents
- Dashboard with application statistics and charts
- Simple single-user authentication

## Tech Stack

- **Framework:** [Laravel](https://laravel.com)
- **Admin Panel:** [FilamentPHP](https://filamentphp.com)
- **Database:** MySQL
- **File Storage:** [Spatie Media Library](https://github.com/spatie/laravel-medialibrary)

## Installation

1. Clone the repository
   ```bash
   git clone https://github.com/yourusername/applybox.git
   cd applybox
   ```

2. Install PHP dependencies
   ```bash
   composer install
   ```

3. Copy the environment file and configure your database
   ```bash
   cp .env.example .env
   ```

4. Generate application key
   ```bash
   php artisan key:generate
   ```

5. Run migrations and seed the database
   ```bash
   php artisan migrate --seed
   ```

6. Link storage directory
   ```bash
   php artisan storage:link
   ```

7. Serve the application
   ```bash
   php artisan serve
   ```

## Usage

1. Access the admin panel at `/admin`
2. Login using the default credentials:
   - Email: admin@applybox.com
   - Password: password
3. Start tracking your job applications!

### Managing Companies

Add companies you're applying to with details like:
- Company name
- Industry
- Contact information
- Website

### HR Contacts

Keep track of your contacts at each company:
- Name
- Position
- Email and phone

### Applications

Track every job application:
- Position details
- Application date
- Current status (applied, interview, offer, rejected, or withdrawn)
- Notes about the application
- Upload relevant documents (resume, cover letter, etc.)

## Dashboard

The dashboard provides an overview of your job search:
- Total applications count
- Active applications
- Number of companies
- Application status chart

## Security

This application is designed for personal use with a single user account. All data is stored locally in your database.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
