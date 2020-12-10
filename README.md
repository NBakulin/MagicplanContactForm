# Coding Task - Contact form

This is a coding task made by Nikita Bakulin (nk.bakulin@gmail.com) for Magicplan.

## Requirements
There are two easiest variants to run this app:
* With `PHP 7.4.13` installed locally.
* Or using `Docker` for Mac or Windows.

Also need to have installed:
* Composer

## Installation and run
1. Clone via `git clone https://github.com/NBakulin/MagicplanContactForm.git`
2. Run `composer install` in a root of repo
3. Run a server via `bin/cake server` (if use local PHP) or `docker-compose up` (if use Docker)
4. Form can be accessed on http://localhost:8765/contact_form (by default) or http://localhost/contact_form respectively

## Configuration
Configuration is managed by `/config/.env` file variables. Only two of them are useful for us, they are: `MAIL_ADDRESS_TO` to define a mail address to send emails to and `API_ENDPOINT_URL` to define endpoint url to send post request to.

## Email sending
To send an email via customer support go to `app.php` file, comment the line `'className' => 'Debug',` and uncomment `'className' => 'Smtp',`. I have created a new Google account to send emails, so there is no need to change `MAIL_ADDRESS_FROM` or `MAIL_PASSWORD` variables.

## Requesting real API
By default application requests an external API endpoint `https://apiendpoint.app/sales` (which will give 500 error code and an error message on a form since domain does not exist). If you want to make a request to existing API endpoint, you may manually change `API_ENDPOINT_URL` variable to one you want (I suggest `https://postman-echo.com/post`).

## Logging
Logs are stored in `/logs` directory
The pplication writes logs on unsuccessful email sending, request to external API or unhandled error. These logs are stored in a `contact_form_logs.log` file.

## Autotests
There are phpunit tests for ContactFormController and validators in a `/tests` folder.
