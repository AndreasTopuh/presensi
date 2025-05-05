<?php
class Dosen extends Controller
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function index()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'dosen') {
            header('Location: ' . BASE_URL . 'home');
            exit;
        }

        $model = $this->model('Dosen_model');
        $data['lecturers'] = $model->getLecturers();
        $data['classes'] = $model->getClasses($_SESSION['user']['nomor_regis']);

        $this->view('dosen/index', $data);
    }

    public function class($class_id = null)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'dosen') {
            header('Location: ' . BASE_URL . 'home');
            exit;
        }

        if (!$class_id) {
            header('Location: ' . BASE_URL . 'dosen?error=Class ID required');
            exit;
        }

        $model = $this->model('Dosen_model');
        $nomor_regis = $_SESSION['user']['nomor_regis'];
        $dosen_id = $this->getDosenId($nomor_regis);

        if (!$dosen_id) {
            header('Location: ' . BASE_URL . 'dosen?error=Lecturer not found');
            exit;
        }

        $this->db->query("SELECT * FROM class WHERE id = :class_id AND dosen_id = :dosen_id");
        $this->db->bind(':class_id', $class_id);
        $this->db->bind(':dosen_id', $dosen_id);
        $data['class'] = $this->db->single();

        if (!$data['class']) {
            header('Location: ' . BASE_URL . 'dosen?error=Class not found');
            exit;
        }

        $data['students'] = $model->getClassStudents($class_id);
        $this->view('dosen/class', $data);
    }

    public function addStudent($class_id = null)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'dosen') {
            header('Location: ' . BASE_URL . 'home');
            exit;
        }

        if (!$class_id) {
            header('Location: ' . BASE_URL . 'dosen?error=Class ID required');
            exit;
        }

        $model = $this->model('Dosen_model');
        $nomor_regis = $_SESSION['user']['nomor_regis'];
        $dosen_id = $this->getDosenId($nomor_regis);

        if (!$dosen_id) {
            header('Location: ' . BASE_URL . 'dosen?error=Lecturer not found');
            exit;
        }

        $this->db->query("SELECT * FROM class WHERE id = :class_id AND dosen_id = :dosen_id");
        $this->db->bind(':class_id', $class_id);
        $this->db->bind(':dosen_id', $dosen_id);
        $data['class'] = $this->db->single();

        if (!$data['class']) {
            header('Location: ' . BASE_URL . 'dosen?error=Class not found');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $action = isset($_POST['action']) ? $_POST['action'] : '';

            if ($action === 'search') {
                $nomor_regis = $_POST['nomor_regis'];
                $data['search_results'] = $model->searchStudent($nomor_regis);
                $data['students'] = $model->getClassStudents($class_id);
                $this->view('dosen/class', $data);
            } elseif ($action === 'add') {
                $nomor_regis = $_POST['nomor_regis'];
                $result = $model->addStudentToClass($class_id, $nomor_regis);
                if ($result['success']) {
                    header('Location: ' . BASE_URL . 'dosen/class/' . $class_id . '?success=' . urlencode($result['message']));
                } else {
                    header('Location: ' . BASE_URL . 'dosen/class/' . $class_id . '?error=' . urlencode($result['message']));
                }
                exit;
            }
        } else {
            header('Location: ' . BASE_URL . 'dosen/class/' . $class_id);
            exit;
        }
    }

    public function updateAttendance($attendance_id = null)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'dosen') {
            header('Location: ' . BASE_URL . 'home');
            exit;
        }

        if (!$attendance_id) {
            header('Location: ' . BASE_URL . 'dosen?error=Attendance ID required');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = $this->model('Dosen_model');
            $status = $_POST['status'];

            $this->db->query("SELECT class_id FROM attendance WHERE id = :id");
            $this->db->bind(':id', $attendance_id);
            $attendance = $this->db->single();

            if (!$attendance) {
                header('Location: ' . BASE_URL . 'dosen?error=Attendance record not found');
                exit;
            }

            $class_id = $attendance['class_id'];
            $result = $model->updateAttendance($attendance_id, $status);

            if ($result['success']) {
                header('Location: ' . BASE_URL . 'dosen/class/' . $class_id . '?success=' . urlencode($result['message']));
            } else {
                header('Location: ' . BASE_URL . 'dosen/class/' . $class_id . '?error=' . urlencode($result['message']));
            }
            exit;
        } else {
            header('Location: ' . BASE_URL . 'dosen');
            exit;
        }
    }

    public function deleteStudentFromClass($class_id, $student_id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = $this->model('Dosen_model');
            $result = $model->deleteStudentFromClass($class_id, $student_id);
            if ($result['success']) {
                header('Location: ' . BASE_URL . 'dosen/class/' . $class_id . '?success=' . urlencode($result['message']));
            } else {
                header('Location: ' . BASE_URL . 'dosen/class/' . $class_id . '?error=' . urlencode($result['message']));
            }
            exit;
        }
    }

    public function openPresensi($class_id = null)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'dosen') {
            header('Location: ' . BASE_URL . 'home');
            exit;
        }

        if (!$class_id) {
            header('Location: ' . BASE_URL . 'dosen?error=Class ID required');
            exit;
        }

        $model = $this->model('Dosen_model');
        $nomor_regis = $_SESSION['user']['nomor_regis'];
        $dosen_id = $this->getDosenId($nomor_regis);

        $this->db->query("SELECT dosen_id FROM class WHERE id = :class_id");
        $this->db->bind(':class_id', $class_id);
        $class_dosen_id = $this->db->single()['dosen_id'];

        if ($dosen_id != $class_dosen_id) {
            header('Location: ' . BASE_URL . 'dosen?error=You are not authorized to open presensi for this class');
            exit;
        }

        $current_time = date('H:i:s');
        $this->db->query("SELECT waktu_mulai, waktu_selesai FROM class WHERE id = :class_id");
        $this->db->bind(':class_id', $class_id);
        $class = $this->db->single();

        if ($current_time < $class['waktu_mulai'] || $current_time > $class['waktu_selesai']) {
            header('Location: ' . BASE_URL . 'dosen/class/' . $class_id . '?error=Presensi can only be opened during class time');
            exit;
        }

        $result = $model->openPresensi($class_id);
        if ($result) {
            header('Location: ' . BASE_URL . 'dosen/class/' . $class_id . '?success=Presensi opened successfully');
        } else {
            header('Location: ' . BASE_URL . 'dosen/class/' . $class_id . '?error=Failed to open presensi');
        }
        exit;
    }

    public function closePresensi($class_id = null)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'dosen') {
            header('Location: ' . BASE_URL . 'home');
            exit;
        }

        if (!$class_id) {
            header('Location: ' . BASE_URL . 'dosen?error=Class ID required');
            exit;
        }

        $model = $this->model('Dosen_model');
        $nomor_regis = $_SESSION['user']['nomor_regis'];
        $dosen_id = $this->getDosenId($nomor_regis);

        $this->db->query("SELECT dosen_id FROM class WHERE id = :class_id");
        $this->db->bind(':class_id', $class_id);
        $class_dosen_id = $this->db->single()['dosen_id'];

        if ($dosen_id != $class_dosen_id) {
            header('Location: ' . BASE_URL . 'dosen?error=You are not authorized to close presensi for this class');
            exit;
        }

        $result = $model->closePresensi($class_id);
        if ($result) {
            header('Location: ' . BASE_URL . 'dosen/class/' . $class_id . '?success=Presensi closed successfully');
        } else {
            header('Location: ' . BASE_URL . 'dosen/class/' . $class_id . '?error=Failed to close presensi');
        }
        exit;
    }

    private function getDosenId($nomor_regis)
    {
        $this->db->query("SELECT id FROM dosen WHERE nomor_regis = :nomor_regis");
        $this->db->bind(':nomor_regis', $nomor_regis);
        $result = $this->db->single();
        return $result ? $result['id'] : null;
    }
}
