<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.header')
    {{-- @vite(['resources/js/app.js']) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <livewire:styles />
</head>

<body class="min-h-screen flex flex-col">

    <!-- Main navbar -->
    @include('layouts.navbar')
    <!-- /main navbar -->

    <!-- Page content -->
    <main class="flex-1">
        <div class="page-content">

            <!-- Main sidebar -->
            {{-- @include('layouts.sidebar') --}}
            <!-- /main sidebar -->

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Content area -->
                <div class="content">
                    {{ $slot ?? '' }}
                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
    </main>
    <!-- /page content -->

    <!-- Footer -->
    @include('layouts.footer')
    <!-- /footer -->

    <!-- Custom Logout Otomatis -->
    {{-- @ livewire('auto-logout') --}}
    <!-- /Custom Logout Otomatis -->

    <livewire:scripts />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    @stack('js')
</body>

</html>
