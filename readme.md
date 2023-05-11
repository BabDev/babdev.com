# BabDev Website

This is the source code for the babdev.com website

## Requirements

- PHP 8.1 or newer
- MySQL 5.7 or newer
- [Composer](https://getcomposer.org/download/)
- [Node.js](https://nodejs.org/en/) 16 or newer
- [NPM](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm) 7.10 or newer
- Optionally, a [GitHub personal access token](https://help.github.com/en/github/authenticating-to-github/creating-a-personal-access-token-for-the-command-line) to interact with the GitHub API

### Special Notes

This application is designed to run with two separate subdomains, one for the live website (i.e. `www.babdev.com`) and one for the Filament application (i.e. `filament.babdev.com`); this is done to allow the public facing portion of the website to have no sessions (as the functionality is not necessary).

## Installation

1. Clone this repository (`git clone git@github.com:BabDev/babdev.com.git babdev.com`)
2. Setup a new database on your MySQL server for the website
3. Copy the `.env.example` file to `.env` and fill in the required configuration:
    - Set the database connection info to the `DB_*` env vars
    - Set the `APP_DOMAIN_NAME` env var to the domain the main website exists at
    - Set the `FILAMENT_DOMAIN_NAME` env var to the domain the Filament application exists at
    - If you have one, set the `GITHUB_TOKEN` env var to your GitHub personal access token you created for the application
4. Install the PHP dependencies with `composer install`
5. Generate a new app key with `php artisan key:generate`
6. Prepare the database by running `php artisan migrate --seed`
7. Install and compile the front-end dependencies with `npm install && npm run dev`
8. Ensure your local webserver is set up to run the application (you can use `php artisan serve` to run the in-built PHP web server for working with the frontend of the website)
