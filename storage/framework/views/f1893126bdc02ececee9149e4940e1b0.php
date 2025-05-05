<?php $__env->startSection('content'); ?>
    <style>
        .item {
            transition: opacity 0.3s ease, transform 0.3s ease;
            opacity: 0;
            transform: translateX(50px);
        }

        .hover\:scale-105:hover {
            transform: scale(1.05) !important;
        }

        #slider {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 16px; /* Jarak antar item */
            transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out;
        }

        .package-item {
            width: calc((100% / var(--itemsPerRow)) - 16px);
            max-width: 300px;
        }

        /* Ukuran tablet */
        @media (max-width: 1024px) {
            :root {
                --itemsPerRow: 2;
            }
        }

        /* Ukuran HP */
        @media (max-width: 768px) {
            :root {
                --itemsPerRow: 1;
            }
        }
    </style>
    <!-- banner -->
    <div class="bg-cover bg-no-repeat bg-center h-[1200px] flex items-center" 
        style="background-image: url('assets/images/welcome.jpg');">
        <div class="container text-left">
            <h1 class="text-6xl font-bold mb-4 capitalize bg-gradient-to-r from-orange-700 to-yellow-400 bg-clip-text text-transparent font-[Lora]">
                A wide collection of the best <br> trips for your journey
            </h1>
            <div class="mt-12">
                <a href="#" class="bg-gradient-to-b from-orange-700 to-yellow-400 text-white px-8 py-3 font-medium 
                rounded-md hover:from-yellow-400 hover:to-orange-700 hover:text-white hover:no-underline font-[Lora] transition duration-300">Check Now</a>
            </div>
        </div>
    </div>
    <div class="container pb-16">
        <!-- <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6 mt-10 font-[Lora]">Package List</h2> -->
        <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6 mt-10 font-[Lora] flex items-center relative">
            <span x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" 
                class="relative flex items-center cursor-pointer">
                Package List
                <!-- Wrapper ikon & teks See More -->
                <a href="/shop" class="relative flex items-center ml-1 whitespace-nowrap cursor-pointer">
                <!-- <span class="relative flex items-center ml-1 whitespace-nowrap"> -->
                    <!-- Teks See More (Maju sedikit saat hover) -->
                    <span class="absolute left-0 opacity-0 text-xs font-medium text-gray-600 transition-all duration-300"
                        :class="hover ? 'opacity-100 translate-x-4' : 'translate-x-0'">
                        See More
                    </span>

                    <!-- Wrapper untuk ikon, tetap bergerak jauh saat hover -->
                    <span class="flex items-center transition-transform duration-300"
                        :class="hover ? 'translate-x-20' : 'translate-x-0'">
                        
                        <!-- Ikon ">" (Hanya bergerak saat hover) -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            class="w-5 h-5 text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                <!-- </span> -->
                </a>
            </span>
        </h2>
        <div class="relative w-full flex items-center">
           <!-- Tombol Navigasi Kiri -->
            <button id="slideLeft" class="p-3 rounded-full mr-4"
                style="background-color: rgba(169, 169, 169, 0.3); transition: background-color 0.3s;"
                onmouseover="this.style.backgroundColor='rgba(169, 169, 169, 0.6)';"
                onmouseout="this.style.backgroundColor='rgba(169, 169, 169, 0.3)';">
                <i class="fa-solid fa-arrow-left"></i>
            </button>

            <div id="sliderContainer" class="w-full overflow-hidden">
                <div id="slider" class="flex gap-6 transition-transform duration-300 ease-in-out overflow-x-scroll scroll-smooth justify-center"
                    style="display: flex; flex-wrap: nowrap; scroll-behavior: smooth; scrollbar-width: none;">
                    <?php $__currentLoopData = $package; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white/70 shadow rounded-2xl overflow-hidden flex flex-col items-center p-4 
                            hover:shadow-xl hover:shadow-gray-300/50 hover:scale-105 transition-all duration-300 my-4 mx-2" 
                            style="flex: 0 0 auto; width: 300px;">
                            <div x-data="{
                                    currentIndex: 0, 
                                    total: <?php echo e(count($item->packageImages)); ?>, 
                                    startAutoSlide() {
                                        setInterval(() => {
                                            this.currentIndex = (this.currentIndex + 1) % this.total;
                                        }, 5000);
                                    }
                                }" 
                                x-init="startAutoSlide()" 
                                class="relative w-full aspect-[4/3] overflow-hidden rounded-lg">
                                <a href="/detail-product/<?php echo e($item->id); ?>">
                                    <template x-if="<?php echo e($item->packageImages->isNotEmpty()); ?>">
                                        <div class="relative w-full h-full overflow-hidden">
                                            <div class="flex w-full h-full transition-transform duration-500 ease-in-out"
                                                :style="'transform: translateX(-' + (currentIndex * 100) + '%)'">
                                                <?php $__currentLoopData = $item->packageImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <img src="<?php echo e(asset('img/package/' . $image->image)); ?>" 
                                                        alt="product image" 
                                                        class="w-full h-full object-cover flex-shrink-0">
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </template>
                                    <?php if($item->packageImages->isEmpty()): ?>
                                        <img src="<?php echo e(asset('img/default.png')); ?>" 
                                            alt="default image" 
                                            class="w-full h-full object-cover">
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="pt-4 pb-3 px-4 h-[180px] flex flex-col justify-between w-full">
                                <h4 class="font-medium text-xl text-gray-800 font-[Lora]">
                                    <?php echo e($item->name); ?>

                                </h4>
                                <p class="text-sm text-gray-500 font-[Lora]">
                                    Type : <?php echo e($item->type->name); ?>

                                    <br>
                                    <small><?php echo e($item->descriptions); ?></small>
                                </p>
                                <p class="text-xl text-primary font-semibold text-center font-[Lora]">Rp <?= number_format($item->price, 0, ',' , '.') ?></p>
                                <a href="/detail-product/<?php echo e($item->id); ?>" 
                                    class="mt-3 inline-flex items-center justify-center gap-2 bg-gradient-to-b from-orange-700 to-yellow-400 
                                        text-white px-4 py-2 rounded-lg shadow-md transition duration-300 ease-in-out 
                                        hover:from-orange-800 hover:to-yellow-500 hover:no-underline font-[Lora]">
                                    CHECK NOW !
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Tombol Navigasi Kanan -->
            <button id="slideRight" class="p-3 rounded-full ml-4"
                style="background-color: rgba(169, 169, 169, 0.3); transition: background-color 0.3s;"
                onmouseover="this.style.backgroundColor='rgba(169, 169, 169, 0.6)';"
                onmouseout="this.style.backgroundColor='rgba(169, 169, 169, 0.3)';">
                <i class="fa-solid fa-arrow-right"></i>
            </button>
        </div>
        <div id="pagination" class="flex justify-center mt-4"></div>
    </div>

    <section class="text-center py-12">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900">
            Millions of Users Trust Our Service, See what sets us apart
        </h2>
        
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8 px-6 md:px-20">
            <!-- Feature 1 -->
            <div class="flex flex-col items-center text-center">
                <img src="https://via.placeholder.com/80" alt="Highlighted Sentences" class="mb-4">
                <h3 class="font-bold text-lg">Highlighted Sentences</h3>
                <p class="text-gray-600">
                    Every sentence written by AI is highlighted, with a gauge showing the percentage of AI inside the text.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="flex flex-col items-center text-center">
                <img src="https://via.placeholder.com/80" alt="Multiple Features" class="mb-4">
                <h3 class="font-bold text-lg">Multiple Features</h3>
                <p class="text-gray-600">
                    Enjoy our Top-notch Plagiarism Checker, Paraphraser, Summarizer, Grammar checker, Translator, Writing Assistant...
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="flex flex-col items-center text-center">
                <img src="https://via.placeholder.com/80" alt="High Accuracy Model" class="mb-4">
                <h3 class="font-bold text-lg">High Accuracy Model</h3>
                <p class="text-gray-600">
                    Advanced and premium model, trained on all languages to provide highly accurate results.
                </p>
            </div>

            <!-- Feature 4 -->
            <div class="flex flex-col items-center text-center">
                <img src="https://via.placeholder.com/80" alt="Generated Report" class="mb-4">
                <h3 class="font-bold text-lg">Generated Report</h3>
                <p class="text-gray-600">
                    Automatically generated .pdf reports for every detection, used as a proof of AI-Free plagiarism.
                </p>
            </div>

            <!-- Feature 5 -->
            <div class="flex flex-col items-center text-center">
                <img src="https://via.placeholder.com/80" alt="Support All Languages" class="mb-4">
                <h3 class="font-bold text-lg">Support All Languages</h3>
                <p class="text-gray-600">
                    Support all the languages with the highest accuracy rate of detection.
                </p>
            </div>

            <!-- Feature 6 -->
            <div class="flex flex-col items-center text-center">
                <img src="https://via.placeholder.com/80" alt="Batch Files Upload" class="mb-4">
                <h3 class="font-bold text-lg">Batch Files Upload</h3>
                <p class="text-gray-600">
                    Simply upload multiple files at once, and they will get checked automatically in the dashboard.
                </p>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const slider = document.getElementById('slider');
        const slideLeft = document.getElementById('slideLeft');
        const slideRight = document.getElementById('slideRight');
        const items = Array.from(slider.children);
        let currentPage = 0;

        function getItemsPerPage() {
            const containerWidth = document.getElementById('sliderContainer').offsetWidth;
            const itemWidth = 300 + 16; // Lebar card + gap antar card
            return Math.max(1, Math.floor(containerWidth / itemWidth)); // Hitung berapa item yg bisa muat
        }

        function updateSlider() {
            const itemsPerPage = getItemsPerPage();
            const totalPages = Math.ceil(items.length / itemsPerPage);

            slider.style.setProperty('--itemsPerRow', itemsPerPage); // CSS var untuk grid
            slider.style.opacity = '0';
            slider.style.transform = 'translateY(20px)';

            setTimeout(() => {
                items.forEach((item, index) => {
                    item.style.display = (index >= currentPage * itemsPerPage && index < (currentPage + 1) * itemsPerPage) ? 'block' : 'none';
                });

                slider.style.opacity = '1';
                slider.style.transform = 'translateY(0)';
                slider.style.transition = 'opacity 0.5s ease-in-out, transform 0.5s ease-in-out';
                updatePagination();
            }, 300);
        }

        function updatePagination() {
            const indicators = document.getElementById('pagination');
            indicators.innerHTML = '';
            const itemsPerPage = getItemsPerPage();
            const totalPages = Math.ceil(items.length / itemsPerPage);

            for (let i = 0; i < totalPages; i++) {
                const dot = document.createElement('span');
                dot.classList.add('w-3', 'h-3', 'mx-1', 'rounded-full', 'cursor-pointer', 'inline-block', 'transition-all', 'duration-300');
                dot.style.backgroundColor = i === currentPage ? '#000' : '#ccc';
                dot.style.transform = i === currentPage ? 'scale(0.85)' : 'scale(0.5)';
                dot.addEventListener('click', () => goToPage(i));
                indicators.appendChild(dot);
            }
        }

        function goToPage(page) {
            const totalPages = Math.ceil(items.length / getItemsPerPage());
            if (page < 0 || page >= totalPages) return;
            currentPage = page;
            updateSlider();
        }

        slideLeft.addEventListener('click', () => goToPage(currentPage - 1));
        slideRight.addEventListener('click', () => goToPage(currentPage + 1));

        window.addEventListener('resize', updateSlider);
        updateSlider();
    });
</script>
<?php echo $__env->make('layouts.customer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH B:\Project\Transport\transport\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>