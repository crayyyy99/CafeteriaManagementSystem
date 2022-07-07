<!DOCTYPE html>
<html>
    <head>
        <title>SCOS -Home</title>
        <link rel = "stylesheet" type="text/css" href = "style.css">
        <link rel = "stylesheet" type="text/css" href = "style-responsive.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
            var slideIndex = 1;
            var myTimer;
            var slideshowContainer;

            //KEEP ARROWS PART OF MOUSEENTER PAUSE/RESUME
            window.addEventListener("load",function() {
                showSlides(slideIndex);
                myTimer = setInterval(function(){plusSlides(1)}, 4000);
            
                slideshowContainer = document.getElementsByClassName('slideshow-inner')[0];
            
                slideshowContainer.addEventListener('mouseenter', pause);
                slideshowContainer.addEventListener('mouseleave', resume);
            })

            //NEXT AND PREVIOUS CONTROL
            function plusSlides(n){
            clearInterval(myTimer);
            if (n < 0){
                showSlides(slideIndex -= 1);
            } else {
            showSlides(slideIndex += 1); 
            }

            if (n === -1){
                myTimer = setInterval(function(){plusSlides(n + 2)}, 4000);
            } else {
                myTimer = setInterval(function(){plusSlides(n + 1)}, 4000);
            }
            }

            //Controls the current slide and resets interval if needed
            function currentSlide(n){
            clearInterval(myTimer);
            myTimer = setInterval(function(){plusSlides(n + 1)}, 4000);
            showSlides(slideIndex = n);
            }

            function showSlides(n){
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";
            dots[slideIndex-1].className += " active";
            }           

            pause = () => {
            clearInterval(myTimer);
            }

            resume = () =>{
            clearInterval(myTimer);
            myTimer = setInterval(function(){plusSlides(slideIndex)}, 4000);
            }

        </script>

    </head>

    <body>
    <div class="index-content-right">
                <div id="slideshow-inner">
                    <div class="mySlides fade">
                        <img src='image/background4.jpg' style="width:100%;object-position: 20% 100%;">
                    </div>
                    <div class="mySlides fade">
                        <img src='image/20211025_Facemask-btn-min.jpg' style="width:80%"> 
                    </div>
                    <div class="mySlides fade">
                        <img src='image/20211202_Omicron2-btn.jpg' style="width:80%;object-position: 23% 70%;">
                    </div>
                    <div class="mySlides fade">
                        <img src='image/20211204_PatusSOP.jpg' style="width:80%;object-position: 23% 70%;">
                    </div>
                    <div class="mySlides fade">
                        <img src='image/background3.jpg' style="width:100%;">
                    </div>
                    <div class="mySlides fade">
                        <img src='image/food/20211208_184537.png' style="width:100%;object-position: 100% 80%;">
                    </div>
                </div>
            
                <div>
                <a class="prev" onclick='plusSlides(-1)'>&#10094;</a>
                <a class="next" onclick='plusSlides(1)'>&#10095;</a>
                </div>

                <div class="color-box"></div>
            
                <div style='text-align: center;'>
                    <span class="dot" onclick='currentSlide(1)'></span>
                    <span class="dot" onclick='currentSlide(2)'></span>
                    <span class="dot" onclick='currentSlide(3)'></span>
                    <span class="dot" onclick='currentSlide(4)'></span>
                    <span class="dot" onclick='currentSlide(5)'></span>
                    <span class="dot" onclick='currentSlide(6)'></span>
                </div>     
            </div>   
        </section>

    </body>
</html>