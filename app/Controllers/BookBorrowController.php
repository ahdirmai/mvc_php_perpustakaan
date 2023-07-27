<?php

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once './vendor/autoload.php';

require_once './app/Models/BookBorrow.php';

class BookBorrowController
{
    private $conn;
    private $borrowModel;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->borrowModel = new BookBorrow($conn);
    }

    public function index()
    {
        $_SESSION['page'] = "books";

        // $books_borrow = $this->borrowModel->getAllBooksBorrow();
        $books_borrow = $this->borrowModel->getAllBooksBorrow();
        require './app/Views/BookBorrow/index.php';
    }

    public function updateBorrow()
    {
        $_SESSION['page'] = "books";

        $id = $_GET['id'];
        $status = $_GET['status'];

        // return  $_GET['id'];
        $data = [
            'id' => $id,
            'status' => $status
        ];
        $changeStatus = $this->borrowModel->setStatusBorrow($data);
        header('Location: index.php?action=booksborrow');
    }
}
