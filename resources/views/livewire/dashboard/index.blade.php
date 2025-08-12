<div>
    {{-- History Url --}}
    <div class="container max-w-full mx-auto py-2 bg-white text-xs">
        <div class="flex justify-end items-center pr-12">
            <span class="text-gray-600"><a href="{{ route('dashboard.index') }}" class="text-blue-600 ml-1">Home</a> /
            </span>
            <a href="#" class="text-gray-600 ml-1 mr-3">{{ $titleHistoryUrl }}</a>
            @if (!$showFilterPeriodeForm)
                {{-- Tampilkan jika form tersembunyi --}}
                <button wire:click="showFilterForm" title="Filter">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path
                            d="M10 3.75a2 2 0 1 0-4 0 2 2 0 0 0 4 0ZM17.25 4.5a.75.75 0 0 0 0-1.5h-5.5a.75.75 0 0 0 0 1.5h5.5ZM5 3.75a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5a.75.75 0 0 1 .75.75ZM4.25 17a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5h1.5ZM17.25 17a.75.75 0 0 0 0-1.5h-5.5a.75.75 0 0 0 0 1.5h5.5ZM9 10a.75.75 0 0 1-.75.75h-5.5a.75.75 0 0 1 0-1.5h5.5A.75.75 0 0 1 9 10ZM17.25 10.75a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5h1.5ZM14 10a2 2 0 1 0-4 0 2 2 0 0 0 4 0ZM10 16.25a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                    </svg>
                </button>
            @endif

            {{-- Button Close Filter --}}
            @if ($showFilterPeriodeForm)
                {{-- Tampilkan jika form terlihat --}}
                <button wire:click="closeFilterForm" title="Reset Filter">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd"
                            d="M15.312 11.424a5.5 5.5 0 0 1-9.201 2.466l-.312-.311h2.433a.75.75 0 0 0 0-1.5H3.989a.75.75 0 0 0-.75.75v4.242a.75.75 0 0 0 1.5 0v-2.43l.31.31a7 7 0 0 0 11.712-3.138.75.75 0 0 0-1.449-.39Zm1.23-3.723a.75.75 0 0 0 .219-.53V2.929a.75.75 0 0 0-1.5 0V5.36l-.31-.31A7 7 0 0 0 3.239 8.188a.75.75 0 1 0 1.448.389A5.5 5.5 0 0 1 13.89 6.11l.311.31h-2.432a.75.75 0 0 0 0 1.5h4.243a.75.75 0 0 0 .53-.219Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            @endif
        </div>
    </div>

    {{-- Form Tambah Penilaian secara Group --}}
    @if ($showFilterPeriodeForm)
        <div class="mb-4 p-4 bg-gray-100 border border-blue-600 ml-6 mr-6 rounded">
            <div class="flex flex-col md:flex-row md:items-end md:space-x-4">
                <div class="flex-1">
                    {{-- <label class="block mb-2 font-bold">Periode Penilaian <b class="text-red-500">*</b></label> --}}
                    <input type="text" wire:model.live.debounce.500ms="tahun" {{-- PASTIKAN INI ADA --}}
                        placeholder="Masukkan Tahun Periode Evaluasi Sakip (Contoh : 2025)"
                        class="mt-1 w-full rounded-md border px-2.5 py-1.5 text-sm">
                    @error('tahun')
                        {{-- Ganti periode_id menjadi tahun --}}
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Tambahkan tombol "Process" untuk menjalankan filter --}}
                {{-- <div class="flex items-end space-x-2 mt-2 md:mt-0">
                    <button wire:click="filterDataDashboard"
                        class="flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-2 py-2 text-sm rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd"
                                d="M4.25 2A2.25 2.25 0 0 0 2 4.25v11.5A2.25 2.25 0 0 0 4.25 18h11.5A2.25 2.25 0 0 0 18 15.75V4.25A2.25 2.25 0 0 0 15.75 2H4.25ZM6 13.25V3.5h8v9.75a.75.75 0 0 1-1.064.681L10 12.576l-2.936 1.355A.75.75 0 0 1 6 13.25Z"
                                clip-rule="evenodd" />
                        </svg>
                        Process
                    </button>
                    <button wire:click="closeFilterForm"
                        class="flex items-center gap-1 bg-gray-600 hover:bg-gray-700 text-white px-2 py-2 text-sm rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path
                                d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                        Batal
                    </button>
                </div> --}}
            </div>
        </div>
    @endif

    <!-- Banner Pengumuman for OPD -->
    @if (auth()->user()?->role === 'superadmin' || auth()->user()?->role === 'user')
        @if ($pengumumanOpdTahun != null && $pengumumanOpdTglMulaiLke != null && $pengumumanOpdTglSampaiLke != null)
            @if (now()->between($pengumumanOpdTglMulaiLke, \Carbon\Carbon::parse($pengumumanOpdTglSampaiLke)->endOfDay()))
                <div class="flex flex-wrap mx-3">
                    <div class="w-full px-3 mt-0 mb-3 md:w-full">
                        <div class="bg-white rounded-lg shadow-md">
                            <div class="bg-red-600 text-white p-2 rounded-t-lg">
                                <h4 class="text-lg font-semibold text-center">Perhatian !!!</h4>
                            </div>
                            <div class="p-2 mx-4">
                                <marquee direction="left">
                                    <h6 class="text-base">
                                        ~ Periode Pengisian <i>Lembar Kerja Evaluasi</i> (LKE) Sakip Perangkat
                                        Daerah Di Lingkungan Pemerintah Kabupaten Wonosobo Tahun
                                        {{ $pengumumanOpdTahun }} dimulai
                                        tanggal
                                        <b
                                            class="text-red-600">{{ \Carbon\Carbon::parse($pengumumanOpdTglMulaiLke)->format('d M Y') }}</b>
                                        s/d
                                        <b
                                            class="text-red-600">{{ \Carbon\Carbon::parse($pengumumanOpdTglSampaiLke)->format('d M Y') }}</b>.
                                        Mohon pergunakan waktu sebaik-baiknya dalam pengisian LKE. Terima Kasih ~
                                    </h6>
                                </marquee>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    @endif
    <!-- /Banner Pengumuman for OPD -->

    {{-- Success/Error Flash Message (pastikan Anda memiliki ini di layout utama jika ingin di luar komponen) --}}
    @if (session()->has('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition:leave.duration.500ms
            class="fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg border-l-4 bg-red-100 border-red-400 text-red-700"
            role="alert">
            <div class="flex items-center">
                <p class="font-bold text-sm">{{ session('error') }}</p>
            </div>
        </div>
    @endif
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition:leave.duration.500ms
            class="fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg border-l-4 bg-green-100 border-green-400 text-green-700"
            role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                <p class="font-bold text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Container --}}
    <div class="container max-w-full mx-auto px-6 py-0 bg-white">
        <div class="py-5 bg-white shadow rounded">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 px-4">

                <div
                    class="bg-blue-100 border border-blue-400 text-blue-800 rounded-lg p-6 shadow flex items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-16">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                    </svg>
                    <div>
                        <p class="text-3xl font-semibold">{{ $periodeTotal }}</p>
                        <h3 class="text-lg font-bold mb-2">Periode Penilaian</h3>
                    </div>
                </div>

                <div
                    class="bg-red-100 border border-red-400 text-red-800 rounded-lg p-6 shadow flex items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-16">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                    </svg>
                    <div>
                        <p class="text-3xl font-semibold">{{ $penilaianTotal }}</p>
                        <h3 class="text-lg font-bold mb-2">Total Penilaian</h3>
                    </div>
                </div>

                @if (auth()->user()?->role != 'user')
                    <div
                        class="bg-orange-100 border border-orange-400 text-orange-800 rounded-lg p-6 shadow flex items-center gap-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-16">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                        </svg>
                        <div>
                            <p class="text-3xl font-semibold">{{ $opdTotal }}</p>
                            <h3 class="text-lg font-bold mb-2">Total Opd Dinilai</h3>
                        </div>
                    </div>

                    <div
                        class="bg-green-100 border border-green-400 text-green-800 rounded-lg p-6 shadow flex items-center gap-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-16">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                        <div>
                            <p class="text-3xl font-semibold">{{ $userTotal }}</p>
                            <h3 class="text-lg font-bold mb-2">Total Users</h3>
                        </div>
                    </div>
                @endif

            </div>

            @if (auth()->user()?->role != 'user')
                {{-- Teruskan tahun sebagai properti ke komponen chart --}}
                <livewire:dashboard.chart-statistik-penilaian-opd />
                <livewire:dashboard.chart-statistik-penilaian-kec />
            @endif

            @if (auth()->user()?->role === 'user')
                <livewire:dashboard.chart-statistik-penilaian-user />
            @endif

        </div>
    </div>
</div>
