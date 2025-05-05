<?php require_once '../app/views/template/header.php'; ?>
<div class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-gray-900 text-center mb-6">Add Student to Class</h2>
        <form method="POST" action="">
            <div class="mb-4">
                <label for="nomor_regis" class="block text-gray-700 font-medium mb-2">Reg Number</label>
                <input type="text" name="nomor_regis" id="nomor_regis" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">Add Student</button>
                <a href="<?php echo BASE_URL; ?>dosen" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">Back</a>
            </div>
        </form>
    </div>
</div>
<?php require_once '../app/views/template/footer.php'; ?>