
// document.addEventListener("DOMContentLoaded", function () {
$(document).ready(function () {
    const inputWrapper = document.querySelector(".input-number");
    if (!inputWrapper) return;

    const input = inputWrapper.querySelector("input[type='number']");
    const btnUp = inputWrapper.querySelector(".qty-up");
    const btnDown = inputWrapper.querySelector(".qty-down");

    const min = parseInt(input.getAttribute("min")) || 1;
    const max = parseInt(input.getAttribute("max")) || Infinity;

    // Decrement button
    btnDown.addEventListener("click", function () {
        let value = parseInt(input.value) - 1;
        if (value < min) value = min;
        input.value = value;
    });

    // Increment button
    btnUp.addEventListener("click", function () {
        let value = parseInt(input.value) + 1;
        if (value > max) value = max;
        input.value = value;
    });
});
