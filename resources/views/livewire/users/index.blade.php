<div>
    @php use Illuminate\Support\Facades\Crypt; @endphp

    {{-- History Map --}}
    <div class="container max-w-full mx-auto py-2 bg-white text-xs">
        <div class="flex justify-end items-center pr-12">
            <span class="text-gray-600">Setting /</span>
            <a href="{{ route('users.index') }}" class="text-blue-600 ml-1">{{ $titleHistoryUrl }}</a>
        </div>
    </div>

    {{-- Container --}}
    <div class="container max-w-full mx-auto mt-0 px-6 py-0 bg-white">
        <div class="max-w-full mx-auto mt-0 px-0 py-5 bg-white shadow rounded">
            <div class="p-6" style="margin-top:-30px;">
                <h2 class="text-xl font-semibold mb-4">Daftar User</h2>
                <div class="flex justify-between mb-4">
                    <input type="text" wire:model.live.debounce.500ms="search" class="border rounded px-3 py-2 w-1/3"
                        placeholder="Search...">
                    <a href="{{ route('users.create') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah</a>
                </div>
                {{-- @if (session()->has('message'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                    class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded shadow">
                    {{ session('message') }}
                </div>
            @endif --}}
                <div x-data x-init="@if (session()->has('message')) Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('message') }}',
                showConfirmButton: false,
                timer: 3000
            }); @endif">
                </div>

                <div class="w-full overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead class="bg-gray-100 text-left text-sm font-semibold">
                            <tr class="border-t">
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Whatsapp</th>
                                <th class="px-4 py-2">Opd</th>
                                <th class="px-4 py-2">Role</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse ($users as $user)
                                <tr class="border-t">
                                    <td class="px-4 py-2">
                                        {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                                    </td>
                                    <td class="px-4 py-2">{{ $user->name }}</td>
                                    <td class="px-4 py-2">{{ $user->email }}</td>
                                    <td class="px-4 py-2">{{ $user->nowa }}</td>
                                    <td class="px-4 py-2">{{ $user->opd->nama_singkat_opd ?? '' }}</td>
                                    <td class="px-4 py-2 capitalize">{{ $user->role }}</td>
                                    <td class="px-4 py-2">
                                        @php
                                            $status = $user->active;
                                            $badgeClass = match ($status) {
                                                '1' => 'bg-green-500 text-white border border-green-500',
                                                '0' => 'bg-red-500 text-white border border-red-500',
                                                default => 'bg-gray-400 text-white border border-gray-400',
                                            };
                                        @endphp
                                        <span
                                            class="border border-gray-200 px-2 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                            @if ( $status === '1')
                                                Active
                                            @else
                                                Off
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 space-x-2 flex items-center">
                                        <a href="{{ route('users.edit', Crypt::encrypt($user->id)) }}"
                                            class="text-blue-600 hover:text-blue-800" title="Edit" wire:navigate>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path
                                                    d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.343Z" />
                                            </svg>
                                        </a>
                                        {{-- <a href="{{ route('users.resetpassword', $user->id) }}"
                                    class="text-green-600 hover:text-green-800" title="Reset Password">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M8 7a5 5 0 1 1 3.61 4.804l-1.903 1.903A1 1 0 0 1 9 14H8v1a1 1 0 0 1-1 1H6v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-2a1 1 0 0 1 .293-.707L8.196 8.39A5.002 5.002 0 0 1 8 7Zm5-3a.75.75 0 0 0 0 1.5A1.5 1.5 0 0 1 14.5 7 .75.75 0 0 0 16 7a3 3 0 0 0-3-3Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a> --}}
                                        <button
                                            onclick="Livewire.dispatch('show-reset-modal', {id: '{{ Crypt::encrypt($user->id) }}'})"
                                            class="text-green-600 hover:text-green-800" title="Reset Password">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M8 7a5 5 0 1 1 3.61 4.804l-1.903 1.903A1 1 0 0 1 9 14H8v1a1 1 0 0 1-1 1H6v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-2a1 1 0 0 1 .293-.707L8.196 8.39A5.002 5.002 0 0 1 8 7Zm5-3a.75.75 0 0 0 0 1.5A1.5 1.5 0 0 1 14.5 7 .75.75 0 0 0 16 7a3 3 0 0 0-3-3Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <button wire:click="confirmDelete('{{ Crypt::encrypt($user->id) }}')"
                                            class="text-red-600 hover:text-red-800" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-3 text-center text-gray-500">Data Users tidak
                                        ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>

            </div>

            <div x-data
                x-on:show-toast.window="Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: $event.detail.message, showConfirmButton: false, timer: 3000 })">
            </div>

            <div x-data
                x-on:confirm-delete.window="Swal.fire({
                title: 'Hapus user?',
                text: 'Tindakan ini tidak bisa dibatalkan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('deleteConfirmed', { id: $event.detail.id });
                }
            })">
            </div>

            @push('js')
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            @endpush
        </div>
    </div>

    {{-- Modal Reset Password --}}
    @if ($showResetModal)
        <div x-data class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                <h2 class="text-lg font-semibold mb-4">Reset Password</h2>

                <div class="mb-4">
                    <label>Password Baru <b class="text-red-500">*</b></label>
                    <input type="password" wire:model.defer="resetPassword" class="w-full border rounded p-2 mt-1">
                    @error('resetPassword')
                        <div class="text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label>Konfirmasi Password <b class="text-red-500">*</b></label>
                    <input type="password" wire:model.defer="resetPasswordConfirmation"
                        class="w-full border rounded p-2 mt-1">
                    @error('resetPasswordConfirmation')
                        <div class="text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex justify-end space-x-2">
                    <button wire:click="$set('showResetModal', false)"
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</button>
                    <button wire:click="submitResetPassword"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Reset</button>
                </div>
            </div>
        </div>
    @endif

</div>
