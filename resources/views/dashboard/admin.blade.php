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
    <div class="link" id="production-link" @click="navigateToSection($event.target)">
        <a>
            <div class="link-icon">
                <i class="fa-solid fa-cubes-stacked"></i>
            </div>
            <span>Producción</span>
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
    <div class="link" id="inventory-link" @click="navigateToSection($event.target)">
        <a>
            <div class="link-icon">
                <i class="fa-solid fa-calculator"></i>
            </div>
            <span>Inventario</span>
        </a>
    </div>
@endsection

@section('content')
    <template x-if="section =='home'">
        <a href="">home</a>
    </template>
    <template x-if="section =='production'">
        <div class="proceso">
            <template x-for="(step, index) in productionSteps" :key="index">
                <template x-if="step.type == 'simple'">
                    <div class="step simple">
                        <span class="step-text" x-text="step.text"></span>
                    </div>
                </template>
            </template> 
        </div>
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
                        zxczxc
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
    <template x-if="section =='inventory'">
        <div class="inventory">
            <section class="management" x-data="managementData">
                <aside class="management-header">
                    <div class="left">
                        <img src="{{ asset('images/welcome/TRIVIUM_recortado.png') }}" alt="Trivium" class="logo-triviumn">
                        <h1 x-text="section"></h1>
                    </div>
                    <div class="right">
                        <div class="search action">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" placeholder="Buscar en Productos" class="search">
                        </div>
                        <div class="select-multiple action">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div class="refresh action">
                            <i class="fa-solid fa-arrows-rotate"></i>
                        </div>
                    </div>
                </aside>
                <aside class="management-content">
                    <template x-if="section== 'Productos'">
                        <div class="table">
                        <table class="productos-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Stock</th>
                                    <th>Precio</th>
                                    <th>Producidas</th>
                                    <th>Vendidas</th>
                                    <th>Producción</th>
                                    <th>Ventas</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Golden Ale</td>
                                <td>100</td>
                                <td>9000</td>
                                <td>898</td>
                                <td>732</td>
                                <td>Detalles (209) ›</td>
                                <td>Detalles (460) ›</td>
                                <td>
                                    <div class="actions">
                                        <i class="fa-solid fa-trash-can"></i>
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <i class="fa-solid fa-print"></i>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Golden Ale</td>
                                <td>100</td>
                                <td>9000</td>
                                <td>898</td>
                                <td>732</td>
                                <td>Detalles (209) ›</td>
                                <td>Detalles (460) ›</td>
                                <td>
                                    <div class="actions">
                                        <i class="fa-solid fa-trash-can"></i>
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <i class="fa-solid fa-print"></i>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Golden Ale</td>
                                <td>100</td>
                                <td>9000</td>
                                <td>898</td>
                                <td>732</td>
                                <td>Detalles (209) ›</td>
                                <td>Detalles (460) ›</td>
                                <td>
                                    <div class="actions">
                                        <i class="fa-solid fa-trash-can"></i>
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <i class="fa-solid fa-print"></i>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    </template>
                    <button class="add big-action" x-show="addAvailable(section)">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </aside>
                <aside class="management-sections">
                    <div class="section entrada-de-material" :class="section== 'Entrada de Material' ? 'active' : ''" @click="setSection('Entrada de Material')">
                        <i class="fa-solid fa-arrow-right-arrow-left"></i >
                        <h1>Entrada de Material</h1>
                    </div>
                    <div class="section materia-prima" :class="section == 'Materia Prima' ?'active':''" @click="setSection('Materia Prima')">
                        <i class="fa-solid fa-box"></i>
                        <h1>Materia Prima</h1>
                    </div>
                    <div class="section productos" :class="section == 'Productos' ?'active':''" @click="setSection('Productos')">
                        <i class="fa-solid fa-box-open"></i>
                        <h1>Productos</h1>
                    </div>
                    <div class="section ventas" :class="section== 'Ventas' ? 'active' : ''" @click="setSection('Ventas')">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <h1>Ventas</h1>
                    </div>
                    <div class="section procesos" :class="section== 'Procesos' ? 'active' : ''" @click="setSection('Procesos')">
                        <i class="fa-solid fa-cubes-stacked"></i>
                        <h1>Procesos</h1>
                    </div>
                    <div class="section stock-bajo" :class="section== 'Stock Bajo' ? 'active' : ''" @click="setSection('Stock Bajo')">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <h1>Stock Bajo</h1>
                    </div>
                    <div class="section estadisticas" :class="section== 'Estadísticas' ? 'active' : ''" @click="setSection('Estadísticas')">
                        <i class="fa-solid fa-chart-simple"></i>
                        <h1>Estadísticas</h1>
                    </div>
                </aside>
            </section>
        </div> 
    </template>
@endsection
