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

            <!-- Botón del carrito en el header -->
            <div class="cart-container" @click.outside="closeCart">
                <button @click="openCart" class="cart-button">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span x-text="cart.length" class="cart-counter"></span>
                </button>

                <!-- Dropdown del carrito -->
                <div x-show="showCartModal" 
                     class="cart-dropdown"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95">
                    <div class="cart-header">
                        <h3>Carrito de compras</h3>
                        <button @click="closeCart" class="close-button">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="cart-body">
                        <template x-if="cart.length === 0">
                            <p class="empty-cart">El carrito está vacío</p>
                        </template>
                        <ul class="cart-items">
                            <template x-for="item in cart" :key="item.id">
                                <li class="cart-item">
                                    <span x-text="item.name ?? item.nombre"></span>
                                    <div class="item-controls">
                                        <span x-text="item.quantity"></span>
                                        <button @click="removeFromCart(item.id)" class="remove-item">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </li>
                            </template>
                        </ul>
                    </div>
                    <div class="cart-footer" x-show="cart.length > 0">
                        <button class="checkout-button">
                            Proceder al pago
                        </button>
                    </div>
                </div>
            </div>

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
        <section class="notification" :class="notification.visible?'visible':''">
            <div class="notification-container">
                <i class="fa-solid fa-bell"></i>
                <span class="notification-text">677576</span>
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
