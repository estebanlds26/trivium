@extends('layouts.app')

@section('title', 'Dashboard | Trivium | Cervecería Artesanal')

@section('sidebar')
    <div class="link" id="store-link" @click="navigateToSection($event.target)">
        <a>
            <div class="link-icon">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <span>Tienda</span>
        </a>
    </div>
    <div class="link" id="contact-link" @click="navigateToSection($event.target)">
        <a>
            <div class="link-icon">
                <i class="fa-solid fa-comments"></i>
            </div>
            <span>Contáctanos</span>
        </a>
    </div>
    <div class="link" id="settings-link" @click="navigateToSection($event.target)">
        <a>
            <div class="link-icon">
                <i class="fa-solid fa-cog"></i>
            </div>
            <span>Ajustes</span>
        </a>
    </div>
    <div class="link" id="help-link" @click="navigateToSection($event.target)">
        <a>
            <div class="link-icon">
                <i class="fa-solid fa-circle-question"></i>
            </div>
            <span>Preguntas frecuentes</span>
        </a>
    </div>
@endsection

@section('content')
    <template x-if="section =='home'">
        <a href="">home</a>
    </template>
    <template x-if="section =='store'">
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
                                <img @click="updateSlideshow(index)" :class="index == 0 ? 'active' : ''"
                                    :src="image" alt>
                            </template>
                        </div>
                        <div class="scroll-left-controls visible" @mouseenter="scrollLeft"
                            @mouseleave="clearInterval(intervalScroll)">
                        </div>
                        <div class="scroll-right-controls visible" @mouseenter="scrollRight"
                            @mouseleave="clearInterval(intervalScroll)">
                        </div>
                    </div>
                    <div class="right">
                        <div class="close" @click="closeProductDetail">
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                        <h1 x-text="productDetail.name"></h1>
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
                                <input type="number" x-model="quantity" name="quantity" class="quantity" value="1"
                                    autocomplete="off">
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
    </template>
    <template x-if="section =='contact'">
        <div id="contact" class="relevant-content">
            <aside class="left">
                <article class="qr">
                    <h1>Agréganos a WhatsApp:</h1>
                    <img src="{{ asset('images/dashboard/whatsapp-qr.png') }}" alt="">
                </article>
                <article class="qr">
                    <h1>Encuéntranos en Instagram:</h1>
                    <img src="{{ asset('images/dashboard/instagram-qr.png') }}" alt="">
                </article>
            </aside>
            <aside class="right">
                <h1>O envíanos un correo electrónico:</h1>
                <form>
                    <label for="subject">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="text" name="subject" placeholder="Asunto" required>
                    </label>
                    <label for="message">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <textarea name="message" placeholder="Mensaje"></textarea>
                    </label>
                    <button title="Enviar" type="submit">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </aside>
        </div>
    </template>
    <template x-if="section =='settings'">
        <div id="settings" class="relevant-content">
            <div class="accordion" x-data="accordion">
                <div class="accordion-search">
                    <input type="text" placeholder="Buscar ajustes" class="search" id="settings-search">
                </div>
                <div class="accordion-item">
                    <div class="accordion-header" @click="toggleItem(0)">
                        <h1>Perfil</h1>
                        <i class="fa-solid fa-chevron-down" :class="openItem == 0 ? 'open' : ''"></i>
                    </div>
                    <div class="accordion-body" :class="openItem == 0 ? 'open' : ''">
                        <fieldset>
                            <legend>Información personal</legend>
                            <label for="profilePic">Foto de Perfil
                                <input type="file" name="profilePic" id="profilePic" accept="image/*">
                            </label>
                            <label for="fullName">Nombre
                                <input type="text" name="fullName" id="fullName">
                            </label>
                            <label for="username">Nombre de usuario
                                <input type="text" name="username" id="username">
                            </label>
                        </fieldset>
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header" @click="toggleItem(1)">
                        <h1>Aplicación</h1>
                        <i class="fa-solid fa-chevron-down" :class="openItem == 1 ? 'open' : ''"></i>
                    </div>
                    <div class="accordion-body" :class="openItem == 1 ? 'open' : ''">
                        asdasd
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header" @click="toggleItem(2)">
                        <h1>Accesibilidad</h1>
                        <i class="fa-solid fa-chevron-down" :class="openItem == 2 ? 'open' : ''"></i>
                    </div>
                    <div class="accordion-body" :class="openItem == 2 ? 'open' : ''">
                        asdasd
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header" @click="toggleItem(3)">
                        <h1>Notificaciones</h1>
                        <i class="fa-solid fa-chevron-down" :class="openItem == 3 ? 'open' : ''"></i>
                    </div>
                    <div class="accordion-body" :class="openItem == 3 ? 'open' : ''">
                        asdasd
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header" @click="toggleItem(4)">
                        <h1>Acerca de la aplicación</h1>
                        <i class="fa-solid fa-chevron-down" :class="openItem == 4 ? 'open' : ''"></i>
                    </div>
                    <div class="accordion-body" :class="openItem == 4 ? 'open' : ''">
                        asdasd
                    </div>
                </div>
            </div>
        </div>
    </template>
    <template x-if="section =='help'">
        <div id="help" class="relevant-content">
            <div class="accordion" x-data="accordion">
                <div class="accordion-search">
                    <input type="text" placeholder="Buscar ayuda" class="search" id="settings-search">
                </div>
                <div class="accordion-item">
                    <div class="accordion-header" @click="toggleItem(0)">
                        <h1>¿Cómo puedo crear una cuenta?</h1>
                        <i class="fa-solid fa-chevron-down" :class="openItem == 0 ? 'open' : ''"></i>
                    </div>
                    <div class="accordion-body" :class="openItem == 0 ? 'open' : ''">
                        Puedes crear una cuenta haciendo clic en el botón “Registrarse” en la parte superior de la página. 
                        Completa el formulario con tu nombre, correo electrónico y una contraseña segura. 
                        Una vez enviado, recibirás un correo de confirmación para activar tu cuenta.
                    </div>
                    <div class="accordion-body" :class="openItem == 1 ? 'open' : ''">
                        Si olvidaste tu contraseña, ve a la página de inicio de sesión y haz clic en “¿Olvidaste tu contraseña?”. 
                        Ingresa tu correo electrónico y te enviaremos un enlace para que puedas establecer una nueva contraseña de forma segura.
                    </div>
                    <div class="accordion-body" :class="openItem == 2 ? 'open' : ''">
                        Puedes contactarnos directamente a través del formulario en la sección Contacto, por WhatsApp escaneando nuestro código QR, 
                        o enviándonos un correo electrónico. Estamos disponibles para ayudarte con cualquier consulta o inconveniente.
                    </div>
                    <div class="accordion-body" :class="openItem == 3 ? 'open' : ''">
                        Sí, puedes cancelar o modificar tu pedido antes de que sea despachado. 
                        Por favor contáctanos lo antes posible a través del servicio de atención al cliente para gestionar el cambio.
                    </div>
                    <div class="accordion-body" :class="openItem == 4 ? 'open' : ''">
                        Actualmente nuestras entregas están limitadas al territorio nacional. 
                        Sin embargo, estamos trabajando para habilitar envíos internacionales próximamente. ¡Te mantendremos informado!
                    </div>
                    
                </div>
                <div class="accordion-item">
                    <div class="accordion-header" @click="toggleItem(1)">
                        <h1>¿Cómo restablezco mi contraseña?</h1>
                        <i class="fa-solid fa-chevron-down" :class="openItem == 1 ? 'open' : ''"></i>
                    </div>
                    <div class="accordion-body" :class="openItem == 1 ? 'open' : ''">
                        asdasd
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header" @click="toggleItem(2)">
                        <h1>¿Cómo puedo contactar al servicio de atención al cliente?</h1>
                        <i class="fa-solid fa-chevron-down" :class="openItem == 2 ? 'open' : ''"></i>
                    </div>
                    <div class="accordion-body" :class="openItem == 2 ? 'open' : ''">
                        asdasd
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header" @click="toggleItem(3)">
                        <h1>¿Puedo cancelar o modificar mi pedido?</h1>
                        <i class="fa-solid fa-chevron-down" :class="openItem == 3 ? 'open' : ''"></i>
                    </div>
                    <div class="accordion-body" :class="openItem == 3 ? 'open' : ''">
                        asdasd
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header" @click="toggleItem(4)">
                        <h1>¿Ofrecen servicios de entrega internacional?</h1>
                        <i class="fa-solid fa-chevron-down" :class="openItem == 4 ? 'open' : ''"></i>
                    </div>
                    <div class="accordion-body" :class="openItem == 4 ? 'open' : ''">
                        asdasd
                    </div>
                </div>
            </div>
        </div>
    </template>
@endsection
