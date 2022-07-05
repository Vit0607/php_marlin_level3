<?php

require '../vendor/autoload.php';

//if($_SERVER['REQUEST_URI'] == '/home') {
//    require '../app/controllers/homepage.php';
//}

// Create new Plates instance
$templates = new League\Plates\Engine('../app/views');

// Render a template
echo $templates->render('about', ['title' => 'Jonathan']);

//exit;

echo 'hello';



