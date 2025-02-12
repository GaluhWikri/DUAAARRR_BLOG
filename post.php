<?php
session_start();

// Periksa apakah 'id' ada di URL
if (isset($_GET['id']) && isset($_SESSION['articles'][$_GET['id']])) {
    // Ambil artikel berdasarkan ID yang dipilih
    $article = $_SESSION['articles'][$_GET['id']];
} else {
    // Jika ID tidak ditemukan, arahkan ke halaman utama atau tampilkan pesan error
    header('Location: index.php');
    exit();
}
?>

<?php include 'navbar.php'; ?>


   
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .custom-prose p {
            margin-bottom: 1.5em;
        }
    </style>
</head>
<body class="bg-white" style="font-family: Arial, sans-serif; font-weight: bold;">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Grid untuk Gambar dan Teks -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <!-- Gambar Pelengkap -->
            <div class="md:col-span-1.3">
                <img src="img/2.jpg" alt="Mark Krespis Illustration" class="w-full h-auto rounded-lg">
            </div>
            
            <!-- Judul, Tanggal, Penulis, dan Kategori -->
            <div class="md:col-span-2">
                <h1 class="text-3xl font-bold text-gray-900 mb-4 text-left">Illustrator Spotlight: Mark Krespis</h1>
                <p class="text-sm font-boldt ext-gray-500 mb-2 text-left">Published on February 13, 2025 at 00:25</p>
                <p class="text-sm font-bold text-gray-500 mb-4 text-left">By Admin</p>
                <div class="text-sm text-gray-700 text-left">
                    <span class="font-medium">Categories:</span>
                    <a href="#" class="text-black-600 text-left hover:text-black-800">Art</a>
                </div>
            </div>
        </div>

        <!-- Isi Artikel -->
        <div class="custom-prose text-gray-700">
            <p>A selection of work by Toronto-based illustrator Mark Krespis. Of mixed Filipino and Polish descent, Krespis is a recent graduate of Ontario College of Art & Design University. He has illustrated cover art for Toronto artists such as BADBADNOTGOOD and Charlotte Day Wilson.</p>
            <p>After facing a house fire in 2022, Krespis has focused his work towards the tactility and precariousness of reality. Inspired by literature, music, art history, and the absurd, he draws upon themes of human nature relevant in both fine art and lowbrow illustration.</p>
            <p>Mark Krespis participated in our 2024 Booooooom Illustration Awards and made our shortlist. Be the first to know about our next Awards by clicking here and pre-registering for the 2025 Booooooom Illustration Awards!</p>
        </div>
    </div>
</body>

<!-- Section for User Comments -->
<div class="mt-12">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Comments</h2>

    <!-- Form to Add a Comment -->
    <div class="mb-8">
        <form id="commentForm">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black sm:text-sm" required>
            </div>
            <div class="mb-4">
                <label for="comment" class="block text-sm font-medium text-gray-700">Your Comment</label>
                <textarea id="comment" name="comment" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black sm:text-sm" required></textarea>
            </div>
            <button type="submit" class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">Submit Comment</button>
        </form>
    </div>

    <!-- List of Comments -->
    <div id="commentsList" class="space-y-6">
        <!-- Example Comment (You can dynamically generate these with JavaScript) -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <div class="flex items-center mb-2">
                <span class="font-bold text-gray-900">John Doe</span>
                <span class="text-sm text-gray-500 ml-2">• February 14, 2025 at 10:30</span>
            </div>
            <p class="text-gray-700">This is an example comment. Mark Krespis's work is truly inspiring!</p>
        </div>

        <!-- Another Example Comment -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <div class="flex items-center mb-2">
                <span class="font-bold text-gray-900">Jane Smith</span>
                <span class="text-sm text-gray-500 ml-2">• February 15, 2025 at 08:15</span>
            </div>
            <p class="text-gray-700">I love how he blends fine art and lowbrow illustration. Great article!</p>
        </div>
    </div>
</div>

    <footer>
        <div class="footer-content">
            <p>&copy; 2025 BOOOOOOOM. All rights reserved.</p>
            <ul>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">Privacy Policy</a></li>
            </ul>
        </div>
    </footer>

    <script src="scripts.js"></script>
</body>

</html>