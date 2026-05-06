    // Accordion
    function myFunction(id) {
        var x = document.getElementById(id);
        var caretId = "caret-" + id.replace("Demo", ""); // Create dynamic caret ID
        var caretElement = document.getElementById(caretId).querySelector("i"); // Select the i element
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
            caretElement.className = "fa-solid fa-square-caret-up w3-small"; // Change to up caret
        } else {
            x.className = x.className.replace("w3-show", "");
            caretElement.className = "fa-solid fa-caret-down w3-small"; // Change to down caret
        }
    }
//----------------------
    // Set the date we're counting down to
    //var countDownDate = new Date("Apr 8, 2025 00:00:00").getTime();
    var countDownDate = new Date("May 1, 2025 00:00:00").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        document.getElementById("demo").innerHTML = days + " hari &nbsp;" + hours + " jam &nbsp;" +
            minutes + " menit &nbsp;" + seconds + " detik";

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "";
        }
    }, 1000);
//------------------------
// Get the modal
    var modal = document.getElementById("myModal");

    // Get the image and insert it inside the modal
    var img = document.querySelector(".thumbnail");
    var modalImg = document.getElementById("img01");
    img.addEventListener("click", () => {
        modal.style.display = "block";
        modalImg.src = "images/jerseyzoom.png"; // Replace with your large image source
    });

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Also close it when clicking anywhere on the modal background.
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
//-----
    AOS.init();
//-----

    // Optional JavaScript for older browsers that don't support scroll-behavior: smooth

    if (!('scrollBehavior' in document.documentElement.style)) {
        // Polyfill for smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }
//-----------------------------

