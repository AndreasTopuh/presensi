<?php
class Mahasiswa extends Controller
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function index()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'mahasiswa') {
            header('Location: ' . BASE_URL . 'home');
            exit;
        }

        $model = $this->model('Mahasiswa_model');
        $mahasiswa_id = $this->getMahasiswaId($_SESSION['user']['nomor_regis']);

        if (!$mahasiswa_id) {
            header('Location: ' . BASE_URL . 'home?error=Student not found');
            exit;
        }

        $data['classes'] = $model->getClasses($mahasiswa_id);
        $data['stats'] = $model->getAttendanceStats($_SESSION['user']['nomor_regis']);

        foreach ($data['classes'] as &$class) {
            $class['attendance_status'] = $model->hasAttended($class['id'], $mahasiswa_id);
            $class['can_attend'] = $model->canAttend($class['id']);
        }

        $this->view('mahasiswa/index', $data);
    }

    public function classStats($class_id)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'mahasiswa') {
            header('Location: ' . BASE_URL . 'home');
            exit;
        }

        $model = $this->model('Mahasiswa_model');
        $mahasiswa_id = $this->getMahasiswaId($_SESSION['user']['nomor_regis']);

        if (!$mahasiswa_id) {
            header('Location: ' . BASE_URL . 'mahasiswa?error=Student not found');
            exit;
        }

        $data['class'] = $model->getClassById($class_id);
        if (!$data['class']) {
            header('Location: ' . BASE_URL . 'mahasiswa?error=Class not found');
            exit;
        }

        $data['stats'] = $model->getClassAttendanceStats($mahasiswa_id, $class_id);

        $this->view('mahasiswa/class_stats', $data);
    }

    public function markAttendance($class_id)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'mahasiswa') {
            header('Location: ' . BASE_URL . 'home');
            exit;
        }

        $model = $this->model('Mahasiswa_model');
        if ($model->canAttend($class_id)) {
            $mahasiswa_id = $this->getMahasiswaId($_SESSION['user']['nomor_regis']);
            if (!$mahasiswa_id) {
                header('Location: ' . BASE_URL . 'mahasiswa?error=Student not found');
                exit;
            }
            $result = $model->markAttendance($class_id, $mahasiswa_id);
            if ($result) {
                header('Location: ' . BASE_URL . 'mahasiswa?success=Attendance marked successfully');
            } else {
                header('Location: ' . BASE_URL . 'mahasiswa?error=Failed to mark attendance');
            }
            exit;
        } else {
            header('Location: ' . BASE_URL . 'mahasiswa?error=Attendance not allowed at this time');
            exit;
        }
    }

    private function getMahasiswaId($nomor_regis)
    {
        $this->db->query("SELECT id FROM mahasiswa WHERE nomor_regis = :nomor_regis");
        $this->db->bind(':nomor_regis', $nomor_regis);
        $result = $this->db->single();
        return $result ? $result['id'] : null;
    }
}
