<?php
class Admin_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function login($nomor_regis, $password)
    {
        $this->db->query("SELECT * FROM admin WHERE nomor_regis = :nomor_regis");
        $this->db->bind(':nomor_regis', $nomor_regis);
        $user = $this->db->single();
        if ($user && $user['password'] === $password) {
            $user['role'] = 'admin';
            return $user;
        }
        return false;
    }

    public function getClasses()
    {
        $this->db->query("SELECT c.*, d.nama_lengkap AS dosen_nama FROM class c JOIN dosen d ON c.dosen_id = d.id");
        return $this->db->resultSet();
    }

    public function getClass($id)
    {
        $this->db->query("SELECT * FROM class WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addClass($nama_kelas, $dosen_id, $waktu_mulai, $waktu_selesai)
    {
        $this->db->query("INSERT INTO class (nama_kelas, dosen_id, waktu_mulai, waktu_selesai) VALUES (:nama_kelas, :dosen_id, :waktu_mulai, :waktu_selesai)");
        $this->db->bind(':nama_kelas', $nama_kelas);
        $this->db->bind(':dosen_id', $dosen_id);
        $this->db->bind(':waktu_mulai', $waktu_mulai);
        $this->db->bind(':waktu_selesai', $waktu_selesai);
        return $this->db->execute();
    }

    public function updateClass($id, $nama_kelas, $dosen_id, $waktu_mulai, $waktu_selesai)
    {
        $this->db->query("UPDATE class SET nama_kelas = :nama_kelas, dosen_id = :dosen_id, waktu_mulai = :waktu_mulai, waktu_selesai = :waktu_selesai WHERE id = :id");
        $this->db->bind(':id', $id);
        $this->db->bind(':nama_kelas', $nama_kelas);
        $this->db->bind(':dosen_id', $dosen_id);
        $this->db->bind(':waktu_mulai', $waktu_mulai);
        $this->db->bind(':waktu_selesai', $waktu_selesai);
        return $this->db->execute();
    }

    public function deleteClass($id)
    {
        // Delete related attendance records first
        $this->db->query("DELETE FROM attendance WHERE class_id = :id");
        $this->db->bind(':id', $id);
        $this->db->execute();

        // Delete the class
        $this->db->query("DELETE FROM class WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getLecturer($id)
    {
        $this->db->query("SELECT * FROM dosen WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateLecturer($id, $nama_lengkap, $nomor_regis)
    {
        $this->db->query("UPDATE dosen SET nama_lengkap = :nama_lengkap, nomor_regis = :nomor_regis WHERE id = :id");
        $this->db->bind(':id', $id);
        $this->db->bind(':nama_lengkap', $nama_lengkap);
        $this->db->bind(':nomor_regis', $nomor_regis);
        return $this->db->execute();
    }

    public function deleteLecturer($id)
    {
        $this->db->query("DELETE FROM dosen WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getAllStudents()
    {
        $this->db->query("SELECT * FROM mahasiswa");
        return $this->db->resultSet();
    }
}
