<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('partials.styles')
    @stack('style')

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>{{ $title }} | Redesmanagement</title>

    {{-- My Css --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <x-toast-container />

    @yield('base')
    @include('partials.scripts')
    @stack('script')

</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script >
    // employee precense
    var ctxEmployee = document.getElementById('staffPresence').getContext('2d');
    
    var myChart = new Chart(ctxEmployee, {
        type: 'doughnut',
        data: {
            labels: ['Hadir', 'Tidak Hadir'],
            datasets: [{
                label: 'Presensi',
                data: [{{ $staffPresentCount }}, {{ $staffOnly - $staffPresentCount }}],
                backgroundColor: [
                    // blue and red color
                    'rgba(0, 149, 255, 0.58)',
                    'rgba(255, 129, 133, 0.58)'
                ],
                borderColor: [
                    'rgba(0, 149, 255, 0.58)',
                    'rgba(255, 129, 133, 0.58)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom',
                },
                title: {
                    display: true,
                    text: 'Presensi Karyawan Tetap'
                }
            }
        }
    });

    // internship precense
    var ctxInternship = document.getElementById('internshipPresence').getContext('2d');
    var myChart1 = new Chart(ctxInternship, {
        type: 'doughnut',
        data: {
            labels: ['Hadir', 'Tidak Hadir'],
            datasets: [{
                label: 'Presensi',
                data: [{{ $internshipPresentCount }}, {{ $internshipOnly - $internshipPresentCount }}],
                backgroundColor: [
                    'rgba(0, 149, 255, 0.58)',
                    'rgba(255, 129, 133, 0.58)'
,
                ],
                borderColor: [
                    'rgba(0, 149, 255, 0.58)',
                    'rgba(255, 129, 133, 0.58)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom',
                },
                title: {
                    display: true,
                    text: 'Presensi Internship'
                }
            }
        }
    });

    // part time precense
    var ctxPartTime = document.getElementById('partTimePresence').getContext('2d');
    var myChart2 = new Chart(ctxPartTime, {
        type: 'doughnut',
        data: {
            labels: ['Hadir', 'Tidak Hadir'],
            datasets: [{
                label: 'Presensi',
                data: [{{ $partTimePresentCount }}, {{ $partTimeOnly - $partTimePresentCount }}],
                backgroundColor: [
                    'rgba(0, 149, 255, 0.58)',
                    'rgba(255, 129, 133, 0.58)'
,
                ],
                borderColor: [
                    'rgba(0, 149, 255, 0.58)',
                    'rgba(255, 129, 133, 0.58)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom',
                },
                title: {
                    display: true,
                    text: 'Presensi Karyawan Part Time'
                }
            }
        }
    });
</script>
</html>