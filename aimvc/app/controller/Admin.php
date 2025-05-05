<?php
class Admin extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
            header('Location: ' . BASE_URL . 'home');
            exit;
        }

        $model = $this->model('Admin_model');
        $data['classes'] = $model->getClasses();
        $data['lecturers'] = $this->model('Dosen_model')->getLecturers();
        $data['students'] = $model->getAllStudents();

        $this->view('admin/index', $data);
    }

    public function addClass()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
            header('Location: ' . BASE_URL . 'home');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = $this->model('Admin_model');
            $result = $model->addClass(
                $_POST['nama_kelas'],
                $_POST['dosen_id'],
                $_POST['waktu_mulai'],
                $_POST['waktu_selesai'],
                $_POST['hari']
            );
            if ($result) {
                $message = 'Class added successfully';
                header('Location: ' . BASE_URL . 'admin?success=' . urlencode($message));
            } else {
                $message = 'Failed to add class';
                header('Location: ' . BASE_URL . 'admin?error=' . urlencode($message));
            }
            exit;
        } else {
            // Handle GET request: Load the add class form
            $data['lecturers'] = $this->model('Dosen_model')->getLecturers();
            $this->view('admin/add_class', $data);
        }
    }

    public function editClass($id)
    {
        $model = $this->model('Admin_model');
        $class = $model->getClass($id);
        echo json_encode($class);
    }

    public function updateClass()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = $this->model('Admin_model');
            $id = $_POST['id'];
            $nama_kelas = $_POST['nama_kelas'];
            $dosen_id = $_POST['dosen_id'];
            $waktu_mulai = $_POST['waktu_mulai'];
            $waktu_selesai = $_POST['waktu_selesai'];
            $hari = $_POST['hari'];
            $result = $model->updateClass($id, $nama_kelas, $dosen_id, $waktu_mulai, $waktu_selesai, $hari);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Class updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update class']);
            }
        }
    }

    public function deleteClass($id)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
            header('Location: ' . BASE_URL . 'home');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = $this->model('Admin_model');
            $result = $model->deleteClass($id);
            if ($result) {
                $message = 'Class deleted successfully';
                header('Location: ' . BASE_URL . 'admin?success=' . urlencode($message));
            } else {
                $message = 'Failed to delete class';
                header('Location: ' . BASE_URL . 'admin?error=' . urlencode($message));
            }
            exit;
        }
    }

    public function editLecturer($id)
    {
        $model = $this->model('Admin_model');
        $lecturer = $model->getLecturer($id);
        echo json_encode($lecturer);
    }

    public function updateLecturer()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = $this->model('Admin_model');
            $id = $_POST['id'];
            $nama_lengkap = $_POST['nama_lengkap'];
            $nomor_regis = $_POST['nomor_regis'];
            $result = $model->updateLecturer($id, $nama_lengkap, $nomor_regis);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Lecturer updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update lecturer']);
            }
        }
    }

    public function deleteLecturer($id)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
            header('Location: ' . BASE_URL . 'home');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = $this->model('Admin_model');
            $result = $model->deleteLecturer($id);
            if ($result) {
                $message = 'Lecturer deleted successfully';
                header('Location: ' . BASE_URL . 'admin?success=' . urlencode($message));
            } else {
                $message = 'Failed to delete lecturer';
                header('Location: ' . BASE_URL . 'admin?error=' . urlencode($message));
            }
            exit;
        }
    }
}