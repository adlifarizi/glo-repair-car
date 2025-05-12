@extends('main.layouts.app')

@section('title', 'Ulasan')

@section('content')
    <div>
        <!-- Dialog -->
        @include('admin.components.dialog', ['id' => 'dialog-success', 'show' => false, 'type' => 'success', 'message' => ''])
        @include('admin.components.dialog', ['id' => 'dialog-error', 'show' => false, 'type' => 'error', 'message' => ''])

        <!-- Hero -->
        <section class="flex justify-center items-center bg-hero-image bg-cover h-72 md:h-96">
            <div class="flex flex-col justify-center items-center">
                <p class="text-base text-white text-center">
                    Beranda | <b>Ulasan</b>
                </p>
                <h1 class="text-3xl md:text-4xl font-bold text-white text-center">
                    Ulasan
                </h1>
            </div>
        </section>

        <!-- Daftar Ulasan dan Form -->
        <section class="flex flex-col gap-8 justify-center items-center py-10 md:py-14 px-4 md:px-10 lg:px-16 xl:px-24">
            <div class="w-full sm:w-5/6 flex flex-col justify-center items-center">
                <h2 class="text-3xl md:text-4xl font-bold text-red-700 text-center mb-8">
                    Apa yang Mereka Katakan?
                </h2>

                <!-- Swiper Container -->
                <div class="swiper testimonialSwiper w-full relative pb-4">
                    <div class="swiper-wrapper" id="testimonial-wrapper">
                        <!-- Add at least one placeholder slide -->
                        <div class="swiper-slide">Loading...</div>
                    </div>

                    <!-- Pagination -->
                    <div class="swiper-pagination"></div>
                </div>

            </div>

            <!-- Form Ulasan -->
            <div class="w-full sm:w-5/6 flex flex-col justify-center items-center">
                <h2 class="text-3xl md:text-4xl font-bold text-red-700 text-center mb-8">
                    Berikan Feedback Anda terhadap Kinerja Kami
                </h2>

                <form class="w-full" id="feedback-form">
                    @csrf
                    <!-- Rating -->
                    <div class="flex justify-center mb-4 space-x-2" id="stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button" class="text-5xl md:text-6xl focus:outline-none star-button"
                                data-value="{{ $i }}">
                                <span class="star text-red-500" data-index="{{ $i }}">&#9733;</span> <!-- Default solid -->
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating" value="5"> <!-- default value -->

                    <!-- Form Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <input type="text" name="nama_pelanggan" placeholder="Nama"
                            class="border border-gray-300 rounded p-2 w-full" required>
                        <input type="text" maxlength="20" name="plat_no" placeholder="Nomor Plat Kendaraan yang Pernah Diservis"
                            class="border border-gray-300 rounded p-2 w-full" required>
                    </div>

                    <textarea name="feedback" rows="5" placeholder="Ulasan" maxlength="255"
                        class="w-full border border-gray-300 rounded p-2 mb-4" required></textarea>

                    <button type="submit" id="submit-button"
                        class="bg-red-500 text-white py-2 w-48 md:w-64 rounded hover:bg-red-600 block mx-auto">
                        <span id="submit-button-text">Kirim Ulasan</span>
                        <div id="spinner" class="hidden" role="status">
                            <i class="fa-solid fa-spinner animate-spin"></i>
                        </div>
                    </button>
                </form>

            </div>
        </section>

    </div>

    <script src="{{ asset('js/main/feedback.js') }}" defer></script>

    <style>
        .testimonialSwiper .swiper-pagination {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
        }

        .testimonialSwiper .swiper-slide {
            margin-bottom: 20px;
        }

        /* Bullet aktif warna merah */
        .swiper-pagination-bullet-active {
            background-color: #ef4444; /* red-500 */
            opacity: 1;
        }

        /* Custom style for fixed height text with line clamp */
        .line-clamp-4 {
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            min-height: 6rem; /* Adjust this value to match 4 lines of your text */
            word-break: break-word; /* Memecah kata yang sangat panjang */
            overflow-wrap: break-word; /* Alternatif untuk browser yang lebih baru */
            word-wrap: break-word; /* Untuk kompatibilitas browser */
        }
    </style>
@endsection