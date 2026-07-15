<div>

    {{-- History Url --}}
    <div class="container max-w-full mx-auto py-2 bg-white text-xs">
        <div class="flex justify-end items-center pr-12">
            <span class="text-gray-600">Setting / Sakip / </span>
            <a href="{{ route('tipejawaban.index') }}" class="text-blue-600 ml-1">{{ $titleHistoryUrl }}</a>
        </div>
    </div>

    {{-- Container --}}
    <div class="container max-w-full mx-auto mt-0 px-6 py-0 bg-white">
        <div class="max-w-full mx-auto mt-0 px-0 py-5 bg-white shadow rounded">
            <div class="p-6" style="margin-top:-30px;">

                <h2 class="text-xl font-semibold mb-4">Tipe Jawaban</h2>

                {{-- Tombol & Pencarian --}}
                <div class="flex items-center justify-between mb-4">
                    <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search..."
                        class="border px-3 py-2 rounded w-1/3">
                    <button wire:click="showCreateForm"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+
                        Tambah</button>
                </div>

                {{-- Form Tambah/Edit --}}
                @if ($showForm)
                    <div class="mb-4 p-4 bg-gray-100 rounded">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block mb-1 font-bold">Keterangan <b class="text-red-500">*</b></label>
                                <input type="text" wire:model="keterangan" class="w-full border px-2 py-1 rounded">
                                @error('keterangan')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button wire:click="save"
                                class="bg-green-600 text-white px-4 py-2 text-sm rounded">Simpan</button>
                            <button wire:click="closeForm"
                                class="ml-1 bg-gray-500 text-white px-4 py-2 text-sm rounded">Batal</button>
                        </div>
                    </div>
                @endif

                @if ($showOpsiManager)
                    <div class="mb-4 rounded border border-blue-200 bg-blue-50 p-4">
                        <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-blue-900">Kelola Opsi Jawaban</h3>
                                <p class="text-sm text-blue-800">
                                    Tipe Jawaban:
                                    <span class="font-semibold">{{ $selectedTipeJawabanKeterangan }}</span>
                                </p>
                            </div>
                            <button wire:click="closeOpsiManager"
                                class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold">
                                &times;
                            </button>

                        </div>

                        <div class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block mb-1 font-bold">Nilai <b class="text-red-500">*</b></label>
                                <input type="number" wire:model="opsiNilai" class="w-full border px-2 py-1 rounded">
                                @error('opsiNilai')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="md:col-span-3">
                                <label class="block mb-1 font-bold">Label <b class="text-red-500">*</b></label>
                                <textarea wire:model="opsiLabel" rows="1"
                                    class="w-full border px-2 py-1 rounded"></textarea>
                                @error('opsiLabel')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button wire:click="saveOpsi" class="bg-green-600 text-white px-4 py-2 text-sm rounded">
                                {{ $opsiId ? 'Update Opsi' : 'Simpan Opsi' }}
                            </button>
                            <button wire:click="resetOpsiForm"
                                class="ml-1 bg-yellow-500 text-white px-4 py-2 text-sm rounded hover:bg-yellow-600">
                                Reset
                            </button>
                        </div>

                        <div class="mt-6 overflow-x-auto">
                            <table class="w-full table-auto bg-white rounded">
                                <thead class="bg-blue-100 text-left text-sm font-semibold">
                                    <tr class="border-t">
                                        <th class="px-4 py-2">#</th>
                                        <th class="px-4 py-2">Nilai</th>
                                        <th class="px-4 py-2">Label</th>
                                        <th class="px-4 py-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    @forelse ($opsiJawabans as $opsi)
                                        @php
                                            $encryptedOpsiId = \Illuminate\Support\Facades\Crypt::encrypt($opsi->id);
                                        @endphp
                                        <tr class="border-t @if ($opsiId == $opsi->id) bg-yellow-50 @endif">
                                            <td class="px-4 py-2 align-top">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-2 align-top">{{ $opsi->nilai }}</td>
                                            <td class="px-4 py-2 align-top">{!! nl2br(e($opsi->label)) !!}</td>
                                            <td class="px-4 py-2 align-top">
                                                <div class="flex items-center space-x-2">
                                                    <a wire:click="editOpsi('{{ $encryptedOpsiId }}')" href="#"
                                                        class="text-blue-600" title="Edit Opsi">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path
                                                                d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.343Z" />
                                                        </svg>
                                                    </a>
                                                    <a wire:click.prevent="deleteOpsi('{{ $encryptedOpsiId }}')" href="#"
                                                        class="text-red-600" title="Hapus Opsi">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-gray-500">
                                                Belum ada opsi jawaban untuk tipe ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                {{-- Tabel --}}
                {{-- <div class="w-full overflow-x-auto h-full min-h-[730px]"> --}}
                    <div class="w-full overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead class="bg-gray-100 text-left text-sm font-semibold">
                                <tr class="border-t">
                                    <th class="px-4 py-2">#</th>
                                    <th class="px-4 py-2">Tipe Jawaban</th>
                                    <th class="px-4 py-2">Jumlah Opsi</th>
                                    <th class="px-4 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @forelse ($tipejawabans as $index => $tipejawaban)
                                    @php
                                        $encryptedId = \Illuminate\Support\Facades\Crypt::encrypt($tipejawaban->id);
                                    @endphp
                                    <tr
                                        class="border-t @if ($idNya == $tipejawaban->id || $selectedTipeJawabanId == $tipejawaban->id) bg-orange-100 @endif">
                                        <td class="px-4 py-2">
                                            {{ ($tipejawabans->currentPage() - 1) * $tipejawabans->perPage() + $loop->iteration }}
                                        </td>
                                        <td class="px-4 py-2 text-left">{{ $tipejawaban->keterangan }}</td>
                                        <td class="px-4 py-2 text-left">{{ $tipejawaban->opsi_count }}</td>
                                        <td class="px-4 py-2 space-x-2 flex items-center">
                                            <a wire:click="showEditForm('{{ $encryptedId }}')" href="#"
                                                class="text-blue-600" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path
                                                        d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.343Z" />
                                                </svg>
                                            </a>
                                            <a wire:click.prevent="delete('{{ $encryptedId }}')" href="#"
                                                class="text-red-600" title="Delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                            <a wire:click="manageOpsi('{{ $encryptedId }}')" href="#"
                                                class="inline-flex items-center gap-1 text-amber-600 hover:text-amber-700"
                                                title="Kelola Opsi Jawaban">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="size-5">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-11.25a.75.75 0 0 0-1.5 0v2.5h-2.5a.75.75 0 0 0 0 1.5h2.5v2.5a.75.75 0 0 0 1.5 0v-2.5h2.5a.75.75 0 0 0 0-1.5h-2.5v-2.5Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $tipejawabans->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>