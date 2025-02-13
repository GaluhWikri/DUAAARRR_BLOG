
document.addEventListener("DOMContentLoaded", function () {
    const filterButtons = document.querySelectorAll(".filter-btn");
    const articles = document.querySelectorAll(".article");

    filterButtons.forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            const filter = this.getAttribute("data-filter");

            articles.forEach(article => {
                const category = article.getAttribute("data-category");

                if (filter === "all" || category === filter) {
                    article.classList.remove("opacity-0", "scale-90");
                    article.classList.add("opacity-100", "scale-100");
                    setTimeout(() => {
                        article.style.display = "block";
                    }, 300);
                } else {
                    article.classList.remove("opacity-100", "scale-100");
                    article.classList.add("opacity-0", "scale-90");
                    setTimeout(() => {
                        article.style.display = "none";
                    }, 300);
                }
            });
        });
    });
});
