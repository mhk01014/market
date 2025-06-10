<?php
require_once '..\database\dbconnect.php';
require_once '..\controller\productController.php';

$db = new Database();

$controller = new ProductController();
$products = $controller->getAllProducts();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Products Grid</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

<h1 class="text-3xl font-bold mb-6 text-center">Product List</h1>

<?php if (!empty($products)): ?>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <?php foreach ($products as $row): ?>
      <div class="bg-white rounded-lg shadow p-4 flex flex-col">
        <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="h-48 object-contain mb-4" />
        <h2 class="text-lg font-semibold mb-2"><?php echo htmlspecialchars($row['name']); ?></h2>
        <p class="text-gray-600 flex-grow"><?php echo htmlspecialchars($row['description']); ?></p>
        <p class="mt-4 font-bold text-blue-600">$<?php echo number_format($row['price'], 2); ?></p>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <p class="text-center text-gray-500">No products found.</p>
<?php endif; ?>
</body>
</html>