<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Trivium | Cervecería Artesanal</title>
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
            integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="css/landing_page/style.css" />
        <link
            rel="shortcut icon"
            href="{{ asset('images/favicon.ico') }}"
            type="image/x-icon" />
            @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <aside class="content">
            <section class="bottom">
                <figure>
                    <img id="home-link" class="link active"
                        src="{{ asset('images/welcome/TRIVIUM_recortado.png') }}"
                        alt="Logo de Trivium" />
                </figure>
                <article class="relevant">
                    <nav>
                        <div><a data-title="Iniciar Sesión" data-link="login" id="login-link" class="link">Iniciar
                                Sesión</a><a data-title="Productos" data-link="products"
                                id="products-link" class="link">Ver Productos</a></div>
                        <div><a data-title="Acerca De" data-link="about"
                                id="about-link" class="link">Acerca De</a><a id="register-link" data-title="Registrarse"
                                data-link="register" class="link">Registrarse</a></div>
                    </nav>

                        <section id="login" class="relevant-content">
                            <form>
                                <label for="username">
                                    <i class="fa-solid fa-user"></i>
                                    <input type="text" name="username"
                                        placeholder="Nombre de usuario o Correo">
                                </label>
                                <label for="password">
                                    <i class="fa-solid fa-key"></i>
                                    <input type="password" name="password"
                                        placeholder="Contraseña">
                                </label>
                                <button type="submit"
                                    class="fa-solid fa-door-open"></button>
                            </form>
                            <figure>
                                <img src="{{ asset('images/welcome/TRIVIUM-Texto-Sin Fondo.png') }}" alt>
                            </figure>
                        </section>
                        <section id="products" class="relevant-content">
                            <div class="product-detail">
                                <div class="slideshow-container" data-index="0">
                                    <figure class="slideshow">
                                        <img src="{{ asset('images/welcome/TRIVIUM-25.jpg') }}" alt>
                                        <img src="{{ asset('images/welcome/TRIVIUM-28.jpg') }}" alt>
                                        <img src="{{ asset('images/welcome/TRIVIUM-25.jpg') }}" alt>
                                        <img src="{{ asset('images/welcome/TRIVIUM-28.jpg') }}" alt>
                                        <img src="{{ asset('images/welcome/TRIVIUM-25.jpg') }}" alt>
                                        <img src="{{ asset('images/welcome/TRIVIUM-28.jpg') }}" alt>
                                    </figure>
                                    <div class="prev-image">
                                        <i class="fa-solid fa-circle-chevron-left"></i>
                                    </div>
                                    <div class="next-image">
                                        <i class="fa-solid fa-circle-chevron-right"></i>
                                    </div>
                                    <div class="controls visible">
                                        <img class="active" src="{{ asset('images/welcome/TRIVIUM-25.jpg') }}" alt>
                                        <img src="{{ asset('images/welcome/TRIVIUM-28.jpg') }}" alt>
                                        <img src="{{ asset('images/welcome/TRIVIUM-25.jpg') }}" alt>
                                        <img src="{{ asset('images/welcome/TRIVIUM-28.jpg') }}" alt>
                                        <img src="{{ asset('images/welcome/TRIVIUM-25.jpg') }}" alt>
                                        <img src="{{ asset('images/welcome/TRIVIUM-28.jpg') }}" alt>
                                    </div>
                                    <div class="scroll-left-controls visible">
                                    </div>
                                    <div class="scroll-right-controls visible">
                                    </div>

                                </div>
                                <div class="right">
                                    <div class="close">
                                        <i class="fa-solid fa-xmark"></i>
                                    </div>
                                    <h1>Irish Red Ale</h1>
                                    <p class="description">
                                        La Irish Red Ale es una joya en nuestro repertorio en
                                        Trivium, una cerveza que tiene profundas raíces en la
                                        tradición cervecera irlandesa. Cuando comenzamos
                                        nuestra aventura en el mundo de la cerveza artesanal,
                                        sabíamos que queríamos capturar la esencia y el
                                        carácter únicos de este estilo clásico.

                                        Nos enamoramos de la Irish Red Ale por su color rojizo
                                        distintivo, que proviene de las maltas tostadas que
                                        utilizamos en su elaboración. Estas maltas no solo le
                                        dan su apariencia característica, sino que también
                                        aportan sabores dulces y notas de caramelo que
                                        complementan perfectamente el ligero amargor de
                                        los lúpulos utilizados.

                                        Cada lote de nuestra Irish Red Ale es una celebración
                                        de la rica historia cervecera de Irlanda y de nuestra
                                        pasión por la calidad y la artesanía. Es una cerveza que
                                        nos conecta con las tradiciones mientras permitimos
                                        que nuestro toque personal y creativo brille a través de
                                        cada sorbo. Nos enorgullece compartir esta cerveza con
                                        nuestros clientes, invitándolos a disfrutar de su
                                        complejidad y carácter único, al tiempo que honramos
                                        y celebramos la herencia cervecera que inspiró su
                                        creación.
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
                            <form>
                                <label for="username">
                                    <i class="fa-solid fa-user"></i>
                                    <input type="text" name="username"
                                        placeholder="Nombre de usuario">
                                </label>
                                <label for="fullname">
                                    <i class="fa-solid fa-id-card"></i>
                                    <input type="text" name="fullname"
                                        placeholder="Nombres y apellidos">
                                </label>
                                <label for="phone">
                                    <i class="fa-solid fa-mobile-screen-button"></i>
                                    <input type="text" name="phone"
                                        placeholder="Número de celular">
                                </label>
                                <label for="email">
                                    <i class="fa-solid fa-envelope"></i>
                                    <input type="email" name="email"
                                        placeholder="Correo electrónico">
                                </label>
                                <label for="emailconfirmation">
                                    <i class="fa-solid fa-envelope"></i>
                                    <input type="email" name="emailconfirmation"
                                        placeholder="Confirma el correo electrónico">
                                </label>
                                <label for="password">
                                    <i class="fa-solid fa-key"></i>
                                    <input type="password" name="password"
                                        placeholder="Crea una contraseña">
                                </label>
                                <label for="passwordconfirmation">
                                    <i class="fa-solid fa-key"></i>
                                    <input type="password" name="passwordconfirmation"
                                        placeholder="Confirma la contraseña">
                                </label>
                                <button type="submit"
                                    class="fa-solid fa-user-plus"></button>
                            </form>
                            <figure>
                                <img src="{{ asset('images/welcome/TRIVIUM-Texto-Sin Fondo.png') }}" alt>
                            </figure>
                        </section>
                </article>
            </section>
        </aside>
            <img class="background" src="{{ asset('images/welcome/3cervezastrivium.jpg') }}" alt="Tres cervezas Trivium">
        <script src="js/app.js"></script>
    </body>
</html>
