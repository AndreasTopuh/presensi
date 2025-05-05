<?php require_once '../app/views/template/header.php'; ?>
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-3xl font-bold text-gray-900">Dosen Dashboard</h1>
            <p class="mt-2 text-sm text-gray-600">View and manage your assigned classes</p>
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
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Classes</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-4">Class Name</th>
                            <th class="p-4">Day</th>
                            <th class="p-4">Time</th>
                            <th class="p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data['classes'])): ?>
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-600">No classes assigned.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($data['classes'] as $class): ?>
                                <tr class="border-b">
                                    <td class="p-4"><?php echo isset($class['nama_kelas']) ? $class['nama_kelas'] : 'N/A'; ?></td>
                                    <td class="p-4"><?php echo isset($class['hari']) ? $class['hari'] : 'N/A'; ?></td>
                                    <td class="p-4"><?php echo (isset($class['waktu_mulai']) ? $class['waktu_mulai'] : 'N/A') . ' - ' . (isset($class['waktu_selesai']) ? $class['waktu_selesai'] : 'N/A'); ?></td>
                                    <td class="p-4">
                                        <a href="<?php echo BASE_URL; ?>dosen/class/<?php echo $class['id']; ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">View Students</a>
                                    </td>
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