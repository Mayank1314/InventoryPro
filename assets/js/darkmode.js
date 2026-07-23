document.addEventListener("DOMContentLoaded", function(){


    const toggle = document.getElementById("darkModeToggle");


    // Apply saved theme on every page load

    if(localStorage.getItem("theme") === "dark"){

        document.body.classList.add("dark-mode");

    }



    if(toggle){


        toggle.addEventListener("click", function(){


            document.body.classList.toggle("dark-mode");


            if(document.body.classList.contains("dark-mode")){


                localStorage.setItem("theme","dark");


            }
            else{


                localStorage.setItem("theme","light");


            }


        });


    }


});