<?php require_once '../app/views/template/header.php'; ?>
<div class="min-h-screen bg-gray-100">
    <!-- Dashboard Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
            <p class="mt-2 text-sm text-gray-600">Manage classes, lecturers, and students efficiently</p>
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

        <!-- Dashboard Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-900">Total Classes</h3>
                <p class="mt-2 text-3xl font-bold text-blue-600"><?php echo count($data['classes']); ?></p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-900">Total Lecturers</h3>
                <p class="mt-2 text-3xl font-bold text-blue-600"><?php echo count($data['lecturers']); ?></p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-900">Total Students</h3>
                <p class="mt-2 text-3xl font-bold text-blue-600"><?php echo count($data['students']); ?></p>
            </div>
        </div>

        <!-- Classes Section -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Classes</h3>
                <a href="<?php echo BASE_URL; ?>admin/addClass" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add New Class</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-4">Class Name</th>
                            <th class="p-4">Lecturer</th>
                            <th class="p-4">Day</th>
                            <th class="p-4">Time</th>
                            <th class="p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['classes'] as $class): ?>
                            <tr class="border-b">
                                <td class="p-4"><?php echo $class['nama_kelas']; ?></td>
                                <td class="p-4"><?php echo $class['dosen_nama']; ?></td>
                                <td class="p-4"><?php echo $class['hari']; ?></td>
                                <td class="p-4"><?php echo $class['waktu_mulai'] . ' - ' . $class['waktu_selesai']; ?></td>
                                <td class="p-4">
                                    <button onclick="openEditClassModal(<?php echo $class['id']; ?>)" class="text-blue-600 hover:underline">Edit</button>
                                    <form action="<?php echo BASE_URL; ?>admin/deleteClass/<?php echo $class['id']; ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this class?');">
                                        <button type="submit" class="text-red-600 hover:underline ml-2">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Lecturers Section -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Lecturers</h3>
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
                        <?php foreach ($data['lecturers'] as $lecturer): ?>
                            <tr class="border-b">
                                <td class="p-4"><?php echo $lecturer['nama_lengkap']; ?></td>
                                <td class="p-4"><?php echo $lecturer['nomor_regis']; ?></td>
                                <td class="p-4">
                                    <button onclick="openEditModal(<?php echo $lecturer['id']; ?>)" class="text-blue-600 hover:underline">Edit</button>
                                    <form action="<?php echo BASE_URL; ?>admin/deleteLecturer/<?php echo $lecturer['id']; ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this lecturer?');">
                                        <button type="submit" class="text-red-600 hover:underline ml-2">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Students Section -->
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Students</h3>
                <button onclick="toggleStudents()" id="toggleStudentBtn" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Hide Students</button>
            </div>
            <div class="overflow-x-auto">
                <table id="studentTable" class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-4">Name</th>
                            <th class="p-4">Reg Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['students'] as $student): ?>
                            <tr class="border-b">
                                <td class="p-4"><?php echo $student['nama_lengkap']; ?></td>
                                <td class="p-4"><?php echo $student['nomor_regis']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Lecturer Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg max-w-md w-full">
            <h3 class="text-xl font-bold mb-4">Edit Lecturer</h3>
            <form id="editForm">
                <input type="hidden" id="editId" name="id">
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Name</label>
                    <input type="text" id="editNama" name="nama_lengkap" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Reg Number</label>
                    <input type="text" id="editNomor" name="nomor_regis" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
                    <button type="button" onclick="closeEditModal()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 ml-2">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Class Modal -->
    <div id="editClassModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg max-w-md w-full">
            <h3 class="text-xl font-bold mb-4">Edit Class</h3>
            <form id="editClassForm">
                <input type="hidden" id="editClassId" name="id">
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Class Name</label>
                    <input type="text" id="editClassName" name="nama_kelas" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Lecturer</label>
                    <select id="editDosenId" name="dosen_id" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                        <?php foreach ($data['lecturers'] as $lecturer): ?>
                            <option value="<?php echo $lecturer['id']; ?>"><?php echo $lecturer['nama_lengkap']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Day</label>
                    <select id="editHari" name="hari" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
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
                    <label class="block text-gray-700 font-medium mb-1">Start Time</label>
                    <input type="time" id="editWaktuMulai" name="waktu_mulai" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">End Time</label>
                    <input type="time" id="editWaktuSelesai" name="waktu_selesai" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
                    <button type="button" onclick="closeEditClassModal()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 ml-2">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditModal(id) {
        fetch('<?php echo BASE_URL; ?>admin/editLecturer/' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editId').value = data.id;
                document.getElementById('editNama').value = data.nama_lengkap;
                document.getElementById('editNomor').value = data.nomor_regis;
                document.getElementById('editModal').classList.remove('hidden');
            })
            .catch(error => console.error('Error fetching lecturer data:', error));
    }

    function openEditClassModal(id) {
        fetch('<?php echo BASE_URL; ?>admin/editClass/' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editClassId').value = data.id;
                document.getElementById('editClassName').value = data.nama_kelas;
                document.getElementById('editDosenId').value = data.dosen_id;
                document.getElementById('editHari').value = data.hari;
                document.getElementById('editWaktuMulai').value = data.waktu_mulai;
                document.getElementById('editWaktuSelesai').value = data.waktu_selesai;
                document.getElementById('editClassModal').classList.remove('hidden');
            })
            .catch(error => console.error('Error fetching class data:', error));
    }

    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        fetch('<?php echo BASE_URL; ?>admin/updateLecturer', {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeEditModal();
                    location.reload();
                } else {
                    alert('Update failed: ' + data.message);
                }
            })
            .catch(error => console.error('Error updating lecturer:', error));
    });

    document.getElementById('editClassForm').addEventListener('submit', function(e) {
        e.preventDefault();
        fetch('<?php echo BASE_URL; ?>admin/updateClass', {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeEditClassModal();
                    location.reload();
                } else {
                    alert('Update failed: ' + data.message);
                }
            })
            .catch(error => console.error('Error updating class:', error));
    });

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    function closeEditClassModal() {
        document.getElementById('editClassModal').classList.add('hidden');
    }

    function toggleStudents() {
        const table = document.getElementById('studentTable');
        const button = document.getElementById('toggleStudentBtn');
        if (table.style.display === 'none') {
            table.style.display = 'table';
            button.textContent = 'Hide Students';
        } else {
            table.style.display = 'none';
            button.textContent = 'View Students';
        }
    }
</script>
<?php require_once '../app/views/template/footer.php'; ?>