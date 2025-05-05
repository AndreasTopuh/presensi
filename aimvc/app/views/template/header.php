<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Presensi System</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
  <nav class="bg-blue-600 text-white p-4">
    <div class="container mx-auto flex justify-between">
      <h1>Presensi</h1>
      <div>
        <?php if (isset($_SESSION['user'])): ?>
          <span>Hi, <?php echo $_SESSION['user']['nama_lengkap']; ?> | </span>
          <a href="<?php echo BASE_URL; ?>home/logout" class="text-red-200">Logout</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>