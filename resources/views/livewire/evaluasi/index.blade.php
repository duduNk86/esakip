<div>

    {{-- History Url --}}
    <div class="container max-w-full mx-auto py-2 bg-white text-xs">
        <div class="flex justify-end items-center pr-12">
            <span class="text-gray-600">
                <a href="{{ route('dashboard.index') }}" class="text-blue-600 ml-1">Home</a> /<a
                    href="{{ route('penilaianopd.index') }}" class="text-blue-600 ml-1">Penilaian Sakip</a> /
            </span>
            <a href="#" class="text-gray-600 ml-1">{{ $titleHistoryUrl }}</a>
        </div>
    </div>

    {{-- Container --}}
    <div class="container max-w-full mx-auto mt-0 px-6 py-0 bg-white">
        <div class="max-w-full mx-auto mt-0 px-0 py-5 bg-white shadow rounded">
            <div class="p-6" style="margin-top:-30px;">
                <h2 class="text-2xl font-bold mb-4 text-center">Lembar Kerja Evaluasi (LKE) SAKIP</h2>

                @foreach ($aspeks as $aspek)
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold mb-2">
                            {{ $aspek->kode }} - {{ $aspek->keterangan }} (Bobot: {{ $aspek->bobot }}%)
                        </h3>

                        @foreach ($aspek->komponen as $row)
                            <div class="mb-4 pl-4 border-l-4 border-blue-600">
                                <h4 class="text-lg font-semibold mb-2">
                                    {{ $row->kode }} - {{ $row->keterangan }} (Bobot: {{ $row->bobot }}%)
                                </h4>

                                @foreach ($row->subkomponen as $sub)
                                    <div class="mb-4 p-4 bg-gray-50 border border-gray-300 rounded">

                                        <p class="font-medium">
                                            {{ $sub->kode }} -
                                            <button wire:click="showSubDetail({{ $sub->id }})"
                                                class="text-blue-600 hover:underline hover:text-blue-800"
                                                title="Klik untuk detail penjelasan dan contoh dokumen bukti dukungnya">
                                                {!! nl2br(e($sub->pertanyaan)) !!}
                                            </button>
                                        </p>

                                        {{-- Modal Detail Penjelesan & Contoh Dokumen --}}
                                        @if ($showSubModal && $subDetail)
                                            <div
                                                class="fixed inset-0 backdrop-blur-sm flex items-center justify-center z-50">
                                                <div
                                                    class="bg-white p-8 rounded shadow-md max-w-7xl w-full max-h-screen overflow-auto">
                                                    <h2 class="text-2xl font-bold mb-2">Detail Penjelasan Subkomponen
                                                    </h2>

                                                    <h3 class="text-xl font-bold mb-2 text-red-500">
                                                        <strong>{{ $subDetail->kode }} -
                                                            {!! nl2br(e($subDetail->pertanyaan)) !!}</strong>
                                                    </h3>

                                                    <p class="mb-2"><strong>Penjelasan:</strong></p>
                                                    <p class="mb-4">{!! nl2br(e($subDetail->keterangan)) !!}</p>

                                                    <p class="mb-2"><strong>Contoh:</strong></p>
                                                    <a href="{{ $subDetail->url_contoh }}" target="_blank"
                                                        class="text-blue-600 underline">
                                                        Buka Dokumen
                                                    </a>
                                                    <br>
                                                    <div class="text-right mt-6">
                                                        <button wire:click="closeSubModal"
                                                            class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded">
                                                            Tutup
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($showSubModal)
                                            <style>
                                                body {
                                                    overflow: hidden;
                                                }
                                            </style>
                                        @endif

                                        {{-- Jawaban OPD --}}
                                        @if (auth()->user()?->role === 'superadmin' || auth()->user()?->role === 'user')
                                            <div class="flex flex-wrap md:flex-nowrap items-end gap-2">
                                                <div class="w-full md:w-5/6">
                                                    <label class="block mt-2 text-sm font-bold">
                                                        Jawaban
                                                    </label>
                                                    <select type="text"
                                                        wire:model.live="jawaban_opd.{{ $sub->id }}"
                                                        class="w-full mt-1 border rounded px-3 py-2 text-sm">
                                                        <option value="">- Pilih -</option>
                                                        <option value="0">
                                                            a. Jika sama sekali tidak ada upaya dalam pemenuhan kriteria
                                                            penialaian akuntabilitas kinerja
                                                        </option>
                                                        <option value="30">
                                                            b. Jika kriteria penilaian akuntabilitas kinerja telah mulai
                                                            dipenuhi (>0%25%)
                                                        </option>
                                                        <option value="50">
                                                            c. Jika kualitas sebagian kecil kriteria telah terpenuhi
                                                            (>25%-50%)
                                                        </option>
                                                        <option value="60">
                                                            d. Jika kualitas sebagian besar kriteria telah terpenuhi
                                                            (>50%-75%)
                                                        </option>
                                                        <option value="70">
                                                            e. Jika kualitas sebagian besar kriteria telah terpenuhi
                                                            (>75%-100%)
                                                        </option>
                                                        <option value="80">
                                                            f. Jika kualitas seluruh kriteria telah terpenuhi (100%)
                                                            sesuai
                                                            dengan mandat kebijakan nasional
                                                        </option>
                                                        <option value="90">
                                                            g. Jika seluruh kriteria telah terpenuhi (100%) dan telah
                                                            dipertahankan dalam setidaknya 1 tahun terakhir
                                                        </option>
                                                        <option value="100">
                                                            h. Jika seluruh kriteria telah terpenuhi (100%) dan telah
                                                            dipertahankan dalam setidaknya 5 tahun terakhir
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="w-full md:w-1/6">
                                                    <label class="block mt-2 text-sm font-bold">
                                                        Skor
                                                    </label>
                                                    <input type="text" wire:model="skor_opd.{{ $sub->id }}"
                                                        class="w-full mt-1 border rounded px-3 py-2 text-sm bg-gray-100"
                                                        readonly>
                                                </div>
                                            </div>
                                            <label class="block mt-2 text-sm font-bold">
                                                URL Bukti
                                            </label>
                                            <input type="text" wire:model="url_bukti.{{ $sub->id }}"
                                                class="w-full mt-1 border rounded px-3 py-2 text-sm">
                                        @elseif (auth()->user()?->role === 'penilai')
                                            <div class="flex flex-wrap md:flex-nowrap items-end gap-2">
                                                <div class="w-full md:w-5/6">
                                                    <label class="block mt-2 text-sm font-bold">
                                                        Jawaban
                                                    </label>
                                                    <select type="text"
                                                        wire:model.live="jawaban_opd.{{ $sub->id }}"
                                                        class="w-full mt-1 border rounded px-3 py-2 text-sm" disabled>
                                                        <option value="">- Pilih -</option>
                                                        <option value="0">
                                                            a. Jika sama sekali tidak ada upaya dalam pemenuhan kriteria
                                                            penialaian akuntabilitas kinerja
                                                        </option>
                                                        <option value="30">
                                                            b. Jika kriteria penilaian akuntabilitas kinerja telah mulai
                                                            dipenuhi (>0%25%)
                                                        </option>
                                                        <option value="50">
                                                            c. Jika kualitas sebagian kecil kriteria telah terpenuhi
                                                            (>25%-50%)
                                                        </option>
                                                        <option value="60">
                                                            d. Jika kualitas sebagian besar kriteria telah terpenuhi
                                                            (>50%-75%)
                                                        </option>
                                                        <option value="70">
                                                            e. Jika kualitas sebagian besar kriteria telah terpenuhi
                                                            (>75%-100%)
                                                        </option>
                                                        <option value="80">
                                                            f. Jika kualitas seluruh kriteria telah terpenuhi (100%)
                                                            sesuai
                                                            dengan mandat kebijakan nasional
                                                        </option>
                                                        <option value="90">
                                                            g. Jika seluruh kriteria telah terpenuhi (100%) dan telah
                                                            dipertahankan dalam setidaknya 1 tahun terakhir
                                                        </option>
                                                        <option value="100">
                                                            h. Jika seluruh kriteria telah terpenuhi (100%) dan telah
                                                            dipertahankan dalam setidaknya 5 tahun terakhir
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="w-full md:w-1/6">
                                                    <label class="block mt-2 text-sm font-bold">
                                                        Skor
                                                    </label>
                                                    <input type="text" wire:model="skor_opd.{{ $sub->id }}"
                                                        class="w-full mt-1 border rounded px-3 py-2 text-sm bg-gray-100"
                                                        readonly>
                                                </div>
                                            </div>
                                            <label class="block mt-2 text-sm font-bold">
                                                URL Bukti
                                            </label>
                                            <p class="mt-1">
                                                @if ($url_bukti[$sub->id] ?? false)
                                                    <a href="{{ $url_bukti[$sub->id] }}" target="_blank"
                                                        class="inline-flex items-center gap-1 text-blue-600 underline hover:text-blue-800">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-4 h-4">
                                                            <path
                                                                d="M12.232 4.232a2.5 2.5 0 0 1 3.536 3.536l-1.225 1.224a.75.75 0 0 0 1.061 1.06l1.224-1.224a4 4 0 0 0-5.656-5.656l-3 3a4 4 0 0 0 .225 5.865.75.75 0 0 0 .977-1.138 2.5 2.5 0 0 1-.142-3.667l3-3Z" />
                                                            <path
                                                                d="M11.603 7.963a.75.75 0 0 0-.977 1.138 2.5 2.5 0 0 1 .142 3.667l-3 3a2.5 2.5 0 0 1-3.536-3.536l1.225-1.224a.75.75 0 0 0-1.061-1.06l-1.224 1.224a4 4 0 1 0 5.656 5.656l3-3a4 4 0 0 0-.225-5.865Z" />
                                                        </svg>
                                                        Lihat Dokumen
                                                    </a>
                                                @else
                                                    <span class="inline-flex items-center gap-1 text-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-4 h-4">
                                                            <path
                                                                d="M12.232 4.232a2.5 2.5 0 0 1 3.536 3.536l-1.225 1.224a.75.75 0 0 0 1.061 1.06l1.224-1.224a4 4 0 0 0-5.656-5.656l-3 3a4 4 0 0 0 .225 5.865.75.75 0 0 0 .977-1.138 2.5 2.5 0 0 1-.142-3.667l3-3Z" />
                                                            <path
                                                                d="M11.603 7.963a.75.75 0 0 0-.977 1.138 2.5 2.5 0 0 1 .142 3.667l-3 3a2.5 2.5 0 0 1-3.536-3.536l1.225-1.224a.75.75 0 0 0-1.061-1.06l-1.224 1.224a4 4 0 1 0 5.656 5.656l3-3a4 4 0 0 0-.225-5.865Z" />
                                                        </svg>
                                                        Bukti belum diunggah
                                                    </span>
                                                @endif
                                            </p>
                                        @endif

                                        {{-- Evaluasi APIP --}}
                                        @if (auth()->user()?->role === 'superadmin' || auth()->user()?->role === 'penilai')
                                            <p class="font-bold mt-3 text-red-500">Evaluasi APIP</p>
                                            <div class="flex flex-wrap md:flex-nowrap items-end gap-2">
                                                <div class="w-full md:w-5/6">
                                                    <label class="block mt-2 text-sm font-bold">
                                                        Penilaian
                                                    </label>
                                                    <select type="text"
                                                        wire:model.live="nilai_penilai.{{ $sub->id }}"
                                                        class="w-full mt-1 border rounded px-3 py-2 text-sm">
                                                        <option value="">- Pilih -</option>
                                                        <option value="0">
                                                            a. Jika sama sekali tidak ada upaya dalam pemenuhan kriteria
                                                            penialaian akuntabilitas kinerja
                                                        </option>
                                                        <option value="30">
                                                            b. Jika kriteria penilaian akuntabilitas kinerja telah mulai
                                                            dipenuhi (>0%25%)
                                                        </option>
                                                        <option value="50">
                                                            c. Jika kualitas sebagian kecil kriteria telah terpenuhi
                                                            (>25%-50%)
                                                        </option>
                                                        <option value="60">
                                                            d. Jika kualitas sebagian besar kriteria telah terpenuhi
                                                            (>50%-75%)
                                                        </option>
                                                        <option value="70">
                                                            e. Jika kualitas sebagian besar kriteria telah terpenuhi
                                                            (>75%-100%)
                                                        </option>
                                                        <option value="80">
                                                            f. Jika kualitas seluruh kriteria telah terpenuhi (100%)
                                                            sesuai
                                                            dengan mandat kebijakan nasional
                                                        </option>
                                                        <option value="90">
                                                            g. Jika seluruh kriteria telah terpenuhi (100%) dan telah
                                                            dipertahankan dalam setidaknya 1 tahun terakhir
                                                        </option>
                                                        <option value="100">
                                                            h. Jika seluruh kriteria telah terpenuhi (100%) dan telah
                                                            dipertahankan dalam setidaknya 5 tahun terakhir
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="w-full md:w-1/6">
                                                    <label class="block mt-2 text-sm font-bold">
                                                        Skor
                                                    </label>
                                                    <input type="text"
                                                        wire:model="skor_penilai.{{ $sub->id }}"
                                                        class="w-full mt-1 border rounded px-3 py-2 text-sm bg-gray-100"
                                                        readonly>
                                                </div>
                                            </div>
                                            <label class="block mt-2 text-sm font-bold">
                                                Catatan
                                            </label>
                                            <textarea type="text" wire:model="catatan.{{ $sub->id }}"
                                                class="w-full mt-1 border rounded px-3 py-2 text-sm" rows="4"></textarea>
                                            <label class="block mt-2 text-sm">
                                                Saran
                                            </label>
                                            <textarea type="text" wire:model="saran.{{ $sub->id }}" class="w-full mt-1 border rounded px-3 py-2 text-sm"
                                                rows="4"></textarea>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endforeach

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('penilaianopd.index') }}"
                        class="flex items-center gap-1 bg-gray-600 text-white px-3 py-2 mr-1 text-sm rounded hover:bg-gray-700">
                        Kembali
                    </a>
                    <button wire:click="save"
                        class="flex items-center gap-1 bg-green-600 text-white px-3 py-2 text-sm rounded hover:bg-green-700">
                        Simpan
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
