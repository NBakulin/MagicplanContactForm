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
//ToDo add a message on invalid form field
//ToDo br needed?
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $description ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken'), ['id' => 'csrfToken']) ?>
    <?= $this->Html->css('contact_form/contact_form') ?>
    <?= $this->Html->script('contact_form/contact_form') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body class="body">
    <main>
        <div>
            <h1 class="text-center">Hi, Hallo, Salut 👋</h1>
            <h3 class="text-center">Interested in magicplan? Already a customer?<br> We're here for you</h3>

            <div id="customer_support">
                <form id="contact_form" method="post" onsubmit="onSubmit(event)">

                    <p class="margin-bottom-0">My question is related to:</p>
                    <div id="question_type" class="display-inline">
                        <input type="radio" id="question_customer_support" name="question_customer_support" value="customer_support" onchange="toggleForm(event)" checked>
                        <label for="question_customer_support">Customer Support</label>
                        <input type="radio" id="question_sales" name="question_customer_support" value="sales" onchange="toggleForm(event)">
                        <label for="question_sales">Sales</label>
                    </div>

                    <div>
                        <div class="display-inline">
                            <label for="input_first_name">First name</label><br>
                            <input type="text" id="input_first_name" name="first_name" required>
                        </div>
                        <div class="display-inline">
                            <label for="input_last_name">Last name</label><br>
                            <input type="text" id="input_last_name" name="last_name" required>
                        </div>
                    </div>

                    <div>
                        <label for="input_email">Email</label><br>
                        <input type="text" id="input_email" name="email" required>
                    </div>

                    <div>
                        <label for="input_message">Message</label><br>
                        <input type="text" id="input_message" name="message" required>
                    </div>

                    <section id="sales-section" class="display-none">
                        <div>
                            <label for="input_company_name">Company Name</label><br>
                            <input type="text" id="input_company_name" name="company_name">
                        </div>
                        <div>
                            <label for="input_company_size">Company Size</label><br>
                            <select type="text" id="input_company_size" name="company_size">
                                <option value="" selected="selected">Select Size</option>
                                <option value="1">1</option>
                                <option value="2-9">2-9</option>
                                <option value="10-19">10-19</option>
                                <option value="20+">20+</option>
                            </select>
                        </div>
                        <div>
                            <label for="input_industry">Industry</label><br>
                            <select type="text" id="input_industry" name="industry">
                                <option value="" selected="selected">Select Industry</option>
                                <option value="Renovation">Renovation</option>
                                <option value="Inspection">Inspection</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label for="input_region">Region</label><br>
                            <select type="text" id="input_region" name="region">
                                <option value="" selected="selected">Select Region</option>
                                <option value="North-America">North-America</option>
                                <option value="Europe">Europe</option>
                                <option value="Asia">Asia</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label for="input_phone">Phone (optional)</label><br>
                            <input type="text" id="input_phone" name="phone">
                        </div>
                    </section>

                    <p>This site is protected by reCAPTCHA and the Google Privacy Policy and Terms of Service apply.</p>
                    <button type="submit">Contact us</button>

                </form>
            </div>
        </div>

    </main>
    <script></script>
</body>
</html>
