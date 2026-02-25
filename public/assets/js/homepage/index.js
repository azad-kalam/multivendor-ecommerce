// document.addEventListener("DOMContentLoaded", function () {
$(document).ready(function () {
    // Handle submenu toggle
    const submenuLinks = document.querySelectorAll(".dropdown-submenu > a");
    if (submenuLinks.length) {
        submenuLinks.forEach(function (trigger) {
            trigger.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopPropagation();

                const parentLi = this.parentElement;

                // Close all other open submenus
                document.querySelectorAll(".dropdown-submenu").forEach(function (submenuItem) {
                    if (submenuItem !== parentLi) {
                        submenuItem.classList.remove("show");
                    }
                });

                // Toggle current submenu
                parentLi.classList.toggle("show");
            });
        });
    }

    // Close submenus when dropdown closes (Bootstrap required)
    const dropdowns = document.querySelectorAll(".dropdown");
    if (dropdowns.length && typeof bootstrap !== "undefined") {
        dropdowns.forEach(function (dropdown) {
            dropdown.addEventListener("hide.bs.dropdown", function () {
                this.querySelectorAll(".dropdown-submenu").forEach(function (submenuItem) {
                    submenuItem.classList.remove("show");
                });
            });
        });
    }
});
