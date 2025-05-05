<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="dashboardApp">

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
            <a class="link active" id="home-link" @click="navigateToSection($event.target)">
                <img draggable="false" src="{{ asset('images/welcome/TRIVIUM_recortado.png') }}" alt="">
            </a>
            <input type="text" placeholder="Busca en nuestra plataforma aquí" class="search" id="main-search"/>
            
            <div class="user" @click="triggerProfileLink($event.target)" x-on:click.outside="closeProfileLink()">
                <img draggable="false" src="{{ asset('images/welcome/TRIVIUM-1.jpeg') }}" alt="" class="avatar">
                <i class="fa-solid fa-chevron-down" :class="openProfileLink?'open':''"></i>
                <div class="profile" :class="openProfileLink?'open':''">
                    <div class="profile-info">
                        <span class="name">{{ Auth::user()->name }}</span>
    
                    </div>
                    <div class="profile-options">
                        <form action="{{ route('logout') }}" method="POST" class="logout-form" id="logout-form">
                            @csrf
                            <button type="submit" class="logout">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <section class="sidebar">
            @yield('sidebar')
        </section>
        <section class="content">
            @yield('content')
        </section>
    </aside>
    <img class="background" src="{{ asset('images/welcome/3cervezastrivium.jpg') }}" alt="Tres cervezas Trivium">
</body>

</html>
