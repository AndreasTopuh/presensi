<?php
class Mahasiswa_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function login($nomor_regis, $password)
    {
        $this->db->query("SELECT * FROM mahasiswa WHERE nomor_regis = :nomor_regis");
        $this->db->bind(':nomor_regis', $nomor_regis);
        $user = $this->db->single();
        if ($user && $user['password'] === $password) {
            $user['role'] = 'mahasiswa';
            return $user;
        }
        return false;
    }

    public function getClasses($mahasiswa_id)
    {
        $this->db->query("
            SELECT c.*, d.nama_lengkap AS dosen_nama 
            FROM class c 
            JOIN dosen d ON c.dosen_id = d.id 
            JOIN attendance a ON c.id = a.class_id 
            WHERE a.mahasiswa_id = :mahasiswa_id
        ");
        $this->db->bind(':mahasiswa_id', $mahasiswa_id);
        return $this->db->resultSet();
    }

    public function getClassById($class_id)
    {
        $this->db->query("
            SELECT c.*, d.nama_lengkap AS dosen_nama 
            FROM class c 
            JOIN dosen d ON c.dosen_id = d.id 
            WHERE c.id = :class_id
        ");
        $this->db->bind(':class_id', $class_id);
        return $this->db->single();
    }

    public function getAttendanceStats($nomor_regis)
    {
        $this->db->query("SELECT status, COUNT(*) as count FROM attendance a JOIN mahasiswa m ON a.mahasiswa_id = m.id WHERE m.nomor_regis = :nomor_regis GROUP BY status");
        $this->db->bind(':nomor_regis', $nomor_regis);
        return $this->db->resultSet();
    }

    public function getClassAttendanceStats($mahasiswa_id, $class_id)
    {
        $this->db->query("SELECT status, COUNT(*) as count FROM attendance WHERE mahasiswa_id = :mahasiswa_id AND class_id = :class_id GROUP BY status");
        $this->db->bind(':mahasiswa_id', $mahasiswa_id);
        $this->db->bind(':class_id', $class_id);
        return $this->db->resultSet();
    }

    public function hasAttended($class_id, $mahasiswa_id)
    {
        $this->db->query("SELECT status FROM attendance WHERE class_id = :class_id AND mahasiswa_id = :mahasiswa_id");
        $this->db->bind(':class_id', $class_id);
        $this->db->bind(':mahasiswa_id', $mahasiswa_id);
        $result = $this->db->single();
        return $result ? $result['status'] : false;
    }

    public function canAttend($class_id)
    {
        $this->db->query("SELECT waktu_mulai, waktu_selesai, is_presensi_open FROM class WHERE id = :class_id");
        $this->db->bind(':class_id', $class_id);
        $class = $this->db->single();
        if ($class) {
            date_default_timezone_set('Asia/Makassar'); // Pastikan zona waktu WIB
            $current_time = date('H:i:s');
            return ($class['is_presensi_open'] && $current_time >= $class['waktu_mulai'] && $current_time <= $class['waktu_selesai']);
        }
        return false;
    }

    public function markAttendance($class_id, $mahasiswa_id)
    {
        $this->db->query("SELECT id FROM attendance WHERE class_id = :class_id AND mahasiswa_id = :mahasiswa_id");
        $this->db->bind(':class_id', $class_id);
        $this->db->bind(':mahasiswa_id', $mahasiswa_id);
        $existing = $this->db->single();

        if ($existing) {
            $this->db->query("UPDATE attendance SET status = 'hadir', waktu_absen = NOW() WHERE id = :id");
            $this->db->bind(':id', $existing['id']);
        } else {
            $this->db->query("INSERT INTO attendance (mahasiswa_id, class_id, status, waktu_absen) VALUES (:mahasiswa_id, :class_id, 'hadir', NOW())");
            $this->db->bind(':mahasiswa_id', $mahasiswa_id);
            $this->db->bind(':class_id', $class_id);
        }
        return $this->db->execute();
    }
}
