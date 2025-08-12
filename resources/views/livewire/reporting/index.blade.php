<div>
    {{-- History Url --}}
    <div class="container max-w-full mx-auto py-2 bg-white text-xs">
        <div class="flex justify-end items-center pr-12">
            <span class="text-gray-600"><a href="{{ route('dashboard.index') }}" class="text-blue-600 ml-1">Home</a> /
            </span>
            <a href="#" class="text-gray-600 ml-1">{{ $titleHistoryUrl }}</a>
        </div>
    </div>

    {{-- Container --}}
    <div class="container max-w-full mx-auto mt-0 px-6 py-0 bg-white">
        <div class="max-w-full mx-auto mt-0 px-0 py-5 bg-white shadow rounded">
            <div class="p-6" style="margin-top:-30px;">

                <h2 class="text-xl font-semibold mb-4">Reporting</h2>

                {{-- Tombol untuk menampilkan/menyembunyikan form filter --}}
                <div class="flex items-center mb-4 gap-2">
                    <button wire:click="showFilterDatalistForm"
                        class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 inline-flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd"
                                d="M3 3.5A1.5 1.5 0 0 1 4.5 2h6.879a1.5 1.5 0 0 1 1.06.44l4.122 4.12A1.5 1.5 0 0 1 17 7.622V16.5a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 3 16.5v-13ZM13.25 9a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5a.75.75 0 0 1 .75-.75Zm-6.5 4a.75.75 0 0 1 .75.75v.5a.75.75 0 0 1-1.5 0v-.5a.75.75 0 0 1 .75-.75Zm4-1.25a.75.75 0 0 0-1.5 0v2.5a.75.75 0 0 0 1.5 0v-2.5Z"
                                clip-rule="evenodd" />
                        </svg>
                        Datalist
                    </button>
                    <button wire:click="showFilterAgregatForm"
                        class="bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 inline-flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd"
                                d="M12.577 4.878a.75.75 0 0 1 .919-.53l4.78 1.281a.75.75 0 0 1 .531.919l-1.281 4.78a.75.75 0 0 1-1.449-.387l.81-3.022a19.407 19.407 0 0 0-5.594 5.203.75.75 0 0 1-1.139.093L7 10.06l-4.72 4.72a.75.75 0 0 1-1.06-1.061l5.25-5.25a.75.75 0 0 1 1.06 0l3.074 3.073a20.923 20.923 0 0 1 5.545-4.931l-3.042-.815a.75.75 0 0 1-.53-.919Z"
                                clip-rule="evenodd" />
                        </svg>
                        Agregat
                    </button>
                </div>

                {{-- Pesan error --}}
                @if (session()->has('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                {{-- Form Filter Datalist --}}
                @if ($showDatalistForm)
                    <div class="mb-4 p-4 bg-gray-100 border border-blue-600 rounded">
                        <div class="flex flex-col md:flex-row md:items-end md:space-x-4">
                            <div class="flex-1">
                                {{-- <label class="block mb-2 font-bold">Filter Tahun</label> --}}
                                <input type="text" wire:model="tahun"
                                    placeholder="Masukkan Tahun Periode Evaluasi Sakip (Contoh: 2025)"
                                    class="mt-1 w-full rounded-md border px-2.5 py-1.5 text-sm">
                                @error('tahun')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex items-end space-x-2 mt-2 md:mt-0">
                                <button wire:click="processDatalist"
                                    class="flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-2 py-2 text-sm rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="size-5">
                                        <path
                                            d="M3.105 2.288a.75.75 0 0 0-.826.95l1.414 4.926A1.5 1.5 0 0 0 5.135 9.25h6.115a.75.75 0 0 1 0 1.5H5.135a1.5 1.5 0 0 0-1.442 1.086l-1.414 4.926a.75.75 0 0 0 .826.95 28.897 28.897 0 0 0 15.293-7.155.75.75 0 0 0 0-1.114A28.897 28.897 0 0 0 3.105 2.288Z" />
                                    </svg>
                                    Process
                                </button>
                                <button wire:click="downloadPdfDatalist"
                                    class="flex items-center gap-1 bg-yellow-600 hover:bg-yellow-700 text-white px-2 py-2 text-sm rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="size-5">
                                        <path
                                            d="M10.75 2.75a.75.75 0 0 0-1.5 0v8.614L6.295 8.235a.75.75 0 1 0-1.09 1.03l4.25 4.5a.75.75 0 0 0 1.09 0l4.25-4.5a.75.75 0 0 0-1.09-1.03l-2.955 3.129V2.75Z" />
                                        <path
                                            d="M3.5 12.75a.75.75 0 0 0-1.5 0v2.5A2.75 2.75 0 0 0 4.75 18h10.5A2.75 2.75 0 0 0 18 15.25v-2.5a.75.75 0 0 0-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5Z" />
                                    </svg>
                                    Pdf
                                </button>
                                <button wire:click="closeDatalistForm"
                                    class="flex items-center gap-1 bg-gray-600 hover:bg-gray-700 text-white px-2 py-2 text-sm rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="h-5 w-5">
                                        <path
                                            d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                    </svg>
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Form Filter Agregat --}}
                @if ($showAgregatForm)
                    <div class="mb-4 p-4 bg-gray-100 border border-green-600 rounded">
                        <div class="flex flex-col md:flex-row md:items-end md:space-x-4">
                            <div class="flex-1">
                                <label for="tahunMulai" class="block mb-1 text-sm font-medium text-gray-700">Dari
                                    Tahun:</label>
                                <input type="number" wire:model="tahunMulai" id="tahunMulai" placeholder="Contoh: 2023"
                                    class="mt-1 w-full rounded-md border px-2.5 py-1.5 text-sm">
                                @error('tahunMulai')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1">
                                <label for="tahunSampai" class="block mb-1 text-sm font-medium text-gray-700">Sampai
                                    Tahun:</label>
                                <input type="number" wire:model="tahunSampai" id="tahunSampai"
                                    placeholder="Contoh: 2025"
                                    class="mt-1 w-full rounded-md border px-2.5 py-1.5 text-sm">
                                @error('tahunSampai')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1">
                                <label for="selectedOpdId"
                                    class="block mb-1 text-sm font-medium text-gray-700">OPD:</label>
                                <select wire:model="selectedOpdId" id="selectedOpdId"
                                    class="mt-1 w-full rounded-md border px-2.5 py-1.5 text-sm">
                                    <option value="">-- Semua OPD --</option>
                                    @foreach ($opdOptions as $opd)
                                        <option value="{{ $opd->id }}">{{ $opd->nama_opd }}</option>
                                    @endforeach
                                </select>
                                @error('selectedOpdId')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex items-end space-x-2 mt-2 md:mt-0">
                                <button wire:click="processAgregat"
                                    class="flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white px-2 py-2 text-sm rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="size-5">
                                        <path
                                            d="M3.105 2.288a.75.75 0 0 0-.826.95l1.414 4.926A1.5 1.5 0 0 0 5.135 9.25h6.115a.75.75 0 0 1 0 1.5H5.135a1.5 1.5 0 0 0-1.442 1.086l-1.414 4.926a.75.75 0 0 0 .826.95 28.897 28.897 0 0 0 15.293-7.155.75.75 0 0 0 0-1.114A28.897 28.897 0 0 0 3.105 2.288Z" />
                                    </svg>
                                    Process
                                </button>
                                <button wire:click="downloadPdfAgregat"
                                    class="flex items-center gap-1 bg-yellow-600 hover:bg-yellow-700 text-white px-2 py-2 text-sm rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="size-5">
                                        <path
                                            d="M10.75 2.75a.75.75 0 0 0-1.5 0v8.614L6.295 8.235a.75.75 0 1 0-1.09 1.03l4.25 4.5a.75.75 0 0 0 1.09 0l4.25-4.5a.75.75 0 0 0-1.09-1.03l-2.955 3.129V2.75Z" />
                                        <path
                                            d="M3.5 12.75a.75.75 0 0 0-1.5 0v2.5A2.75 2.75 0 0 0 4.75 18h10.5A2.75 2.75 0 0 0 18 15.25v-2.5a.75.75 0 0 0-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5Z" />
                                    </svg>
                                    Pdf
                                </button>
                                <button wire:click="closeAgregatForm"
                                    class="flex items-center gap-1 bg-gray-600 hover:bg-gray-700 text-white px-2 py-2 text-sm rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="h-5 w-5">
                                        <path
                                            d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                    </svg>
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Tabel --}}
                @if ($dataLoadedDatalist)
                    @if ($datalists !== null && $datalists->isNotEmpty())
                        <div class="w-full overflow-x-auto">
                            {{-- Gunakan $tahun dari properti Livewire --}}
                            <h1 class="text-xl text-center font-bold mt-2 mb-3">Daftar Nilai Evaluasi SAKIP Tahun
                                {{ $tahun }}</h1>
                            <table class="w-full table-auto border">
                                <thead class="bg-gray-100 text-center text-sm font-semibold border">
                                    {{-- <tr class="border-t">
                                    <th class="px-4 py-2">#</th>
                                    <th class="px-4 py-2">Periode</th>
                                    <th class="px-4 py-2">Nama OPD</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Nilai Aspek A (30%)</th>
                                    <th class="px-4 py-2">Nilai Aspek B (30%)</th>
                                    <th class="px-4 py-2">Nilai Aspek C (15%)</th>
                                    <th class="px-4 py-2">Nilai Aspek D (25%)</th>
                                    <th class="px-4 py-2">Nilai Sakip</th>
                                    <th class="px-4 py-2">Predikat</th>
                                </tr> --}}
                                    <tr class="border-t">
                                        <th class="border border-gray-400 px-4 py-2" rowspan="3">No</th>
                                        {{-- <th class="border border-gray-400 px-4 py-2" rowspan="3">Periode</th> --}}
                                        <th class="border border-gray-400 px-4 py-2" rowspan="3">Nama OPD</th>
                                        <th class="border border-gray-400 px-4 py-2" colspan="8">Aspek A (30%)</th>
                                        <th class="border border-gray-400 px-4 py-2" colspan="8">Aspek B (30%)</th>
                                        <th class="border border-gray-400 px-4 py-2" colspan="8">Aspek C (15%)</th>
                                        <th class="border border-gray-400 px-4 py-2" colspan="8">Aspek D (25%)</th>
                                        <th class="border border-gray-400 px-4 py-2" rowspan="3">Total Skor</th>
                                        <th class="border border-gray-400 px-4 py-2" rowspan="3">Nilai Sakip</th>
                                        <th class="border border-gray-400 px-4 py-2" rowspan="3">Predikat</th>
                                    </tr>
                                    <tr>
                                        <th class="border border-gray-400 px-4 py-2" colspan="2">A1 (6%)</th>
                                        <th class="border border-gray-400 px-4 py-2" colspan="2">A2 (9%)</th>
                                        <th class="border border-gray-400 px-4 py-2" colspan="2">A3 (15%)</th>
                                        <th class="border border-gray-400 px-4 py-2" colspan="2">Sub Total A</th>
                                        <th class="border border-gray-400 px-4 py-2" colspan="2">B1 (6%)</th>
                                        <th class="border border-gray-400 px-4 py-2" colspan="2">B2 (9%)</th>
                                        <th class="border border-gray-400 px-4 py-2" colspan="2">B3 (15%)</th>
                                        <th class="border border-gray-400 px-4 py-2" colspan="2">Sub Total B</th>
                                        <th class="border border-gray-400 px-4 py-2" colspan="2">C1 (3%)</th>
                                        <th class="border border-gray-400 px-4 py-2" colspan="2">C2 (4.5%)</th>
                                        <th class="border border-gray-400 px-4 py-2" colspan="2">C3 (7.5%)</th>
                                        <th class="border border-gray-400 px-4 py-2" colspan="2">Sub Total C</th>
                                        <th class="border border-gray-400 px-4 py-2" colspan="2">D1 (5%)</th>
                                        <th class="border border-gray-400 px-4 py-2" colspan="2">D2 (7.5%)</th>
                                        <th class="border border-gray-400 px-4 py-2" colspan="2">D3 (12.5%)</th>
                                        <th class="border border-gray-400 px-4 py-2" colspan="2">Sub Total D</th>
                                    </tr>
                                    <tr>
                                        {{-- Aspek A --}}
                                        <th class="border border-gray-400 px-4 py-2">Skor</th>
                                        <th class="border border-gray-400 px-4 py-2">Nilai</th>
                                        <th class="border border-gray-400 px-4 py-2">Skor</th>
                                        <th class="border border-gray-400 px-4 py-2">Nilai</th>
                                        <th class="border border-gray-400 px-4 py-2">Skor</th>
                                        <th class="border border-gray-400 px-4 py-2">Nilai</th>
                                        <th class="border border-gray-400 px-4 py-2">Skor</th>
                                        <th class="border border-gray-400 px-4 py-2">Nilai</th>
                                        {{-- Aspek B --}}
                                        <th class="border border-gray-400 px-4 py-2">Skor</th>
                                        <th class="border border-gray-400 px-4 py-2">Nilai</th>
                                        <th class="border border-gray-400 px-4 py-2">Skor</th>
                                        <th class="border border-gray-400 px-4 py-2">Nilai</th>
                                        <th class="border border-gray-400 px-4 py-2">Skor</th>
                                        <th class="border border-gray-400 px-4 py-2">Nilai</th>
                                        <th class="border border-gray-400 px-4 py-2">Skor</th>
                                        <th class="border border-gray-400 px-4 py-2">Nilai</th>
                                        {{-- Aspek C --}}
                                        <th class="border border-gray-400 px-4 py-2">Skor</th>
                                        <th class="border border-gray-400 px-4 py-2">Nilai</th>
                                        <th class="border border-gray-400 px-4 py-2">Skor</th>
                                        <th class="border border-gray-400 px-4 py-2">Nilai</th>
                                        <th class="border border-gray-400 px-4 py-2">Skor</th>
                                        <th class="border border-gray-400 px-4 py-2">Nilai</th>
                                        <th class="border border-gray-400 px-4 py-2">Skor</th>
                                        <th class="border border-gray-400 px-4 py-2">Nilai</th>
                                        {{-- Aspek D --}}
                                        <th class="border border-gray-400 px-4 py-2">Skor</th>
                                        <th class="border border-gray-400 px-4 py-2">Nilai</th>
                                        <th class="border border-gray-400 px-4 py-2">Skor</th>
                                        <th class="border border-gray-400 px-4 py-2">Nilai</th>
                                        <th class="border border-gray-400 px-4 py-2">Skor</th>
                                        <th class="border border-gray-400 px-4 py-2">Nilai</th>
                                        <th class="border border-gray-400 px-4 py-2">Skor</th>
                                        <th class="border border-gray-400 px-4 py-2">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    @foreach ($datalists as $index => $datalist)
                                        <tr class="border-t">
                                            <td class="px-4 py-2 align-top">{{ $loop->iteration }}</td>
                                            {{-- <td class="px-4 py-2 align-top text-center">{{ $datalist->periode->tahun }} --}}
                                            </td>
                                            <td class="px-4 py-2 align-top">{{ $datalist->opd->nama_opd }}</td>
                                            {{-- <td class="px-4 py-2 align-top text-center">{{ $datalist->status }}</td> --}}

                                            {{-- Aspek A --}}
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_a1_s }}</td>
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_a1_n }}</td>
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_a2_s }}</td>
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_a2_n }}</td>
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_a3_s }}</td>
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_a3_n }}</td>
                                            <td class="px-4 py-2 align-top text-right font-bold">
                                                {{ $datalist->ev_a_skor }}</td>
                                            <td class="px-4 py-2 align-top text-right font-bold">
                                                {{ $datalist->ev_a_nilai }}</td>

                                            {{-- Aspek B --}}
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_b1_s }}</td>
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_b1_n }}</td>
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_b2_s }}</td>
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_b2_n }}</td>
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_b3_s }}</td>
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_b3_n }}</td>
                                            <td class="px-4 py-2 align-top text-right font-bold">
                                                {{ $datalist->ev_b_skor }}</td>
                                            <td class="px-4 py-2 align-top text-right font-bold">
                                                {{ $datalist->ev_b_nilai }}</td>

                                            {{-- Aspek C --}}
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_c1_s }}</td>
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_c1_n }}</td>
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_c2_s }}</td>
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_c2_n }}</td>
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_c3_s }}</td>
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_c3_n }}</td>
                                            <td class="px-4 py-2 align-top text-right font-bold">
                                                {{ $datalist->ev_c_skor }}</td>
                                            <td class="px-4 py-2 align-top text-right font-bold">
                                                {{ $datalist->ev_c_nilai }}</td>

                                            {{-- Aspek D --}}
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_d1_s }}</td>
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_d1_n }}</td>
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_d2_s }}</td>
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_d2_n }}</td>
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_d3_s }}</td>
                                            <td class="px-4 py-2 align-top text-right">{{ $datalist->ev_d3_n }}</td>
                                            <td class="px-4 py-2 align-top text-right font-bold">
                                                {{ $datalist->ev_d_skor }}</td>
                                            <td class="px-4 py-2 align-top text-right font-bold">
                                                {{ $datalist->ev_d_nilai }}</td>

                                            <td class="px-4 py-2 align-top text-right font-bold">
                                                {{ $datalist->skor_by_penilai }}
                                            </td>
                                            <td class="px-4 py-2 align-top text-right font-bold">
                                                {{ $datalist->nilai_by_penilai }}
                                            </td>
                                            <td class="px-4 py-2 align-top text-center font-bold">
                                                @if ($datalist->predikat === 'AA')
                                                    Sangat Memuaskan ({{ $datalist->predikat }})
                                                @elseif($datalist->predikat === 'A')
                                                    Memuaskan ({{ $datalist->predikat }})
                                                @elseif($datalist->predikat === 'BB')
                                                    Sangat Baik ({{ $datalist->predikat }})
                                                @elseif($datalist->predikat === 'B')
                                                    Baik ({{ $datalist->predikat }})
                                                @elseif($datalist->predikat === 'CC')
                                                    Cukup/Memadai ({{ $datalist->predikat }})
                                                @elseif($datalist->predikat === 'C')
                                                    Kurang ({{ $datalist->predikat }})
                                                @elseif($datalist->predikat === 'D')
                                                    Sangat Kurang ({{ $datalist->predikat }})
                                                @else
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">- Tidak ada data untuk ditampilkan dengan filter ini -</div>
                    @endif
                @elseif ($dataLoadedAgregat)
                    {{-- Tabel Agregat --}}
                    @if ($agregatData !== null && $agregatData->isNotEmpty())
                        <div class="w-full overflow-x-auto mt-8">
                            <h1 class="text-xl text-center font-bold mt-2 mb-3">Agregat Nilai Evaluasi SAKIP Tahun
                                {{ $tahunMulai }} - {{ $tahunSampai }}</h1>
                            <table class="w-full table-auto border">
                                <thead class="bg-gray-100 text-center text-sm font-semibold border">
                                    <tr class="border-t">
                                        <th class="border border-gray-400 px-4 py-2">No</th>
                                        <th class="border border-gray-400 px-4 py-2">Perangkat Daerah</th>
                                        @foreach ($agregatYears as $year)
                                            <th class="border border-gray-400 px-4 py-2">{{ $year }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    @foreach ($agregatData as $index => $data)
                                        <tr class="border-t">
                                            <td class="border border-gray-400 px-4 py-2 align-top">{{ $loop->iteration }}</td>
                                            <td class="border border-gray-400 px-4 py-2 align-top">{{ $data['nama_opd'] }}</td>
                                            @foreach ($agregatYears as $year)
                                                <td class="border border-gray-400 px-4 py-2 align-top text-right">
                                                    {{ $data[$year] ?? '-' }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">- Tidak ada data Agregat untuk ditampilkan dengan filter ini -
                        </div>
                    @endif
                @else
                    <p class="text-center py-4 text-gray-600">- Silakan pilih jenis laporan dan masukkan filter untuk
                        menampilkan data -</p>
                @endif
            </div>
        </div>
    </div>
</div>
