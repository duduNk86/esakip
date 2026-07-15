<div>
    @php
        $firstAspek = collect($aspeks)->first();
        $aspekIds = collect($aspeks)->pluck('id')->values();
    @endphp

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    {{-- History Url --}}
    <div class="container max-w-full mx-auto py-2 bg-white text-xs">
        <div class="flex justify-end items-center pr-12">
            <span class="text-gray-600">
                <a href="{{ route('dashboard.index') }}" class="text-blue-600 ml-1">Home</a> /<a
                    href="{{ route('penilaianopd.index') }}" class="text-blue-600 ml-1">Penilaian AKIP</a> /
            </span>
            <a href="#" class="text-gray-600 ml-1">{{ $titleHistoryUrl }}</a>
        </div>
    </div>

    {{-- Container --}}
    <div class="container max-w-full mx-auto mt-0 px-6 py-0 bg-white">
        <div class="max-w-full mx-auto mt-0 px-0 py-5 bg-white shadow rounded" x-data="{
                activeTab: {{ $firstAspek?->id ?? 'null' }},
                aspekOrder: {{ Illuminate\Support\Js::from($aspekIds) }},
                setTab(id) {
                    this.activeTab = id;
                    this.scrollToTop();
                },
                currentIndex() {
                    return this.aspekOrder.indexOf(this.activeTab);
                },
                hasPrev() {
                    return this.currentIndex() > 0;
                },
                hasNext() {
                    return this.currentIndex() !== -1 && this.currentIndex() < this.aspekOrder.length - 1;
                },
                prevTab() {
                    if (this.hasPrev()) {
                        this.activeTab = this.aspekOrder[this.currentIndex() - 1];
                        this.scrollToTop();
                    }
                },
                nextTab() {
                    if (this.hasNext()) {
                        this.activeTab = this.aspekOrder[this.currentIndex() + 1];
                        this.scrollToTop();
                    }
                },
                scrollToTop() {
                    this.$nextTick(() => {
                        this.$refs.tabTop?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });
                }
            }">
            <div class="p-6" style="margin-top:-30px;" x-ref="tabTop">
                <h2 class="text-2xl font-bold text-center">Lembar Kerja Evaluasi (LKE) AKIP</h2>
                <h4 class="text-lg mb-5 text-center"><b>OPD :</b> {{ $opd }} | <b>Tahun :</b> {{ $tahun_evaluasi }}
                </h4>

                @if (collect($aspeks)->isNotEmpty())
                    <div class="mb-6 border-b border-gray-200">
                        <div class="flex gap-0.5 overflow-x-auto pb-0">
                            @foreach ($aspeks as $aspek)
                                <button type="button" @click="setTab({{ $aspek->id }})"
                                    class="min-w-max rounded-t-lg border border-b-0 px-4 py-3 text-left text-sm transition"
                                    :class="activeTab === {{ $aspek->id }} ? 'border-blue-600 bg-blue-600 text-white shadow-sm' : 'border-gray-300 bg-gray-50 text-gray-700 hover:bg-gray-100'">
                                    <div class="font-semibold">{{ $aspek->kode }} - {{ $aspek->keterangan }}</div>
                                    {{-- <div class="mt-1 text-xs"
                                        :class="activeTab === {{ $aspek->id }} ? 'text-blue-100' : 'text-gray-500'">
                                        Bobot: {{ $aspek->bobot }}%
                                    </div> --}}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                @foreach ($aspeks as $aspek)
                    <div class="mb-6" x-show="activeTab === {{ $aspek->id }}" x-cloak
                        wire:key="aspek-panel-{{ $aspek->id }}">
                        <h3 class="mb-2 text-xl font-semibold">
                            {{ $aspek->kode }} - {{ $aspek->keterangan }} (Bobot: {{ $aspek->bobot }}%)
                        </h3>

                        <p class="mb-4 text-sm text-gray-500">
                            Komponen: {{ $aspek->komponen->count() }} |
                            Subkomponen: {{ $aspek->komponen->sum(fn($komponen) => $komponen->subkomponen->count()) }}
                        </p>

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

                                        {{-- Jawaban OPD --}}
                                        @if (auth()->user()?->role === 'superadmin' || auth()->user()?->role === 'user')
                                            <div class="flex flex-wrap md:flex-nowrap items-end gap-2">
                                                <div class="w-full md:w-5/6">
                                                    <label class="block mt-2 text-sm font-bold">
                                                        Jawaban
                                                    </label>
                                                    <select wire:model.live="jawaban_opd.{{ $sub->id }}"
                                                        class="w-full mt-1 border rounded px-3 py-2 text-sm">
                                                        <option value="">- Pilih -</option>
                                                        @foreach ($sub->tipeJawaban->opsi ?? [] as $opsi)
                                                            <option value="{{ $opsi->nilai }}">
                                                                {{ $opsi->label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="w-full md:w-1/6">
                                                    <label class="block mt-2 text-sm font-bold">
                                                        Skor
                                                    </label>
                                                    <input type="text" wire:model="skor_opd.{{ $sub->id }}"
                                                        class="w-full mt-1 border rounded px-3 py-2 text-sm bg-gray-100" readonly>
                                                </div>
                                            </div>
                                            <div class="flex flex-wrap md:flex-nowrap items-end gap-2">
                                                <div class="w-full md:w-5/6">
                                                    <label class="block mt-2 text-sm font-bold">
                                                        URL Bukti
                                                    </label>
                                                    <input type="text" wire:model="url_bukti.{{ $sub->id }}"
                                                        class="w-full mt-1 border rounded px-3 py-2 text-sm">
                                                </div>
                                                <div class="w-full md:w-1/6">
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
                                                </div>
                                            </div>
                                        @elseif (auth()->user()?->role === 'penilai')
                                            <div class="flex flex-wrap md:flex-nowrap items-end gap-2">
                                                <div class="w-full md:w-5/6">
                                                    <label class="block mt-2 text-sm font-bold">
                                                        Jawaban
                                                    </label>
                                                    <select wire:model.live="jawaban_opd.{{ $sub->id }}"
                                                        class="w-full mt-1 border rounded px-3 py-2 text-sm">
                                                        <option value="">- Pilih -</option>
                                                        @foreach ($sub->tipeJawaban->opsi ?? [] as $opsi)
                                                            <option value="{{ $opsi->nilai }}">
                                                                {{ $opsi->label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="w-full md:w-1/6">
                                                    <label class="block mt-2 text-sm font-bold">
                                                        Skor
                                                    </label>
                                                    <input type="text" wire:model="skor_opd.{{ $sub->id }}"
                                                        class="w-full mt-1 border rounded px-3 py-2 text-sm bg-gray-100" readonly>
                                                </div>
                                            </div>
                                            <label class="block mt-2 text-sm font-bold">
                                                URL Bukti
                                            </label>
                                            <p class="mt-1">
                                                @if ($url_bukti[$sub->id] ?? false)
                                                    <a href="{{ $url_bukti[$sub->id] }}" target="_blank"
                                                        class="inline-flex items-center gap-1 text-blue-600 underline hover:text-blue-800">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                            class="w-4 h-4">
                                                            <path
                                                                d="M12.232 4.232a2.5 2.5 0 0 1 3.536 3.536l-1.225 1.224a.75.75 0 0 0 1.061 1.06l1.224-1.224a4 4 0 0 0-5.656-5.656l-3 3a4 4 0 0 0 .225 5.865.75.75 0 0 0 .977-1.138 2.5 2.5 0 0 1-.142-3.667l3-3Z" />
                                                            <path
                                                                d="M11.603 7.963a.75.75 0 0 0-.977 1.138 2.5 2.5 0 0 1 .142 3.667l-3 3a2.5 2.5 0 0 1-3.536-3.536l1.225-1.224a.75.75 0 0 0-1.061-1.06l-1.224 1.224a4 4 0 1 0 5.656 5.656l3-3a4 4 0 0 0-.225-5.865Z" />
                                                        </svg>
                                                        Lihat Dokumen
                                                    </a>
                                                @else
                                                    <span class="inline-flex items-center gap-1 text-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                            class="w-4 h-4">
                                                            <path
                                                                d="M12.232 4.232a2.5 2.5 0 0 1 3.536 3.536l-1.225 1.224a.75.75 0 0 0 1.061 1.06l1.224-1.224a4 4 0 0 0-5.656-5.656l-3 3a4 4 0 0 0 .225 5.865.75.75 0 0 0 .977-1.138 2.5 2.5 0 0 1-.142-3.667l3-3Z" />
                                                            <path
                                                                d="M11.603 7.963a.75.75 0 0 0-.977 1.138 2.5 2.5 0 0 1 .142 3.667l-3 3a2.5 2.5 0 0 1-3.536-3.536l1.225-1.224a.75.75 0 0 0-1.061-1.06l-1.224 1.224a4 4 0 1 0 5.656 5.656l3-3a4 4 0 0 0-.225-5.865Z" />
                                                        </svg>
                                                        Bukti belum diunggah
                                                    </span>
                                                @endif
                                            </p>
                                        @elseif (auth()->user()?->role === 'viewer')
                                            <div class="flex flex-wrap md:flex-nowrap items-end gap-2">
                                                <div class="w-full md:w-5/6">
                                                    <label class="block mt-2 text-sm font-bold">
                                                        Jawaban
                                                    </label>
                                                    <select wire:model.live="jawaban_opd.{{ $sub->id }}"
                                                        class="w-full mt-1 border rounded px-3 py-2 text-sm" disabled>
                                                        <option value="">- Pilih -</option>
                                                        @foreach ($sub->tipeJawaban->opsi ?? [] as $opsi)
                                                            <option value="{{ $opsi->nilai }}">
                                                                {{ $opsi->label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="w-full md:w-1/6">
                                                    <label class="block mt-2 text-sm font-bold">
                                                        Skor
                                                    </label>
                                                    <input type="text" wire:model="skor_opd.{{ $sub->id }}"
                                                        class="w-full mt-1 border rounded px-3 py-2 text-sm bg-gray-100" readonly>
                                                </div>
                                            </div>
                                            <label class="block mt-2 text-sm font-bold">
                                                URL Bukti
                                            </label>
                                            <p class="mt-1">
                                                @if ($url_bukti[$sub->id] ?? false)
                                                    <a href="{{ $url_bukti[$sub->id] }}" target="_blank"
                                                        class="inline-flex items-center gap-1 text-blue-600 underline hover:text-blue-800">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                            class="w-4 h-4">
                                                            <path
                                                                d="M12.232 4.232a2.5 2.5 0 0 1 3.536 3.536l-1.225 1.224a.75.75 0 0 0 1.061 1.06l1.224-1.224a4 4 0 0 0-5.656-5.656l-3 3a4 4 0 0 0 .225 5.865.75.75 0 0 0 .977-1.138 2.5 2.5 0 0 1-.142-3.667l3-3Z" />
                                                            <path
                                                                d="M11.603 7.963a.75.75 0 0 0-.977 1.138 2.5 2.5 0 0 1 .142 3.667l-3 3a2.5 2.5 0 0 1-3.536-3.536l1.225-1.224a.75.75 0 0 0-1.061-1.06l-1.224 1.224a4 4 0 1 0 5.656 5.656l3-3a4 4 0 0 0-.225-5.865Z" />
                                                        </svg>
                                                        Lihat Dokumen
                                                    </a>
                                                @else
                                                    <span class="inline-flex items-center gap-1 text-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                            class="w-4 h-4">
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
                                                    <select wire:model.live="nilai_penilai.{{ $sub->id }}"
                                                        class="w-full mt-1 border rounded px-3 py-2 text-sm">
                                                        <option value="">- Pilih -</option>
                                                        @foreach ($sub->tipeJawaban->opsi ?? [] as $opsi)
                                                            <option value="{{ $opsi->nilai }}">
                                                                {{ $opsi->label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="w-full md:w-1/6">
                                                    <label class="block mt-2 text-sm font-bold">
                                                        Skor
                                                    </label>
                                                    <input type="text" wire:model="skor_penilai.{{ $sub->id }}"
                                                        class="w-full mt-1 border rounded px-3 py-2 text-sm bg-gray-100" readonly>
                                                </div>
                                            </div>
                                            <label class="block mt-2 text-sm font-bold">
                                                Catatan
                                            </label>
                                            <textarea type="text" wire:model="catatan.{{ $sub->id }}"
                                                class="w-full mt-1 border rounded px-3 py-2 text-sm" rows="4"></textarea>
                                            <label class="block mt-2 text-sm font-bold">
                                                Saran
                                            </label>
                                            <textarea type="text" wire:model="saran.{{ $sub->id }}"
                                                class="w-full mt-1 border rounded px-3 py-2 text-sm" rows="4"></textarea>
                                        @elseif (auth()->user()?->role === 'viewer')
                                            <p class="font-bold mt-3 text-red-500">Evaluasi APIP</p>
                                            <div class="flex flex-wrap md:flex-nowrap items-end gap-2">
                                                <div class="w-full md:w-5/6">
                                                    <label class="block mt-2 text-sm font-bold">
                                                        Penilaian
                                                    </label>
                                                    <select wire:model.live="nilai_penilai.{{ $sub->id }}"
                                                        class="w-full mt-1 border rounded px-3 py-2 text-sm" disabled>
                                                        <option value="">- Pilih -</option>
                                                        @foreach ($sub->tipeJawaban->opsi ?? [] as $opsi)
                                                            <option value="{{ $opsi->nilai }}">
                                                                {{ $opsi->label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="w-full md:w-1/6">
                                                    <label class="block mt-2 text-sm font-bold">
                                                        Skor
                                                    </label>
                                                    <input type="text" wire:model="skor_penilai.{{ $sub->id }}"
                                                        class="w-full mt-1 border rounded px-3 py-2 text-sm bg-gray-100" readonly>
                                                </div>
                                            </div>
                                            <label class="block mt-2 text-sm font-bold">
                                                Catatan
                                            </label>
                                            <textarea type="text" wire:model="catatan.{{ $sub->id }}"
                                                class="w-full mt-1 border rounded px-3 py-2 text-sm" rows="4" disabled></textarea>
                                            <label class="block mt-2 text-sm font-bold">
                                                Saran
                                            </label>
                                            <textarea type="text" wire:model="saran.{{ $sub->id }}"
                                                class="w-full mt-1 border rounded px-3 py-2 text-sm" rows="4" disabled></textarea>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                        <div class="mt-6 flex flex-wrap items-center justify-between gap-3 border-t border-gray-200 pt-4">
                            <div class="flex gap-2">
                                <button type="button" @click="prevTab()" x-bind:disabled="!hasPrev()"
                                    class="rounded bg-gray-600 px-3 py-2 text-sm text-white transition hover:bg-gray-700 disabled:cursor-not-allowed disabled:bg-gray-300">
                                    Sebelumnya
                                </button>
                                <button type="button" @click="nextTab()" x-bind:disabled="!hasNext()"
                                    class="rounded bg-blue-600 px-3 py-2 text-sm text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:bg-blue-300">
                                    Berikutnya
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Modal Detail Penjelasan & Contoh Dokumen --}}
                @if ($showSubModal && $subDetail)
                    <div class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm">
                        <div class="max-h-screen w-full max-w-7xl overflow-auto rounded bg-white p-8 shadow-md">
                            <h2 class="mb-2 text-2xl font-bold">Detail Penjelasan Subkomponen</h2>

                            <h3 class="mb-2 text-xl font-bold text-red-500">
                                <strong>{{ $subDetail->kode }} - {!! nl2br(e($subDetail->pertanyaan)) !!}</strong>
                            </h3>

                            <p class="mb-2"><strong>Penjelasan:</strong></p>
                            <p class="mb-4">{!! nl2br(e($subDetail->keterangan)) !!}</p>

                            <p class="mb-2"><strong>Contoh:</strong></p>
                            <a href="{{ $subDetail->url_contoh }}" target="_blank" class="text-blue-600 underline">
                                Buka Dokumen
                            </a>

                            <div class="mt-6 text-right">
                                <button wire:click="closeSubModal"
                                    class="rounded bg-gray-700 px-4 py-2 text-white hover:bg-gray-800">
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

                <div
                    class="sticky bottom-0 z-40 -mx-6 mt-6 border-t border-gray-200 bg-white/95 px-6 py-4 backdrop-blur">
                    <div class="flex justify-end">
                        <a href="{{ route('penilaianopd.index') }}"
                            class="mr-1 flex items-center gap-1 rounded bg-gray-600 px-3 py-2 text-sm text-white hover:bg-gray-700">
                            Kembali
                        </a>
                        @if(auth()->user()?->role !== 'viewer')
                            <button wire:click="save"
                                class="flex items-center gap-1 rounded bg-green-600 px-3 py-2 text-sm text-white hover:bg-green-700">
                                Simpan
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>