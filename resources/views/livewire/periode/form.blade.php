<div>

    {{-- History Map --}}
    <div class="container max-w-full mx-auto py-2 bg-white text-xs shadow">
        <div class="flex justify-end items-center pr-12">
            <span class="text-gray-600">Setting / <a href="{{ route('periode.index') }}" class="text-blue-600 ml-1">Periode
                    Penilaian</a> /</span>
            <a href="#" class="text-blue-600 ml-1">{{ $periodeId ? 'Edit Periode' : 'Tambah Periode' }}</a>
        </div>
    </div>

    {{-- Container --}}
    <div class="container max-w-md mx-auto mt-5 px-8 py-10 bg-white shadow rounded">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">
            {{ $periodeId ? 'Edit Periode' : 'Tambah Periode' }}
        </h2>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Tahun <b class="text-red-500">*</b></label>
                <input type="text" wire:model.lazy="tahun"
                    class="w-full border p-2 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-300">
                @error('tahun')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Keterangan <b class="text-red-500">*</b></label>
                <textarea type="text" wire:model.lazy="keterangan"
                    class="w-full border p-2 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-300" rows="4">
                </textarea>
                @error('keterangan')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tgl. Mulai <b class="text-red-500">*</b></label>
                <input type="date" wire:model.lazy="tgl_start"
                    class="w-full border p-2 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-300">
                @error('tgl_start')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tgl. Sampai <b class="text-red-500">*</b></label>
                <input type="date" wire:model.lazy="tgl_end"
                    class="w-full border p-2 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-300">
                @error('tgl_end')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex space-x-2 pt-4">
                <a href="{{ route('periode.index') }}"
                    class="inline-flex items-center bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Batal
                </a>
                <button wire:click="save" wire:loading.attr="disabled"
                    class="inline-flex items-center bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    <svg wire:loading wire:target="save" class="w-4 h-4 mr-2 animate-spin text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="save">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </span>
                    Simpan
                </button>
            </div>
        </div>
    </div>

    <div x-data
        x-on:show-toast.window="Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: $event.detail.message, showConfirmButton: false, timer: 3000 })">
    </div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush

</div>
