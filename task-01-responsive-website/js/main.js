// To ensure the page loads completely
document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.querySelector(".menu-toggle")
    const menu = document.querySelector("#menu")
    const menuLinks = document.querySelectorAll("#menu a");
    menuToggle.addEventListener("click", () => {
        menu.classList.toggle("active")
        menuToggle.setAttribute(
            "aria-expanded",
            menu.classList.contains("active")
        );
        if (menu.classList.contains("active")) {
            menuToggle.textContent = "✕";
        } else {
            menuToggle.textContent = "☰";
        }
    });
    menuLinks.forEach((link) => {
        link.addEventListener("click", () => {
            menu.classList.remove("active")
            menuToggle.textContent = "☰";
            menuToggle.setAttribute("aria-expanded", "false");
        })
    })

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && menu.classList.contains("active")) {
            menu.classList.remove("active");
            menuToggle.textContent = "☰";
            menuToggle.setAttribute("aria-expanded", "false");
            menuToggle.focus();
        }
    });
});