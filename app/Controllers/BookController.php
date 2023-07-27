<?php

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once './vendor/autoload.php';

require_once './app/Models/Book.php';

class BookController
{
    private $conn;
    private $booksModel;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->booksModel = new Book($conn);
    }

    public function index()
    {
        $_SESSION['page'] = "books";

        $books_borrow = $this->booksModel->getAllBooksBorrow();
        $books = $this->booksModel->getAllBooks();
        require './app/Views/Books/index.php';
    }

    public function showBook()
    {
        $_SESSION['page'] = "books";

        $id = $_GET['id'];
        $book = $this->booksModel->getBookById($id);
        require './app/Views/Books/show.php';
    }

    public function createBooks()
    {
        $_SESSION['page'] = "books";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $author = $_POST['author'];
            $publisher = $_POST['publisher'];
            $genre = $_POST['genre'];
            $description = $_POST['description'];

            // Upload gambar sampul (cover image) ke direktori yang sesuai
            $coverImage = $_FILES['cover_image']['name'];
            $tempName = $_FILES['cover_image']['tmp_name'];
            $uploadPath = './public/img/books/' . $coverImage;
            move_uploaded_file($tempName, $uploadPath);

            // Data buku yang akan disimpan ke database
            $data = [
                'title' => $title,
                'author' => $author,
                'publisher' => $publisher,
                'genre' => $genre,
                'description' => $description,
                'cover_image' => $coverImage,
            ];
            $this->booksModel->addBook($data);
            header('Location: index.php?action=books');
        } else {
            require './app/Views/Books/create.php';
        }
    }


    public function editBooks()
    {
        $_SESSION['page'] = "books";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $author = $_POST['author'];
            $publisher = $_POST['publisher'];
            $genre = $_POST['genre'];
            $description = $_POST['description'];

            $book = $this->booksModel->getBookById($id);
            $coverImage = $book['cover_image']; // Nama file gambar yang sudah ada

            if ($_FILES['cover_image']['name']) {
                // Jika ada file gambar baru diunggah, proses unggah gambar baru
                $coverImage = $_FILES['cover_image']['name'];
                $tempName = $_FILES['cover_image']['tmp_name'];
                $uploadPath = './public/img/books/' . $coverImage;
                move_uploaded_file($tempName, $uploadPath);
            }

            // Data buku yang akan diupdate ke database
            $data = [
                'title' => $title,
                'author' => $author,
                'publisher' => $publisher,
                'genre' => $genre,
                'description' => $description,
                'cover_image' => $coverImage, // Nama file gambar baru atau yang sudah ada
            ];

            $this->booksModel->updateBook($id, $data);
            header('Location: index.php?action=books');
        } else {
            $id = $_GET['id'];
            $book = $this->booksModel->getBookById($id);
            require './app/Views/Books/edit.php';
        }
    }


    public function deleteBooks()
    {
        $_SESSION['page'] = "books";

        $id = $_GET['id'];

        // Dapatkan data buku berdasarkan ID
        $book = $this->booksModel->getBookById($id);
        if (!$book) {
            // Tampilkan halaman 404 jika buku tidak ditemukan
            http_response_code(404);
            include './app/Views/404.php';
            return;
        }

        // Hapus file cover image jika ada
        $coverImagePath = './public/img/books/' . $book['cover_image'];
        if ($book['cover_image'] && file_exists($coverImagePath)) {
            unlink($coverImagePath);
        }

        // Hapus data buku dari database
        $this->booksModel->deleteBook($id);

        // Redirect kembali ke halaman daftar buku
        header('Location: index.php?action=books');
    }

    public function exportToPDF()
    {
        $books = $this->booksModel->getAllBooks();

        // Create a new Dompdf instance
        $dompdf = new Dompdf();

        // Generate the PDF content
        ob_start();
        require './app/Views/Books/export_pdf.php'; // Create a new view file for the PDF content
        $content = ob_get_clean();

        // Load the HTML content into Dompdf
        $dompdf->loadHtml($content);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF
        $dompdf->render();

        // Output the generated PDF to the browser
        $dompdf->stream("books.pdf", array("Attachment" => false));
    }

    public function exportToExcel()
    {
        $books = $this->booksModel->getAllBooks();

        // Create a new PHPExcel instance
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setTitle("Books Data")->setDescription("Data for books");

        // Create a new worksheet and set headers
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Books Data');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Title');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Author');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Publisher');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Genre');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Description');

        // Fill data into the worksheet
        $row = 2;
        foreach ($books as $book) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $book['id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $book['title']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $book['author']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $book['publisher']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $book['genre']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $book['description']);
            $row++;
        }

        // Redirect the output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="books.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function printBooks()
    {
        $books = $this->booksModel->getAllBooks();

        require './app/Views/Books/print.php'; // Create a new view file for printing data
    }

    public function borrowBooks()
    {
        $user_id = $_GET['user_id'];
        $book_id = $_GET['book_id'];

        $data = [
            'user_id' => $user_id,
            'book_id' => $book_id

        ];
        $this->booksModel->borrowBook($data);
        // echo 'user_id = ' .  . " & " . "book_id = " . $_GET['book_id'];
        header('Location: index.php?action=books');
    }
}
