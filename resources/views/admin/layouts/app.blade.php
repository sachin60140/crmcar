<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title> @yield('title')</title>

    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ url('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ url('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ url('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ url('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ url('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ url('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ url('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ url('assets/css/style.css') }}" rel="stylesheet">
    @yield('style')

</head>

<body>
    @include('admin.layouts._header')
    @include('admin.layouts._sidebar')

    <main id="main" class="main">
        @yield('content')
    </main>

    @include('admin.layouts._footer')

    <!-- Vendor JS Files -->
    <script src="{{ url('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ url('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ url('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ url('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ url('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ url('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ url('assets/js/main.js') }}"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const displayElement = document.getElementById('session-timer-display');

        // 1. Get session lifetime from Laravel and calculate absolute expiration time
        // Note: We use Date.now() to ensure accuracy even if the tab sleeps
        const lifetimeSeconds = {{ config('session.lifetime') * 60 }};
        const expiresAt = Date.now() + (lifetimeSeconds * 1000);

        function updateTimer() {
            const now = Date.now();
            const secondsRemaining = Math.max(0, Math.floor((expiresAt - now) / 1000));

            // 2. Format Minutes and Seconds
            const minutes = Math.floor(secondsRemaining / 60);
            const seconds = secondsRemaining % 60;
            const formattedTime = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

            // 3. Update the display text
            if (displayElement) {
                displayElement.innerText = `Session expires in: ${formattedTime}`;

                // Optional: Turn text red when less than 1 minute remains
                if (secondsRemaining < 60) {
                    displayElement.style.color = 'red';
                }
            }

            // 4. Handle Expiration
            if (secondsRemaining <= 0) {
                // Stop the timer logic
                if (timerInterval) clearInterval(timerInterval);

                if (displayElement) displayElement.innerText = "Session Expired. Redirecting...";

                // Redirect to logout
                window.location.href = "{{ route('logout') }}";
            }
        }

        // Run the timer update every second
        let timerInterval = setInterval(updateTimer, 1000);

        // 5. Intelligent Sync: Force an update immediately if user switches tabs back
        document.addEventListener("visibilitychange", function() {
            if (document.visibilityState === 'visible') {
                updateTimer();
            }
        });

        // Run once immediately to avoid 1-second delay on load
        updateTimer();
    });
</script>
    @yield('script')

</body>

</html>
