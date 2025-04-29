<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$clearance = $_SESSION['clearance'];
$images = [];
if ($clearance == 'T') {
    $images = ['TopSecret.png', 'Secret.png', 'Confidential.png', 'Unclassified.png'];
} elseif ($clearance == 'S') {
    $images = ['Secret.png', 'Confidential.png', 'Unclassified.png'];
} elseif ($clearance == 'C') {
    $images = ['Confidential.png', 'Unclassified.png'];
} elseif ($clearance == 'U') {
    $images = ['Unclassified.png'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center p-6">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-4xl">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <h3 class="text-xl font-semibold text-gray-700 mb-6">Authorized Images</h3>
        <?php if (empty($images)): ?>
            <p class="text-gray-600">No images available.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php foreach ($images as $image): ?>
                    <div class="flex flex-col items-center">
                        <img src="Files/<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($image); ?>" class="w-48 h-48 object-cover rounded-md shadow">
                        <span class="mt-2 text-sm text-gray-600"><?php echo htmlspecialchars($image); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="logout.php" method="POST" class="mt-8">
            <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition duration-200">Log Out</button>
        </form>
    </div>
</body>
</html>
