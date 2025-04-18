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
    <aside class="content" @scroll="handleScroll($event.target, document.querySelector('.background'))">
        <section class="bottom">
            <figure>
                <img id="home-link" class="link active" src="{{ asset('images/welcome/TRIVIUM_recortado.png') }}"
                    alt="Logo de Trivium" @click="navigateToSection($event.target)" />
            </figure>
            <article class="relevant">
                <nav>
                    <div>
                        <a data-title="Iniciar Sesión" data-link="login" id="login-link" class="link"
                            @click.prevent="navigateToSection($event.target)">Iniciar Sesión</a>
                        <a data-title="Productos" data-link="products" id="products-link" class="link"
                            @click.prevent="navigateToSection($event.target)">Ver Productos</a>
                    </div>
                    <div>
                        <a data-title="Acerca De" data-link="about" id="about-link" class="link"
                            @click.prevent="navigateToSection($event.target)">Acerca De</a>
                        <a id="register-link" data-title="Registrarse" data-link="register" class="link"
                            @click.prevent="navigateToSection($event.target)">Registrarse</a>
                    </div>
                </nav>

                <section id="login" class="relevant-content">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <label for="login">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" name="login" placeholder="Nombre de usuario o Correo">
                        </label>
                        <label for="password">
                            <i class="fa-solid fa-key"></i>
                            <input type="password" name="password" placeholder="Contraseña">
                        </label>
                        <button type="submit" class="fa-solid fa-door-open"></button>
                    </form>
                    <figure>
                        <img src="{{ asset('images/welcome/TRIVIUM-Texto-Sin Fondo.png') }}" alt>
                    </figure>
                </section>

                <section id="products" class="relevant-content" x-data="productos">
                    <template x-if="showProductDetail">
                    <div class="product-detail">
                        <div class="slideshow-container" @mousemove="appearControls" :data-index="slideshowIndex">
                            <figure class="slideshow">
                                <template x-for="(image, index) in productDetail.images" :key="index">
                                    <img :src="image" alt>
                                </template>
                            </figure>
                            <div class="prev-image" @click="prevSlideshowImage">
                                <i class="fa-solid fa-circle-chevron-left"></i>
                            </div>
                            <div class="next-image" @click="nextSlideshowImage">
                                <i class="fa-solid fa-circle-chevron-right"></i>
                            </div>
                            <div class="controls visible">
                                <template x-for="(image, index) in productDetail.images" :key="index">
                                    <img @click="updateSlideshow(index)" :class="index== 0?'active': ''" :src="image" alt>
                                </template>
                            </div>
                            <div class="scroll-left-controls visible" @mouseenter="scrollLeft" @mouseleave="clearInterval(intervalScroll)">
                            </div>
                            <div class="scroll-right-controls visible" @mouseenter="scrollRight" @mouseleave="clearInterval(intervalScroll)">
                            </div>
                        </div>
                        <div class="right">
                            <div class="close" @click="closeProductDetail">
                                <i class="fa-solid fa-xmark"></i>
                            </div>
                            <h1  x-text="productDetail.name"></h1>
                            <p class="description" x-text="productDetail.description">
                                
                            </p>
                            <div class="bottom">
                                <div class="info">
                                    <div class="left"><span class="price">$ 9.000</span></div>
                                    <div class="right">
                                        <input type="number" name="quantity" class="quantity">
                                        <div class="add-to-cart">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </template>
                    <template x-for="product in products" :key="product.id">
                        <div x-data="producto" class="product-container">
                            <article class="product" @click="setProductDetail(product)">
                                <figure><img :src="product.image" alt></figure>
                                <h1 x-text="product.name"></h1>
                                <div class="info">
                                    <div class="left"><span class="price" x-text="`$ ${product.price}`"></span></div>
                                    <div class="right">
                                        <input type="number" x-model="quantity" name="quantity" class="quantity" value="1" autocomplete="off">
                                        <div class="add-to-cart" @click="addToCart(product, quantity)">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </template>
                    <div class="product-container">
                        <article class="product">
                            <figure><img src="{{ asset('images/welcome/TRIVIUM-25.jpg') }}" alt></figure>
                            <h1>Irish Red Ale</h1>
                            <div class="info">
                                <div class="left"><span class="price">$ 9.000</span></div>
                                <div class="right">
                                    <input type="number" name="quantity" class="quantity">
                                    <div class="add-to-cart">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="product-container">
                        <article class="product">
                            <figure><img src="{{ asset('images/welcome/TRIVIUM-26.jpg') }}" alt></figure>
                            <h1>Irish Red Ale</h1>
                            <div class="info">
                                <div class="left"><span class="price">$ 9.000</span></div>
                                <div class="right">
                                    <input type="number" name="quantity" class="quantity">
                                    <div class="add-to-cart">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="product-container">
                        <article class="product">
                            <figure><img src="{{ asset('images/welcome/TRIVIUM-27.jpg') }}" alt></figure>
                            <h1>Irish Red Ale</h1>
                            <div class="info">
                                <div class="left"><span class="price">$ 9.000</span></div>
                                <div class="right">
                                    <input type="number" name="quantity" class="quantity">
                                    <div class="add-to-cart">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>

                </section>

                <section id="about" class="relevant-content">
                    <div class="paragraph">
                        <img src="{{ asset('images/welcome/TRIVIUM-36.jpg') }}" alt>
                        <p>
                            Así fue como nació Trivium, nuestro emprendimiento de cerveza
                            artesanal. Desde hace años, los tres compartimos una pasión
                            profunda por la buena cerveza. Nos encantaba explorar
                            diferentes
                            estilos y probar cervezas artesanales de todo el mundo,
                            maravillándonos con la variedad de sabores, aromas y la
                            calidad
                            que estas ofrecían, gracias a sus técnicas tradicionales y
                            cuidado
                            artesanal.
                            <br>
                            <br>
                            En 2022, decidimos que era momento de llevar nuestra pasión un
                            paso más allá. Nos inscribimos en un curso intensivo de
                            cerveza
                            artesanal, donde aprendimos desde los fundamentos básicos
                            hasta
                            técnicas avanzadas de elaboración. Durante semanas, nos
                            sumergimos en el proceso detallado de malteado, maceración,
                            hervido, fermentación y embotellado. Aprendimos sobre la
                            importancia de los ingredientes de calidad, las levaduras
                            adecuadas
                            para cada estilo y cómo controlar parámetros clave como la
                            temperatura y el pH para obtener resultados consistentes y
                            deliciosos.
                        </p>
                    </div>
                    <div class="paragraph">
                        <p>
                            Así fue como nació XXXX, nuestro emprendimiento de cerveza
                            artesanal. Desde hace años, los tres compartimos una pasión
                            profunda por la buena cerveza. Nos encantaba explorar
                            diferentes
                            estilos y probar cervezas artesanales de todo el mundo,
                            maravillándonos con la variedad de sabores, aromas y la
                            calidad
                            que estas ofrecían, gracias a sus técnicas tradicionales y
                            cuidado
                            artesanal.
                            <br>
                            <br>
                            En 2022, decidimos que era momento de llevar nuestra pasión un
                            paso más allá. Nos inscribimos en un curso intensivo de
                            cerveza
                            artesanal, donde aprendimos desde los fundamentos básicos
                            hasta
                            técnicas avanzadas de elaboración. Durante semanas, nos
                            sumergimos en el proceso detallado de malteado, maceración,
                            hervido, fermentación y embotellado. Aprendimos sobre la
                            importancia de los ingredientes de calidad, las levaduras
                            adecuadas
                            para cada estilo y cómo controlar parámetros clave como la
                            temperatura y el pH para obtener resultados consistentes y
                            deliciosos.
                        </p>
                        <img src="{{ asset('images/welcome/TRIVIUM-36.jpg') }}" alt>
                    </div>
                    <div class="paragraph vertical">
                        <img src="{{ asset('images/welcome/TRIVIUM-38.jpg') }}" alt>
                        <p>
                            Así fue como nació XXXX, nuestro emprendimiento de cerveza
                            artesanal. Desde hace años, los tres compartimos una pasión
                            profunda por la buena cerveza. Nos encantaba explorar
                            diferentes
                            estilos y probar cervezas artesanales de todo el mundo,
                            maravillándonos con la variedad de sabores, aromas y la
                            calidad
                            que estas ofrecían, gracias a sus técnicas tradicionales y
                            cuidado
                            artesanal.
                            <br>
                            <br>
                            En 2022, decidimos que era momento de llevar nuestra pasión un
                            paso más allá. Nos inscribimos en un curso intensivo de
                            cerveza
                            artesanal, donde aprendimos desde los fundamentos básicos
                            hasta
                            técnicas avanzadas de elaboración. Durante semanas, nos
                            sumergimos en el proceso detallado de malteado, maceración,
                            hervido, fermentación y embotellado. Aprendimos sobre la
                            importancia de los ingredientes de calidad, las levaduras
                            adecuadas
                            para cada estilo y cómo controlar parámetros clave como la
                            temperatura y el pH para obtener resultados consistentes y
                            deliciosos.
                        </p>
                    </div>
                </section>

                <section id="register" class="relevant-content">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <label for="username">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" name="username" placeholder="Nombre de usuario">
                        </label>
                        <label for="name">
                            <i class="fa-solid fa-id-card"></i>
                            <input type="text" name="name" placeholder="Nombres y apellidos">
                        </label>
                        <label for="cellphone">
                            <i class="fa-solid fa-mobile-screen-button"></i>
                            <input type="text" name="cellphone" placeholder="Número de celular">
                        </label>
                        <label for="email">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" name="email" placeholder="Correo electrónico">
                        </label>
                        <label for="email_confirmation">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" name="email_confirmation"
                                placeholder="Confirma el correo electrónico">
                        </label>
                        <label for="password">
                            <i class="fa-solid fa-key"></i>
                            <input type="password" name="password" placeholder="Crea una contraseña">
                        </label>
                        <label for="password_confirmation">
                            <i class="fa-solid fa-key"></i>
                            <input type="password" name="password_confirmation" placeholder="Confirma la contraseña">
                        </label>
                        <button type="submit" class="fa-solid fa-user-plus"></button>
                    </form>
                    <figure>
                        <img src="{{ asset('images/welcome/TRIVIUM-Texto-Sin Fondo.png') }}" alt>
                    </figure>
                </section>
            </article>
        </section>
    </aside>
    <img class="background" src="{{ asset('images/welcome/3cervezastrivium.jpg') }}" alt="Tres cervezas Trivium">
</body>

</html>
