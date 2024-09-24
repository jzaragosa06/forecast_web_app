<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Tailwind Carousel</title>
    <style>
        .carousel {
            transition: transform 0.5s ease;
        }
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="relative w-96 overflow-hidden">
        <div id="carousel" class="carousel flex">
            <div class="min-w-full">
                <img src="https://via.placeholder.com/400x300/FF5733/FFFFFF?text=Slide+1" alt="Slide 1"
                    class="w-full" />
            </div>
            <div class="min-w-full">
                <img src="https://via.placeholder.com/400x300/33FF57/FFFFFF?text=Slide+2" alt="Slide 2"
                    class="w-full" />
            </div>
            <div class="min-w-full">
                <img src="https://via.placeholder.com/400x300/3357FF/FFFFFF?text=Slide+3" alt="Slide 3"
                    class="w-full" />
            </div>
        </div>
        <button onclick="prevSlide()"
            class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow">❮</button>
        <button onclick="nextSlide()"
            class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow">❯</button>
    </div>

    <script>
        let currentIndex = 0;

        function showSlide(index) {
            const carousel = document.getElementById('carousel');
            const totalSlides = carousel.children.length;
            currentIndex = (index + totalSlides) % totalSlides;
            carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        function nextSlide() {
            showSlide(currentIndex + 1);
        }

        function prevSlide() {
            showSlide(currentIndex - 1);
        }
    </script>
</body>

</html>
