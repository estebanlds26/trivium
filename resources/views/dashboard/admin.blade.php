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
        <div class="produccion" x-data="produccion">
            <template x-for="(proceso, indexProceso) in procesos" :key="indexProceso">
                <div class="proceso-container">
                    <div class="proceso-header">
                        Proceso # <span x-text="proceso.procesoId"></span> | <span
                            x-text="proceso.productionSteps[proceso.activeStep].text"></span>
                    </div>
                    <div class="proceso" onWheel= "this.scrollLeft+=event.deltaY>0?140:-140">
                        <div>
                            <template x-for="(step, index) in proceso.productionSteps" :key="index">
                                <div class="step" :class="[step.type, index == proceso.activeStep ? 'active' : '']">
                                    <span class="step-text" x-text="step.text"></span>
                                    <template x-if="step.type == 'simple'">
                                        <div>
                                            <div class="controls">
                                                <div class="continue"
                                                    @click="continuar(index + 1, $el, step, indexProceso)">
                                                    <i class="fa-solid fa-check"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <template x-if="step.type == 'checklist'">
                                        <div>
                                            <div class="checklist-items">

                                                <template x-for="(item, index) in step.items" :key="index">
                                                    <div class="checklist-item">
                                                        <label :for="`checklist-item-${index}_${indexProceso}`"><span
                                                                x-text="item[0]"></span><input type="checkbox"
                                                                :id="`checklist-item-${index}_${indexProceso}`"
                                                                :value="item[0]" x-model="item[1]"></label>
                                                    </div>
                                                </template>
                                            </div>

                                            <div class="controls">
                                                <div class="continue" :class="!todoChuleado(step) ? 'disabled' : ''"
                                                    @click="continuar(index + 1, $el, step, indexProceso)">
                                                    <i class="fa-solid fa-check"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <template x-if="step.type == 'time'">
                                        <div>
                                            <p x-text="formatTime(step.milliseconds)"></p>
                                            <div class="controls">
                                                <div class="start" :class="!!step.startTime ? 'disabled' : ''"
                                                    @click="startTimer(step, indexProceso)">
                                                    <i class="fa-solid fa-play"></i>
                                                </div>
                                                <div class="continue" :class="step.milliseconds != 0 ? 'disabled' : ''"
                                                    @click="continuar(index + 1, $el, step, indexProceso)">
                                                    <i class="fa-solid fa-check"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
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
                                <input type="number" x-model="quantity" name="quantity" class="quantity"
                                    value="1" autocomplete="off">
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
                        <i @click="edit()" class="fa-solid fa-pen-to-square"></i>
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
                        <img src="{{ asset('images/welcome/TRIVIUM_recortado.png') }}" alt="Trivium"
                            class="logo-trivium">
                        <div class="return" @click="goBack()" x-show="subsection != 'index'">
                            <i class="fa-solid fa-chevron-left"></i>
                        </div>
                        <h1 x-text="capitalize(sections[section].pluralName)"></h1>
                    </div>
                    <div class="right">
                        <div class="search action">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" placeholder="Buscar en Productos" class="search">
                        </div>
                        <div class="select-multiple action">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div class="refresh action" @click="load(section)">
                            <i class="fa-solid fa-arrows-rotate"></i>
                        </div>
                    </div>
                </aside>
                <aside class="management-content">
                    <template x-if="section== 'productos'">
                        <div class="productos-management">
                            <template x-if="subsection=='edit'">
                                <div class="edit">
                                    <label for="nombre-producto-edit">
                                        Nombre
                                        <input type="text" id="nombre-producto-edit" :value="sections.productos.details.nombre">
                                    </label>
                                    <label for="nombre-producto-edit">
                                        Descripción
                                        <textarea type="text" id="descripcion-producto-edit" x-text="sections.productos.details.descripcion">lorem ipsum...</textarea>
                                    </label>
                                    <label for="precio-producto-edit">
                                        Precio
                                        <input type="text" id="precio-producto-edit" :value="sections.productos.details.precio">
                                    </label>
                                    <div class="buttons">
                                        <div class="btn green" @click="update()">Actualizar</div>
                                        <div class="btn grey" @click="goBack()">Descartar</div>
                                    </div>
                                </div>
                            </template>
                            <template x-if="subsection=='create'">
                                <div class="create">
                                    <label for="nombre-producto-create">
                                        Nombre
                                        <input type="text" id="nombre-producto-create" value="">
                                    </label>
                                    <label for="descripcion-producto-create">
                                        Descripción
                                        <textarea type="text" id="descripcion-producto-create"></textarea>
                                    </label>
                                    <label for="precio-producto-create">
                                        Precio
                                        <input type="text" id="precio-producto-create" value="">
                                    </label>
                                    <div class="buttons">
                                        <div class="btn green" @click="add()">Crear</div>
                                        <div class="btn grey" @click="goBack()">Descartar</div>
                                    </div>
                                </div>
                            </template>
                            <template x-if="subsection=='view'">
                                <div class="view">
                                    <label for="nombre-producto">
                                        Nombre
                                        <p id="nombre-producto" x-text="sections.productos.details.nombre"></p>
                                    </label>
                                    <label for="descripcion-producto">
                                        Descripción
                                        <p id="descripcion-producto" x-text="sections.productos.details.descripcion"></p>
                                    </label>
                                    <label for="precio-producto">
                                        Precio
                                        <p id="precio-producto" x-text="sections.productos.details.precio"></p>
                                    </label>
                                    <label for="stock-producto">
                                        Stock disponible
                                        <p id="stock-producto" x-text="countQuantityProductions(sections.productos.details.producciones) - countQuantitySales(sections.productos.details.pedidos)">136</p>
                                    </label>
                                    <label for="produccion-producto">
                                        Producción
                                        <p id="produccion-producto" x-text="countQuantityProductions(sections.productos.details.producciones)"></p>
                                    </label>
                                    <label for="detalles-produccion-producto">
                                        Detalles producción
                                        <div class="table">
                                            <table class="productos-table">
                                                <thead>
                                                    <tr>
                                                        <th>Fecha</th>
                                                        <th>Cantidad</th>
                                                        <th>Producto</th>
                                                        <th>Importe</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <template x-for="(produccion, index) in sections.productos.details.producciones"
                                                        :key="index">
                                                        <tr>
                                                            <td x-text="produccion.fecha"></td>
                                                            <td x-text="produccion.cantidad"></td>
                                                            <td x-text="produccion.producto.nombre"></td>
                                                            <td x-text="sumInsumos(produccion.insumos)"></td>
                                                        </tr>
                                                    </template>
                                                    
                                            </table>
                                        </div>
                                    </label>
                                    <label for="ventas-producto">
                                        Ventas
                                        <p id="ventas-producto" x-text="countQuantitySales(sections.productos.details.pedidos)"></p>
                                    </label>
                                    <label for="detalles-ventas-producto">
                                        Detalles ventas
                                        <div class="table">
                                            <table class="productos-table">
                                                <thead>
                                                    <tr>
                                                        <th>Fecha</th>
                                                        <th>Cantidad</th>
                                                        <th>Estado</th>
                                                        <th>Cliente</th>
                                                        <th>Importe</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <template x-for="(pedido, index) in sections.productos.details.pedidos"
                                                        :key="index">
                                                        <tr>
                                                            <td x-text="pedido.fecha"></td>
                                                            <td x-text="pedido.pivot.cantidad"></td>
                                                            <td x-text="pedido.estado"></td>
                                                            <td x-text="pedido.user.name"></td>
                                                            <td x-text="pedido.pivot.importe"></td>
                                                        </tr>
                                                    </template>
                                            </table>
                                        </div>
                                    </label>
                                </div>
                            </template>
                            <template x-if="subsection=='index'">
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
                                        <template x-if="sections.productos.rows == null">
                                            <tbody>
                                                <tr>
                                                    <td colspan="8">Cargando</td>
                                                </tr>
                                            </tbody>
                                        </template>
                                        <template x-if="sections.productos.rows != null && sections.productos.rows.length == 0">
                                            <tbody>
                                                <tr>
                                                    <td colspan="8">No hay productos</td>
                                                </tr>
                                            </tbody>
                                        </template>
                                        <template x-if="sections.productos.rows != null && sections.productos.rows.length != 0">

                                        <tbody>
                                            <template x-for="(producto, index) in sections.productos.rows"
                                                :key="index">
                                                <tr @click="view(producto)">
                                                    <td x-text="producto.nombre"></td>
                                                    <td x-text="countQuantityProductions(producto.producciones) - countQuantitySales(producto.pedidos)">100</td>
                                                    <td x-text="producto.precio"></td>
                                                    <td x-text="countQuantityProductions(producto.producciones)"></td>
                                                    <td x-text="countQuantitySales(producto.pedidos)"></td>
                                                    <td>Detalles (<span
                                                            x-text="countProductions(producto.producciones)"></span>) ›
                                                    </td>
                                                    <td>Detalles (<span
                                                            x-text="countProductions(producto.pedidos)"></span>) ›</td>
                                                    <td>
                                                        <div class="actions">
                                                            <i @click.stop="destroy(producto.id)" class="fa-solid fa-trash-can"></i>
                                                            <i @click.stop="edit(producto)" class="fa-solid fa-pen-to-square"></i>
                                                            <i class="fa-solid fa-print"></i>
                                                             
                                                        </div>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </template>
                                    </table>
                                </div>
                            </template>

                        </div>
                    </template>
                    <button class="add big-action" x-show="subsection=='index'" @click="create()">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </aside>
                <aside class="management-sections">
                    <div class="section entrada-de-material" :class="section == 'Entrada de Material' ? 'active' : ''"
                        @click="setSection('Entrada de Material')">
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        <h1>Entrada de Material</h1>
                    </div>
                    <div class="section materia-prima" :class="section == 'Materia Prima' ? 'active' : ''"
                        @click="setSection('Materia Prima')">
                        <i class="fa-solid fa-box"></i>
                        <h1>Materia Prima</h1>
                    </div>
                    <div class="section productos" :class="section == 'Productos' ? 'active' : ''"
                        @click="setSection('Productos')">
                        <i class="fa-solid fa-box-open"></i>
                        <h1>Productos</h1>
                    </div>
                    <div class="section ventas" :class="section == 'Ventas' ? 'active' : ''"
                        @click="setSection('Ventas')">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <h1>Ventas</h1>
                    </div>
                    <div class="section procesos" :class="section == 'Procesos' ? 'active' : ''"
                        @click="setSection('Procesos')">
                        <i class="fa-solid fa-cubes-stacked"></i>
                        <h1>Procesos</h1>
                    </div>
                    <div class="section stock-bajo" :class="section == 'Stock Bajo' ? 'active' : ''"
                        @click="setSection('Stock Bajo')">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <h1>Stock Bajo</h1>
                    </div>
                    <div class="section estadisticas" :class="section == 'Estadísticas' ? 'active' : ''"
                        @click="setSection('Estadísticas')">
                        <i class="fa-solid fa-chart-simple"></i>
                        <h1>Estadísticas</h1>
                    </div>
                </aside>
            </section>
        </div>
    </template>
@endsection
