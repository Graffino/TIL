const element = document.querySelector(".js-slide-top");
if (element) {
    element.addEventListener("click", (e) => {
        requestAnimationFrame(() =>
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            })
        );
    });
    window.addEventListener("scroll", function () {
        scrollY > 600
            ? element.classList.replace("hidden", "visible")
            : element.classList.replace("visible", "hidden");
    });
}
