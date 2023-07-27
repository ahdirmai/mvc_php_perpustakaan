<?php

require_once './config/database.php';
require_once './app/Models/Auth.php';
require_once './app/Controllers/AuthController.php';
require_once './app/Controllers/UserController.php';
require_once './app/Controllers/BookController.php';
require_once './app/Controllers/BookBorrowController.php';
// require_once './app/Models/User.php';
session_start();

$auth = new Auth($koneksi);

function handleAuthController($action, $conn)
{
    $auth = new Auth($conn);
    $controller = new AuthController($auth);
    switch ($action) {
        case 'login':
            $controller->login();
            break;
        case 'logout':
            $controller->logout();
            break;
        case 'dashboard':
            $controller->dashboard();
            break;
        default:
            echo "404 Not Found";
            break;
    }
}

function handleUserController($action, $conn, $auth)
{
    $controller = new UserController($conn);
    switch ($action) {
        case 'users':
            if ($auth->getRole() === 'admin') {
                $controller->index();
            } else {
                require "./app/Views/errors/404.php";
            }
            break;
        case 'createUsers':
        case 'editUsers':
        case 'deleteUsers':
            if ($auth->getRole() === 'admin') {
                $controller->$action();
            } else {
                require "./app/Views/errors/404.php";
            }
            break;
        default:
            echo "404 Not Found Users";
            break;
    }
}

function handleBooksController($action, $conn, $auth)
{
    $controller = new BookController($conn);
    switch ($action) {
        case 'books':
            $controller->index();
            break;
        case 'createBooks':
        case 'editBooks':
        case 'deleteBooks':
            if ($auth->getRole() === 'admin') {
                $controller->$action();
            } else {
                require "./app/Views/errors/404.php";
            }
            break;
        case 'showBooks':
            $controller->showBook();
            break;
        case 'borrowBooks':
            $controller->borrowBooks();
            break;
        default:
            echo "404 Not Found Handler";
            break;
    }
}

function handleBooksBorrowController($action, $conn, $auth)
{
    $controller = new BookBorrowController($conn);
    switch ($action) {
        case 'booksborrow':
            $controller->index();
            break;
        case 'updateBorrow':
            $controller->updateBorrow();
            break;
        default:
            echo "404 Not Found Handler";
            break;
    }
}

if (!isset($_GET['action'])) {
    $_GET['action'] = 'login';
}

if (!isset($_SESSION['username']) && $_GET['action'] !== 'login') {
    // Jika pengguna belum login dan akses halaman selain login, arahkan ke halaman login
    header('Location: index.php?action=login');
    exit;
}

switch ($_GET['action']) {
    case 'login':
    case 'logout':
    case 'dashboard':
        handleAuthController($_GET['action'], $koneksi);
        break;
    case 'users':
    case 'createUsers':
    case 'editUsers':
    case 'deleteUsers':
        handleUserController($_GET['action'], $koneksi, $auth);
        break;
    case 'books':
    case 'createBooks':
    case 'editBooks':
    case 'deleteBooks':
    case 'showBooks':
    case 'borrowBooks':
        handleBooksController($_GET['action'], $koneksi, $auth);
        break;
    case 'exportUsersPDF':
        if ($auth->getRole() === 'admin') {
            $controller = new UserController($koneksi);
            $controller->exportToPDF();
        } else {
            require "./app/Views/errors/404.php";
        }
        break;
    case 'exportUsersExcel':
        if ($auth->getRole() === 'admin') {
            $controller = new UserController($koneksi);
            $controller->exportToExcel();
        } else {
            require "./app/Views/errors/404.php";
        }
        break;
    case 'printUsers':
        if ($auth->getRole() === 'admin') {
            $controller = new UserController($koneksi);
            $controller->printUsers();
        } else {
            require "./app/Views/errors/404.php";
        }
        break;
    case 'exportBooksPDF':
        if ($auth->getRole() === 'admin') {
            $controller = new BookController($koneksi);
            $controller->exportToPDF();
        } else {
            require "./app/Views/errors/404.php";
        }
        break;
    case 'exportbooksExcel':
        if ($auth->getRole() === 'admin') {
            $controller = new BookController($koneksi);
            $controller->exportToExcel();
        } else {
            require "./app/Views/errors/404.php";
        }
        break;
    case 'printBooks':
        if ($auth->getRole() === 'admin') {
            $controller = new BookController($koneksi);
            $controller->printBooks();
        } else {
            require "./app/Views/errors/404.php";
        }
        break;
    case 'booksborrow':
        if ($auth->getRole() === 'admin') {
            handleBooksBorrowController($_GET['action'], $koneksi, $auth);
        } else {
            require "./app/Views/errors/404.php";
        }
        break;
    case 'updateBorrow':
        if ($auth->getRole() === 'admin') {
            handleBooksBorrowController($_GET['action'], $koneksi, $auth);
        } else {
            require "./app/Views/errors/404.php";
        }
        break;
    default:
        echo "404 Not Found Action";
        break;
}
