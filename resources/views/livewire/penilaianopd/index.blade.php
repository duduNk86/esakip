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

                <h2 class="text-xl font-semibold mb-4">Penilaian Sakip</h2>

                {{-- Tombol & Pencarian --}}
                <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                    <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search..."
                        class="border px-2.5 py-1.5 text-sm rounded w-full sm:w-1/3">
                    @if (auth()->user()?->role === 'superadmin')
                        <div class="flex flex-wrap gap-2 sm:justify-end">
                            <button wire:click="showCreateForm"
                                class="flex items-center gap-1 px-2.5 py-1.5 text-sm rounded bg-blue-600 text-white hover:bg-blue-700"
                                title="Tambah Penilaian LKE Opd Tunggal">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path
                                        d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                </svg>
                                Penilaian
                            </button>
                            <button wire:click="showCreateGroupForm"
                                class="flex items-center gap-1 px-2.5 py-1.5 text-sm rounded bg-green-600 text-white hover:bg-green-700"
                                title="Tambah Penilaian LKE Opd by Group">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M1 2.75A.75.75 0 0 1 1.75 2h10.5a.75.75 0 0 1 0 1.5H12v13.75a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1-.75-.75v-2.5a.75.75 0 0 0-.75-.75h-2.5a.75.75 0 0 0-.75.75v2.5a.75.75 0 0 1-.75.75h-2.5a.75.75 0 0 1 0-1.5H2v-13h-.25A.75.75 0 0 1 1 2.75ZM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM4.5 9a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1ZM8 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM8.5 9a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1ZM14.25 6a.75.75 0 0 0-.75.75V17a1 1 0 0 0 1 1h3.75a.75.75 0 0 0 0-1.5H18v-9h.25a.75.75 0 0 0 0-1.5h-4Zm.5 3.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm.5 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Z"
                                        clip-rule="evenodd" />
                                </svg>
                                Group
                            </button>
                            <button wire:click="showCutoffGroupForm"
                                class="flex items-center gap-1 px-2.5 py-1.5 text-sm rounded bg-yellow-500 text-white hover:bg-yellow-600"
                                title="Cutoff Pengisian LKE by Group">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M10 2a.75.75 0 0 1 .75.75v7.5a.75.75 0 0 1-1.5 0v-7.5A.75.75 0 0 1 10 2ZM5.404 4.343a.75.75 0 0 1 0 1.06 6.5 6.5 0 1 0 9.192 0 .75.75 0 1 1 1.06-1.06 8 8 0 1 1-11.313 0 .75.75 0 0 1 1.06 0Z"
                                        clip-rule="evenodd" />
                                </svg>
                                Cutoff
                            </button>
                            <button wire:click="showPengumumanGroupForm"
                                class="flex items-center gap-1 px-2.5 py-1.5 text-sm rounded bg-gray-600 text-white hover:bg-gray-700"
                                title="Ubah Status Penilaian LKE by Group">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path
                                        d="M10.5 3.75a.75.75 0 0 0-1.264-.546L5.203 7H2.667a.75.75 0 0 0-.7.48A6.985 6.985 0 0 0 1.5 10c0 .887.165 1.737.468 2.52.111.29.39.48.7.48h2.535l4.033 3.796a.75.75 0 0 0 1.264-.546V3.75ZM16.45 5.05a.75.75 0 0 0-1.06 1.061 5.5 5.5 0 0 1 0 7.778.75.75 0 0 0 1.06 1.06 7 7 0 0 0 0-9.899Z" />
                                    <path
                                        d="M14.329 7.172a.75.75 0 0 0-1.061 1.06 2.5 2.5 0 0 1 0 3.536.75.75 0 0 0 1.06 1.06 4 4 0 0 0 0-5.656Z" />
                                </svg>
                                Pengumuman
                            </button>
                            <button wire:click="showDeleteGroupForm"
                                class="flex items-center gap-1 px-2.5 py-1.5 text-sm rounded bg-red-600 text-white hover:bg-red-700"
                                title="Hapus Penilaian LKE Opd by Group">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                                Delete
                            </button>
                        </div>
                    @endif
                </div>

                {{-- Form Tambah/Edit --}}
                @if ($showForm)
                    <div class="mb-4 p-4 bg-gray-100 border border-blue-600 rounded">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <div>
                                <label class="block mb-1 font-bold">Tahun <b class="text-red-500">*</b></label>
                                <select wire:model="periode_id" id="periode_id"
                                    class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-2 py-2 shadow-sm focus:outline-none focus:ring focus:border-blue-300 text-sm">
                                    <option value="">- Pilih -</option>
                                    @foreach ($listPeriode as $row)
                                        <option value="{{ $row->id }}">{{ $row->tahun }}</option>
                                    @endforeach
                                </select>
                                @error('periode_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block mb-1 font-bold">Opd <b class="text-red-500">*</b></label>
                                <select wire:model="opd_id" id="opd_id"
                                    class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-2 py-2 shadow-sm focus:outline-none focus:ring focus:border-blue-300 text-sm">
                                    <option value="">- Pilih -</option>
                                    @foreach ($listOpd as $row)
                                        <option value="{{ $row->id }}">{{ $row->nama_singkat_opd }}</option>
                                    @endforeach
                                </select>
                                @error('opd_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block mb-1 font-bold">User <b class="text-red-500">*</b></label>
                                <select wire:model="user_id" id="user_id"
                                    class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-2 py-2 shadow-sm focus:outline-none focus:ring focus:border-blue-300 text-sm">
                                    <option value="">- Pilih -</option>
                                    @foreach ($userNya as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block mb-1 font-bold">Penilai <b class="text-red-500">*</b></label>
                                <select wire:model="penilai_id" id="penilai_id"
                                    class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-2 py-2 shadow-sm focus:outline-none focus:ring focus:border-blue-300 text-sm">
                                    <option value="">- Pilih -</option>
                                    @foreach ($listPenilai as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                                @error('penilai_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block mb-1 font-bold">Status <b class="text-red-500">*</b></label>
                                <select wire:model="status" id="status"
                                    class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-2 py-2 shadow-sm focus:outline-none focus:ring focus:border-blue-300 text-sm">
                                    <option value="">- Pilih -</option>
                                    <option value="SAQ">SAQ</option>
                                    <option value="Penilaian">Penilaian</option>
                                    <option value="Final">Final</option>
                                    <option value="Pengumuman">Pengumuman</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button wire:click="save"
                                class="flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 text-sm rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="h-5 w-5">
                                    <path fill-rule="evenodd"
                                        d="M4.25 2A2.25 2.25 0 0 0 2 4.25v11.5A2.25 2.25 0 0 0 4.25 18h11.5A2.25 2.25 0 0 0 18 15.75V4.25A2.25 2.25 0 0 0 15.75 2H4.25ZM6 13.25V3.5h8v9.75a.75.75 0 0 1-1.064.681L10 12.576l-2.936 1.355A.75.75 0 0 1 6 13.25Z"
                                        clip-rule="evenodd" />
                                </svg>
                                Simpan
                            </button>
                            <button wire:click="closeForm"
                                class="flex items-center gap-1 ml-2 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 text-sm rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="h-5 w-5">
                                    <path
                                        d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                </svg>
                                Batal
                            </button>
                        </div>
                    </div>
                @endif

                {{-- Form Tambah Penilaian secara Group --}}
                @if ($showGroupForm)
                    <div class="mb-4 p-4 bg-gray-100 border border-green-600 rounded">
                        <div class="flex flex-col md:flex-row md:items-end md:space-x-4">
                            <div class="flex-1">
                                <label class="block mb-2 font-bold">Tahun <b class="text-red-500">*</b></label>
                                <select wire:model="periode_id"
                                    class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-2 py-2 shadow-sm focus:outline-none focus:ring focus:border-blue-300 text-sm">
                                    <option value="">- Pilih -</option>
                                    @foreach ($listPeriode as $periode)
                                        <option value="{{ $periode->id }}">{{ $periode->tahun }}</option>
                                    @endforeach
                                </select>
                                @error('periode_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex items-end space-x-2 mt-2 md:mt-0">
                                <button wire:click="createGroup"
                                    class="flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white px-2 py-2 text-sm rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="h-5 w-5">
                                        <path fill-rule="evenodd"
                                            d="M4.25 2A2.25 2.25 0 0 0 2 4.25v11.5A2.25 2.25 0 0 0 4.25 18h11.5A2.25 2.25 0 0 0 18 15.75V4.25A2.25 2.25 0 0 0 15.75 2H4.25ZM6 13.25V3.5h8v9.75a.75.75 0 0 1-1.064.681L10 12.576l-2.936 1.355A.75.75 0 0 1 6 13.25Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Simpan
                                </button>
                                <button wire:click="closeGroupForm"
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

                {{-- Cutoff Penilaian secara Group --}}
                @if ($showCutoffForm)
                    <div class="mb-4 p-4 bg-gray-100 border border-yellow-500 rounded">
                        <div class="flex flex-col md:flex-row md:items-end md:space-x-4">
                            <div class="flex-1">
                                <label class="block mb-1 font-bold">Tahun <b class="text-red-500">*</b></label>
                                <select wire:model="periode_id"
                                    class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-2 py-2 shadow-sm focus:outline-none focus:ring focus:border-blue-300 text-sm">
                                    <option value="">- Pilih -</option>
                                    @foreach ($listPeriode as $periode)
                                        <option value="{{ $periode->id }}">{{ $periode->tahun }}</option>
                                    @endforeach
                                </select>
                                @error('periode_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1">
                                <label class="block mb-1 font-bold">Status <b class="text-red-500">*</b></label>
                                <select wire:model="status" id="status"
                                    class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-2 py-2 shadow-sm focus:outline-none focus:ring focus:border-blue-300 text-sm">
                                    <option value="">- Pilih -</option>
                                    <option value="Penilaian">Penilaian</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1">
                                <label class="block mb-1 font-bold">Tanggal dan Jam Cut Off <b
                                        class="text-red-500">*</b></label>
                                <input type="datetime-local" id="tgl_submit_opd" wire:model="tgl_submit_opd"
                                    class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-2 py-2 shadow-sm focus:outline-none focus:ring focus:border-blue-300 text-sm">
                                @error('tgl_submit_opd')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex items-end space-x-2 mt-2 md:mt-0">
                                <button wire:click="cutOffGroup"
                                    class="flex items-center gap-1 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 text-sm rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="h-5 w-5">
                                        <path fill-rule="evenodd"
                                            d="M10 2a.75.75 0 0 1 .75.75v7.5a.75.75 0 0 1-1.5 0v-7.5A.75.75 0 0 1 10 2ZM5.404 4.343a.75.75 0 0 1 0 1.06 6.5 6.5 0 1 0 9.192 0 .75.75 0 1 1 1.06-1.06 8 8 0 1 1-11.313 0 .75.75 0 0 1 1.06 0Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Cutoff
                                </button>

                                <button wire:click="closeCutoffGroupForm"
                                    class="flex items-center gap-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 text-sm rounded">
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

                {{-- Pengumuman Penilaian secara Group --}}
                @if ($showPengumumanForm)
                    <div class="mb-4 p-4 bg-gray-100 border border-gray-600 rounded">
                        <div class="flex flex-col md:flex-row md:items-end md:space-x-4">
                            <div class="flex-1">
                                <label class="block mb-1 font-bold">Tahun <b class="text-red-500">*</b></label>
                                <select wire:model="periode_id"
                                    class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-2 py-2 shadow-sm focus:outline-none focus:ring focus:border-blue-300 text-sm">
                                    <option value="">- Pilih -</option>
                                    @foreach ($listPeriode as $periode)
                                        <option value="{{ $periode->id }}">{{ $periode->tahun }}</option>
                                    @endforeach
                                </select>
                                @error('periode_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1">
                                <label class="block mb-1 font-bold">Status <b class="text-red-500">*</b></label>
                                <select wire:model="status" id="status"
                                    class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-2 py-2 shadow-sm focus:outline-none focus:ring focus:border-blue-300 text-sm">
                                    <option value="">- Pilih -</option>
                                    {{-- <option value="SAQ">SAQ</option>
                                    <option value="Penilaian">Penilaian</option>
                                    <option value="Final">Final</option> --}}
                                    <option value="Pengumuman">Pengumuman</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex items-end space-x-2 mt-2 md:mt-0">
                                <button wire:click="pengumumanGroup"
                                    class="flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 text-sm rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="h-5 w-5">
                                        <path
                                            d="M10.5 3.75a.75.75 0 0 0-1.264-.546L5.203 7H2.667a.75.75 0 0 0-.7.48A6.985 6.985 0 0 0 1.5 10c0 .887.165 1.737.468 2.52.111.29.39.48.7.48h2.535l4.033 3.796a.75.75 0 0 0 1.264-.546V3.75ZM16.45 5.05a.75.75 0 0 0-1.06 1.061 5.5 5.5 0 0 1 0 7.778.75.75 0 0 0 1.06 1.06 7 7 0 0 0 0-9.899Z" />
                                        <path
                                            d="M14.329 7.172a.75.75 0 0 0-1.061 1.06 2.5 2.5 0 0 1 0 3.536.75.75 0 0 0 1.06 1.06 4 4 0 0 0 0-5.656Z" />
                                    </svg>
                                    Ubah
                                </button>
                                <button wire:click="closePengumumanGroupForm"
                                    class="flex items-center gap-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 text-sm rounded">
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

                {{-- Hapus Penilaian secara Group --}}
                @if ($showDeleteForm)
                    <div class="mb-4 p-4 bg-gray-100 border border-red-600 rounded">
                        <div class="flex flex-col md:flex-row md:items-end md:space-x-4">
                            <div class="flex-1">
                                <label class="block mb-2 font-bold">Tahun <b class="text-red-500">*</b></label>
                                <select wire:model="periode_id"
                                    class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-2 py-2 shadow-sm focus:outline-none focus:ring focus:border-blue-300 text-sm">
                                    <option value="">- Pilih -</option>
                                    @foreach ($listPeriode as $periode)
                                        <option value="{{ $periode->id }}">{{ $periode->tahun }}</option>
                                    @endforeach
                                </select>
                                @error('periode_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex items-end space-x-2 mt-2 md:mt-0">
                                <button wire:click="deleteGroup"
                                    class="flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white px-2 py-2 text-sm rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="h-5 w-5">
                                        <path fill-rule="evenodd"
                                            d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Delete
                                </button>
                                <button wire:click="closeDeleteGroupForm"
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
                <div class="w-full overflow-x-auto h-full min-h-[730px]">
                    <table class="w-full table-auto border-collapse border border-gray-200">
                        <thead class="bg-gray-100 text-left text-sm font-semibold text-center">
                            <tr>
                                <th class="border border-gray-400 px-2 py-1" rowspan="4">Aksi</th>
                                <th class="border border-gray-400 px-2 py-1" rowspan="4">#</th>
                                <th class="border border-gray-400 px-2 py-1" rowspan="4">Tahun</th>
                                <th class="border border-gray-400 px-2 py-1" rowspan="4">OPD</th>
                                <th class="border border-gray-400 px-2 py-1" rowspan="4">Status</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="34">Penilaian Mandiri</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="34">Evaluasi APIP</th>
                                <th class="border border-gray-400 px-2 py-1" rowspan="4">Predikat</th>
                                @if (auth()->user()?->role != 'user')
                                    <th class="border border-gray-400 px-2 py-1" rowspan="4">Waktu Submit</th>
                                    <th class="border border-gray-400 px-2 py-1" rowspan="4">Penilai</th>
                                @endif
                            </tr>
                            <tr>
                                <th class="border border-gray-400 px-2 py-1" colspan="8">A (30%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="8">B (30%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="8">C (15%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="8">D (25%)</th>
                                <th class="border border-gray-400 px-2 py-1" rowspan="3">Skor</th>
                                <th class="border border-gray-400 px-2 py-1" rowspan="3">Nilai</th>

                                <th class="border border-gray-400 px-2 py-1" colspan="8">A (30%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="8">B (30%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="8">C (15%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="8">D (25%)</th>
                                <th class="border border-gray-400 px-2 py-1" rowspan="3">Skor</th>
                                <th class="border border-gray-400 px-2 py-1" rowspan="3">Nilai</th>

                            </tr>
                            <tr>
                                <!-- PM OPD Sub A -->
                                <th class="border border-gray-400 px-2 py-1" colspan="2">A1 (6%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">A2 (9%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">A3 (15%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">Sub Total A</th>
                                <!-- PM OPD Sub B -->
                                <th class="border border-gray-400 px-2 py-1" colspan="2">B1 (6%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">B2 (9%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">B3 (15%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">Sub Total B</th>
                                <!-- PM OPD Sub C -->
                                <th class="border border-gray-400 px-2 py-1" colspan="2">C1 (3%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">C2 (4.5%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">C3 (7.5%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">Sub Total C</th>
                                <!-- PM OPD Sub D -->
                                <th class="border border-gray-400 px-2 py-1" colspan="2">D1 (5%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">D2 (7.5%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">D3 (12.5%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">Sub Total D</th>

                                <!-- Evaluasi APIP Sub A -->
                                <th class="border border-gray-400 px-2 py-1" colspan="2">A1 (6%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">A2 (9%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">A3 (15%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">Sub Total A</th>
                                <!-- Evaluasi APIP Sub B -->
                                <th class="border border-gray-400 px-2 py-1" colspan="2">B1 (6%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">B2 (9%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">B3 (15%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">Sub Total B</th>
                                <!-- Evaluasi APIP Sub C -->
                                <th class="border border-gray-400 px-2 py-1" colspan="2">C1 (3%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">C2 (4.5%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">C3 (7.5%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">Sub Total C</th>
                                <!-- Evaluasi APIP Sub D -->
                                <th class="border border-gray-400 px-2 py-1" colspan="2">D1 (5%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">D2 (7.5%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">D3 (12.5%)</th>
                                <th class="border border-gray-400 px-2 py-1" colspan="2">Sub Total D</th>
                            </tr>
                            <tr>
                                @php
                                    for ($i = 1; $i < 16; $i++) {
                                        echo '<th class="border border-gray-400 px-2 py-1">Skor</th>';
                                        echo '<th class="border border-gray-400 px-2 py-1">Nilai</th>';
                                    }
                                @endphp
                                <th class="border border-gray-400 px-2 py-1">Skor</th>
                                <th class="border border-gray-400 px-2 py-1">Nilai</th>
                                @php
                                    for ($i = 1; $i < 17; $i++) {
                                        echo '<th class="border border-gray-400 px-2 py-1">Skor</th>';
                                        echo '<th class="border border-gray-400 px-2 py-1">Nilai</th>';
                                    }
                                @endphp
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse ($penilaianopds as $index => $penilaianopd)
                                @php
                                    $encryptedId = \Illuminate\Support\Facades\Crypt::encrypt($penilaianopd->id);
                                @endphp
                                <tr @if ($idNya == $penilaianopd->id) class="border-t bg-orange-300 border" @endif>
                                    {{-- Aksi --}}
                                    <td class="border border-gray-200 relative px-4 py-2 align-top">
                                        <div x-data="{
                                            open: false,
                                            dropUp: false,
                                            toggle() {
                                                this.open = !this.open;
                                                this.$nextTick(() => {
                                                    const dropdown = this.$refs.dropdown;
                                                    const rect = dropdown.getBoundingClientRect();
                                                    const spaceBelow = window.innerHeight - rect.top;

                                                    this.dropUp = spaceBelow < 200;
                                                });
                                            }
                                        }"
                                            class="relative inline-flex items-center justify-center w-full h-full">
                                            <!-- Tombol -->
                                            <button @click="toggle()"
                                                class="text-gray-600 hover:text-black focus:outline-none">
                                                <!-- Ikon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    viewBox="0 0 24 24" class="w-5 h-5">
                                                    <path
                                                        d="M5.625 3.75a2.625 2.625 0 1 0 0 5.25h12.75a2.625 2.625 0 0 0 0-5.25H5.625ZM3.75 11.25a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5H3.75ZM3 15.75a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75ZM3.75 18.75a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5H3.75Z" />
                                                </svg>
                                            </button>

                                            <!-- Dropdown -->
                                            <div x-show="open" x-ref="dropdown" @click.away="open = false"
                                                x-transition :class="dropUp ? 'bottom-full mb-2' : 'top-full mt-2'"
                                                class="absolute left-0 min-w-max max-h-70 overflow-auto bg-white rounded shadow z-50">

                                                <div class="py-1 text-sm text-gray-700">
                                                    <!-- Dropdown item -->
                                                    {{-- Edit Data --}}
                                                    @if (auth()->user()?->role === 'superadmin')
                                                        <a @click="open = false"
                                                            wire:click="showEditForm('{{ $encryptedId }}')"
                                                            href="#"
                                                            class="flex items-center gap-2 px-4 py-2 hover:bg-blue-100 text-blue-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path
                                                                    d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.343Z" />
                                                            </svg>
                                                            Edit
                                                        </a>
                                                    @endif

                                                    {{-- Klaim LKE oleh Penilai --}}
                                                    @if (auth()->user()?->role === 'penilai' && $penilaianopd->penilai_id === null && $penilaianopd->status === 'Penilaian')
                                                        <a @click="open = false"
                                                            wire:click="klaimLke('{{ $encryptedId }}')"
                                                            href="#"
                                                            class="flex items-center gap-2 px-4 py-2 hover:bg-orange-100 text-orange-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M11 2a1 1 0 1 0-2 0v6.5a.5.5 0 0 1-1 0V3a1 1 0 1 0-2 0v5.5a.5.5 0 0 1-1 0V5a1 1 0 1 0-2 0v7a7 7 0 1 0 14 0V8a1 1 0 1 0-2 0v3.5a.5.5 0 0 1-1 0V3a1 1 0 1 0-2 0v5.5a.5.5 0 0 1-1 0V2Z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            Klaim
                                                        </a>
                                                    @endif

                                                    {{-- Isi dan Nilai LKE --}}
                                                    @if (auth()->user()?->role === 'superadmin' ||
                                                            (auth()->user()?->role === 'penilai' &&
                                                                $penilaianopd->penilai_id === auth()->user()?->id &&
                                                                $penilaianopd->status === 'Penilaian'))
                                                        <a href="{{ route('evaluasi.index', ['penilaian_opd_id' => $encryptedId]) }}"
                                                            class="flex items-center gap-2 px-4 py-2 hover:bg-orange-100 text-orange-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875ZM12.75 12a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V18a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V12Z"
                                                                    clip-rule="evenodd" />
                                                                <path
                                                                    d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z" />
                                                            </svg>
                                                            Nilai LKE
                                                        </a>
                                                    @elseif (auth()->user()?->role === 'user' && $penilaianopd->status === 'SAQ')
                                                        @if (now()->between(
                                                                $penilaianopd->periode->tgl_start,
                                                                \Carbon\Carbon::parse($penilaianopd->periode->tgl_end)->endOfDay()))
                                                            <a href="{{ route('evaluasi.index', ['penilaian_opd_id' => $encryptedId]) }}"
                                                                class="flex items-center gap-2 px-4 py-2 hover:bg-orange-100 text-orange-500">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-5 w-5" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path fill-rule="evenodd"
                                                                        d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875ZM12.75 12a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V18a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V12Z"
                                                                        clip-rule="evenodd" />
                                                                    <path
                                                                        d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z" />
                                                                </svg>
                                                                Isi LKE
                                                            </a>
                                                        @endif
                                                    @endif

                                                    {{-- Kirim LKE --}}
                                                    @if (auth()->user()?->role === 'superadmin' || (auth()->user()?->role === 'user' && $penilaianopd->status === 'SAQ'))
                                                        <a @click="open = false"
                                                            wire:click="kirimLke('{{ $encryptedId }}')"
                                                            href="#"
                                                            class="flex items-center gap-2 px-4 py-2 hover:bg-cyan-100 text-cyan-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path
                                                                    d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                                                            </svg>
                                                            Kirim
                                                        </a>
                                                    @endif

                                                    {{-- Final LKE --}}
                                                    @if (auth()->user()?->role === 'superadmin' ||
                                                            (auth()->user()?->role === 'penilai' &&
                                                                $penilaianopd->penilai_id === auth()->user()?->id &&
                                                                $penilaianopd->status === 'Penilaian'))
                                                        <a @click="open = false"
                                                            wire:click="finalLke('{{ $encryptedId }}')"
                                                            href="#"
                                                            class="flex items-center gap-2 px-4 py-2 hover:bg-green-100 text-green-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            Final
                                                        </a>
                                                    @endif

                                                    {{-- Print LKE --}}
                                                    @if (auth()->user()?->role === 'superadmin' ||
                                                            ((auth()->user()?->role === 'penilai' &&
                                                                ($penilaianopd->penilai_id === auth()->user()?->id) === $penilaianopd->penilai_id &&
                                                                $penilaianopd->status === 'Final') ||
                                                                ((auth()->user()?->role === 'user' &&
                                                                    $penilaianopd->penilai_id != null &&
                                                                    $penilaianopd->status === 'Pengumuman') ||
                                                                    (auth()->user()?->role === 'viewer' &&
                                                                        $penilaianopd->penilai_id != null &&
                                                                        $penilaianopd->status === 'Final'))))
                                                        <a @click="open = false"
                                                            wire:click="printLKE('{{ $encryptedId }}')"
                                                            href="#"
                                                            class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            Print
                                                        </a>
                                                    @endif

                                                    {{-- Download Excel LKE --}}
                                                    @if (auth()->user()?->role === 'superadmin' ||
                                                            ((auth()->user()?->role === 'penilai' &&
                                                                ($penilaianopd->penilai_id === auth()->user()?->id) === $penilaianopd->penilai_id &&
                                                                $penilaianopd->status === 'Final') ||
                                                                ((auth()->user()?->role === 'user' &&
                                                                    $penilaianopd->penilai_id != null &&
                                                                    $penilaianopd->status === 'Pengumuman') ||
                                                                    (auth()->user()?->role === 'viewer' &&
                                                                        $penilaianopd->penilai_id != null &&
                                                                        $penilaianopd->status === 'Final'))))
                                                        <a wire:click="exportLKE('{{ $encryptedId }}')"
                                                            href="#"
                                                            class="flex items-center gap-2 px-4 py-2 hover:bg-fuchsia-100 text-fuchsia-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                            </svg>
                                                            Excel
                                                        </a>
                                                    @endif

                                                    {{-- Delete LKE --}}
                                                    @if (auth()->user()?->role === 'superadmin')
                                                        <a @click="open = false"
                                                            wire:click.prevent="delete('{{ $encryptedId }}')"
                                                            href="#"
                                                            class="flex items-center gap-2 px-4 py-2 hover:bg-red-100 text-red-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            Delete
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    {{-- End of Aksi --}}
                                    <td class="border border-gray-200 px-4 py-2 align-top">
                                        {{ ($penilaianopds->currentPage() - 1) * $penilaianopds->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-center">
                                        {{ $penilaianopd->periode->tahun }}</td>
                                    <td
                                        class="border border-gray-200 px-4 py-2 max-w-[200px] break-words whitespace-normal text-justify align-top">
                                        {{ $penilaianopd->opd->nama_singkat_opd }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-center">
                                        @php
                                            $status = $penilaianopd->status;
                                            $badgeClass = match ($status) {
                                                'SAQ' => 'bg-red-500 text-white border border-red-500',
                                                'Penilaian' => 'bg-orange-400 text-white border border-orange-400',
                                                'Final' => 'bg-blue-500 text-white border border-blue-500',
                                                'Pengumuman' => 'bg-green-500 text-white border border-green-500',
                                                default => 'bg-gray-400 text-white border border-gray-400',
                                            };
                                        @endphp
                                        <span
                                            class="border border-gray-200 px-2 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                            {{ $status }}
                                        </span>
                                    </td>

                                    {{-- <td
                                    class="border border-gray-200 px-4 py-2 align-top text-right {{ ($penilaianopd->pm_a1_s ?? 0) == 0 ? 'text-red-500' : '' }}">
                                    {{ $penilaianopd->pm_a1_s ?? '' }}
                                </td> --}}
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_a1_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_a1_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_a2_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_a2_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_a3_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_a3_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_a_skor ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_a_nilai ?? '' }}</td>

                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_b1_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_b1_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_b2_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_b2_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_b3_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_b3_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_b_skor ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_b_nilai ?? '' }}</td>

                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_c1_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_c1_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_c2_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_c2_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_c3_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_c3_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_c_skor ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_c_nilai ?? '' }}</td>

                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_d1_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_d1_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_d2_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_d2_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_d3_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_d3_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_d_skor ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->pm_d_nilai ?? '' }}</td>

                                    <td class="border border-gray-200 px-4 py-2 align-top text-right font-bold">
                                        {{ $penilaianopd->skor_by_opd ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right font-bold">
                                        {{ $penilaianopd->nilai_by_opd ?? '' }}</td>

                                    {{-- <td
                                    class="border border-gray-200 px-4 py-2 align-top text-right {{ ($penilaianopd->ev_a1_s ?? 0) == 0 ? 'text-red-500' : '' }}">
                                    {{ $penilaianopd->ev_a1_s ?? '' }}
                                </td> --}}
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_a1_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_a1_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_a2_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_a2_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_a3_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_a3_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_a_skor ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_a_nilai ?? '' }}</td>

                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_b1_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_b1_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_b2_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_b2_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_b3_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_b3_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_b_skor ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_b_nilai ?? '' }}</td>

                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_c1_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_c1_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_c2_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_c2_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_c3_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_c3_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_c_skor ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_c_nilai ?? '' }}</td>

                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_d1_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_d1_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_d2_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_d2_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_d3_s ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_d3_n ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_d_skor ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right">
                                        {{ $penilaianopd->ev_d_nilai ?? '' }}</td>

                                    <td class="border border-gray-200 px-4 py-2 align-top text-right font-bold">
                                        {{ $penilaianopd->skor_by_penilai ?? '' }}</td>
                                    <td class="border border-gray-200 px-4 py-2 align-top text-right font-bold">
                                        {{ $penilaianopd->nilai_by_penilai ?? '' }}</td>

                                    <td class="border border-gray-200 px-4 py-2 align-top text-center">
                                        @if ($penilaianopd->status === 'Final' || $penilaianopd->status === 'Pengumuman')
                                            {{-- {{ $penilaianopd->predikat ?? '' }} --}}
                                            @php
                                                $predikat = $penilaianopd->predikat;
                                                $badgeClass = match ($predikat) {
                                                    'AA'
                                                        => 'border border-emerald-500 px-2 py-1 rounded-full text-xs font-semibold bg-emerald-500 text-white',
                                                    'A'
                                                        => 'border border-lime-500 px-2 py-1 rounded-full text-xs font-semibold bg-lime-500 text-white',
                                                    'BB'
                                                        => 'border border-sky-500 px-2 py-1 rounded-full text-xs font-semibold bg-sky-500 text-white',
                                                    'B'
                                                        => 'border border-cyan-500 px-2 py-1 rounded-full text-xs font-semibold bg-cyan-500 text-white',
                                                    'CC'
                                                        => 'border border-amber-500 px-2 py-1 rounded-full text-xs font-semibold bg-amber-500 text-white',
                                                    'C'
                                                        => 'border border-yellow-500 px-2 py-1 rounded-full text-xs font-semibold bg-yellow-500 text-white',
                                                    'D'
                                                        => 'border border-red-500 px-2 py-1 rounded-full text-xs font-semibold bg-red-500 text-white',
                                                    default => '',
                                                };
                                            @endphp
                                            <span class="{{ $badgeClass }}">
                                                {{ $predikat }}
                                            </span><br>
                                            {{-- {{ $penilaianopd->predikat ?? '' }} --}}
                                            <p class="mt-2 font-bold">
                                                @if ($penilaianopd->predikat === 'AA')
                                                    Sangat Memuaskan
                                                @elseif($penilaianopd->predikat === 'A')
                                                    Memuaskan
                                                @elseif($penilaianopd->predikat === 'BB')
                                                    Sangat Baik
                                                @elseif($penilaianopd->predikat === 'B')
                                                    Baik
                                                @elseif($penilaianopd->predikat === 'CC')
                                                    Cukup (Memadai)
                                                @elseif($penilaianopd->predikat === 'C')
                                                    Kurang
                                                @elseif($penilaianopd->predikat === 'D')
                                                    Sangat Kurang
                                                @else
                                                @endif
                                            </p>
                                        @endif
                                    </td>

                                    @if (auth()->user()?->role != 'user')
                                        <td class="border border-gray-200 px-4 py-2 align-top text-center">
                                            @if ($penilaianopd->tgl_submit_opd != null)
                                                {{ \Carbon\Carbon::parse($penilaianopd->tgl_submit_opd)->format('d-m-Y H:i:s') }}
                                            @else
                                            @endif
                                        </td>
                                        <td class="border border-gray-200 px-4 py-2 align-top">
                                            {{ $penilaianopd->penilai->name ?? '' }}</td>
                                    @endif

                                    {{-- <td class="px-4 py-2 relative">
                                    <div x-data="{ open: false }" class="relative inline-block text-left">
                                        <!-- Tombol utama -->
                                        <button @click="open = !open"
                                            class="text-gray-600 hover:text-black focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 24 24" class="w-5 h-5">
                                                <path
                                                    d="M5.625 3.75a2.625 2.625 0 1 0 0 5.25h12.75a2.625 2.625 0 0 0 0-5.25H5.625ZM3.75 11.25a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5H3.75ZM3 15.75a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75ZM3.75 18.75a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5H3.75Z" />
                                            </svg>
                                        </button>

                                        <!-- Dropdown -->
                                        <div x-show="open" @click.away="open = false" x-transition
                                            class="absolute right-0 bottom-full mb-2 min-w-max max-h-60 overflow-auto bg-white rounded shadow z-50">
                                            <div class="py-1 text-sm text-gray-700">
                                                <a @click="open = false"
                                                    wire:click="showEditForm('{{ $encryptedId }}')" href="#"
                                                    class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path
                                                            d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.343Z" />
                                                    </svg>
                                                    Edit
                                                </a>
                                                <a @click="open = false"
                                                    wire:click="showDetail('{{ $encryptedId }}')" href="#"
                                                    class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875ZM12.75 12a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V18a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V12Z"
                                                            clip-rule="evenodd" />
                                                        <path
                                                            d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z" />
                                                    </svg>
                                                    Isi LKE
                                                </a>
                                                <a @click="open = false"
                                                    wire:click="showDetail('{{ $encryptedId }}')" href="#"
                                                    class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path
                                                            d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                                                    </svg>
                                                    Kirim
                                                </a>
                                                <a @click="open = false"
                                                    wire:click="showDetail('{{ $encryptedId }}')" href="#"
                                                    class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Final
                                                </a>
                                                <a @click="open = false"
                                                    wire:click="showDetail('{{ $encryptedId }}')" href="#"
                                                    class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Print
                                                </a>
                                                <a @click="open = false"
                                                    wire:click.prevent="delete('{{ $encryptedId }}')" href="#"
                                                    class="flex items-center gap-2 px-4 py-2 text-red-600 hover:bg-red-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td> --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="76" class="text-center py-4">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $penilaianopds->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
