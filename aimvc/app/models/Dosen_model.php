<?php
class Dosen_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function login($nomor_regis, $password)
    {
        $this->db->query("SELECT * FROM dosen WHERE nomor_regis = :nomor_regis");
        $this->db->bind(':nomor_regis', $nomor_regis);
        $user = $this->db->single();
        if ($user && $user['password'] === $password) {
            $user['role'] = 'dosen';
            return $user;
        }
        return false;
    }

    public function getClasses($nomor_regis)
    {
        $this->db->query("SELECT c.*, d.nama_lengkap AS dosen_nama FROM class c JOIN dosen d ON c.dosen_id = d.id WHERE d.nomor_regis = :nomor_regis");
        $this->db->bind(':nomor_regis', $nomor_regis);
        return $this->db->resultSet();
    }

    public function getClassesByDosen($dosen_id)
    {
        $this->db->query("SELECT * FROM class WHERE dosen_id = :dosen_id");
        $this->db->bind(':dosen_id', $dosen_id);
        return $this->db->resultSet();
    }

    public function getClassStudents($class_id)
    {
        $this->db->query("SELECT a.*, m.nama_lengkap, m.nomor_regis FROM attendance a JOIN mahasiswa m ON a.mahasiswa_id = m.id WHERE a.class_id = :class_id");
        $this->db->bind(':class_id', $class_id);
        return $this->db->resultSet();
    }

    public function updateAttendance($id, $status)
    {
        $this->db->query("UPDATE attendance SET status = :status WHERE id = :id");
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);
        $success = $this->db->execute();

        return ['success' => $success, 'message' => $success ? 'Attendance updated successfully' : 'Failed to update attendance'];
    }

    public function addStudentToClass($class_id, $nomor_regis)
    {
        $this->db->query("SELECT id FROM mahasiswa WHERE nomor_regis = :nomor_regis");
        $this->db->bind(':nomor_regis', $nomor_regis);
        $mahasiswa = $this->db->single();

        if (!$mahasiswa) {
            return ['success' => false, 'message' => 'Student not found'];
        }

        $this->db->query("SELECT id FROM attendance WHERE class_id = :class_id AND mahasiswa_id = :mahasiswa_id");
        $this->db->bind(':class_id', $class_id);
        $this->db->bind(':mahasiswa_id', $mahasiswa['id']);
        $existing = $this->db->single();

        if ($existing) {
            return ['success' => false, 'message' => 'Student already enrolled in this class'];
        }

        $this->db->query("INSERT INTO attendance (mahasiswa_id, class_id, status, waktu_absen) VALUES (:mahasiswa_id, :class_id, 'tidak hadir', NOW())");
        $this->db->bind(':mahasiswa_id', $mahasiswa['id']);
        $this->db->bind(':class_id', $class_id);
        $success = $this->db->execute();

        return ['success' => $success, 'message' => $success ? 'Student added successfully' : 'Failed to add student to class'];
    }

    public function searchStudent($nomor_regis)
    {
        $this->db->query("SELECT * FROM mahasiswa WHERE nomor_regis LIKE :nomor_regis");
        $this->db->bind(':nomor_regis', '%' . $nomor_regis . '%');
        return $this->db->resultSet();
    }

    public function getLecturers()
    {
        $this->db->query("SELECT * FROM dosen");
        return $this->db->resultSet();
    }

    public function getDosenId($nomor_regis)
    {
        $this->db->query("SELECT id FROM dosen WHERE nomor_regis = :nomor_regis");
        $this->db->bind(':nomor_regis', $nomor_regis);
        $result = $this->db->single();
        return $result ? $result['id'] : null;
    }

    public function addLecturer($nama_lengkap, $nomor_regis, $password)
    {
        $this->db->query("INSERT INTO dosen (nama_lengkap, nomor_regis, password) VALUES (:nama_lengkap, :nomor_regis, :password)");
        $this->db->bind(':nama_lengkap', $nama_lengkap);
        $this->db->bind(':nomor_regis', $nomor_regis);
        $this->db->bind(':password', $password);
        return $this->db->execute();
    }

    public function deleteStudentFromClass($class_id, $student_id)
    {
        $this->db->query("DELETE FROM attendance WHERE class_id = :class_id AND mahasiswa_id = :student_id");
        $this->db->bind(':class_id', $class_id);
        $this->db->bind(':student_id', $student_id);
        $success = $this->db->execute();
        return ['success' => $success, 'message' => $success ? 'Student removed successfully' : 'Failed to remove student'];
    }

    public function openPresensi($class_id)
    {
        $this->db->query("UPDATE class SET is_presensi_open = TRUE WHERE id = :class_id");
        $this->db->bind(':class_id', $class_id);
        return $this->db->execute();
    }

    public function closePresensi($class_id)
    {
        $this->db->query("UPDATE class SET is_presensi_open = FALSE WHERE id = :class_id");
        $this->db->bind(':class_id', $class_id);
        return $this->db->execute();
    }
}
