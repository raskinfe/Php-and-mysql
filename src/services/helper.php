<?php

function checkPassword($plain, $password): bool
{
    return $password === $plain;
}

function isLoggedIn(): bool
{
    return isset($_SESSION['loggedIn']);
}

const CATEGORIES = array(
    'novel' => 'Novel',
    'fantasy'=>'Fantasy',
    'horror'=>'Horror',
    'classics'=>'Classics',
    'crime'=>'Crime',
    'technology'=>'Technology',
    'engineering'=>'Engineering',
    'business'=>'Business',
    'computer'=>'Computer Science',
    'maths'=>'Mathematics',
);
