@extends('layouts.customer')
@section('content')
    <div class="container pb-16">
        <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6 mt-10">Package List</h2>
        <div class="grid md:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-6">
            @foreach ($package as $item)
                <div class="bg-white/70 shadow rounded overflow-hidden group flex flex-col items-center p-4 hover:shadow-xl hover:shadow-gray-300/50 hover:scale-105 transition-all duration-300">
                    <div x-data="{
                            currentIndex: 0, 
                            total: {{ count($item->packageImages) }}, 
                            startAutoSlide() {
                                setInterval(() => {
                                    this.currentIndex = (this.currentIndex + 1) % this.total;
                                }, 5000);
                            }
                        }" 
                        x-init="startAutoSlide()" 
                        class="relative w-full aspect-[4/3] overflow-hidden rounded-lg">
                        <a href="/detail-product/{{ $item->id }}">
                            <template x-if="{{ $item->packageImages->isNotEmpty() }}">
                                <div class="relative w-full h-full overflow-hidden">
                                    <div class="flex w-full h-full transition-transform duration-500 ease-in-out"
                                        :style="'transform: translateX(-' + (currentIndex * 100) + '%)'">
                                        @foreach($item->packageImages as $image)
                                            <img src="{{ asset('img/package/' . $image->image) }}" 
                                                alt="product image" 
                                                class="w-full h-full object-cover flex-shrink-0">
                                        @endforeach
                                    </div>
                                </div>
                            </template>

                            <!-- Jika tidak ada gambar -->
                            @if($item->packageImages->isEmpty())
                                <img src="{{ asset('img/default.jpg') }}" 
                                    alt="default image" 
                                    class="w-full h-full object-cover">
                            @endif
                        </a>

                        <!-- Tombol Navigasi -->
                        <template x-if="total > 1">
                            <button @click="currentIndex = (currentIndex === 0) ? total - 1 : currentIndex - 1"
                                class="absolute left-2 top-1/2 transform -translate-y-1/2 
                                    bg-white/80 text-gray-800 hover:bg-white shadow-lg
                                    w-10 h-10 flex items-center justify-center rounded-full
                                    opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                        </template>

                        <template x-if="total > 1">
                            <button @click="currentIndex = (currentIndex === total - 1) ? 0 : currentIndex + 1"
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 
                                    bg-white/80 text-gray-800 hover:bg-white shadow-lg
                                    w-10 h-10 flex items-center justify-center rounded-full
                                    opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </template>
                    </div>
                    <div class="pt-4 pb-3 px-4 h-[180px] flex flex-col justify-between w-full">
                        <h4 class="font-medium text-xl text-gray-800 font-[Lora]">
                            {{ $item->name }}
                        </h4>
                        <p class="text-sm text-gray-500 font-[Lora]">
                            Type : {{ $item->type->name }}
                            <br>
                            <small>{{ $item->descriptions }}</small>
                        </p>
                        <p class="text-xl text-primary font-semibold text-center font-[Lora]">@currency($item->price)</p>
                        <a href="/detail-product/{{ $item->id }}" 
                            class="mt-3 inline-flex items-center justify-center gap-2 bg-gradient-to-b from-orange-700 to-yellow-400 
                                text-white px-4 py-2 rounded-lg shadow-md transition duration-300 ease-in-out 
                                hover:from-orange-800 hover:to-yellow-500 hover:no-underline font-[Lora]">
                                CHECK NOW !
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
