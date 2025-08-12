<div>

    {{-- History Url --}}
    <div class="container max-w-full mx-auto py-2 bg-white text-xs">
        <div class="flex justify-end items-center pr-12">
            <span class="text-gray-600">Setting / Sakip / </span>
            <a href="{{ route('komponen.index') }}" class="text-blue-600 ml-1">{{ $titleHistoryUrl }}</a>
        </div>
    </div>

    {{-- Container --}}
    <div class="container max-w-full mx-auto mt-0 px-6 py-0 bg-white">
        <div class="max-w-full mx-auto mt-0 px-0 py-5 bg-white shadow rounded">
            <div class="p-6" style="margin-top:-30px;">

                <h2 class="text-xl font-semibold mb-4">Komponen</h2>

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
                                <label class="block mb-1 font-bold">Kode Aspek <b class="text-red-500">*</b></label>
                                <select wire:model="aspek_id" id="aspek_id"
                                    class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-2 py-2 shadow-sm focus:outline-none focus:ring focus:border-blue-300 text-sm">
                                    <option value="">- Pilih Aspek -</option>
                                    @foreach ($listAspek as $aspek)
                                        <option value="{{ $aspek->id }}">{{ $aspek->kode }} -
                                            {{ $aspek->keterangan }}</option>
                                    @endforeach
                                </select>
                                @error('aspek_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block mb-1 font-bold">Kode Komponen <b class="text-red-500">*</b></label>
                                <input type="text" wire:model="kode" class="w-full border px-2 py-1 rounded">
                                @error('kode')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block mb-1 font-bold">Bobot (%) <b class="text-red-500">*</b></label>
                                <input type="number" step="0.1" wire:model="bobot"
                                    class="w-full border px-2 py-1 rounded">
                                @error('bobot')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mt-4">
                            <div>
                                <label class="block mb-1 font-bold">Keterangan <b class="text-red-500">*</b></label>
                                <textarea type="text" wire:model="keterangan" class="w-full border px-2 py-1 rounded"></textarea>
                                @error('keterangan')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button wire:click="save" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
                            <button wire:click="closeForm"
                                class="ml-2 bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
                        </div>
                    </div>
                @endif

                {{-- Tabel --}}

                <div class="w-full overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead class="bg-gray-100 text-left text-sm font-semibold">
                            <tr class="border-t">
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Kode Aspek</th>
                                <th class="px-4 py-2">Kode Komponen</th>
                                <th class="px-4 py-2 max-w-[700px] break-words whitespace-normal">Keterangan</th>
                                <th class="px-4 py-2">Bobot</th>
                                <th class="px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse ($komponens as $index => $komponen)
                                @php
                                    $encryptedId = \Illuminate\Support\Facades\Crypt::encrypt($komponen->id);
                                @endphp
                                <tr class="border-t"
                                    @if ($idNya == $komponen->id) class="border-t bg-orange-300" @endif>
                                    <td class="px-4 py-2 align-top">
                                        {{ ($komponens->currentPage() - 1) * $komponens->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-2 align-top">{{ $komponen->aspek->kode }}</td>
                                    <td class="px-4 py-2 align-top">{{ $komponen->kode }}</td>
                                    <td class="px-4 py-2 max-w-[700px] break-words whitespace-normal text-justify align-top">{{ $komponen->keterangan }}</td>
                                    <td class="px-4 py-2 align-top">{{ $komponen->bobot }}%</td>
                                    <td class="px-4 py-2 space-x-2 flex items-center align-top">
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
                    {{ $komponens->links() }}
                </div>
            </div>
        </div>
    </div>

</div>
