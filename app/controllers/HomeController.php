<?php

namespace App\controllers;

use App\exсeptions\NotEnoughMoneyException;
use App\QueryBuilder;
use League\Plates\Engine;
use PDO;
use Delight\Auth\Auth;

class HomeController
{
    private $templates;
    private $auth;
    private $qb;

    public function __construct(QueryBuilder $qb, Engine $engine, Auth $auth)
    {
        $this->qb= $qb;
        $this->templates = $engine;
        $this->auth = $auth;
    }

    public function index()
    {
        d($this->auth);die();

        $users = $this->qb->getAll('users');

        echo $this->templates->render('homepage', ['usersInView' => $users]);
    }

    public function about()
    {
        try {
            $userId = $this->auth->register('rahim@marlindev.ru', '123', 'Rahim', function
            ($selector, $token) {
                echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
                echo '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
                echo '  For SMS, consider using a third-party service and a compatible SDK';
            });

            echo 'We have signed up a new user with the ID ' . $userId;
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Invalid email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('User already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }

        echo $this->templates->render('about', ['name' => 'Jonathan about page']);
    }

    public function email_verification() {
        try {
            $this->auth->confirmEmail('KO3Cr6YVLP_T_DWb', 'fAwWrAymKfY04AYY');

            echo 'Email address has been verified';
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function login() {
        try {
            $this->auth->login('rahim@marlindev.ru', '123');

            echo 'User is logged in';
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Wrong email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Wrong password');
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            die('Email not verified');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }
}
