<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PENAKs`E</title>
    <link href="{{ asset('global_assets') }}/images/PENAKsE Icon.png" rel="icon">
    <meta name="description"
        content="PENAKs`E adalah Aplikasi yang digunakan untuk melakukan evaluasi atas kinerja instansi pemerintah, dengan fokus pada perencanaan, penganggaran, dan pelaporan kinerja yang terintegrasi di lingkungan Pemerintah Kabupaten Wonosobo yang dilakukan secara elektronik. SAKIP bertujuan untuk meningkatkan akuntabilitas dan efektivitas kinerja instansi pemerintah, serta mendorong terwujudnya tata kelola pemerintahan yang baik." />
    <meta name="keywords"
        content="PENAKs`E, eSakip, eSakip Wonosobo, Sakip, Sakip Wonosobo, Sistem Akuntabilitas Kinerja Instansi Pemerintah" />
    <meta name="author" content="esakipwonosobo" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <livewire:styles />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom sticky header styles */
        .header-sticky {
            position: -webkit-sticky;
            /* For Safari */
            position: sticky;
            top: 0;
            z-index: 50;
            /* Ensure it stays above other content */
        }

        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1000;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            /* Could be responsive */
            max-width: 500px;
            border-radius: 8px;
            position: relative;
        }

        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow header-sticky">
        <div class="container mx-auto flex justify-between items-center py-6 px-6 lg:px-20">
            <a href="{{ '/' }}" class="text-2xl font-bold text-blue-600">
                <img src="{{ asset('global_assets') }}/images/PENAKsE Icon.png" alt=""
                    style="width:50px; height:60px; margin-top:-30px; margin-bottom:-160px;">
            </a>

            <!-- Tombol Menu untuk Mobile -->
            <button id="menu-toggle"
                class="lg:hidden flex items-center px-3 py-2 border rounded text-gray-700 border-gray-400 hover:text-blue-600 hover:border-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>

            <!-- Menu Navigasi -->
            <nav id="navbar-menu" class="hidden lg:flex lg:items-center lg:space-x-6">
                <ul class="flex space-x-6">
                    <li><a href="#" class="beranda text-gray-700 hover:text-green-600">Beranda</a></li>
                    <li><a href="#alur" class="text-gray-700 hover:text-green-600">Alur</a></li>
                    <li><a href="#statistik" class="text-gray-700 hover:text-green-600">Statistik</a></li>
                    {{-- <li><a href="#galeri" class="text-gray-700 hover:text-green-600">Galeri</a></li> --}}
                    <li><a href="#berita" class="text-gray-700 hover:text-green-600">Berita</a></li>
                    <li><a href="#kontak" class="text-gray-700 hover:text-green-600">Kontak</a></li>
                    <li>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-green-600">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-600">Login</a>
                            @endauth
                        @endif
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Menu Dropdown untuk Mobile -->
        <div id="mobile-menu"
            class="lg:hidden hidden absolute top-16 right-0 mt-2 w-48 bg-white border border-gray-200 shadow-lg">
            <ul class="space-y-2 py-2 px-4">
                <li><a href="#" class="block text-gray-700 hover:text-green-600">Beranda</a></li>
                <li><a href="#alur" class="block text-gray-700 hover:text-green-600">Alur</a></li>
                <li><a href="#statistik" class="block text-gray-700 hover:text-green-600">Statistik</a></li>
                {{-- <li><a href="#galeri" class="block text-gray-700 hover:text-green-600">Galeri</a></li> --}}
                <li><a href="#berita" class="block text-gray-700 hover:text-green-600">Berita</a></li>
                <li><a href="#kontak" class="block text-gray-700 hover:text-green-600">Kontak</a></li>
                <li>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="block text-gray-700 hover:text-green-600">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="block text-gray-700 hover:text-green-600">Login</a>
                        @endauth
                    @endif
                </li>
            </ul>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="beranda" class="bg-cover bg-center"
        style="background-image: url('{{ asset('global_assets/images/SAKIP2022.jpg') }}'); background-size: cover; background-position: center;">
        <div class="bg-gray-800 bg-opacity-60">
            <div class="container mx-auto text-center py-32">
                <h1 class="text-4xl font-bold text-white mb-2">Penilaian Akuntabilitas Kinerja secara Elektronik
                    (PENAKs'E)
                </h1>
                <h1 class="text-3xl font-bold text-white mb-6">Pemerintah Kabupaten Wonosobo</h1>
                <p class="text-xl text-gray-200 mb-8"><i>" Performance Accountability is Key "</i></p>
                {{-- <a href="{{ route('login') }}"
                    class="bg-green-600 opacity-80 text-white font-semibold py-3 px-8 rounded-lg shadow hover:bg-green-500">
                    Let's Start !</a> --}}
            </div>
        </div>
    </section>

    <!-- Beranda Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto text-center px-4 md:px-6 lg:px-10 max-w-screen-xl">
            <h2 class="text-4xl font-bold text-gray-800 mb-12">Tahap Evaluasi SAKIP</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-10">
                <div class="flex flex-col items-center">
                    <div
                        class="bg-green-100 p-6 rounded-xl shadow hover:shadow-xl transition-transform duration-300 transform hover:scale-105 hover:-translate-y-2">
                        <i class="fa-solid fa-users text-4xl text-green-800 opacity-75 mb-4"></i>
                        <h3 class="text-2xl font-bold mb-2">Perangkat Daerah</h3>
                        <p class="text-gray-600">Perangkat Daerah Objek Evaluasi Sistem Akuntabilitas
                            Kinerja Instansi Pemerintah (SAKIP) adalah Seluruh Perangkat Daerah Kabupaten Wonosobo.
                        </p>
                    </div>
                </div>
                <div class="flex flex-col items-center">
                    <div
                        class="bg-green-100 p-6 rounded-xl shadow hover:shadow-xl transition-transform duration-300 transform hover:scale-105 hover:-translate-y-2">
                        <i class="fa-solid fa-pen-to-square text-4xl text-green-800 opacity-75 mb-4"></i>
                        <h3 class="text-2xl font-bold mb-2">Pengisian LKE</h3>
                        <p class="text-gray-600">Pengisian LKE oleh Seluruh Perangkat Daerah Kabupaten Wonosobo sesuai
                            dengan jadwal yang telah ditetapkan.<br><br></p>
                    </div>
                </div>
                <div class="flex flex-col items-center">
                    <div
                        class="bg-green-100 p-6 rounded-xl shadow hover:shadow-xl transition-transform duration-300 transform hover:scale-105 hover:-translate-y-2">
                        <i class="fa-solid fa-check text-4xl text-green-800 opacity-75 mb-4"></i>
                        <h3 class="text-2xl font-bold mb-2">Penilaian LKE</h3>
                        <p class="text-gray-600">Evaluasi dan Penilaian dilakukan oleh Aparat Pengawas Internal
                            Pemerintah (APIP).<br><br>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Alur Section -->
    <section id="alur" class="py-20 bg-white">
        <div class="container mx-auto text-center px-4 md:px-6 lg:px-10 max-w-screen-xl">
            <h2 class="text-4xl font-bold text-gray-800 mb-12 mt-6">Alur Evaluasi SAKIP</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-10">
                <div class="flex flex-col items-center">
                    <div
                        class="bg-green-100 p-6 rounded-xl shadow hover:shadow-xl transition-transform duration-300 transform hover:scale-105 hover:-translate-y-2">
                        <i class="fa-solid fa-1 text-4xl text-green-800 opacity-75 mb-4"></i>
                        <h3 class="text-2xl font-bold mb-2">Akses PENAKs'E</h3>
                        <p class="text-gray-600">Perangkat Daerah mengakses portal aplikasi PENAKs'E melalui laman <a
                                href="{{ '/' }}"><b><u>esakip.wonosobokab.go.id</u></b></a>
                        </p>
                    </div>
                </div>
                <div class="flex flex-col items-center">
                    <div
                        class="bg-green-100 p-6 rounded-xl shadow hover:shadow-xl transition-transform duration-300 transform hover:scale-105 hover:-translate-y-2">
                        <i class="fa-solid fa-2 text-4xl text-green-800 opacity-75 mb-4"></i>
                        <h3 class="text-2xl font-bold mb-2">Login Sistem</h3>
                        <p class="text-gray-600">Perangkat Daerah <b>Login</b> dengan menggunakan
                            <b><i>Username</i></b> dan <b><i>Password</i></b> yang telah diberikan.
                        </p>
                    </div>
                </div>
                <div class="flex flex-col items-center">
                    <div
                        class="bg-green-100 p-6 rounded-xl shadow hover:shadow-xl transition-transform duration-300 transform hover:scale-105 hover:-translate-y-2">
                        <i class="fa-solid fa-3 text-4xl text-green-800 opacity-75 mb-4"></i>
                        <h3 class="text-2xl font-bold mb-2">Pengisian LKE</h3>
                        <p class="text-gray-600">Perangkat Daerah melakukan pengisian <b>Lembar Kerja Evaluasi
                                (LKE)</b> secara mandiri.
                        </p>
                    </div>
                </div>
                <div class="flex flex-col items-center">
                    <div
                        class="bg-green-100 p-6 rounded-xl shadow hover:shadow-xl transition-transform duration-300 transform hover:scale-105 hover:-translate-y-2">
                        <i class="fa-solid fa-4 text-4xl text-green-800 opacity-75 mb-4"></i>
                        <h3 class="text-2xl font-bold mb-2">Evaluasi & Penilaian</h3>
                        <p class="text-gray-600">APIP melakukan Evaluasi dan Penilaian atas hasil pengisian LKE
                            yang dilaksanakan oleh Perangkat Daerah.
                        </p>
                    </div>
                </div>
                <div class="flex flex-col items-center">
                    <div
                        class="bg-green-100 p-6 rounded-xl shadow hover:shadow-xl transition-transform duration-300 transform hover:scale-105 hover:-translate-y-2">
                        <i class="fa-solid fa-5 text-4xl text-green-800 opacity-75 mb-4"></i>
                        <h3 class="text-2xl font-bold mb-2">Masa Sanggah</h3>
                        <p class="text-gray-600">Perangkat Daerah diberikan kesempatan sanggah atas hasil Evaluasi dan
                            Penilaian LKE sesuai jadwal yang ditetapkan.</p>
                    </div>
                </div>
                <div class="flex flex-col items-center">
                    <div
                        class="bg-green-100 p-6 rounded-xl shadow hover:shadow-xl transition-transform duration-300 transform hover:scale-105 hover:-translate-y-2">
                        <i class="fa-solid fa-6 text-4xl text-green-800 opacity-75 mb-4"></i>
                        <h3 class="text-2xl font-bold mb-2">Pengumuman</h3>
                        <p class="text-gray-600">Pengumuman Nilai Akhir Hasil Evaluasi SAKIP dilaksanakan sesuai jadwal
                            yang ditetapkan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistik Section -->
    <section id="statistik" class="py-20 bg-gray-50">
        <div class="container mx-auto text-center px-4 md:px-6 lg:px-10 max-w-screen-xl">

            <div class="flex items-center justify-between mb-6 mt-4 relative">
                <div class="hidden md:block w-1/3"></div>

                <h2 class="text-4xl font-bold text-gray-800 text-center flex-grow">Statistik</h2>

                <div class="flex space-x-2 justify-end w-1/3">
                    <button id="openFilterModal"
                        class="px-2 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 flex items-center"
                        title="Filter Tahun">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="size-5 inline-block align-middle">
                            <path
                                d="M10 3.75a2 2 0 1 0-4 0 2 2 0 0 0 4 0ZM17.25 4.5a.75.75 0 0 0 0-1.5h-5.5a.75.75 0 0 0 0 1.5h5.5ZM5 3.75a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5a.75.75 0 0 1 .75.75ZM4.25 17a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5h1.5ZM17.25 17a.75.75 0 0 0 0-1.5h-5.5a.75.75 0 0 0 0 1.5h5.5ZM9 10a.75.75 0 0 1-.75.75h-5.5a.75.75 0 0 1 0-1.5h5.5A.75.75 0 0 1 9 10ZM17.25 10.75a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5h1.5ZM14 10a2 2 0 1 0-4 0 2 2 0 0 0 4 0ZM10 16.25a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                        </svg>
                        {{-- Filter --}}
                    </button>
                    <button id="resetFilterButton"
                        class="px-2 py-1 bg-gray-500 text-white text-sm rounded hover:bg-gray-600 flex items-center"
                        title="Reset Chart">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="size-5 inline-block align-middle">
                            <path fill-rule="evenodd"
                                d="M10 4.5c1.215 0 2.417.055 3.604.162a.68.68 0 0 1 .615.597c.124 1.038.208 2.088.25 3.15l-1.689-1.69a.75.75 0 0 0-1.06 1.061l2.999 3a.75.75 0 0 0 1.06 0l3.001-3a.75.75 0 1 0-1.06-1.06l-1.748 1.747a41.31 41.31 0 0 0-.264-3.386 2.18 2.18 0 0 0-1.97-1.913 41.512 41.512 0 0 0-7.477 0 2.18 2.18 0 0 0-1.969 1.913 41.16 41.16 0 0 0-.16 1.61.75.75 0 1 0 1.495.12c.041-.52.093-1.038.154-1.552a.68.68 0 0 1 .615-.597A40.012 40.012 0 0 1 10 4.5ZM5.281 9.22a.75.75 0 0 0-1.06 0l-3.001 3a.75.75 0 1 0 1.06 1.06l1.748-1.747c.042 1.141.13 2.27.264 3.386a2.18 2.18 0 0 0 1.97 1.913 41.533 41.533 0 0 0 7.477 0 2.18 2.18 0 0 0 1.969-1.913c.064-.534.117-1.071.16-1.61a.75.75 0 1 0-1.495-.12c-.041.52-.093 1.037-.154 1.552a.68.68 0 0 1-.615.597 40.013 40.013 0 0 1-7.208 0 .68.68 0 0 1-.615-.597 39.785 39.785 0 0 1-.25-3.15l1.689 1.69a.75.75 0 0 0 1.06-1.061l-2.999-3Z"
                                clip-rule="evenodd" />
                        </svg>
                        {{-- Reset --}}
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 p-2">
                <div class="col-span-1">
                    <livewire:dashboard.chart-statistik-penilaian-opd />
                </div>
            </div>
            <div class="grid grid-cols-1 gap-8 p-2">
                <div class="col-span-1">
                    <livewire:dashboard.chart-statistik-penilaian-kec />
                </div>
            </div>
        </div>
    </section>

    <div id="filterModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h3 class="text-xl font-bold mb-4">Filter Data Chart</h3>
            <div class="mb-4">
                <label for="modalTahunInput" class="block text-sm font-medium text-gray-700">Tahun:</label>
                <input type="text" id="modalTahunInput" placeholder="Contoh: 2025"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
            <button id="applyFilterButton" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Terapkan
                Filter</button>
        </div>
    </div>

    @livewireScripts

    <script>
        // --- Modal Control JavaScript ---
        const filterModal = document.getElementById('filterModal');
        const openFilterModalBtn = document.getElementById('openFilterModal');
        const closeButton = document.querySelector('.close-button');
        const applyFilterBtn = document.getElementById('applyFilterButton');
        const modalTahunInput = document.getElementById('modalTahunInput');
        const resetFilterButton = document.getElementById('resetFilterButton');

        // Variabel untuk menyimpan tahun terakhir yang difilter
        // Inisialisasi dengan tahun saat ini sebagai default awal
        let lastFilteredTahun = new Date().getFullYear();

        openFilterModalBtn.onclick = function() {
            filterModal.style.display = 'flex';
            // Mengisi input modal dengan tahun terakhir yang difilter
            modalTahunInput.value = lastFilteredTahun;
        }

        closeButton.onclick = function() {
            filterModal.style.display = 'none';
        }

        applyFilterBtn.onclick = function() {
            const selectedTahun = modalTahunInput.value;

            // Simple validation (menggunakan SweetAlert seperti sebelumnya)
            if (selectedTahun && !/^\d{4}$/.test(selectedTahun)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Input Tidak Valid!',
                    text: 'Tahun harus 4 digit angka.',
                    confirmButtonText: 'Oke'
                });
                return;
            }

            // Update lastFilteredTahun dengan nilai yang baru difilter
            lastFilteredTahun = selectedTahun;

            Livewire.dispatch('tahunFilterUpdated', {
                tahun: selectedTahun
            });
            filterModal.style.display = 'none';
        }

        // --- Event Listener untuk Tombol Reset ---
        resetFilterButton.onclick = function() {
            Livewire.dispatch('tahunFilterUpdated', {
                tahun: null
            });

            lastFilteredTahun = new Date().getFullYear();

            modalTahunInput.value = lastFilteredTahun;

            filterModal.style.display = 'none';
        }
    </script>

    <!-- Galeri Section -->
    {{-- <section id="galeri" class="py-20 bg-white">
        <div class="container mx-auto text-center px-4 md:px-6 lg:px-10 max-w-screen-xl">
            <h2 class="text-4xl font-bold text-gray-800 mb-8 mt-6">Galeri</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-10">
                @foreach ($galeryData as $row)
                    <div class="flex flex-col items-center">
                        <img src="{{ route('helper.show-picture', ['path' => $row->filename]) }}"
                            data-description="{{ $row->keterangan }}" onclick="openModal(this)"
                            class="cursor-pointer rounded-xl shadow-md hover:shadow-xl transition-transform duration-300 transform hover:scale-110 hover:-translate-y-2"
                            style="width:400px; height:230px;" title="Click for View">
                        <p class="text-gray-600 mt-4 mb-2" style="font-size: 9pt;">
                            <b>[ <i>{{ $row->keterangan }}</i> ]</b>
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section> --}}

    <!-- Berita Section -->
    @php
        use Carbon\Carbon;
    @endphp
    <section id="berita" class="py-20 bg-gray-50">
        <div class="container mx-auto text-center px-4 md:px-6 lg:px-10 max-w-screen-xl">
            <h2 class="text-4xl font-bold text-gray-800 mb-4 mt-6">Berita</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-10" id="beritacontent">
            </div>
            <div class="flex justify-end mt-6">
                <a href="https://website.wonosobokab.go.id/newsall" target="_blank"
                    class="text-green-600 hover:text-green-800 font-semibold transition duration-300">
                    Read another news ->
                </a>
            </div>
            {{-- @endif --}}
        </div>
    </section>

    <!-- Kontak Section -->
    <section id="kontak" class="py-20 bg-green-800 bg-opacity-75 text-white">
        <div class="container mx-auto">
            <h2 class="text-4xl font-bold text-center text-white mb-16">Kontak</h2>
            <div class="flex flex-wrap">
                <!-- Contact Information -->
                <div class="w-full lg:w-1/3 px-20 mb-8 lg:mb-0">
                    <p class="text-sm leading-relaxed">
                        <strong class="block text-xs mb-2">INSPEKTORAT DAERAH KABUPATEN WONOSOBO</strong>
                        <hr class="border-t-2 border-white mt-1" style="margin-bottom: -10px;">
                        <br> <i class="fa-solid fa-location-dot mr-2 mb-2"></i> Jl. T. Jogonegoro No. 35 KP. 56311
                        <br> <i class="fa-solid fa-phone mr-1 mb-2"></i> (0286)321039
                        <br> <i class="fa-solid fa-fax mr-1 mb-2"></i> (0286)321039
                        <br> <i class="fa-solid fa-envelope mr-1 mb-2"></i> <a
                            href="mailto: inspektoratkabwonosobo@gmail.com"
                            class="no-underline hover:underline hover:text-gray-300">
                            inspektoratkabwonosobo@gmail.com</a>
                        <br> <i class="fa-solid fa-globe mr-1 mb-2"></i> <a
                            href="https://inspektorat.wonosobokab.go.id" target="_blank"
                            class="no-underline hover:underline hover:text-gray-300">https://inspektorat.wonosobokab.go.id</a>
                        <br> <i class="fa-solid fa-map-location-dot mr-1 mb-2"></i> <a
                            href="https://maps.app.goo.gl/qbtvLwGe4KoaiLjKA" target="_blank"
                            class="no-underline hover:underline hover:text-gray-300">maps</a>
                    </p>
                </div>

                <!-- Social Media Links -->
                <div class="w-full lg:w-1/3 px-8 mb-8 lg:mb-0">
                    <strong class="block text-xs mb-2">MEDIA SOSIAL</strong>
                    <hr class="border-t-2 border-white mb-4">
                    <ul class="space-y-1">
                        <li class="flex items-center">
                            <a href="https://wa.me/6281323323923?text=Hi," target="_blank"><i
                                    class="fa-brands fa-whatsapp mr-3"></i>WhatsApp</a>
                        </li>
                        <li class="flex items-center">
                            <a href="https://x.com/inspektorat_wsb" target="_blank"><i
                                    class="fa-brands fa-x-twitter mr-3"></i>@inspektorat_wsb</a>
                        </li>
                        <li class="flex items-center">
                            <a href="https://www.instagram.com/inspektorat_wonosobo/" target="_blank"><i
                                    class="fa-brands fa-instagram mr-3"></i>@inspektorat_wonosobo</a>
                        </li>
                    </ul>
                </div>

                <!-- Image Section -->
                <div class="w-full lg:w-1/3 px-20 mb-8 lg:mb-0">
                    <strong class="block text-xs mb-2">LOKASI KAMI</strong>
                    <hr class="border-t-2 border-white mb-4">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.801565562772!2d109.897628!3d-7.376124!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7aa10892a10003%3A0xcb4313034834b65f!2sKantor%20Inspektorat%20Kabupaten%20Wonosobo!5e0!3m2!1sen!2sid!4v1750750685906!5m2!1sen!2sid"
                        width="320" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4">
        <div class="container mx-auto text-center" style="font-size:8pt;">
            &copy; 2025
            @if (now()->year != 2025)
                - {{ now()->year }}
            @endif
            | PENAKs`E <a href="https://inspektorat.wonosobokab.go.id" class="text-green-500 hover:text-green-400"
                target="_blank">Inspektorat Daerah Kabupaten Wonosobo</a><br>Powered by <a
                href="https://diskominfo.wonosobokab.go.id/" class="text-green-500 hover:text-green-400"
                target="_blank">Diskominfo</a> | Mas@guNk86
        </div>
    </footer>

    <!-- Back to Top -->
    <a href="#"
        class="back-to-top fixed bottom-3 right-5 hidden bg-green-600 text-white p-2 rounded-full shadow-lg">
        <i class="fa-solid fa-chevron-up"></i>
    </a>

    <!-- Modal Galery -->
    {{-- <div id="imageModal"
        class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50 transition-opacity duration-300 ease-in-out"
        style="opacity: 0;">
        <div class="bg-white p-2 rounded-lg shadow-lg max-w-3xl mx-4 transition-transform transform scale-95">
            <button id="closeModal" class="absolute top-0 right-0 m-2 text-gray-500 hover:text-gray-800">
            </button>
            <img id="modalImage" src="" alt="Detail Gambar" class="rounded-lg w-full h-auto">
            <p id="modalDescription" class="text-gray-600 mt-4 text-center"></p>
        </div>
    </div> --}}

    <!-- JavaScript -->

    <!-- Toggle Menu -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
    <!-- Sertakan plugin untuk translasi bahasa -->
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/locale/id.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/advancedFormat.js"></script>
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            var menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

    <script>
        $.ajax({
            url: 'https://api.wonosobokab.go.id/api/news',
            type: 'GET',
            success: function(response) {
                var beritaContainer = $('#beritacontent');
                beritaContainer.empty();
                response.forEach(function(item) {

                    var beritaItem = `<div
                            class="flex flex-col items-center rounded-lg shadow-md hover:shadow-xl transition-transform duration-300 transform hover:scale-110 hover:-translate-y-2">
                            <p class="text-gray-600 mt-2 p-2" style="font-size: 9pt;">
                                <b><i><a href="https://website.wonosobokab.go.id/news-detail/${item.slug}"
                                            target="_blank"
                                            title="Click for News Detail">${item.title}</a></i></b>
                            </p>
                            <a href="https://website.wonosobokab.go.id/news-detail/${item.slug}"
                                target="_blank" title="Click for News Detail">
                                    <img src="https://website.wonosobokab.go.id/show-picture?path=${item.gambarmuka.path}"
                                        class="rounded-xl p-2" style="width:400px; height:230px; object-fit:cover;">
                            </a>
                            <p class="text-gray-600 mt-2 mb-2" style="font-size: 9pt;">
                            ${dayjs(item.date).format('dddd, DD MMMM YYYY')} &nbsp;|&nbsp; <i
                                    class="fa-solid fa-user text-green-800 opacity-75 mb-4"></i>
                                Upload by Admin &nbsp;|&nbsp; <a
                                    href="https://website.wonosobokab.go.id/news-detail/${item.slug}"
                                    target="_blank" class="text-green-600 hover:text-green-800 transition duration-300"
                                    title="Baca Berita">Read
                                    -></a>
                            </p>
                        </div>`
                    // Append setiap item ke container
                    beritaContainer.append(beritaItem);
                    console.log(item);
                });
            },
            error: function(error) {
                console.log('Error:', error);
            }
        });
    </script>

    <!-- Back to Top Button -->
    <script>
        const backToTopButton = document.querySelector('.back-to-top');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                backToTopButton.classList.remove('hidden');
            } else {
                backToTopButton.classList.add('hidden');
            }
        });

        backToTopButton.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>

    <script>
        const berandaButton = document.querySelector('.beranda');
        berandaButton.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>

    <!-- Modal -->
    {{-- <script>
        function openModal(imgElement) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            const modalDescription = document.getElementById('modalDescription');

            modalImage.src = imgElement.src;
            modalDescription.innerText = imgElement.getAttribute('data-description');

            modal.classList.remove('hidden');

            // Add transition effects
            setTimeout(() => {
                modal.style.opacity = '1';
                modal.querySelector('.transform').classList.remove('scale-95');
                modal.querySelector('.transform').classList.add('scale-100');
            }, 10);
        }

        document.getElementById('closeModal').addEventListener('click', function() {
            const modal = document.getElementById('imageModal');

            // Add transition effects
            modal.style.opacity = '0';
            modal.querySelector('.transform').classList.remove('scale-100');
            modal.querySelector('.transform').classList.add('scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        });

        window.addEventListener('click', function(event) {
            const modal = document.getElementById('imageModal');
            if (event.target === modal) {
                modal.style.opacity = '0';
                modal.querySelector('.transform').classList.remove('scale-100');
                modal.querySelector('.transform').classList.add('scale-95');

                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
        });
    </script> --}}

    <!-- Fitur Disabilitas -->
    <style>
        .btn-container {
            margin-bottom: 10px;
            text-align: center;
        }

        .greyscaleall {
            -webkit-filter: grayscale(100%);
            -moz-filter: grayscale(100%);
            -ms-filter: grayscale(100%);
            -o-filter: grayscale(100%);
            filter: grayscale(100%);
        }

        .mycheckbox {
            font-size: 12px;
            color: black;
            font-weight: 500;
        }

        .btn-color-mode-switch {
            display: inline-block;
            margin: 0px;
            position: relative;
        }

        .btn-color-mode-switch>label.btn-color-mode-switch-inner {
            margin: 0px;
            width: 170px;
            height: 26px;
            background: #E0E0E0;
            border-radius: 26px;
            overflow: hidden;
            position: relative;
            transition: all 0.3s ease;
            display: block;
        }

        .btn-color-mode-switch>label.btn-color-mode-switch-inner:before {
            content: attr(data-on);
            cursor: pointer;
            position: absolute;
            font-size: 12px;
            font-weight: bold;
            top: 5px;
            right: 25px;
            margin-bottom: 5px;
        }

        .btn-color-mode-switch>label.btn-color-mode-switch-inner:after {
            content: attr(data-off);
            cursor: pointer;
            width: 85px;
            height: 22px;
            font-size: 12px;
            background: #fff;
            border-radius: 26px;
            position: absolute;
            left: 2px;
            top: 2px;
            font-weight: bold;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0px 0px 6px -2px #111;
            padding: 2px 0px;
            margin-bottom: 10px;
        }

        .btn-color-mode-switch input[type="checkbox"] {
            cursor: pointer;
            width: 70px;
            height: 25px;
            opacity: 0;
            position: absolute;
            top: 0;
            z-index: 1;
            padding: 2px 0px;
            margin: 0px;
        }

        .btn-color-mode-switch input[type="checkbox"]:checked+label.btn-color-mode-switch-inner {
            background: #E0E0E0;
            color: black;
            font-weight: bold;
            font-size: 12px;
        }

        .btn-color-mode-switch input[type="checkbox"]:checked+label.btn-color-mode-switch-inner:after {
            content: attr(data-on);
            left: 83px;
            background: white;
            font-weight: bold;
            font-size: 12px;
        }

        .btn-color-mode-switch input[type="checkbox"]:checked+label.btn-color-mode-switch-inner:before {
            content: attr(data-off);
            right: auto;
            left: 15px;
            color: black;
            font-weight: bold;
            font-size: 12px;
        }

        .btn-color-mode-switch input[type="checkbox"]:checked~.alert {
            display: block;
        }

        .toolbar-disabilitas {
            position: fixed;
            top: 6%;
            left: 0;
            z-index: 999;
            height: 1px;
            width: -180px;
            text-align: center;
            background: transparent !important;
            background-color: transparent !important;
        }

        .open-toolbar {
            margin-top: 100%;
            /* atur posisi button toolbar disabilitas */
            padding-top: 8px;
            padding-right: 5px;
            padding-left: 5px;
            padding-bottom: 3px;
            height: 50px;
            border: none;
            width: 50px;
        }

        .toolbar-disabilitas .open-toolbar {
            background: #4054b2;

        }


        .toolbar-disabilitas .groupcontenttoolbar {
            transform: translateX(-180px);
            transition: transform 0.6s;
        }


        .toolbar-disabilitas.show-toolbar .groupcontenttoolbar {
            transform: translateX(0px);

        }

        .contenttoolbar_disabilitas {
            margin-top: 100%;
            /* atur posisi button toolbar disabilitas */
            padding-top: 15px;
            display: flex;
            flex-direction: column;
            height: max-content;
            border: 1px solid black;
            box-shadow: 0 10px 10px rgb(0 0 0 / 0.2);
            background-color: white;
            width: 180px;
            word-break: break-all;
            overflow: hidden;
        }


        .groupcontenttoolbar {
            display: flex;
            flex-direction: row;

            height: 1px;

            background-color: transparent !important;

        }

        .titletools {
            font-size: 13px !important;
            font-weight: bold;
            margin-bottom: 10px;
            padding-left: 5px;
            padding-right: 5px;
            color: black;
        }


        .bodytools {
            left: 0;
            height: max-content;
            width: 100%;
            margin-bottom: 10px;
        }

        .subtitletools {
            font-size: 12px !important;
            margin-bottom: 5px;
            cursor: pointer;
            left: 0;
            font-family: Arial, Helvetica, sans-serif;
            padding-left: 10px;
            text-align: left;
            color: black
        }

        .subtitletoolsactive {
            background-color: black;
            font-size: 12px !important;
            margin-bottom: 5px;
            cursor: pointer;
            left: 0;
            padding-top: 5px;
            padding-left: 10px;
            padding-bottom: 5px;
            text-align: left;
            color: white;
            font-weight: bold;
        }

        .subtitletools:hover,
        .subtitletools:focus,
        .subtitletools:active {
            background-color: black;
            color: white;
            font-weight: bold;
            font-size: 12;
            max-width: 100%;
            padding-top: 5px;
            padding-left: 10px;
            padding-bottom: 5px;

        }

        .flexrowdata {
            display: flex;
            flex-direction: row;
            height: 100%;
            width: 100%;
        }

        .flexrowtext {
            display: flex;
            flex-direction: column;

            height: 100%;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .datatextinfo {
            display: flex;
            flex-direction: row;
            width: 100%;
            justify-content: center;

        }

        .texttulisan {
            color: black;
            font-size: 18px;
            font-weight: bold;
        }

        @media only screen and (max-width: 900px) {
            .toolbar-disabilitas {
                top: 11%;
            }
        }
    </style>

    <span id="loadmodaldisabilitas"></span>
    <script type="text/javascript">
        localStorage.removeItem("permismobile");
        localStorage.removeItem("permisvoice");
        var arraybase64 = [];


        function speachmobile(value) {
            var voicecek = localStorage.getItem("permismobile");
            if (voicecek != null && voicecek == "on") {
                if (responsiveVoice.voiceSupport()) {
                    responsiveVoice.speak(value, "Indonesian Female");
                }
            }
        }


        function speach(value) {
            var voicecek = localStorage.getItem("permisvoice");
            if (voicecek != null && voicecek == "on") {
                var speechSynthesis = window.speechSynthesis;
                speechSynthesis.cancel();
                if ("speechSynthesis" in window) {
                    const to_speak = new SpeechSynthesisUtterance(value || "");
                    to_speak.lang = "id-ID";
                    speechSynthesis.getVoices();
                    speechSynthesis.speak(to_speak);
                } else {
                    alert("not supported");
                }
            }
        }

        if (!window.James) {
            James = {};
        }
        James.Selector = {};
        James.Selector.mouseup = function() {
            var userSelection;
            if (window.getSelection) {
                userSelection = window.getSelection();
            } else if (document.selection) {
                userSelection = document.selection.createRange();
            }
            var selectedText = userSelection;
            if (userSelection.text) selectedText = userSelection.text;
            if (selectedText != "") {
                var textvalue = window.getSelection().toString();
                speach(textvalue);
                speachmobile(textvalue);
            }
        };
        $(document).ready(function() {
            $(document).bind("mouseup", James.Selector.mouseup);
        });
        $(document).ready(function() {
            document.addEventListener("selectionchange", function(event) {
                var voicecek = localStorage.getItem("permismobile");
                if (voicecek != null && voicecek == "on") {
                    const selection = window.getSelection();
                    if (selection.rangeCount === 0) {
                        return;
                    }
                    const range = selection.getRangeAt(0);
                    const rect = range.getBoundingClientRect();
                    const text = selection.toString();
                    if (!isBlank(text) || text != undefined || text != "") {
                        speachmobile(text);

                    }
                }

            });
        });

        function isBlank(str) {
            return !str || /^\s*$/.test(str);
        }
        var dataspeachweb = `


          <div class="subtitletools" id="webspeach">
          <div class="flexrowdata">

       <span><svg version="1.1" class='fontawesomesvg' width="1em"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 448">
           <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zm2 226.3c37.1 22.4 62 63.1 62 109.7s-24.9 87.3-62 109.7c-7.6 4.6-17.4 2.1-22-5.4s-2.1-17.4 5.4-22C269.4 401.5 288 370.9 288 336s-18.6-65.5-46.5-82.3c-7.6-4.6-10-14.4-5.4-22s14.4-10 22-5.4zm-91.9 30.9c6 2.5 9.9 8.3 9.9 14.8V400c0 6.5-3.9 12.3-9.9 14.8s-12.9 1.1-17.4-3.5L113.4 376H80c-8.8 0-16-7.2-16-16V312c0-8.8 7.2-16 16-16h33.4l35.3-35.3c4.6-4.6 11.5-5.9 17.4-3.5zm51 34.9c6.6-5.9 16.7-5.3 22.6 1.3C249.8 304.6 256 319.6 256 336s-6.2 31.4-16.3 42.7c-5.9 6.6-16 7.1-22.6 1.3s-7.1-16-1.3-22.6c5.1-5.7 8.1-13.1 8.1-21.3s-3.1-15.7-8.1-21.3c-5.9-6.6-5.3-16.7 1.3-22.6z"/>
           </svg></span>
          &nbsp;&nbsp;<div id="twebspeach" class="aksestexttools">Moda Suara</div>
         </div>
         </div>
          `;

        var datamobileweb = `

<div class="subtitletools" id="mobileapp">
<div class="flexrowdata">

<span><svg version="1.1" class='fontawesomesvg' width="1em"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 448">
<path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zm2 226.3c37.1 22.4 62 63.1 62 109.7s-24.9 87.3-62 109.7c-7.6 4.6-17.4 2.1-22-5.4s-2.1-17.4 5.4-22C269.4 401.5 288 370.9 288 336s-18.6-65.5-46.5-82.3c-7.6-4.6-10-14.4-5.4-22s14.4-10 22-5.4zm-91.9 30.9c6 2.5 9.9 8.3 9.9 14.8V400c0 6.5-3.9 12.3-9.9 14.8s-12.9 1.1-17.4-3.5L113.4 376H80c-8.8 0-16-7.2-16-16V312c0-8.8 7.2-16 16-16h33.4l35.3-35.3c4.6-4.6 11.5-5.9 17.4-3.5zm51 34.9c6.6-5.9 16.7-5.3 22.6 1.3C249.8 304.6 256 319.6 256 336s-6.2 31.4-16.3 42.7c-5.9 6.6-16 7.1-22.6 1.3s-7.1-16-1.3-22.6c5.1-5.7 8.1-13.1 8.1-21.3s-3.1-15.7-8.1-21.3c-5.9-6.6-5.3-16.7 1.3-22.6z"/>
</svg></span>
&nbsp;&nbsp;<div id="twebspeach" class="aksestexttools">Moda Suara</div>
</div>
</div>

    `;
        var logicspeachweb = getOS() == "Windows" ? dataspeachweb : datamobileweb;
        var toolbardisabilitas =
            `
<div class="toolbar-disabilitas">
<div class="groupcontenttoolbar" id="checklangmenu">
  <div class="contenttoolbar_disabilitas" id="groupcekmenu">
      <div class="titletools" id="taccessbility">
      Sarana
          </div>

          <div class="btn-container">
  <div class="mycheckbox switch btn-color-mode-switch" id="tmulticheckboxlang">
      <input type="checkbox" id="checklang" value="1">
      <label id="tmycheckbox" for="checklang" data-on="Inggris" data-off="Indonesia" class="btn-color-mode-switch-inner"></label>

</div>
   </div>
      <div class="bodytools">
      ` +
            logicspeachweb +
            `
          <div class="subtitletools" id="increasetext">
          <div class="flexrowdata">
         <span><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="1em" viewBox="0 0 448 448"><path fill="currentColor" d="M256 200v16c0 4.25-3.75 8-8 8h-56v56c0 4.25-3.75 8-8 8h-16c-4.25 0-8-3.75-8-8v-56h-56c-4.25 0-8-3.75-8-8v-16c0-4.25 3.75-8 8-8h56v-56c0-4.25 3.75-8 8-8h16c4.25 0 8 3.75 8 8v56h56c4.25 0 8 3.75 8 8zM288 208c0-61.75-50.25-112-112-112s-112 50.25-112 112 50.25 112 112 112 112-50.25 112-112zM416 416c0 17.75-14.25 32-32 32-8.5 0-16.75-3.5-22.5-9.5l-85.75-85.5c-29.25 20.25-64.25 31-99.75 31-97.25 0-176-78.75-176-176s78.75-176 176-176 176 78.75 176 176c0 35.5-10.75 70.5-31 99.75l85.75 85.75c5.75 5.75 9.25 14 9.25 22.5z" "=""></path></svg></span>
         &nbsp;&nbsp;<div id="tincreasetext" class="aksestexttools">Perbesar Teks</div>
         </div>
          </div>
          <div class="subtitletools"  id="decreasetext">
          <div class="flexrowdata">
         <span><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="1em" viewBox="0 0 448 448"><path fill="currentColor" d="M256 200v16c0 4.25-3.75 8-8 8h-144c-4.25 0-8-3.75-8-8v-16c0-4.25 3.75-8 8-8h144c4.25 0 8 3.75 8 8zM288 208c0-61.75-50.25-112-112-112s-112 50.25-112 112 50.25 112 112 112 112-50.25 112-112zM416 416c0 17.75-14.25 32-32 32-8.5 0-16.75-3.5-22.5-9.5l-85.75-85.5c-29.25 20.25-64.25 31-99.75 31-97.25 0-176-78.75-176-176s78.75-176 176-176 176 78.75 176 176c0 35.5-10.75 70.5-31 99.75l85.75 85.75c5.75 5.75 9.25 14 9.25 22.5z"></path></svg></span>
          &nbsp;&nbsp;<div id="tdecreasetext"  class="aksestexttools">Perkecil Teks</div>
          </div>
          </div>
          <div class="subtitletools"  id="egrayscale">
          <div class="flexrowdata">
          <span><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="1em" viewBox="0 0 448 448"><path fill="currentColor" d="M15.75 384h-15.75v-352h15.75v352zM31.5 383.75h-8v-351.75h8v351.75zM55 383.75h-7.75v-351.75h7.75v351.75zM94.25 383.75h-7.75v-351.75h7.75v351.75zM133.5 383.75h-15.5v-351.75h15.5v351.75zM165 383.75h-7.75v-351.75h7.75v351.75zM180.75 383.75h-7.75v-351.75h7.75v351.75zM196.5 383.75h-7.75v-351.75h7.75v351.75zM235.75 383.75h-15.75v-351.75h15.75v351.75zM275 383.75h-15.75v-351.75h15.75v351.75zM306.5 383.75h-15.75v-351.75h15.75v351.75zM338 383.75h-15.75v-351.75h15.75v351.75zM361.5 383.75h-15.75v-351.75h15.75v351.75zM408.75 383.75h-23.5v-351.75h23.5v351.75zM424.5 383.75h-8v-351.75h8v351.75zM448 384h-15.75v-352h15.75v352z"></path></svg></span>
          &nbsp;&nbsp;<div id="tegrayscale"  class="aksestexttools">Skala Abu - Abu</div>
          </div>
          </div>
          <div class="subtitletools" id="hcontrash">
          <div class="flexrowdata">
          <span><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="1em" viewBox="0 0 448 448"><path fill="currentColor" d="M192 360v-272c-75 0-136 61-136 136s61 136 136 136zM384 224c0 106-86 192-192 192s-192-86-192-192 86-192 192-192 192 86 192 192z" "=""></path></svg></span>
          &nbsp;&nbsp;<div id="thcontrash"  class="aksestexttools">Kontras Tinggi</div>
          </div>
          </div>
          <div class="subtitletools" id="ncontrash">
          <div class="flexrowdata">
          <span><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="1em" viewBox="0 0 448 448"><path fill="currentColor" d="M416 240c-23.75-36.75-56.25-68.25-95.25-88.25 10 17 15.25 36.5 15.25 56.25 0 61.75-50.25 112-112 112s-112-50.25-112-112c0-19.75 5.25-39.25 15.25-56.25-39 20-71.5 51.5-95.25 88.25 42.75 66 111.75 112 192 112s149.25-46 192-112zM236 144c0-6.5-5.5-12-12-12-41.75 0-76 34.25-76 76 0 6.5 5.5 12 12 12s12-5.5 12-12c0-28.5 23.5-52 52-52 6.5 0 12-5.5 12-12zM448 240c0 6.25-2 12-5 17.25-46 75.75-130.25 126.75-219 126.75s-173-51.25-219-126.75c-3-5.25-5-11-5-17.25s2-12 5-17.25c46-75.5 130.25-126.75 219-126.75s173 51.25 219 126.75c3 5.25 5 11 5 17.25z"></path></svg></span>
          &nbsp;&nbsp;<div id="tncontrash"  class="aksestexttools">Latar Gelap</div>
          </div>
          </div>
          <div class="subtitletools"] id="lgcontrash">
          <div class="flexrowdata">
          <span><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="1em" viewBox="0 0 448 448"><path fill="currentColor" d="M184 144c0 4.25-3.75 8-8 8s-8-3.75-8-8c0-17.25-26.75-24-40-24-4.25 0-8-3.75-8-8s3.75-8 8-8c23.25 0 56 12.25 56 40zM224 144c0-50-50.75-80-96-80s-96 30-96 80c0 16 6.5 32.75 17 45 4.75 5.5 10.25 10.75 15.25 16.5 17.75 21.25 32.75 46.25 35.25 74.5h57c2.5-28.25 17.5-53.25 35.25-74.5 5-5.75 10.5-11 15.25-16.5 10.5-12.25 17-29 17-45zM256 144c0 25.75-8.5 48-25.75 67s-40 45.75-42 72.5c7.25 4.25 11.75 12.25 11.75 20.5 0 6-2.25 11.75-6.25 16 4 4.25 6.25 10 6.25 16 0 8.25-4.25 15.75-11.25 20.25 2 3.5 3.25 7.75 3.25 11.75 0 16.25-12.75 24-27.25 24-6.5 14.5-21 24-36.75 24s-30.25-9.5-36.75-24c-14.5 0-27.25-7.75-27.25-24 0-4 1.25-8.25 3.25-11.75-7-4.5-11.25-12-11.25-20.25 0-6 2.25-11.75 6.25-16-4-4.25-6.25-10-6.25-16 0-8.25 4.5-16.25 11.75-20.5-2-26.75-24.75-53.5-42-72.5s-25.75-41.25-25.75-67c0-68 64.75-112 128-112s128 44 128 112z"></path></svg></span>
          &nbsp;&nbsp;<div id="tlgcontrash"  class="aksestexttools">Latar Terang</div>
          </div>
          </div>
          <div class="subtitletools" id="readablefont">
          <div class="flexrowdata">
           <span><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="1em" viewBox="0 0 448 448"><path fill="currentColor" d="M181.25 139.75l-42.5 112.5c24.75 0.25 49.5 1 74.25 1 4.75 0 9.5-0.25 14.25-0.5-13-38-28.25-76.75-46-113zM0 416l0.5-19.75c23.5-7.25 49-2.25 59.5-29.25l59.25-154 70-181h32c1 1.75 2 3.5 2.75 5.25l51.25 120c18.75 44.25 36 89 55 133 11.25 26 20 52.75 32.5 78.25 1.75 4 5.25 11.5 8.75 14.25 8.25 6.5 31.25 8 43 12.5 0.75 4.75 1.5 9.5 1.5 14.25 0 2.25-0.25 4.25-0.25 6.5-31.75 0-63.5-4-95.25-4-32.75 0-65.5 2.75-98.25 3.75 0-6.5 0.25-13 1-19.5l32.75-7c6.75-1.5 20-3.25 20-12.5 0-9-32.25-83.25-36.25-93.5l-112.5-0.5c-6.5 14.5-31.75 80-31.75 89.5 0 19.25 36.75 20 51 22 0.25 4.75 0.25 9.5 0.25 14.5 0 2.25-0.25 4.5-0.5 6.75-29 0-58.25-5-87.25-5-3.5 0-8.5 1.5-12 2-15.75 2.75-31.25 3.5-47 3.5z"></path></svg></span>
           &nbsp;&nbsp;<div id="treadablefont"  class="aksestexttools">Tulisan Dapat Dibaca</div>
           </div>
          </div>
          <div class="subtitletools" id="linkunderline">
          <div class="flexrowdata">
           <span><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="1em" viewBox="0 0 448 448"><path fill="currentColor" d="M364 304c0-6.5-2.5-12.5-7-17l-52-52c-4.5-4.5-10.75-7-17-7-7.25 0-13 2.75-18 8 8.25 8.25 18 15.25 18 28 0 13.25-10.75 24-24 24-12.75 0-19.75-9.75-28-18-5.25 5-8.25 10.75-8.25 18.25 0 6.25 2.5 12.5 7 17l51.5 51.75c4.5 4.5 10.75 6.75 17 6.75s12.5-2.25 17-6.5l36.75-36.5c4.5-4.5 7-10.5 7-16.75zM188.25 127.75c0-6.25-2.5-12.5-7-17l-51.5-51.75c-4.5-4.5-10.75-7-17-7s-12.5 2.5-17 6.75l-36.75 36.5c-4.5 4.5-7 10.5-7 16.75 0 6.5 2.5 12.5 7 17l52 52c4.5 4.5 10.75 6.75 17 6.75 7.25 0 13-2.5 18-7.75-8.25-8.25-18-15.25-18-28 0-13.25 10.75-24 24-24 12.75 0 19.75 9.75 28 18 5.25-5 8.25-10.75 8.25-18.25zM412 304c0 19-7.75 37.5-21.25 50.75l-36.75 36.5c-13.5 13.5-31.75 20.75-50.75 20.75-19.25 0-37.5-7.5-51-21.25l-51.5-51.75c-13.5-13.5-20.75-31.75-20.75-50.75 0-19.75 8-38.5 22-52.25l-22-22c-13.75 14-32.25 22-52 22-19 0-37.5-7.5-51-21l-52-52c-13.75-13.75-21-31.75-21-51 0-19 7.75-37.5 21.25-50.75l36.75-36.5c13.5-13.5 31.75-20.75 50.75-20.75 19.25 0 37.5 7.5 51 21.25l51.5 51.75c13.5 13.5 20.75 31.75 20.75 50.75 0 19.75-8 38.5-22 52.25l22 22c13.75-14 32.25-22 52-22 19 0 37.5 7.5 51 21l52 52c13.75 13.75 21 31.75 21 51z"></path></svg></span>
           &nbsp;&nbsp;<div id="tlinkunderline"  class="aksestexttools">Garis Bawahi Tautan</div>
           </div>
          </div>

          <div class="subtitletools" id="ratatulisan">
          <div class="flexrowdata">
          <span><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="1em" viewBox="0 0 448 448"><path fill="currentColor" d="M384 1056v64q0 13-9.5 22.5T352 1152h-64q-13 0-22.5-9.5T256 1120v-64q0-13 9.5-22.5t22.5-9.5h64q13 0 22.5 9.5t9.5 22.5zm0-256v64q0 13-9.5 22.5T352 896h-64q-13 0-22.5-9.5T256 864v-64q0-13 9.5-22.5T288 768h64q13 0 22.5 9.5T384 800zm0-256v64q0 13-9.5 22.5T352 640h-64q-13 0-22.5-9.5T256 608v-64q0-13 9.5-22.5T288 512h64q13 0 22.5 9.5T384 544zm1152 512v64q0 13-9.5 22.5t-22.5 9.5H544q-13 0-22.5-9.5T512 1120v-64q0-13 9.5-22.5t22.5-9.5h960q13 0 22.5 9.5t9.5 22.5zm0-256v64q0 13-9.5 22.5T1504 896H544q-13 0-22.5-9.5T512 864v-64q0-13 9.5-22.5T544 768h960q13 0 22.5 9.5t9.5 22.5zm0-256v64q0 13-9.5 22.5T1504 640H544q-13 0-22.5-9.5T512 608v-64q0-13 9.5-22.5T544 512h960q13 0 22.5 9.5t9.5 22.5zm128 704V416q0-13-9.5-22.5T1632 384H160q-13 0-22.5 9.5T128 416v832q0 13 9.5 22.5t22.5 9.5h1472q13 0 22.5-9.5t9.5-22.5zm128-1088v1088q0 66-47 113t-113 47H160q-66 0-113-47T0 1248V160Q0 94 47 47T160 0h1472q66 0 113 47t47 113z"/></svg></span>
          &nbsp;&nbsp;<div id="tratatulisan"  class="aksestexttools">Rata Tulisan</div>
          </div>
          </div>

          <div class="subtitletools" id="resetdisabilitas">
          <div class="flexrowdata">
          <span><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="1em" viewBox="0 0 448 448"><path fill="currentColor" d="M384 224c0 105.75-86.25 192-192 192-57.25 0-111.25-25.25-147.75-69.25-2.5-3.25-2.25-8 0.5-10.75l34.25-34.5c1.75-1.5 4-2.25 6.25-2.25 2.25 0.25 4.5 1.25 5.75 3 24.5 31.75 61.25 49.75 101 49.75 70.5 0 128-57.5 128-128s-57.5-128-128-128c-32.75 0-63.75 12.5-87 34.25l34.25 34.5c4.75 4.5 6 11.5 3.5 17.25-2.5 6-8.25 10-14.75 10h-112c-8.75 0-16-7.25-16-16v-112c0-6.5 4-12.25 10-14.75 5.75-2.5 12.75-1.25 17.25 3.5l32.5 32.25c35.25-33.25 83-53 132.25-53 105.75 0 192 86.25 192 192z"></path></svg></span>
          &nbsp;&nbsp;<div id="tidreset"  class="aksestexttools">Atur Ulang</div>
          </div>
          </div>


      </div>
  </div>
  <button type="button" class="open-toolbar"  onmouseout="callfunction('Open Toolbar')">
      <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" enable-background="new 0 0 100 100" viewBox="0 0 100 100" fill="currentColor" width="1em">
          <g>
              <path fill="#FFFFFF" d="M60.4,78.9c-2.2,4.1-5.3,7.4-9.2,9.8c-4,2.4-8.3,3.6-13,3.6c-6.9,0-12.8-2.4-17.7-7.3c-4.9-4.9-7.3-10.8-7.3-17.7c0-5,1.4-9.5,4.1-13.7c2.7-4.2,6.4-7.2,10.9-9.2l-0.9-7.3c-6.3,2.3-11.4,6.2-15.3,11.8C7.9,54.4,6,60.6,6,67.3c0,5.8,1.4,11.2,4.3,16.1s6.8,8.8,11.7,11.7c4.9,2.9,10.3,4.3,16.1,4.3c7,0,13.3-2.1,18.9-6.2c5.7-4.1,9.6-9.5,11.7-16.2l-5.7-11.4C63.5,70.4,62.5,74.8,60.4,78.9z"></path>
              <path fill="#FFFFFF" d="M93.8,71.3l-11.1,5.5L70,51.4c-0.6-1.3-1.7-2-3.2-2H41.3l-0.9-7.2h22.7v-7.2H39.6L37.5,19c2.5,0.3,4.8-0.5,6.7-2.3c1.9-1.8,2.9-4,2.9-6.6c0-2.5-0.9-4.6-2.6-6.3c-1.8-1.8-3.9-2.6-6.3-2.6c-2,0-3.8,0.6-5.4,1.8c-1.6,1.2-2.7,2.7-3.2,4.6c-0.3,1-0.4,1.8-0.3,2.3l5.4,43.5c0.1,0.9,0.5,1.6,1.2,2.3c0.7,0.6,1.5,0.9,2.4,0.9h26.4l13.4,26.7c0.6,1.3,1.7,2,3.2,2c0.6,0,1.1-0.1,1.6-0.4L97,77.7L93.8,71.3z"></path>
          </g>
      </svg>
  </button>
  </div>`;
        document.getElementById("loadmodaldisabilitas").innerHTML = toolbardisabilitas;

        function getOS() {
            var is_chrome = navigator.userAgent.indexOf("Chrome") > -1;
            var is_safari = navigator.userAgent.indexOf("Safari") > -1;
            var userAgent = window.navigator.userAgent,
                platform =
                window.navigator?.userAgentData?.platform || window.navigator.platform,
                macosPlatforms = ["Macintosh", "MacIntel", "MacPPC", "Mac68K"],
                windowsPlatforms = ["Win32", "Win64", "Windows", "WinCE"],
                iosPlatforms = ["iPhone", "iPad", "iPod"],
                os = null;
            if (macosPlatforms.indexOf(platform) !== -1) {
                os = "Mac OS";
            } else if (iosPlatforms.indexOf(platform) !== -1) {
                os = "iOS";
            } else if (windowsPlatforms.indexOf(platform) !== -1) {
                os = "Windows";
            } else if (/Android/.test(userAgent)) {
                os = "Android";
            } else if (/Linux/.test(platform)) {
                os = "Linux";
            }
            return os;
        }
        $(".open-toolbar").click(function(event) {
            var stickyToolbarContainer = document.querySelector(".toolbar-disabilitas");
            stickyToolbarContainer.classList.toggle("show-toolbar");
        });
        $("#checklang").on("change", function() {
            changelang(this);
        });

        var arrayratatulisan = [];
        var langdefault = [];

        function replacemultipletext(lang, status) {
            var dataratatulisanid = "";
            var dataratatulisanen = "";
            if (arrayratatulisan.length == 0) {
                dataratatulisanid = "Rata Tulisan";
                dataratatulisanen = "Average Writing";
            } else if (arrayratatulisan.length > 0) {
                if (arrayratatulisan[0] == 0) {
                    dataratatulisanid = "Rata Tulisan";
                    dataratatulisanen = "Average Writing";
                } else if (arrayratatulisan[0] == 1) {
                    dataratatulisanid = "Rata Kiri";
                    dataratatulisanen = "Align Left";
                } else if (arrayratatulisan[0] == 2) {
                    dataratatulisanid = "Rata Tengah";
                    dataratatulisanen = "Average Middle";
                } else if (arrayratatulisan[0] == 3) {
                    dataratatulisanid = "Rata Tengah";
                    dataratatulisanen = "Average Middle";
                } else if (arrayratatulisan[0] == 4) {
                    dataratatulisanid = "Rata Kanan";
                    dataratatulisanen = "Align Right";
                }
            }

            if (status == "reset") {
                dataratatulisanid = "Rata Tulisan";
                dataratatulisanen = "Average Writing";
            }

            var replaceratatulisan = "";
            if (lang == undefined || lang == "") {
                replaceratatulisan = {
                    ratatulisan: dataratatulisanid,
                };
            } else if (lang == 1) {
                replaceratatulisan = {
                    ratatulisan: dataratatulisanid,
                };
            } else if (lang == 2) {
                replaceratatulisan = {
                    ratatulisan: dataratatulisanen,
                };
            }

            return replaceratatulisan;
        }

        function ratatulisan(lang) {
            var resulttext = replacemultipletext(lang, "noreset");
            var text_tulisan = "";
            if (lang == "") {
                text_tulisan = "";
            } else {
                text_tulisan = resulttext.ratatulisan;
            }
            $("#tratatulisan").text(text_tulisan);
        }

        function changelang(ele) {
            var groups = Array.from(document.querySelectorAll("#checklangmenu"));
            langdefault.length = 0;
            langdefault.push(2);

            var resulttext = replacemultipletext(2, "noreset");
            if ($(ele).prop("checked") == true) {
                var toolslangEn = {
                    tdataoff: "Indonesian",
                    tdataon: "English",
                    taccessbility: "Accessibility Tools",
                    tincreasetext: "Increase Text",
                    tdecreasetext: "Decrease Text",
                    tegrayscale: "Grayscale",
                    thcontrash: "Hight Contrast",
                    tncontrash: "Negative Contrast",
                    tlgcontrash: "Light Background",
                    treadablefont: "Readable Font",
                    tlinkunderline: "Link Underline",
                    twebspeach: "Web Speech",
                    tratatulisan: resulttext.ratatulisan,
                    tidreset: "Reset",
                };
                replacetext(groups, toolslangEn);
            } else if ($(ele).prop("checked") == false) {
                langdefault.length = 0;
                langdefault.push(1);

                var resulttext = replacemultipletext(1, "noreset");
                var toolslangID = {
                    tdataoff: "Indonesia",
                    tdataon: "Inggris",
                    taccessbility: "Sarana",
                    tincreasetext: "Perbesar Teks",
                    tdecreasetext: "Perkecil Teks",
                    tegrayscale: "Skala Abu - Abu",
                    thcontrash: "Kontras Tinggi",
                    tncontrash: "Latar Gelap",
                    tlgcontrash: "Latar Terang",
                    treadablefont: "Tulisan Dapat Dibaca",
                    tlinkunderline: "Garis Bawahi Tautan",
                    twebspeach: "Moda Suara",
                    tratatulisan: resulttext.ratatulisan,
                    tidreset: "Atur Ulang",
                };
                replacetext(groups, toolslangID);
            }
        }

        function callfunction(value) {
            var voicecek = localStorage.getItem("permismobile");
            if (voicecek != null && voicecek == "on") {
                setTimeout(() => {
                    speachmobile(value);
                }, 50);
            } else {
                speach(value);
            }
        }

        function replacetext(groups, arrayjs) {
            var namedatainput = '[class="contenttoolbar_disabilitas"]';
            var namedatainput2 = "div";
            var listgroupselector = groups.map(function(group) {
                return group.querySelector(namedatainput);
            });
            var listdata = listgroupselector.map(function(group) {
                return Array.from(group.querySelectorAll(namedatainput2)).map(function(
                    item
                ) {
                    return item;
                });
            });
            //  console.log(mytext)
            //   var mytext = getelement.replace("indonesian", "indonesia");
            // $("#tmulticheckboxlang").text(resultvalue);
            var keysarray = Object.keys(arrayjs);
            var keysvalues = Object.values(arrayjs);
            for (let i = 0; i < listdata.length; i++) {
                for (let k = 0; k < listdata[i].length; k++) {
                    for (let b = 0; b < keysarray.length; b++) {
                        var idhtml = keysarray[b];
                        if (
                            listdata[i][k].id == idhtml &&
                            idhtml != "tdataoff" &&
                            idhtml != "tdataon"
                        ) {
                            // var listdatallx = listdata[i][k];
                            var getelement = document.getElementById(keysarray[b]);
                            var mytext = getelement.textContent.trim();
                            var resultvalue = mytext.replace(mytext, keysvalues[b]);
                            $("#" + idhtml).text(resultvalue);
                        } else if (idhtml == "tdataoff" || idhtml == "tdataon") {
                            if (idhtml == "tdataon") {
                                var mytext = $("#tmycheckbox").attr("data-on");
                                $("#tmycheckbox").attr("data-on", keysvalues[b]);
                            }
                            if (idhtml == "tdataoff") {
                                var mytext = $("#tmycheckbox").attr("data-off");
                                $("#tmycheckbox").attr("data-off", keysvalues[b]);
                            }
                            ///
                        }
                    }
                }
            }
        }

        $("#ratatulisan").click(function(event) {
            if (arrayratatulisan.length > 0) {
                if (arrayratatulisan[0] == 1) {
                    arrayratatulisan.length = 0;
                    arrayratatulisan.push(2);
                    ratatulisan(langdefault[0]);
                    $('*:not(".btn-color-mode-switch-inner, *")').each(function(i, item) {
                        $(item).cssImportant("text-align", "left");

                        if ($(item).css("flex-direction") == "row") {
                            $(item).cssImportant("justify-content", "flex-start");
                        }
                    });
                }

                if (arrayratatulisan[0] == 2) {
                    arrayratatulisan.length = 0;
                    arrayratatulisan.push(3);

                    ratatulisan(langdefault[0]);

                    $('*:not(".btn-color-mode-switch-inner")').each(function(i, item) {
                        $(item).cssImportant("text-align", "center");
                        if ($(item).css("flex-direction") == "row") {
                            $(item).cssImportant("justify-content", "center");
                        }
                    });
                } else if (arrayratatulisan[0] == 3) {
                    arrayratatulisan.length = 0;
                    arrayratatulisan.push(4);
                    ratatulisan(langdefault[0]);
                    $('*:not(".btn-color-mode-switch-inner")').each(function(i, item) {
                        $(item).cssImportant("text-align", "right");
                        if ($(item).css("flex-direction") == "row") {
                            $(item).cssImportant("justify-content", "flex-end");
                        }
                    });
                } else if (arrayratatulisan[0] == 4) {
                    cekclassactive(groups, "ratatulisan");
                    arrayratatulisan.length = 0;
                    ratatulisan(langdefault[0]);

                    $('*:not(".btn-color-mode-switch-inner")').each(function(i, item) {
                        $(item).cssImportant("text-align", "");
                        if ($(item).css("flex-direction") == "row") {
                            $(item).cssImportant("justify-content", "");
                        }
                    });
                } else if (arrayratatulisan[0] == 0) {
                    cekclassactive(groups, "ratatulisan");
                    arrayratatulisan.length = 0;

                    arrayratatulisan.push(1);
                    ratatulisan(langdefault[0]);

                    $('*:not(".btn-color-mode-switch-inner")').each(function(i, item) {
                        $(item).cssImportant("text-align", "left");
                        if ($(item).css("flex-direction") == "row") {
                            $(item).cssImportant("justify-content", "flex-start");
                        }
                    });
                }
            } else {
                cekclassactive(groups, "ratatulisan");
                arrayratatulisan.length = 0;

                arrayratatulisan.push(1);
                ratatulisan(langdefault[0]);

                $('*:not(".btn-color-mode-switch-inner")').each(function(i, item) {
                    $(item).cssImportant("text-align", "left");
                    if ($(item).css("flex-direction") == "row") {
                        $(item).cssImportant("justify-content", "flex-start");
                    }
                });
            }

            $(".contenttoolbar_disabilitas *,div.titletools,.open-toolbar").each(
                function(i, item) {
                    $(item).cssImportant("text-align", "");
                    $(item).cssImportant("justify-content", "");
                }
            );
            $(".titletools").cssImportant("text-align", "center");
        });

        var zoomLevel = 1;
        var rootFontSize = 12;
        var groups = Array.from(document.querySelectorAll("#groupcekmenu"));
        $("#increasetext").click(function(event) {
            // tracking_fitur_disabilitas('Perbesar Text');
            var listdatagroup = cekclassactive(groups, "increasetext");

            zoomLevel = zoomLevel + 0.1;
            rootFontSize = rootFontSize + 2;
            $('div > *:not(".fa-search,.toolbar-disabilitas  *,.fa,.fa-angle-down")').css({
                // "font-weight": 400,
                "font-size": rootFontSize + "px",
            });
        });
        $("#decreasetext").click(function(event) {
            //  tracking_fitur_disabilitas('Perkecil Text');
            $("#resetdisabilitas").removeClass("subtitletoolsactive");
            $("#resetdisabilitas").addClass("subtitletools");
            //  var listdatagroup = cekclassactive(groups, 'decreasetext');
            setTimeout(() => {
                zoomLevel = zoomLevel - 0.1;
                rootFontSize = rootFontSize - 2;
                $("#increasetext").removeClass("subtitletoolsactive");
                $("#increasetext").addClass("subtitletools");
                $(
                    'div > *:not(".fa-search,.toolbar-disabilitas  *,.fa,.fa-angle-down")'
                ).css({
                    //  "font-weight": 400,
                    "font-size": rootFontSize + "px",
                });
            }, 100);
        });
        $("#readablefont").on("click", function(event) {
            //  tracking_fitur_disabilitas('Tulisan Dapat Di Baca');
            var listdatagroup = cekclassactive(groups, "readablefont");
            if (listdatagroup.getclass.classactiv == "active") {
                $(
                    '*:not(".fa-search,.toolbar-disabilitas  *,.fa,.fa-angle-down, h1 ,h2 , h3")'
                ).css({
                    //"font-weight": 400,

                    "font-size": "25px",
                });

                $("h1,h2,h3,h4").css({
                    "font-size": "45px",
                });
            } else {
                $('*:not(".fa-search,.toolbar-disabilitas  *,.fa,.fa-angle-down")').css({
                    "font-family": "",
                    "font-weight": "",
                    "font-size": "",
                    "font-family": "",
                });
            }
        });
        jQuery(document).ready(function() {
            jQuery.fn.cssImportant = function(name, value) {
                const $this = this;
                const applyStyles = (n, v) => {
                    // Convert style name from camelCase to dashed-case.
                    const dashedName = n.replace(/(.)([A-Z])(.)/g, (str, m1, upper, m2) => {
                        return m1 + "-" + upper.toLowerCase() + m2;
                    });
                    // Loop over each element in the selector and set the styles.
                    $this.each(function() {
                        this.style.setProperty(dashedName, v, "important");
                    });
                };
                // If called with the first parameter that is an object,
                // Loop over the entries in the object and apply those styles.
                if (jQuery.isPlainObject(name)) {
                    for (const [n, v] of Object.entries(name)) {
                        applyStyles(n, v);
                    }
                } else {
                    // Otherwise called with style name and value.
                    applyStyles(name, value);
                }
                // This is required for making jQuery plugin calls chainable.
                return $this;
            };
        });

        $("#hcontrash").click(function(event) {
            //   tracking_fitur_disabilitas('Warna');

            var listdatagroup = cekclassactive(groups, "hcontrash", "on");
            if (listdatagroup.getclass.classactiv == "active") {
                $(".navbar-inverse2").css("background-color", "rgb(0, 0, 0)");
                $(
                    '*:not(".btn-color-mode-switch-inner,.mycheckbox,.Vue-Toastification__container")'
                ).each(function(i, item) {
                    var color = $(item).css("color");
                    $(item).cssImportant("background-color", "black");

                    $(item).cssImportant("color", "#40C090");
                    $(item).cssImportant("background", "black");
                });

                $(
                    '*:not(".fa-search,.titletools,svg,.btn-color-mode-switch-inner,.Vue-Toastification__container")'
                ).cssImportant("border-color", "white");
                var links = document.querySelectorAll("a,div,li a strong");
                for (var i = 0; i < links.length; i++) {
                    if (!isBlank(links[i].href)) {
                        links[i].style.color = "#00f3f7 !important";
                    }
                }
                $("h1,h2,h3,h4,h5").each(function(i, item) {
                    var color = $(item).css("color");
                    $(item).cssImportant("color", "white");

                    $(item).cssImportant("background-color", "black");
                    $(item).cssImportant("color", "#40C090");
                    $(item).cssImportant("background", "black");
                });

                $("* > div").each(function(i, item) {
                    var color = $(item).css("color");
                });

                $("*>button, * > p").each(function(i, item) {
                    var color = $(item).css("color");

                    $(item).cssImportant("background-color", "black");
                    $(item).cssImportant("color", "#40C090");
                    $(item).cssImportant("background", "black");
                });

                $("*>a").each(function(i, item) {
                    var color = $(item).css("color");

                    $(item).cssImportant("background-color", "black");
                    $(item).cssImportant("color", "yellow");
                    $(item).cssImportant("background", "black");
                });
                changecolordisabilitas(groups);
                hoveractive();

                $("#groupcekmenu > *, .bodytools path").each(function(i, item) {
                    $(item).cssImportant("color", "#00f3f7");
                });
            } else {
                $("*").each(function(i, item) {
                    var color = $(item).css("color");
                    $(item).css({
                        "background-color": "",
                        background: "",
                        color: "",
                    });
                });
                $(
                    '*:not(".fa-search,.titletools,svg,.btn-color-mode-switch-inner,.Vue-Toastification__container")'
                ).cssImportant("border-color", "");
                hovernoactive();
            }
        });

        function changecolordisabilitas(groups) {
            var namedatainput = '[class="bodytools"]';
            var namedatainput2 = '[class="aksestexttools"]';
            var listgroupselector = groups.map(function(group) {
                return group.querySelector(namedatainput);
            });
            var listdata = listgroupselector.map(function(group) {
                return Array.from(group.querySelectorAll(namedatainput2)).map(function(
                    item
                ) {
                    return item;
                });
            });

            var listdatall = [];
            var listdatall2 = [];
            for (let i = 0; i < listdata.length; i++) {
                for (let k = 0; k < listdata[i].length; k++) {
                    var classactive = "";
                    var classid = "";
                    //     console.log(listdata[i][k].id);
                    $("#" + listdata[i][k].id).css({
                        color: "#00f3f7",
                    });
                    //  document.getElementById().style.color = "#0080FF";
                    //  $("#thcontrash").css("color", "#0080FF");
                }
            }
        }
        $("#ncontrash").click(function(event) {
            //  tracking_fitur_disabilitas('Klise');
            var listdatagroup = cekclassactive(groups, "ncontrash");
            if (listdatagroup.getclass.classactiv == "active") {
                $(".navbar-inverse2").css("background-color", "rgb(0, 0, 0)");
                $(
                    '*:not(".btn-color-mode-switch-inner,.mycheckbox,.Vue-Toastification__container")'
                ).each(function(i, item) {
                    var color = $(item).css("color");
                    $(item).cssImportant("background-color", "black");
                    $(item).cssImportant("color", "yellow");
                    $(item).cssImportant("background", "black");
                });
                $(
                    '*:not(".fa-search,.titletools,svg,.btn-color-mode-switch-inner,.Vue-Toastification__container")'
                ).cssImportant("border-color", "white");
                hoveractive();
            } else {
                $("*").each(function(i, item) {
                    var color = $(item).css("color");
                    $(item).css({
                        "background-color": "",
                        background: "",
                        color: "",
                    });
                });
                $(
                    '*:not(".fa-search,.titletools,svg,.btn-color-mode-switch-inner,.Vue-Toastification__container")'
                ).cssImportant("border-color", "");
                hovernoactive();
            }
        });

        function hoveractive() {
            $("* > a").hover(function(e) {
                if (e.type === "mouseenter") {
                    $(this).css({
                        "background-color": "#c23616",
                        opacity: "0.5",
                    });
                } else if (e.type === "mouseleave") {
                    $(this).css({
                        "background-color": "black",
                        opacity: "",
                    });
                }
            });
        }

        function hovernoactive() {
            $("* > a").hover(function(e) {
                // console.log(e.type);
                if (e.type === "mouseenter") {
                    $(this).css({
                        "background-color": "",
                        opacity: "",
                    });
                } else if (e.type === "mouseleave") {
                    $(this).css({
                        "background-color": "",
                        opacity: "",
                    });
                }
            });
        }
        $("#lgcontrash").click(function(event) {
            //  tracking_fitur_disabilitas('Penerangan');
            var listdatagroup = cekclassactive(groups, "lgcontrash");
            if (listdatagroup.getclass.classactiv == "active") {
                $("*").each(function(i, item) {
                    var color = $(item).css("color");
                    $(item).css({
                        "background-color": "",
                        background: "",
                        color: "",
                    });
                });

                $(
                    '*:not(".fa-search,.titletools,svg,.btn-color-mode-switch-inner,.Vue-Toastification__container")'
                ).cssImportant("background-color", "white");
                $(
                    '*:not(".fa-search,.titletools,svg,.btn-color-mode-switch-inner,.Vue-Toastification__container")'
                ).cssImportant("color", "black");
                $(
                    '*:not(".fa-search,.titletools,svg,.btn-color-mode-switch-inner,.Vue-Toastification__container")'
                ).cssImportant("background", "white");
                $(
                    '*:not(".fa-search,.titletools,svg,.btn-color-mode-switch-inner,.Vue-Toastification__container")'
                ).cssImportant("border-color", "white");
                $("*:hover").cssImportant("border-color", "white");
                $("*:focus").cssImportant("border-color", "white");

                hovernoactive();
            } else {
                $("*").each(function(i, item) {
                    var color = $(item).css("color");
                    $(item).css({
                        "background-color": "",
                        background: "",
                        color: "",
                    });
                });
                $(
                    '*:not(".fa-search,.titletools,svg,.btn-color-mode-switch-inner,.Vue-Toastification__container")'
                ).cssImportant("border-color", "");
                hovernoactive();
            }
            // resetcss();
        });
        $("#linkunderline").click(function(event) {
            //    tracking_fitur_disabilitas('Garis Bawahi Tautan');
            var listdatagroup = cekclassactive(groups, "linkunderline");
            if (listdatagroup.getclass.classactiv == "active") {

                var links = document.querySelectorAll("a,div > a,li a, a *");
                for (var i = 0; i < links.length; i++) {
                    if (!isBlank(links[i].href)) {

                        $(links[i]).cssImportant("textDecoration", "underline");
                        //  links[i].style.textDecoration = "underline";
                    }
                }

                $('a *:not(".fa-search,.titletools,svg,.btn-color-mode-switch-inner,.Vue-Toastification__container")')
                    .cssImportant("textDecoration", "underline");
                $(".toolbar-disabilitas  *").css({
                    "text-decoration": "",
                });
            } else {
                $("*").css({
                    "text-decoration": "",
                });
            }
        });
        $("#egrayscale").on("click", function(event) {
            //('Skala Abu-abu');
            var listdatagroup = cekclassactive(groups, "egrayscale");
            // console.log("grey");
            if (listdatagroup.getclass.classactiv == "active") {
                $("html").attr("class", "greyscaleall");
            } else {
                $("html").removeAttr("class");
            }
        });

        $("#resetdisabilitas").click(function(event) {
            //    tracking_fitur_disabilitas('Mengatur Ulang');
            var listdatagroup = cekclassactive(groups, "resetdisabilitas");
            if (listdatagroup.getclass.classactiv == "active") {
                resetcss();
                localStorage.removeItem("permisvoice");
                localStorage.removeItem("permismobile");
            }
        });

        function resetcss() {
            localStorage.removeItem("permisvoice");
            localStorage.removeItem("permismobile");
            arrayratatulisan.length = 0;
            arrayratatulisan.push(0);

            $("*").each(function(i, item) {
                var color = $(item).css("color");
                $(item).css({
                    "background-color": "",
                    background: "",
                    color: "",
                    "font-size": "",
                    "text-decoration": "",
                    "font-weight": "",
                    "font-family": "",
                });
            });
            $("a").hover(function(e) {
                //console.log(e.type);
                if (e.type === "mouseenter") {
                    $(this).css({
                        "background-color": "",
                        opacity: "",
                    });
                } else if (e.type === "mouseleave") {
                    $(this).css({
                        "background-color": "",
                        opacity: "",
                    });
                }
            });
            $("html").removeAttr("class");
            $("*").css({
                "text-decoration": "",
                "border-color": "",
                "text-align": "",
            });

            rootFontSize = 20;
            $('*:not(".btn-color-mode-switch-inner")').each(function(i, item) {
                $(item).cssImportant("text-align", "");
                $(item).cssImportant("justify-content", "");
            });

            var text_tulisan = "";
            var langnew = 1;

            if (langdefault.length > 0) {
                langnew = langdefault[0];
            }

            if (langdefault.length == 0) {
                replacemultipletext(langnew, "noreset");
                var resultdata = replacemultipletext(langnew, "reset");
                text_tulisan = resultdata.ratatulisan;
            } else {
                langnew = langdefault[0];

                replacemultipletext(langnew, "noreset");
                var resultdata = replacemultipletext(langnew, "reset");
                // langdefault.length = 0;
                text_tulisan = resultdata.ratatulisan;
            }

            $("#tratatulisan").text(text_tulisan);
        }

        function cekclassactive(groups, idhtml) {
            if (idhtml != "resetdisabilitas") {
                $("#resetdisabilitas").removeClass("subtitletoolsactive");
                $("#resetdisabilitas").addClass("subtitletools");
            }
            var namedatainput = '[class="bodytools"]';
            var namedatainput2 = "div";
            var listgroupselector = groups.map(function(group) {
                return group.querySelector(namedatainput);
            });
            var listdata = listgroupselector.map(function(group) {
                return Array.from(group.querySelectorAll(namedatainput2)).map(function(
                    item
                ) {
                    return item;
                });
            });
            var listdatall = [];
            var listdatall2 = [];
            for (let i = 0; i < listdata.length; i++) {
                for (let k = 0; k < listdata[i].length; k++) {
                    var classactive = "";
                    var classid = "";
                    if (listdata[i][k].id == idhtml) {
                        if (
                            $("#" + idhtml).hasClass("subtitletools") &&
                            idhtml != "decreasetext"
                        ) {
                            classactive = "active";
                            $("#" + idhtml).addClass("subtitletoolsactive");
                            $("#" + idhtml).removeClass("subtitletools");
                        } else if (
                            $("#" + idhtml).hasClass("subtitletoolsactive") &&
                            idhtml == "resetdisabilitas"
                        ) {
                            classactive = "noactive";
                            $("#" + idhtml).removeClass("subtitletoolsactive");
                            $("#" + idhtml).addClass("subtitletools");
                        } else {
                            classactive = "noactive";
                            $("#" + idhtml).removeClass("subtitletoolsactive");
                            $("#" + idhtml).addClass("subtitletools");
                        }
                    } else {
                        if (idhtml == "resetdisabilitas") {
                            classactive = "noactive";
                            //   classid = listdata[i][k].id;
                            if ($("#" + listdata[i][k].id).hasClass("subtitletoolsactive")) {
                                $("#" + listdata[i][k].id).removeClass("subtitletoolsactive");
                                $("#" + listdata[i][k].id).addClass("subtitletools");
                            }
                        } else if (
                            idhtml == "lgcontrash" ||
                            idhtml == "ncontrash" ||
                            idhtml == "hcontrash"
                        ) {
                            if (
                                listdata[i][k].id == "lgcontrash" ||
                                listdata[i][k].id == "ncontrash" ||
                                listdata[i][k].id == "hcontrash"
                            ) {
                                if ($("#" + listdata[i][k].id).hasClass("subtitletoolsactive")) {
                                    $("#" + listdata[i][k].id).removeClass("subtitletoolsactive");
                                    $("#" + listdata[i][k].id).addClass("subtitletools");
                                }
                            }
                        }
                    }
                    //console.log(classactive);
                    var loopmulti = {
                        id: listdata[i][k].id,
                        class: listdata[i][k].className,
                        classactiv: classactive,
                    };
                    listdatall.push(loopmulti);
                }
            }
            var cekactiveclass = listdatall.filter(function(group) {
                return group.id == idhtml;
            });
            var returndata = {
                getclass: cekactiveclass[0],
                data: listdata,
            };
            return returndata;
        }


        $("#webspeach").click(function(event) {
            // tracking_fitur_disabilitas('Moda Suara');
            var listdatagroup = cekclassactive(groups, "webspeach");
            if (listdatagroup.getclass.classactiv == "active") {
                localStorage.setItem("permisvoice", "on");
                speach(
                    "Selamat Datang Di Aplikasi e-SAKIP. e-SAKIP merupakan aplikasi untuk melakukan penilaian akuntabilitas kinerja pemerintah secara elektronik di lingkungan pemerintah kabupaten wonosobo."
                );
                //    localStorage.setItem("setwelcome", "welcomeoff");
            } else {
                localStorage.setItem("permisvoice", "off");
            }
        });


        $("#mobileapp").click(function(event) {
            //     tracking_fitur_disabilitas('Moda Suara Mobile Apps');
            var listdatagroup = cekclassactive(groups, "mobileapp");
            if (listdatagroup.getclass.classactiv == "active") {
                localStorage.setItem("permismobile", "on");
                speachmobile(
                    "Selamat Datang Di Aplikasi e-SAKIP. e-SAKIP merupakan aplikasi untuk melakukan penilaian akuntabilitas kinerja pemerintah secara elektronik di lingkungan pemerintah kabupaten wonosobo."
                );
                //    localStorage.setItem("setwelcome", "welcomeoff");
            } else {
                localStorage.setItem("permismobile", "off");
            }
        });
        localStorage.removeItem("permismobile");
        localStorage.removeItem("permisvoice");

        $(document).on("mouseover", "a > *:not('.subtitletools')", function() {
            var textvalue = $(this).text().toString();
            // console.log(textvalue);
            speach(textvalue);
            speachmobile(textvalue);
        });

        $(document).on("mouseover", "a:not('.subtitletools')", function() {
            var textvalue = $(this).text().toString();
            // console.log(textvalue);
            speach(textvalue);
            speachmobile(textvalue);
        });

        if (getOS() == "Windows" || getOS() == "Mac OS") {
            var namedatainput = '[class="bodytools"]';
            var namedatainput2 = "div";
            var listgroupselector = groups.map(function(group) {
                return group.querySelector(namedatainput);
            });
            var listdata = listgroupselector.map(function(group) {
                return Array.from(group.querySelectorAll(namedatainput2)).map(function(
                    item
                ) {
                    return item;
                });
            });

            var listdatall = [];

            for (let i = 0; i < listdata.length; i++) {
                for (let k = 0; k < listdata[i].length; k++) {
                    var tagid = "#" + listdata[i][k].id;

                    if (tagid == "#ratatulisan") {
                        $(tagid).click(function() {
                            var mytext = $(this).text();
                            callfunction(mytext);
                        });
                    }
                }
            }

            $(document).on("mouseover", ".subtitletools", function() {
                var textvalue = $(this).text().toString();
                callfunction(textvalue);
            });
        } else {
            var namedatainput = '[class="bodytools"]';
            var namedatainput2 = "div";
            var listgroupselector = groups.map(function(group) {
                return group.querySelector(namedatainput);
            });
            var listdata = listgroupselector.map(function(group) {
                return Array.from(group.querySelectorAll(namedatainput2)).map(function(
                    item
                ) {
                    return item;
                });
            });

            var listdatall = [];

            for (let i = 0; i < listdata.length; i++) {
                for (let k = 0; k < listdata[i].length; k++) {
                    var tagid = "#" + listdata[i][k].id;
                    var notagid = listdata[i][k].id;

                    if (tagid != "#resetdisabilitas" && tagid != "#mobileapp") {
                        $(tagid).click(function() {
                            var mytext = $(this).text();
                            callfunction(mytext);
                        });
                    }
                    if (notagid == "resetdisabilitas") {
                        $(document).on("mouseover", ".subtitletools", function() {
                            var textvalue = $(this).text().toString();
                            callmobile(textvalue);
                        });
                    }
                }
            }
        }

        function callmobile(value) {
            var voicecek = localStorage.getItem("permismobile");
            if (voicecek != null && voicecek == "on") {
                speachmobile(value);
            }
        }
    </script>

    <livewire:scripts />
    @stack('js')

</body>

</html>
