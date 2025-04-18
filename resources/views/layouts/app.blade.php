<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="mainApp" x-init="init()">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trivium | Cervecería Artesanal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <aside class="dashboard">
        <section class="header">
            <a href="#">
                <img src="{{ asset('images/welcome/TRIVIUM_recortado.png') }}" alt="">
            </a>
            <input type="text" placeholder="Busca en nuestra plataforma aquí" class="search" id="main-search"/>
            <div class="user">
                <img src="{{ asset('images/welcome/TRIVIUM-1.jpeg') }}" alt="" class="avatar">
                <i class="fa-solid fa-chevron-down"></i>
            </div>
        </section>
        <section class="sidebar">
            @yield('sidebar')
        </section>
    </aside>
    <img class="background" src="{{ asset('images/welcome/3cervezastrivium.jpg') }}" alt="Tres cervezas Trivium">
</body>

</html>
