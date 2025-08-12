<div>

    {{-- History Url --}}
    <div class="container max-w-full mx-auto py-2 bg-white text-xs">
        <div class="flex justify-end items-center pr-12">
            <span class="text-gray-600">Setting / </span>
            <a href="{{ route('appsetup.index') }}" class="text-blue-600 ml-1">{{ $titleHistoryUrl }}</a>
        </div>
    </div>

    {{-- Form Setup Aplikasi --}}
    @if ($isView)
        <div class="container max-w-full mx-auto mt-0 px-6 py-0 bg-white">
            <div class="max-w-full mx-auto mt-0 px-0 py-5 bg-white shadow rounded">
                <div class="p-6 flex justify-between items-center" style="margin-top:-30px;">
                    <h2 class="text-xl font-semibold">Apps Setup</h2>
                    <div class="flex items-center space-x-2">
                        <a href="#" wire:click.prevent="edit('{{ Crypt::encrypt($data->id) }}')"
                            class="btn text-blue-600 hover:text-blue-800" title="Edit Data">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </a>
                    </div>
                </div>
                <hr>
                <div class="p-6">
                    <form wire:submit.prevent="submitForm">
                        <fieldset class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8">
                                <div>
                                    {{-- Pemkab --}}
                                    <div class="flex items-center mb-4">
                                        <label class="block w-1/4 text-sm font-medium text-gray-700">Pemkab
                                            <span class="text-red-500">*</span></label>
                                        <div class="flex-1">
                                            @if ($data->kabupaten)
                                                <p class="form-input rounded">{{ $data->kabupaten }}</p>
                                            @else
                                                <p class="form-input rounded">-</p>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- Unit --}}
                                    <div class="flex items-center mb-4">
                                        <label class="block w-1/4 text-sm font-medium text-gray-700">Unit <span
                                                class="text-red-500">*</span></label>
                                        <div class="flex-1">
                                            @if ($data->unit)
                                                <p class="form-input rounded">{{ $data->unit }}</p>
                                            @else
                                                <p class="form-input rounded">-</p>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- Pimpinan --}}
                                    <div class="flex items-center mb-4">
                                        <label class="block w-1/4 text-sm font-medium text-gray-700">Pimpinan
                                            <span class="text-red-500">*</span></label>
                                        <div class="flex-1">
                                            @if ($data->pimpinan)
                                                <p class="form-input rounded">{{ $data->pimpinan }}</p>
                                            @else
                                                <p class="form-input rounded">-</p>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- NIP --}}
                                    <div class="flex items-center mb-4">
                                        <label class="block w-1/4 text-sm font-medium text-gray-700">NIP <span
                                                class="text-red-500">*</span></label>
                                        <div class="flex-1">
                                            @if ($data->nip)
                                                <p class="form-input rounded">{{ $data->nip }}</p>
                                            @else
                                                <p class="form-input rounded">-</p>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- Alamat --}}
                                    <div class="flex items-center mb-4">
                                        <label class="block w-1/4 text-sm font-medium text-gray-700">Alamat
                                            <span class="text-red-500">*</span></label>
                                        <div class="flex-1">
                                            @if ($data->alamat)
                                                <p class="form-input rounded">{{ $data->alamat }}</p>
                                            @else
                                                <p class="form-input rounded">-</p>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- Maps --}}
                                    <div class="flex items-center mb-4">
                                        <label class="block w-1/4 text-sm font-medium text-gray-700">Maps <span
                                                class="text-red-500">*</span></label>
                                        <div class="flex-1">
                                            @if ($data->map)
                                                <p class="form-input rounded"><a href="{{ $data->map }}"
                                                        target="_blank" title="Open URL">{{ $data->map }}</a></p>
                                            @else
                                                <p class="form-input rounded">-</p>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- Telp --}}
                                    <div class="flex items-center mb-4">
                                        <label class="block w-1/4 text-sm font-medium text-gray-700">Telp. <span
                                                class="text-red-500">*</span></label>
                                        <div class="flex-1">
                                            @if ($data->telp)
                                                <p class="form-input rounded">{{ $data->telp }}</p>
                                            @else
                                                <p class="form-input rounded">-</p>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- Fax --}}
                                    <div class="flex items-center mb-4">
                                        <label class="block w-1/4 text-sm font-medium text-gray-700">Fax.
                                        </label>
                                        <div class="flex-1">
                                            @if ($data->fax)
                                                <p class="form-input rounded">{{ $data->fax }}</p>
                                            @else
                                                <p class="form-input rounded">-</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    {{-- Whatsapp --}}
                                    <div class="flex items-center mb-4">
                                        <label class="block w-1/4 text-sm font-medium text-gray-700">Whatsapp
                                        </label>
                                        <div class="flex-1">
                                            @if ($data->whatsapp)
                                                <p class="form-input rounded">{{ $data->whatsapp }}</p>
                                            @else
                                                <p class="form-input rounded">-</p>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- Email --}}
                                    <div class="flex items-center mb-4">
                                        <label class="block w-1/4 text-sm font-medium text-gray-700">Email <span
                                                class="text-red-500">*</span></label>
                                        <div class="flex-1">
                                            @if ($data->email)
                                                <p class="form-input rounded">{{ $data->email }}</p>
                                            @else
                                                <p class="form-input rounded">-</p>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- Kode Pos --}}
                                    <div class="flex items-center mb-4">
                                        <label class="block w-1/4 text-sm font-medium text-gray-700">Kode Pos
                                            <span class="text-red-500">*</span></label>
                                        <div class="flex-1">
                                            @if ($data->kodepos)
                                                <p class="form-input rounded">{{ $data->kodepos }}</p>
                                            @else
                                                <p class="form-input rounded">-</p>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- Website --}}
                                    <div class="flex items-center mb-4">
                                        <label class="block w-1/4 text-sm font-medium text-gray-700">Website
                                        </label>
                                        <div class="flex-1">
                                            @if ($data->website)
                                                <p class="form-input rounded"><a href="{{ $data->website }}"
                                                        target="_blank" title="Open URL">{{ $data->website }}</a></p>
                                            @else
                                                <p class="form-input rounded">-</p>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- X --}}
                                    <div class="flex items-center mb-4">
                                        <label class="block w-1/4 text-sm font-medium text-gray-700">X </label>
                                        <div class="flex-1">
                                            @if ($data->twitter_x)
                                                <p class="form-input rounded"><a href="{{ $data->twitter_x }}"
                                                        target="_blank" title="Open URL">{{ $data->twitter_x }}</a></p>
                                            @else
                                                <p class="form-input rounded">-</p>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- Instagram --}}
                                    <div class="flex items-center mb-4">
                                        <label class="block w-1/4 text-sm font-medium text-gray-700">Instagram
                                        </label>
                                        <div class="flex-1">
                                            @if ($data->instagram)
                                                <p class="form-input rounded"><a href="{{ $data->instagram }}"
                                                        target="_blank" title="Open URL">{{ $data->instagram }}</a></p>
                                            @else
                                                <p class="form-input rounded">-</p>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- Facebook --}}
                                    <div class="flex items-center mb-4">
                                        <label class="block w-1/4 text-sm font-medium text-gray-700">Facebook
                                        </label>
                                        <div class="flex-1">
                                            @if ($data->facebook)
                                                <p class="form-input rounded"><a href="{{ $data->facebook }}"
                                                        target="_blank" title="Open URL">{{ $data->facebook }}</a></p>
                                            @else
                                                <p class="form-input rounded">-</p>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- Youtube --}}
                                    <div class="flex items-center mb-4">
                                        <label class="block w-1/4 text-sm font-medium text-gray-700">Youtube
                                        </label>
                                        <div class="flex-1">
                                            @if ($data->youtube)
                                                <p class="form-input rounded"><a href="{{ $data->youtube }}"
                                                        target="_blank" title="Open URL">{{ $data->youtube }}</a></p>
                                            @else
                                                <p class="form-input rounded">-</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Tampilan untuk mengedit data (isOpen) --}}
    @if ($isOpen)
        <div class="container max-w-full mx-auto mt-0 px-6 py-0 bg-white">
            <div class="max-w-full mx-auto mt-0 px-0 py-5 bg-white shadow rounded">
                <div class="p-6 flex justify-between items-center" style="margin-top:-30px;">
                    <h2 class="text-xl font-semibold">Edit Apps Setup</h2>
                    <div class="flex items-center">
                        <a href="#" wire:click.prevent="closeForm" title="Cancel"
                            class="text-gray-400 hover:text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    </div>
                </div>
                <hr>
                <div class="p-6">
                    <form wire:submit.prevent="submitForm">
                        @csrf
                        <fieldset class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8">
                                <div>
                                    {{-- Pemkab --}}
                                    <div class="flex flex-col md:flex-row items-start md:items-center mb-4">
                                        <label
                                            class="block md:w-1/4 text-sm font-medium text-gray-700 mb-1 md:mb-0">Pemkab
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex-1 w-full">
                                            <input type="text" wire:model='form.kabupaten' name="kabupaten"
                                                class="form-input rounded w-full" placeholder="Enter Nama Pemkab"
                                                autocomplete="off">
                                            @error('form.kabupaten')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Unit --}}
                                    <div class="flex flex-col md:flex-row items-start md:items-center mb-4">
                                        <label
                                            class="block md:w-1/4 text-sm font-medium text-gray-700 mb-1 md:mb-0">Unit
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex-1 w-full">
                                            <input type="text" wire:model='form.unit' name="unit"
                                                class="form-input rounded w-full" placeholder="Enter Nama Unit"
                                                autocomplete="off">
                                            @error('form.unit')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Pimpinan --}}
                                    <div class="flex flex-col md:flex-row items-start md:items-center mb-4">
                                        <label
                                            class="block md:w-1/4 text-sm font-medium text-gray-700 mb-1 md:mb-0">Pimpinan
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex-1 w-full">
                                            <input type="text" wire:model='form.pimpinan' name="pimpinan"
                                                class="form-input rounded w-full" placeholder="Enter Nama Pimpinan"
                                                autocomplete="off">
                                            @error('form.pimpinan')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- NIP --}}
                                    <div class="flex flex-col md:flex-row items-start md:items-center mb-4">
                                        <label
                                            class="block md:w-1/4 text-sm font-medium text-gray-700 mb-1 md:mb-0">NIP
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex-1 w-full">
                                            <input type="number" wire:model='form.nip' name="nip"
                                                class="form-input rounded w-full" placeholder="Please Enter NIP"
                                                autocomplete="off">
                                            @error('form.nip')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Alamat --}}
                                    <div class="flex flex-col md:flex-row items-start md:items-center mb-4">
                                        <label
                                            class="block md:w-1/4 text-sm font-medium text-gray-700 mb-1 md:mb-0">Alamat
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex-1 w-full">
                                            {{-- <textarea wire:model='form.alamat' name="alamat" class="form-input rounded w-full" placeholder="Please Enter Alamat"
                                                rows="1"></textarea> --}}
                                            <input type="text" wire:model='form.alamat' name="alamat"
                                                class="form-input rounded w-full" placeholder="Please Enter Alamat">
                                            @error('form.alamat')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Maps --}}
                                    <div class="flex flex-col md:flex-row items-start md:items-center mb-4">
                                        <label
                                            class="block md:w-1/4 text-sm font-medium text-gray-700 mb-1 md:mb-0">Maps
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex-1 w-full">
                                            <input type="text" wire:model='form.map' name="map"
                                                class="form-input rounded w-full"
                                                placeholder="Please Enter Koordinat Google Maps">
                                            @error('form.map')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Telp --}}
                                    <div class="flex flex-col md:flex-row items-start md:items-center mb-4">
                                        <label
                                            class="block md:w-1/4 text-sm font-medium text-gray-700 mb-1 md:mb-0">Telp.
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex-1 w-full">
                                            <input type="number" wire:model='form.telp' name="telp"
                                                class="form-input rounded w-full"
                                                placeholder="Please Enter Nomor Telepon" autocomplete="off">
                                            @error('form.telp')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Fax --}}
                                    <div class="flex flex-col md:flex-row items-start md:items-center mb-4">
                                        <label
                                            class="block md:w-1/4 text-sm font-medium text-gray-700 mb-1 md:mb-0">Fax.
                                        </label>
                                        <div class="flex-1 w-full">
                                            <input type="number" wire:model='form.fax' name="fax"
                                                class="form-input rounded w-full" placeholder="Please Enter Nomor Fax"
                                                autocomplete="off">
                                            @error('form.fax')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    {{-- Whatsapp --}}
                                    <div class="flex flex-col md:flex-row items-start md:items-center mb-4">
                                        <label
                                            class="block md:w-1/4 text-sm font-medium text-gray-700 mb-1 md:mb-0">Whatsapp
                                        </label>
                                        <div class="flex-1 w-full">
                                            <input type="number" wire:model='form.whatsapp' name="whatsapp"
                                                class="form-input rounded w-full"
                                                placeholder="Please Enter Nomor Whatsapp" autocomplete="off">
                                            @error('form.whatsapp')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Email --}}
                                    <div class="flex flex-col md:flex-row items-start md:items-center mb-4">
                                        <label
                                            class="block md:w-1/4 text-sm font-medium text-gray-700 mb-1 md:mb-0">Email
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex-1 w-full">
                                            <input type="text" wire:model='form.email' name="email"
                                                class="form-input rounded w-full" placeholder="Please Enter Email"
                                                autocomplete="off">
                                            @error('form.email')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Kode Pos --}}
                                    <div class="flex flex-col md:flex-row items-start md:items-center mb-4">
                                        <label
                                            class="block md:w-1/4 text-sm font-medium text-gray-700 mb-1 md:mb-0">Kode
                                            Pos <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex-1 w-full">
                                            <input type="number" wire:model='form.kodepos' name="kodepos"
                                                class="form-input rounded w-full" placeholder="Please Enter Kode Pos"
                                                autocomplete="off">
                                            @error('form.kodepos')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Website --}}
                                    <div class="flex flex-col md:flex-row items-start md:items-center mb-4">
                                        <label
                                            class="block md:w-1/4 text-sm font-medium text-gray-700 mb-1 md:mb-0">Website
                                        </label>
                                        <div class="flex-1 w-full">
                                            <input type="text" wire:model='form.website' name="website"
                                                class="form-input rounded w-full"
                                                placeholder="Please Enter Alamat Website" autocomplete="off">
                                            @error('form.website')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- X --}}
                                    <div class="flex flex-col md:flex-row items-start md:items-center mb-4">
                                        <label class="block md:w-1/4 text-sm font-medium text-gray-700 mb-1 md:mb-0">X
                                        </label>
                                        <div class="flex-1 w-full">
                                            <input type="text" wire:model='form.twitter_x' name="twitter_x"
                                                class="form-input rounded w-full"
                                                placeholder="Please Enter Alamat X (Twitter)" autocomplete="off">
                                            @error('form.twitter_x')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Instagram --}}
                                    <div class="flex flex-col md:flex-row items-start md:items-center mb-4">
                                        <label
                                            class="block md:w-1/4 text-sm font-medium text-gray-700 mb-1 md:mb-0">Instagram
                                        </label>
                                        <div class="flex-1 w-full">
                                            <input type="text" wire:model='form.instagram' name="instagram"
                                                class="form-input rounded w-full" placeholder="Please Enter Instagram"
                                                autocomplete="off">
                                            @error('form.instagram')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Facebook --}}
                                    <div class="flex flex-col md:flex-row items-start md:items-center mb-4">
                                        <label
                                            class="block md:w-1/4 text-sm font-medium text-gray-700 mb-1 md:mb-0">Facebook
                                        </label>
                                        <div class="flex-1 w-full">
                                            <input type="text" wire:model='form.facebook' name="facebook"
                                                class="form-input rounded w-full" placeholder="Please Enter Facebook"
                                                autocomplete="off">
                                            @error('form.facebook')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Youtube --}}
                                    <div class="flex flex-col md:flex-row items-start md:items-center mb-4">
                                        <label
                                            class="block md:w-1/4 text-sm font-medium text-gray-700 mb-1 md:mb-0">Youtube
                                        </label>
                                        <div class="flex-1 w-full">
                                            <input type="text" wire:model='form.youtube' name="youtube"
                                                class="form-input rounded w-full"
                                                placeholder="Please Enter Youtube Link" autocomplete="off">
                                            @error('form.youtube')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="flex justify-end items-center mt-6">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Sweetalert2 script --}}
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('swal:modal', (event) => {
                const data = event[0];
                Swal.fire({
                    icon: data.type,
                    title: data.title,
                    text: data.text,
                });
            });
        });
    </script>

</div>
