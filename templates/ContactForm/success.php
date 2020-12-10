<?php

$this->disableAutoLayout();

$description = 'Contact Form';

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
        <h2 class="text-center padding-top">Thank you for your message!</h2>
    </div>
</main>
<script></script>
</html>
