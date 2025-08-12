<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-5 text-center">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <b>{{ __('=== DASHBOARD PENAKs`E ===') }}</b>
                </div>
            </div>
        </div>
    </div>

    {{-- Card Section --}}
    <div class="py-0">
        <div class="flex flex-wrap justify-center gap-6 px-4">
            <div class="w-full md:w-1/4 lg:w-1/4">
                <div class="bg-blue-100 border border-blue-400 text-blue-800 rounded-lg p-6 shadow">
                    <p class="text-3xl font-semibold">3</p>
                    {{-- <p class="text-3xl font-semibold">{{ $jumlahPenilaian }}</p> --}}
                    <h3 class="text-lg font-bold mb-2">Periode Penilaian</h3>
                </div>
            </div>
            <div class="w-full md:w-1/4 lg:w-1/4">
                <div class="bg-orange-100 border border-orange-400 text-orange-800 rounded-lg p-6 shadow">
                    <p class="text-3xl font-semibold">38</p>
                    {{-- <p class="text-3xl font-semibold">{{ $jumlahPenilaian }}</p> --}}
                    <h3 class="text-lg font-bold mb-2">Total Opd Dinilai</h3>
                </div>
            </div>
            <div class="w-full md:w-1/4 lg:w-1/4">
                <div class="bg-green-100 border border-green-400 text-green-800 rounded-lg p-6 shadow">
                    <p class="text-3xl font-semibold">45</p>
                    {{-- <p class="text-3xl font-semibold">{{ $jumlahUser }}</p> --}}
                    <h3 class="text-lg font-bold mb-2">Total Users</h3>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
