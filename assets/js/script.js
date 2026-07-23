document.addEventListener("DOMContentLoaded", function () {

    /* Counter Animation */

    document.querySelectorAll(".counter").forEach(counter => {

        const target = parseInt(counter.dataset.target);
        let count = 0;

        const speed = Math.ceil(target / 50);

        function updateCounter(){

            count += speed;

            if(count >= target){

                counter.innerText = target;

            }else{

                counter.innerText = count;

                requestAnimationFrame(updateCounter);

            }

        }

        updateCounter();

    });


    /* Theme Toggle */

    const toggle = document.getElementById("themeToggle");
    const body = document.body;

    if(toggle){

        if(localStorage.getItem("theme") === "light"){

            body.classList.remove("dark-mode");
            toggle.innerHTML = '<i class="bi bi-moon-stars-fill"></i>';

        }else{

            body.classList.add("dark-mode");
            toggle.innerHTML = '<i class="bi bi-sun-fill"></i>';

        }

        toggle.addEventListener("click", function(){

            body.classList.toggle("dark-mode");

            if(body.classList.contains("dark-mode")){

                localStorage.setItem("theme","dark");
                toggle.innerHTML = '<i class="bi bi-sun-fill"></i>';

            }else{

                localStorage.setItem("theme","light");
                toggle.innerHTML = '<i class="bi bi-moon-stars-fill"></i>';

            }

        });

    }

});