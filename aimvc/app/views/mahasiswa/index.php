<?php require_once '../app/views/template/header.php'; ?>
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-3xl font-bold text-gray-900">Mahasiswa</h1>
            <p class="mt-2 text-sm text-gray-600">View your classes and manage attendance</p>
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

        <!-- Classes Section -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Classes</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-4">Class Name</th>
                            <th class="p-4">Lecturer</th>
                            <th class="p-4">Day</th>
                            <th class="p-4">Time</th>
                            <th class="p-4">Attendance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data['classes'])): ?>
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-600">You are not registered in any classes.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($data['classes'] as $class): ?>
                                <tr class="border-b">
                                    <td class="p-4">
                                        <a href="<?php echo BASE_URL; ?>mahasiswa/classStats/<?php echo $class['id']; ?>" class="text-blue-600 hover:underline">
                                            <?php echo $class['nama_kelas']; ?>
                                        </a>
                                    </td>
                                    <td class="p-4"><?php echo $class['dosen_nama']; ?></td>
                                    <td class="p-4"><?php echo $class['hari']; ?></td>
                                    <td class="p-4"><?php echo $class['waktu_mulai'] . ' - ' . $class['waktu_selesai']; ?></td>
                                    <td class="p-4">
                                        <?php if ($class['attendance_status'] === 'hadir'): ?>
                                            <span class="text-gray-600">Attendance Marked: <?php echo $class['attendance_status']; ?></span>
                                        <?php elseif ($class['can_attend']): ?>
                                            <a href="<?php echo BASE_URL; ?>mahasiswa/markAttendance/<?php echo $class['id']; ?>" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">Mark Attendance</a>
                                        <?php elseif ($class['attendance_status']): ?>
                                            <span class="text-gray-600">Attendance Marked: <?php echo $class['attendance_status']; ?></span>
                                        <?php else: ?>
                                            <span class="text-red-600">Not Available</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Attendance Statistics Section -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Attendance Statistics</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-4">Status</th>
                            <th class="p-4">Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data['stats'])): ?>
                            <tr>
                                <td colspan="2" class="p-4 text-center text-gray-600">No attendance records found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($data['stats'] as $stat): ?>
                                <tr class="border-b">
                                    <td class="p-4"><?php echo $stat['status']; ?></td>
                                    <td class="p-4"><?php echo $stat['count']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require_once '../app/views/template/footer.php'; ?>