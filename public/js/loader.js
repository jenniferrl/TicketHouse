document.addEventListener("DOMContentLoaded", function () {//saat DOM fully loaded baru jalankan
    // Hide the loader when the DOM is fully loaded
    var loader = document.getElementById("loader");
    if (loader) {
        loader.style.display = "block";

        // Add a delay 
        setTimeout(function() {
            // Hide the loader after the delay
            loader.style.display = "none";
        }, 500);
    }
});