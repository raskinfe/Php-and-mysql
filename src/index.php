<?php

use src\api\OffersController;
use src\api\ProfileDirectory;

session_start();
$request = explode('?', $_SERVER['REQUEST_URI'])[0];

include_once './services/initialize.php';
require_once './services/helper.php';
require_once './api/ProfileDirectory.php';
require_once './api/OffersController.php';

$profile = new ProfileDirectory();
$offer = new OffersController();

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == 'POST') {
    if ($request == '/update-profile') {
        $profile->update();
        exit();
    }

    if ($request == '/save-offer') {
        return $offer->store();
    }

    if ($request == '/user-name') {
        $profile->getUserByName();
        exit();
    }

    if ($request == '/update-avatar') {
        $profile->updateProfilePicture();
        exit();
    }

    if ($request == '/update-book') {
        $offer->updateBook();
        exit();
    }

    if ($request == '/update-book-cover') {
        $offer->updateBookCover();
        exit();
    }
}

if ($requestMethod == 'DELETE') {
    if ($request == '/delete-profile') {
        $profile->destroy();
        exit();
    }
    
    if ($request == '/delete-book') {
        $offer->destroy();
        exit();
    }
}

if (isLoggedIn()) {
    switch ($request) {
        case '':
        case '/' :
        case '/register':
        case '/login':
            require __DIR__ . '/views/index.php';
            break;
        case '/logout' :
            require __DIR__ . '/views/logout.php';
            break;
        case '/books' :
            $offer->index();
            break;
        case '/books-category' :
            $offer->getBookByCategory();
            break;
        case '/create-new' :
            require __DIR__ . '/views/pages/new-item.php';
            break;
        case '/profile' :
            require __DIR__ . '/views/profile.php';
            break;
        case '/about' :
            require __DIR__ . '/views/about.php';
            break;
        case '/user-offers':
            $offer->getBooksByUser();
            break;
        case '/edit-book':
            require __DIR__ . '/views/pages/edit.php';
            break;
        default:
            http_response_code(404);
            require __DIR__ . '/views/404.php';
            break;
    }
} else {
    switch ($request) {
        case '':
        case '/' :
            require __DIR__ . '/views/index.php';
            break;
        case '/register' :
            require __DIR__ . '/views/register.php';
            break;
        case '/books' :
            $offer->index();
            break;
        case '/books-category' :
            $offer->getBookByCategory();
            break;
        case '/logout':
        case '/create-new':
        case '/profile':
        case '/login' :
            require __DIR__ . '/views/login.php';
            break;
        case '/about' :
            require __DIR__ . '/views/about.php';
            break;
        default:
            http_response_code(404);
            require __DIR__ . '/views/404.php';
            break;
    }
}
