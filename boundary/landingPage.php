<?php
$activeSection = isset($_GET['section']) ? $_GET['section'] : 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Tailwind CDN Example</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <nav class="w-full py-6 bg-blue-950 flex justify-end gap-7 pr-4 text-md">
      <a href="?section=home" class="relative inline-block text-white group">
        <span>Home</span>
        <span class="absolute left-0 -bottom-1 h-0.5 bg-blue-500 transition-all duration-300
          <?php echo ($activeSection === 'home') ? 'w-full' : 'w-0 group-hover:w-full'; ?>">
        </span>
      </a>
      <a href="?section=about" class="relative inline-block text-white group">
        <span>About</span>
        <span class="absolute left-0 -bottom-1 h-0.5 bg-blue-500 transition-all duration-300
          <?php echo ($activeSection === 'about') ? 'w-full' : 'w-0 group-hover:w-full'; ?>">
        </span>
      </a>
      <a href="?section=contact" class="relative inline-block text-white group">
        <span>Contact</span>
        <span class="absolute left-0 -bottom-1 h-0.5 bg-blue-500 transition-all duration-300
          <?php echo ($activeSection === 'contact') ? 'w-full' : 'w-0 group-hover:w-full'; ?>">
        </span>
      </a>
      <a href="?section=register" class="relative inline-block text-white group">
        <span>Register</span>
        <span class="absolute left-0 -bottom-1 h-0.5 bg-blue-500 transition-all duration-300
          <?php echo ($activeSection === 'register') ? 'w-full' : 'w-0 group-hover:w-full'; ?>">
        </span>
      </a>
  </nav>
  <div class="mb-100"> 
    <div class="flex items-center justify-center" style="height: calc(100vh - 4rem);">
      <div class="bg-sky-100 shadow-lg rounded-lg w-full h-full">
        
      </div>
    </div>
  </div>
</body>
</html>
