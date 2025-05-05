<?php require_once '../app/views/template/header.php'; ?>
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-3xl font-bold text-gray-900">Add New Class</h1>
            <p class="mt-2 text-sm text-gray-600">Fill in the details to create a new class</p>
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

        <!-- Add Class Form -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Class Details</h3>
            <form action="<?php echo BASE_URL; ?>admin/addClass" method="POST">
                <div class="mb-4">
                    <label for="nama_kelas" class="block text-gray-700 font-medium mb-1">Class Name</label>
                    <input type="text" id="nama_kelas" name="nama_kelas" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="dosen_id" class="block text-gray-700 font-medium mb-1">Lecturer</label>
                    <select id="dosen_id" name="dosen_id" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                        <option value="" disabled selected>Select a lecturer</option>
                        <?php foreach ($data['lecturers'] as $lecturer): ?>
                            <option value="<?php echo $lecturer['id']; ?>"><?php echo $lecturer['nama_lengkap']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="hari" class="block text-gray-700 font-medium mb-1">Day</label>
                    <select id="hari" name="hari" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                        <option value="" disabled selected>Select a day</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                        <option value="Minggu">Minggu</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="waktu_mulai" class="block text-gray-700 font-medium mb-1">Start Time</label>
                    <input type="time" id="waktu_mulai" name="waktu_mulai" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="waktu_selesai" class="block text-gray-700 font-medium mb-1">End Time</label>
                    <input type="time" id="waktu_selesai" name="waktu_selesai" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="flex justify-end space-x-4">
                    <a href="<?php echo BASE_URL; ?>admin" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">Back to Dashboard</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Add Class</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once '../app/views/template/footer.php'; ?>