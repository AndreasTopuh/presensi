<?php require_once '../app/views/template/header.php'; ?>
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-3xl font-bold text-gray-900">Dosen Class Dashboard</h1>
            <p class="mt-2 text-sm text-gray-600">Manage students and attendance for <?php echo isset($data['class']['nama_kelas']) ? $data['class']['nama_kelas'] : 'N/A'; ?></p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Success/Error Messages -->
        <?php if (isset($_GET['success'])): ?>
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                <?php echo $_GET['success']; ?>
            </div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                <?php echo $_GET['error']; ?>
            </div>
        <?php endif; ?>

        <!-- Class Info -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Class: <?php echo isset($data['class']['nama_kelas']) ? $data['class']['nama_kelas'] : 'N/A'; ?></h3>
            <p class="text-gray-600">Day: <?php echo isset($data['class']['hari']) ? $data['class']['hari'] : 'N/A'; ?></p>
            <p class="text-gray-600">Time: <?php echo (isset($data['class']['waktu_mulai']) ? $data['class']['waktu_mulai'] : 'N/A') . ' - ' . (isset($data['class']['waktu_selesai']) ? $data['class']['waktu_selesai'] : 'N/A'); ?></p>
        </div>

        <!-- Manage Presensi -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Manage Presensi</h3>
            <?php if (!$data['class']['is_presensi_open'] && date('H:i:s') >= $data['class']['waktu_mulai'] && date('H:i:s') <= $data['class']['waktu_selesai']): ?>
                <a href="<?php echo BASE_URL; ?>dosen/openPresensi/<?php echo $data['class']['id']; ?>" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">Open Presensi</a>
            <?php elseif ($data['class']['is_presensi_open']): ?>
                <a href="<?php echo BASE_URL; ?>dosen/closePresensi/<?php echo $data['class']['id']; ?>" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition" onclick="return confirm('Are you sure you want to close presensi?');">Close Presensi</a>
            <?php else: ?>
                <p class="text-gray-600">Presensi can only be opened during class time (<?php echo $data['class']['waktu_mulai'] . ' - ' . $data['class']['waktu_selesai']; ?>).</p>
            <?php endif; ?>
        </div>

        <!-- Search by Reg Number -->
        <div class="bg-white p-4 rounded-lg shadow mb-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Search by Reg Number</h3>
            <form action="<?php echo BASE_URL; ?>dosen/addStudent/<?php echo isset($data['class']['id']) ? $data['class']['id'] : ''; ?>" method="POST" class="flex space-x-2">
            <input type="hidden" name="action" value="search">
            <input type="text" name="nomor_regis" placeholder="Reg Number" class="flex-1 p-2 border rounded focus:ring-1 focus:ring-blue-500 text-sm" required>
            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition text-sm">Search</button>
            </form>
        </div>

        <!-- Search Results -->
        <?php if (isset($data['search_results'])): ?>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Search Results</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="p-4">Name</th>
                                <th class="p-4">Reg Number</th>
                                <th class="p-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($data['search_results'])): ?>
                                <tr>
                                    <td colspan="3" class="p-4 text-center text-gray-600">No students found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($data['search_results'] as $result): ?>
                                    <tr class="border-b">
                                        <td class="p-4"><?php echo isset($result['nama_lengkap']) ? $result['nama_lengkap'] : 'N/A'; ?></td>
                                        <td class="p-4"><?php echo isset($result['nomor_regis']) ? $result['nomor_regis'] : 'N/A'; ?></td>
                                        <td class="p-4">
                                            <form action="<?php echo BASE_URL; ?>dosen/addStudent/<?php echo $data['class']['id']; ?>" method="POST">
                                                <input type="hidden" name="action" value="add">
                                                <input type="hidden" name="nomor_regis" value="<?php echo $result['nomor_regis']; ?>">
                                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">Add to Class</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

        <!-- Students Section -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Students</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-4">Name</th>
                            <th class="p-4">Reg Number</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data['students'])): ?>
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-600">No students found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($data['students'] as $student): ?>
                                <tr class="border-b">
                                    <td class="p-4"><?php echo isset($student['nama_lengkap']) ? $student['nama_lengkap'] : 'N/A'; ?></td>
                                    <td class="p-4"><?php echo isset($student['nomor_regis']) ? $student['nomor_regis'] : 'N/A'; ?></td>
                                    <td class="p-4"><?php echo isset($student['status']) ? $student['status'] : 'N/A'; ?></td>
                                    <td class="p-4 flex space-x-2">
                                        <form action="<?php echo BASE_URL; ?>dosen/updateAttendance/<?php echo $student['id']; ?>" method="POST" class="flex items-center space-x-2">
                                            <select name="status" class="p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                                                <option value="hadir" <?php echo $student['status'] == 'hadir' ? 'selected' : ''; ?>>Hadir</option>
                                                <option value="tidak hadir" <?php echo $student['status'] == 'tidak hadir' ? 'selected' : ''; ?>>Tidak Hadir</option>
                                                <option value="terlambat" <?php echo $student['status'] == 'terlambat' ? 'selected' : ''; ?>>Terlambat</option>
                                            </select>
                                            <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded-lg hover:bg-blue-700 transition">Update</button>
                                        </form>
                                        <form action="<?php echo BASE_URL; ?>dosen/deleteStudentFromClass/<?php echo $data['class']['id']; ?>/<?php echo $student['mahasiswa_id']; ?>" method="POST" onsubmit="return confirm('Are you sure you want to remove this student?');">
                                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>



        <!-- Back Button -->
        <div class="mt-6">
            <a href="<?php echo BASE_URL; ?>dosen" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">Back to Dashboard</a>
        </div>
    </div>
</div>
<?php require_once '../app/views/template/footer.php'; ?>