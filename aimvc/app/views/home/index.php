<?php require_once '../app/views/template/header.php'; ?>
<div class="min-h-screen bg-gray-100 flex items-center justify-center">
  <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-gray-900 text-center mb-6">Login</h2>
    <?php if (isset($_GET['error'])): ?>
      <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
        <?php echo $_GET['error']; ?>
      </div>
    <?php endif; ?>
    <form action="<?php echo BASE_URL; ?>home/login" method="POST">
      <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">Nomor Registrasi</label>
        <input type="text" name="nomor_regis" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">Password</label>
        <input type="password" name="password" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 font-medium mb-2">Role</label>
        <select name="role" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
          <option value="admin">Admin</option>
          <option value="dosen">Dosen</option>
          <option value="mahasiswa">Mahasiswa</option>
        </select>
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition">Login</button>
    </form>
  </div>
</div>
<?php require_once '../app/views/template/footer.php'; ?>