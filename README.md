
# Job Finder

Basic job management system to facilitate the interaction between employers
and candidates.

## Dependencies(versions used for developemnts)
```bash
PHP 7.3.33
Composer 1.10.1
Node v10.24.1
npm 6.14.12
Mysql 8.0.35
```

## Project Setup (run in root directory & copy .example.env as .env and update databse configurations)
```bash
composer install
npm install
php artisan migrate:refresh --seed
php artisan key:generate
php artisan storage:link
php artisan config:clear
```

## run project (from root directory)
```bash
php artisan serve
npm run watch
```

## Features

- This system utilizes JWT authentication.
- It is developed using Laravel and Vue.js.
- There are three types of users in the system: Super admin, Employers, and Candidates.
- Employers can register and log in to the system.
- Employers can post jobs and manage them (create, edit, delete).
- Employers can check the status of each job (review applications).
- Candidates can register and log in to the system.
- Candidates can view jobs from the home page and click to view more details.
- Candidates can apply to any job by providing required details such as name, email, and resume.
- Each user can view their profile information.
- The Super admin has the ability to perform all tasks in the system, including user management which is not available to other users.
- The Super admin can deactivate any user at any time, preventing them from logging into the system. The Super admin can also manage any job posted by anyone.


## Authors

- [@shasika](shasikamadushan555@gmail.com)

## Other (Super admin login)
```bash
Email - admin@gmail.com
Password - 123456
```
