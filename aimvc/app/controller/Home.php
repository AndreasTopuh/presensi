<?php
class Home extends Controller
{
    public function index()
    {
        if (isset($_SESSION['user'])) {
            if ($_SESSION['user']['role'] == 'admin') {
                header('Location: ' . BASE_URL . 'admin');
            } elseif ($_SESSION['user']['role'] == 'dosen') {
                header('Location: ' . BASE_URL . 'dosen');
            } elseif ($_SESSION['user']['role'] == 'mahasiswa') {
                header('Location: ' . BASE_URL . 'mahasiswa');
            }
            exit;
        } else {
            $this->view('home/index');
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nomor_regis = $_POST['nomor_regis'];
            $password = $_POST['password'];
            $role = $_POST['role'];

            $model = $this->model($role . '_model');
            $user = $model->login($nomor_regis, $password);

            if ($user) {
                $_SESSION['user'] = $user;
                if ($role == 'admin') {
                    header('Location: ' . BASE_URL . 'admin');
                } elseif ($role == 'dosen') {
                    header('Location: ' . BASE_URL . 'dosen');
                } elseif ($role == 'mahasiswa') {
                    header('Location: ' . BASE_URL . 'mahasiswa');
                }
            } else {
                header('Location: ' . BASE_URL . 'home?error=Invalid credentials');
            }
            exit;
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: ' . BASE_URL);
        exit;
    }
}
