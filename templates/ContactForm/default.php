<?php

use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;

$this->disableAutoLayout();

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace templates/Pages/home.php with your own version or re-enable debug mode.'
    );
endif;

$description = 'Contact Form';

?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $description ?>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken'), ['id' => 'csrfToken']) ?>
    <?= $this->Html->css("styles.css") ?>
    <?= $this->Html->css('contact_form/contact_form') ?>
    <?= $this->Html->script('contact_form/contact_form') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body class="body">
    <main>
        <div>
            <h2 class="text-center">Hi, Hallo, Salut 👋</h2>
            <h6 class="text-center mb-48">Interested in magicplan? Already a customer?<br> We're here for you</h6>

            <div id="customer_support">
                <form id="contact_form" method="post" accept-charset="utf-8" onsubmit="onSubmit(event)">

                    <div id="question_type" class="mb-24">
                        <label class="d-block font-weight-normal">My question is related to:</label>
                        <label id="customer_support" onclick="toggleForm(event)">
                            <input type="radio" id="question_customer_support" name="question_type" value="customer_support" checked>
                            Customer Support
                        </label>
                        <label id="question_sales" onclick="toggleForm(event)">
                            <input class="ml-12" type="radio" id="question_sales" name="question_type" value="sales">
                            Sales
                        </label>
                    </div>

                    <div id="unhandled_error" class="message error display-none">
                        <i class="fal fa-frown fa-lg"></i>Something went wrong, try to resubmit the form
                    </div>

                    <div class="contact-name-container">
                        <div id="first_name" class="input text">
                            <label for="input_first_name">First name</label>
                            <input class="mr-8 sm:mr-0" type="text" id="input_first_name" name="first_name" required>
                            <div class="error-message" hidden id="error_first_name"></div>
                        </div>
                        <div id="last_name" class="input text">
                            <label for="input_last_name">Last name</label>
                            <input class="ml-8 sm:ml-0" type="text" id="input_last_name" name="last_name" required>
                            <div class="error-message" hidden id="error_last_name"></div>
                        </div>
                    </div>

                    <div id="email" class="input text">
                        <label for="input_email">Email</label>
                        <input class="mr-8 sm:ml-0 text-input" type="email" id="input_email" name="email" required>
                        <div class="error-message" hidden id="error_email"></div>
                    </div>

                    <div id="message" class="input text">
                        <label for="input_message">Message</label>
                        <textarea class="contact-message" type="text" id="input_message" name="message" required></textarea>
                        <div class="error-message" hidden id="error_message"></div>
                    </div>

                    <section id="sales-section" class="display-none">
                        <div id="company_name" class="input text">
                            <label for="input_company_name">Company Name</label>
                            <input class="mr-8 sm:ml-0 text-input" type="text" id="input_company_name" name="company_name">
                            <div class="error-message" hidden id="error_company_name"></div>
                        </div>
                        <div id="company_size" class="input select">
                            <label for="input_company_size">Company Size</label>
                            <select type="text" id="input_company_size" name="company_size">
                                <option value="" selected="selected">Please Select</option>
                                <option value="1">1</option>
                                <option value="2-9">2-9</option>
                                <option value="10-19">10-19</option>
                                <option value="20+">20+</option>
                            </select>
                            <div class="error-message" hidden id="error_company_size"></div>
                        </div>
                        <div id="industry" class="input select">
                            <label for="input_industry">Industry</label>
                            <select type="text" id="input_industry" name="industry">
                                <option value="" selected="selected">Please Select</option>
                                <option value="Renovation">Renovation</option>
                                <option value="Inspection">Inspection</option>
                                <option value="Other">Other</option>
                            </select>
                            <div class="error-message" hidden id="error_industry"></div>
                        </div>
                        <div id="region" class="input select">
                            <label for="input_region">Region</label>
                            <select type="text" id="input_region" name="region">
                                <option value="" selected="selected">Please Select</option>
                                <option value="North-America">North-America</option>
                                <option value="Europe">Europe</option>
                                <option value="Asia">Asia</option>
                                <option value="Other">Other</option>
                            </select>
                            <div class="error-message" hidden id="error_region"></div>
                        </div>
                        <div id="phone" class="input text">
                            <label for="input_phone">Phone (optional)</label>
                            <input class="mr-8 sm:ml-0 text-input" type="text" id="input_phone" name="phone">
                            <div class="error-message" hidden id="error_phone"></div>
                        </div>
                    </section>

                    <div class="text-gray-800 font-size-12">
                        This site is protected by reCAPTCHA and the Google
                        <a class="text-gray-700">Privacy Policy</a> and
                        <a class="text-gray-700">Terms of Service</a> apply.
                    </div>
                    <button class="btn btn-primary btn-large my-20" type="submit">Contact us</button>

                </form>
            </div>
        </div>

    </main>
    <script></script>
</body>
</html>
