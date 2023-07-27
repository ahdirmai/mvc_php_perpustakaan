<?php
// controller/UserController.php
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


require_once './app/Models/User.php';
require_once './vendor/autoload.php';


class UserController
{
    private $userModel;
    private $conn;

    public function __construct($conn)
    {
        $this->userModel = new User($conn);
        $this->conn = $conn;
    }

    public function index()
    {
        $_SESSION['page'] = "users";
        $users = $this->userModel->getAllUsers();
        require './app/Views/Users/index.php';
    }

    public function createUsers()
    {
        $_SESSION['page'] = "users";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'],
                'name' => $_POST['name'],
                'role' => $_POST['role'],
                'password' => password_hash('password', PASSWORD_DEFAULT), // Simpan password yang di-hash
            ];
            $this->userModel->addUser($data);
            header('Location: index.php?action=users');
        } else {
            require './app/Views/Users/create.php';
        }
    }

    public function editUsers()
    {
        $_SESSION['page'] = "users";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // var_dump('asjdiajsd');
            // return 'x';
            $id = $_GET['id'];
            // echo $id;
            $data = [
                'username' => $_POST['username'],
                'name' => $_POST['name'],
                'role' => $_POST['role']
                // 'password' => password_hash($_POST['password'], PASSWORD_DEFAULT), // Simpan password yang di-hash
            ];
            $done  = $this->userModel->updateUser($id, $data);
            header('Location: index.php?action=users');
        } else {
            $id = $_GET['id'];
            $user = $this->userModel->getUserById($id);
            require './app/Views/Users/edit.php';
        }
    }

    public function deleteUsers()
    {
        $_SESSION['page'] = "users";

        $id = $_GET['id'];
        $this->userModel->deleteUser($id);
        header('Location: index.php?action=users');
    }

    public function exportToPDF()
    {
        $users = $this->userModel->getAllUsers();

        // Load view yang akan di-convert menjadi PDF
        ob_start();
        require './app/Views/Users/export_pdf.php';
        $content = ob_get_clean();

        // Set up dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');

        // Render PDF
        $dompdf->render();

        // Output PDF ke browser
        $dompdf->stream('users.pdf', ['Attachment' => false]);
    }

    public function exportToExcel()
    {
        $users = $this->userModel->getAllUsers();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Username');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Role');

        $row = 2;
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $row, $user['username']);
            $sheet->setCellValue('B' . $row, $user['name']);
            $sheet->setCellValue('C' . $row, $user['role']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'users.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function printUsers()
    {
        $_SESSION['page'] = "users";

        $users = $this->userModel->getAllUsers();
        require './app/Views/Users/print.php';
    }
}
