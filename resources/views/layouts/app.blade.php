<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MENTOR @yield('title')</title>
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    {{-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="/css/app.css">
</head>

<body>
    <!-- ----------------- MAIN-HTML-START ----------------- -->
    <main>
        @yield('content')
    </main>
    <!-- ----------------- MAIN-HTML-END ----------------- -->

    <!-- ----------------- FOOTER-HTML-START ----------------- -->
    <footer>
        <div class="container">
            <div class="footer-container d_flex j_cnt__between a_items__center">
                <div class="copyriting">
                    <span>Copyright © 2022 All Rights Reserved.</span>
                </div>
            </div>
        </div>

    </footer>
    <!-- ----------------- FOOTER-HTML-END ----------------- -->

</body>

</html>
