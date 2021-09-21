<html>
<?php
require_once 'functions/helpers.php';
require_once 'config/config.php';

$config = getConfig();
$pageName = getPageName();
?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta charset="UTF-8">
    <title><?= $pageName ?></title>
    <script src="/<?php echo $config['domain_path'] ?>/js/sender.js"></script>
    <style>
        pre {
            font-size: 18px;
        }

        .nav-menu {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: flex-start;
            list-style-type: none;
            width: auto;

        }

        .nav-menu li {
            font-size: 16px;
            text-transform: uppercase;
            margin-right: 20px;
        }
    </style>
</head>
<body>
<h1>
    You are now at <?= $pageName ?> page!
</h1>
<ul class="nav-menu">
    <li><a href="/<?php echo $config['domain_path'] ?>/index.php">Home</a></li>
    <li><a href="/<?php echo $config['domain_path'] ?>/contacts.php">Contacts</a></li>
    <li><a href="/<?php echo $config['domain_path'] ?>/about.php">About</a></li>
</ul>
<?php
