<div>

    {{-- History Map --}}
    <div class="container max-w-full mx-auto py-2 bg-white text-xs shadow">
        <div class="flex justify-end items-center pr-12">
            <span class="text-gray-600">Setting / <a href="{{ route('users.index') }}" class="text-blue-600 ml-1">Daftar
                    User</a> /</span>
            <a href="#" class="text-blue-600 ml-1">{{ $userId ? 'Edit User' : 'Tambah User' }}</a>
        </div>
    </div>

    {{-- Container --}}
    <div class="container max-w-md mx-auto mt-5 px-8 py-10 bg-white shadow rounded">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            {{ $userId ? 'Edit User' : 'Tambah User' }}
        </h2>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Name <b class="text-red-500">*</b></label>
                <input type="text" wire:model.lazy="name"
                    class="w-full border p-2 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-300">
                @error('name')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email <b class="text-red-500">*</b></label>
                <input type="email" wire:model.lazy="email"
                    class="w-full border p-2 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-300">
                @error('email')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Whatsapp</label>
                <input type="number" wire:model.lazy="nowa"
                    class="w-full border p-2 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-300">
                @error('nowa')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password <b class="text-red-500">*</b>
                    {{ $userId ? '(optional)' : '' }}</label>
                <input type="password" wire:model.lazy="password"
                    class="w-full border p-2 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-300">
                @error('password')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Opd <b class="text-red-500">*</b></label>
                <select wire:model.lazy="opd_id"
                    class="w-full border p-2 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option value="">- Pilih -</option>
                    @foreach ($listOpd as $row)
                        <option value="{{ $row->id }}">{{ $row->nama_singkat_opd }}</option>
                    @endforeach
                </select>
                @error('opd_id')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Role <b class="text-red-500">*</b></label>
                <select wire:model.lazy="role"
                    class="w-full border p-2 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option value="superadmin">Superadmin</option>
                    <option value="penilai">Penilai</option>
                    <option value="user">User</option>
                    <option value="viewer">Viewer</option>
                </select>
                @error('role')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Status <b class="text-red-500">*</b></label>
                <select wire:model.lazy="active"
                    class="w-full border p-2 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option value="">- Pilih -</option>
                    <option value="1">Active</option>
                    <option value="0">Off</option>
                </select>
                @error('active')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex space-x-2 pt-2">
                <a href="{{ route('users.index') }}"
                    class="inline-flex items-center bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
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

        <div x-data
            x-on:show-toast.window="Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: $event.detail.message, showConfirmButton: false, timer: 3000 })">
        </div>

        @push('js')
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @endpush
    </div>

</div>
