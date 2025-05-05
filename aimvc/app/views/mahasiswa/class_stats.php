<?php require_once '../app/views/template/header.php'; ?>
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-3xl font-bold text-gray-900">Class Attendance Statistics</h1>
            <p class="mt-2 text-sm text-gray-600">Attendance details for <?php echo isset($data['class']['nama_kelas']) ? $data['class']['nama_kelas'] : 'N/A'; ?></p>
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
            <p class="text-gray-600">Lecturer: <?php echo isset($data['class']['dosen_nama']) ? $data['class']['dosen_nama'] : 'N/A'; ?></p>
            <p class="text-gray-600">Day: <?php echo isset($data['class']['hari']) ? $data['class']['hari'] : 'N/A'; ?></p>
            <p class="text-gray-600">Time: <?php echo (isset($data['class']['waktu_mulai']) ? $data['class']['waktu_mulai'] : 'N/A') . ' - ' . (isset($data['class']['waktu_selesai']) ? $data['class']['waktu_selesai'] : 'N/A'); ?></p>
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
                                <td colspan="2" class="p-4 text-center text-gray-600">No attendance records found for this class.</td>
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

        <!-- Back Button -->
        <div class="mt-6">
            <a href="<?php echo BASE_URL; ?>mahasiswa" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">Back to Dashboard</a>
        </div>
    </div>
</div>
<?php require_once '../app/views/template/footer.php'; ?>