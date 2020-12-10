# Coding Task - Contact form

This is a coding task made by Nikita Bakulin (nk.bakulin@gmail.com) for Magicplan.

## Requirements
* `PHP 7.4.13` - not recommended as additional extensions installation may be needed.
There are two possible variants to run this app locally: using Docker or locally installed PHP.
* Or `Docker` for Mac or Windows.
* Composer installed locally

## Installation
1. Clone via `git clone https://github.com/NBakulin/MagicplanContactForm.git`
2. Run `composer install` in a root of repo
3. Run `bin/cake server` (if use local PHP) or `docker-compose up` (if use Docker)
4. Form can be accessed on http://localhost:8765/contact_form or http://localhost/contact_form respectively

## Configuration
Configuration is managed by `/config/.env` file variables. Only two of them are interested, they are: `MAIL_ADDRESS_TO` to define a mail address to send emails to and `API_URL` (I do not recommend to change it, have a look at section `Requesting real API` in this file for explanation)

## Email sending
To send an email via customer support go to `app.php` file fore local php installation or to `app_local.php` if you are using docker. Comment the line `'className' => 'Debug',` and uncomment `'className' => 'Smtp',`. I have created a new Google account to send emails, so there is no need to change `MAIL_ADDRESS_FROM` or `MAIL_PASSWORD` variables.

## Requesting real API
By default application requests external API with host `https://apiendpoint.app` and path `/sales` (which will give 500 error code and an error message on a form). If you want to make a request to existing API, you may manually change `$this->requestUrl` to one you want (I suggest `https://postman-echo.com/post`). I did not put whole `https://apiendpoint.app/sales` url in `.env` to make `API_URL` variable reusable (e.g. when there will be need to request another endpoint of this API).

## Logging
Logs are stored in `/logs` directory
The pplication writes logs on unsuccessful email sending, request to external API or unhandled error. These logs are stored in a `contact_form_logs.log` file.

## Autotests
There are phpunit tests for ContactFormController and validators in a `/tests` folder.
