// Anda bisa menambahkan animasi atau interaktivitas di sini
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script loaded');
});

document.addEventListener("DOMContentLoaded", function () {
    const menuIcon = document.querySelector(".menu-icon");
    menuIcon.addEventListener("click", function () {
        alert("Menu clicked! (Fitur ini bisa dihubungkan dengan sidebar)");
    });
});
