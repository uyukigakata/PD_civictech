document.addEventListener("DOMContentLoaded", () => {
    const switchOuter = document.querySelector(".switch_outer");
    const toggleSwitch = document.querySelector(".toggle_switch");
    const toggleStateInput = document.getElementById("toggleState");
    const submitBtn = document.getElementById("submitBtn");
    const form = document.getElementById("mtForm");

    switchOuter.addEventListener("click", () => {
        switchOuter.classList.toggle("active");
        toggleSwitch.classList.toggle("active");
        toggleStateInput.value = switchOuter.classList.contains("active") ? "on" : "off";
    });

    submitBtn.addEventListener("click", () => {
        form.submit();
    });
});
