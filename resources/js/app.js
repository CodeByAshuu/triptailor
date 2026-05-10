document.addEventListener("DOMContentLoaded", () => {

    const navbar = document.getElementById("navbar");
    const sections = document.querySelectorAll("[data-theme]");

    const observer = new IntersectionObserver((entries) => {

        entries.forEach(entry => {

            if (entry.isIntersecting) {

                const theme = entry.target.dataset.theme;

                navbar.classList.remove("dark-mode", "light-mode");
                navbar.classList.add(`${theme}-mode`);

                const loginBtn = document.getElementById("loginBtn");
                if (loginBtn) {
                    loginBtn.classList.remove("dark-mode", "light-mode");
                    loginBtn.classList.add(`${theme}-mode`);
                }

            }

        });

    }, {
        rootMargin: "-10% 0px -80% 0px",
        threshold: 0
    });

    sections.forEach(section => observer.observe(section));

});