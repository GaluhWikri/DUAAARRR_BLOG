<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>

    <main class="max-w-6xl mx-auto py-12 px-4">
        <h1 class="text-4xl font-bold text-gray-800 text-center mb-8">Latest Articles</h1>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php for($i = 1; $i <= 4; $i++): ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition">
                    <a href="post.php?id=<?php echo $i; ?>" class="block">
                        <img src="img/2.jpg" alt="Article <?php echo $i; ?>" class="w-full h-56 object-cover">
                        <div class="p-4">
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">Article <?php echo $i; ?> Title</h2>
                            <p class="text-gray-600 text-sm mb-2">
                                <time datetime="2025-02-12T14:30:00">12.02.25 – 14:30</time>
                                – <span class="font-semibold">John Doe</span>
                                – <span class="text-blue-500">Tech</span>
                            </p>
                            <p class="text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                            <button class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500">Read More</button>
                        </div>
                    </a>
                </div>
            <?php endfor; ?>
        </div>
    </main>

    <footer class="bg-gray-900 text-white py-6 mt-12">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center px-4">
            <p class="text-gray-400">&copy; 2025 BOOOOOOOM. All rights reserved.</p>
            <ul class="flex space-x-4 mt-2 md:mt-0">
                <li><a href="#" class="hover:text-gray-300">About</a></li>
                <li><a href="#" class="hover:text-gray-300">Contact</a></li>
                <li><a href="#" class="hover:text-gray-300">Privacy Policy</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>
