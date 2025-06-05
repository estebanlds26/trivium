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
        <a href=""></a>
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

                                                <template x-for="(item, indexItem) in step.items" :key="indexItem">
                                                    <div class="checklist-item">
                                                        <label :for="`checklist-item-${indexItem}_${indexProceso}`">
                                                            <span
                                                                x-text="item[0]"></span>
                                                            <input type="checkbox" :disabled="index != proceso.activeStep"
                                                                :id="`checklist-item-${indexItem}_${indexProceso}`"
                                                                x-model="item[1]">
                                                        </label>
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
           
            <template x-if="!!products">
                <template x-for="(product, index) in products" :key="product.id">
                    <div x-data="producto" class="product-container" x-init="producto= product">
                        <article class="product">
                            <div class="slideshow-container"  x-ref="slideshow-container" @mousemove="appearControls()" :data-index="slideshowIndex">
                                <figure class="slideshow">
                                    <template x-for="(image, index) in product.imagenes" :key="index">
                                        <img :src="`/storage/${image}`" alt @click="openImageModal(`/storage/${image}`, index)" style="cursor: pointer;">                                    </template>
                                </figure>
                                <div class="prev-image"  x-ref="prev-image" @click="prevSlideshowImage()">
                                    <i class="fa-solid fa-circle-chevron-left"></i>
                                </div>
                                <div class="next-image"  x-ref="next-image" @click="nextSlideshowImage()">
                                    <i class="fa-solid fa-circle-chevron-right"></i>
                                </div>
                                <div class="controls visible"  x-ref="controls" >
                                    <template x-for="(image, indexI) in product.imagenes" :key="indexI">
                                        <img @click="updateSlideshow(indexI)" :class="indexI == 0 ? 'active' : ''"
                                            :src="`/storage/${image}`" alt>
                                    </template>
                                </div>
                                <div class="scroll-left-controls visible"   x-ref="scroll-left-controls" @mouseenter="scrollLeft"
                                    @mouseleave="clearInterval(intervalScroll)">
                                </div>
                                <div class="scroll-right-controls visible"  x-ref="scroll-right-controls"  @mouseenter="scrollRight"
                                    @mouseleave="clearInterval(intervalScroll)">
                                </div>
                            </div>
                            <div class="right">
                                <h1 x-text="product.nombre"></h1>
                                <p class="description" x-text="product.descripcion"></p>

                                </p>
                                <div class="info">
                                    <div class="left"  x-ref="left" ><span class="price" x-text="`$ ${product.precio}`"></span></div>
                                    <div class="right"  x-ref="right" >
                                        <input type="number" x-ref="`quantity_product_${product.id}`" name="quantity" class="quantity"
                                            value="1" autocomplete="off">
                                        <div class="add-to-cart" @click="addToCart(product, quantity)">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div x-show="showImageModal" class="product-modal" @click.self="closeImageModal">
                                <button class="close-modal" @click.stop="closeImageModal()">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                                <button class="left-arrow" @click.stop="prevModalImage()" >
                                    <i class="fa-solid fa-chevron-left"></i>
                                </button>
                                <img :src="modalImageUrl">
                                <button class="right-arrow" @click.stop="nextModalImage()" >
                                    <i class="fa-solid fa-chevron-right"></i>
                                </button>
                            </div>
                        </article>
                    </div>
                </template>
            </template>
            <template x-if="!products">
                <div class="loading">
                    <p>Cargando productos...</p>
                </div>
            </template>
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
                        <fieldset>
                            <legend>Preferencias</legend>
                            <div class="option-row"> 
                            <label for="Tema">Tema</label>
                            <div class="radio-inputs">
                                 <label>
                                <label class="radio">
                                    <input type="radio" name="radio" checked="">
                                    <span class="nameTwo">Oscuro</span>
                                </label>
                                <label class="radio"><br><br>
                                    <input type="radio" name="radio">
                                    <span class="nameTwo">Claro</span>
                                </label>
                                </div>
                                </div>
                            <div class="option-row">   
                            <label for="Lenguaje">Lenguaje</label>
                            <div class="radio-inputs">
                                 <label>
                                <label class="radio">
                                    <input type="radio" name="radio" checked="">
                                    <span class="nameTwo">Español</span>
                                </label>
                                <label class="radio"><br><br>
                                    <input type="radio" name="radio">
                                    <span class="nameTwo">English</span>
                                </label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header" @click="toggleItem(2)">
                        <h1>Accesibilidad</h1>
                        <i class="fa-solid fa-chevron-down" :class="openItem == 2 ? 'open' : ''"></i>
                    </div>
                    <div class="accordion-body" :class="openItem == 2 ? 'open' : ''">
                        <fieldset>
                            <legend>Vision</legend>
                            <div class="option-row"> 
                            <label for="Tema">Tamaño de letra</label>
                            <label for="Tema">Modo de alto contraste</label>
                            <div class="radio-inputs">
                                 <label>
                                <label class="radio">
                                    <input type="radio" name="radio" checked="">
                                    <span class="nameTwo">Desactivado</span>
                                </label>
                                <label class="radio"><br><br>
                                    <input type="radio" name="radio">
                                    <span class="nameTwo">Activado</span>
                                </label>
                                </div>
                                </div>
                            <label for="Tema">Nivel de brillo</label>
                            <div class="option-row">   
                            <label for="Lenguaje">Leer en voz alta</label>
                            <div class="radio-inputs">
                                 <label>
                                <label class="radio">
                                    <input type="radio" name="radio" checked="">
                                    <span class="nameTwo">Desactivado</span>
                                </label>
                                <label class="radio"><br><br>
                                    <input type="radio" name="radio">
                                    <span class="nameTwo">Activado</span>
                                </label>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Neurologia</legend>
                            <div class="option-row"> 
                            <label for="Tema">Imagenes destellantes</label>
                            <div class="radio-inputs">
                                 <label>
                                <label class="radio">
                                    <input type="radio" name="radio" checked="">
                                    <span class="nameTwo">Desactivado</span>
                                </label>
                                <label class="radio"><br><br>
                                    <input type="radio" name="radio">
                                    <span class="nameTwo">Activado</span>
                                </label>
                                </div>
                                </div>
                            <div class="option-row">   
                            <label for="Lenguaje">Animaciones</label>
                            <div class="radio-inputs">
                                 <label>
                                <label class="radio">
                                    <input type="radio" name="radio" checked="">
                                    <span class="nameTwo">Desactivado</span>
                                </label>
                                <label class="radio"><br><br>
                                    <input type="radio" name="radio">
                                    <span class="nameTwo">Activado</span>
                                </label>
                                </div>
                            </div>
                        </fieldset>
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
                        <div>
                            Puedes crear una cuenta haciendo clic en el botón “Registrarse” en la parte superior de la página.
                            Completa el formulario con tu nombre, correo electrónico y una contraseña segura.
                            Una vez enviado, recibirás un correo de confirmación para activar tu cuenta.
                        </div>
                    </div>
                    
                </div>
                <div class="accordion-item">
                    <div class="accordion-header" @click="toggleItem(1)">
                        <h1>¿Cómo restablezco mi contraseña?</h1>
                        <i class="fa-solid fa-chevron-down" :class="openItem == 1 ? 'open' : ''"></i>
                    </div>
                    <div class="accordion-body" :class="openItem == 1 ? 'open' : ''">
                        <div>
                            Si olvidaste tu contraseña, ve a la página de inicio de sesión y haz clic en “¿Olvidaste tu contraseña?”.
                            Ingresa tu correo electrónico y te enviaremos un enlace para que puedas establecer una nueva contraseña de forma segura.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header" @click="toggleItem(2)">
                        <h1>¿Cómo puedo contactar al servicio de atención al cliente?</h1>
                        <i class="fa-solid fa-chevron-down" :class="openItem == 2 ? 'open' : ''"></i>
                    </div>
                    <div class="accordion-body" :class="openItem == 2 ? 'open' : ''">
                        <div>    
                            Puedes contactarnos directamente a través del formulario en la sección Contacto, por WhatsApp escaneando nuestro código QR,
                            o enviándonos un correo electrónico. Estamos disponibles para ayudarte con cualquier consulta o inconveniente.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header" @click="toggleItem(3)">
                        <h1>¿Puedo cancelar o modificar mi pedido?</h1>
                        <i class="fa-solid fa-chevron-down" :class="openItem == 3 ? 'open' : ''"></i>
                    </div>
                    <div class="accordion-body" :class="openItem == 3 ? 'open' : ''">
                        <div>
                            Sí, puedes cancelar o modificar tu pedido antes de que sea despachado.
                            Por favor contáctanos lo antes posible a través del servicio de atención al cliente para gestionar el cambio.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header" @click="toggleItem(4)">
                        <h1>¿Ofrecen servicios de entrega internacional?</h1>
                        <i class="fa-solid fa-chevron-down" :class="openItem == 4 ? 'open' : ''"></i>
                    </div>
                    <div class="accordion-body" :class="openItem == 4 ? 'open' : ''">
                        <div>
                            Actualmente nuestras entregas están limitadas al territorio nacional.
                            Sin embargo, estamos trabajando para habilitar envíos internacionales próximamente. ¡Te mantendremos informado!
                        </div>
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
                        <div class="productos management-section">
                            <template x-if="subsection=='edit'">
                                <div class="edit">
                                    <label for="nombre-producto-edit">
                                        Nombre
                                        <input type="text" x-ref="nombreProductoEdit"
                                            :value="sections.productos.details.nombre">
                                    </label>
                                    <label for="nombre-producto-edit">
                                        Descripción
                                        <textarea type="text" x-ref="descripcionProductoEdit" x-text="sections.productos.details.descripcion">lorem ipsum...</textarea>
                                    </label>
                                    <label for="precio-producto-edit">
                                        Precio
                                        <input type="text" x-ref="precioProductoEdit"
                                            :value="sections.productos.details.precio">
                                    </label>
                                    <label for="fotos-producto-edit">
                                        Fotos
                                    </label>
                                    <div class="photo-previews">
                                        <template x-for="(photo, index) in sections.productos.photos" :key="index">
                                            <div class="photo-preview" draggable="true"
                                                 @dragstart="dragIndex = index"
                                                 @dragover.prevent
                                                 @drop="reorder(dragIndex, index)">
                                                <img :src="photo.url" alt="Vista previa">
                                                <button @click="removePhoto(index)">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </template>
                                        <label for="fotos-producto-edit-picker">
                                            <i class="fa-solid fa-plus"></i>
                                            <input type="file" multiple id="fotos-producto-edit-picker" accept="image/*" x-ref="fotosProductoEdit" @change="handleFileUpload($event)">
                                        </label>
                                    </div>
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
                                        <input type="text" x-ref="nombreProductoCreate" value="">
                                    </label>
                                    <label for="descripcion-producto-create">
                                        Descripción
                                        <textarea type="text" x-ref="descripcionProductoCreate"></textarea>
                                    </label>
                                    <label for="precio-producto-create">
                                        Precio
                                        <input type="text" x-ref="precioProductoCreate" value="">
                                    </label>
                                    <label for="fotos-producto-create">
                                        Fotos
                                    </label>
                                    <div class="photo-previews">
                                        <template x-for="(photo, index) in sections.productos.photos" :key="index">
                                            <div class="photo-preview" draggable="true"
                                                 @dragstart="dragIndex = index"
                                                 @dragover.prevent
                                                 @drop="reorder(dragIndex, index)">
                                                <img :src="photo.url" alt="Vista previa">
                                                <button @click="removePhoto(index)">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </template>
                                        <label for="fotos-producto-create-picker">
                                            <i class="fa-solid fa-plus"></i>
                                            <input type="file" multiple id="fotos-producto-create-picker" accept="image/*" x-ref="fotosProductoEdit" @change="handleFileUpload($event)">
                                        </label>
                                    </div>
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
                                        <p id="stock-producto"
                                            x-text="countQuantityProductions(sections.productos.details.producciones) - countQuantitySales(sections.productos.details.pedidos)">
                                            136</p>
                                    </label>
                                    <label for="produccion-producto">
                                        Producción
                                        <p id="produccion-producto"
                                            x-text="countQuantityProductions(sections.productos.details.producciones)"></p>
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
                                                    <template
                                                        x-for="(produccion, index) in sections.productos.details.producciones"
                                                        :key="index">
                                                        <tr>
                                                            <td x-text="produccion.fecha"></td>
                                                            <td x-text="produccion.cantidad"></td>
                                                            <td x-text="produccion.producto.nombre"></td>
                                                            <td x-text="sumInsumos(produccion.insumos)"></td>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </label>
                                    <label for="ventas-producto">
                                        Ventas
                                        <p id="ventas-producto"
                                            x-text="countQuantitySales(sections.productos.details.pedidos)"></p>
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
                                        <template
                                            x-if="sections.productos.rows != null && sections.productos.rows.length == 0">
                                            <tbody>
                                                <tr>
                                                    <td colspan="8">No hay productos</td>
                                                </tr>
                                            </tbody>
                                        </template>
                                        <template
                                            x-if="sections.productos.rows != null && sections.productos.rows.length != 0">

                                            <tbody>
                                                <template x-for="(producto, index) in sections.productos.rows"
                                                    :key="index">
                                                    <tr @click="view(producto)">
                                                        <td x-text="producto.nombre"></td>
                                                        <td
                                                            x-text="countQuantityProductions(producto.producciones) - countQuantitySales(producto.pedidos)">
                                                            100</td>
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
                                                                <i @click.stop="destroy(producto.id)"
                                                                    class="fa-solid fa-trash-can"></i>
                                                                <i @click.stop="edit(producto)"
                                                                    class="fa-solid fa-pen-to-square"></i>
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
                    <template x-if="section== 'ventas'">
                        <div class="ventas management-section">
                            <template x-if="subsection=='edit'">
                                <div class="edit">
                                    <label for="estado-pedido-edit">
                                        Estado del pedido
                                        <select x-ref="estadoPedidoEdit">
                                            <option :selected="sections.ventas.details.estado== 'pendiente'" value="pendiente">Pendiente</option>
                                            <option :selected="sections.ventas.details.estado== 'enviado'" value="enviado">Enviado</option>
                                            <option :selected="sections.ventas.details.estado== 'completado'" value="completado">Completado</option>
                                            <option :selected="sections.ventas.details.estado== 'cancelado'" value="cancelado">Cancelado</option>
                                        </select>
                                        
                                    <div class="buttons">
                                        <div class="btn green" @click="update()">Actualizar</div>
                                        <div class="btn grey" @click="goBack()">Descartar</div>
                                    </div>
                                </div>
                            </template>
                            <template x-if="subsection=='create'">
                                <div class="create">
                                    <label for="fecha-pedido-create">
                                        Fecha del pedido
                                        <p><small>(Esta fecha es tentativa)</small></p>
                                        <div class="datetime">
                                            <input disabled type="datetime-local" x-ref="fechaPedidoCreate" :value="new Date().toISOString().slice(0, 19)">
                                        </div>
                                    </label>
                                    <label for="estado-pedido-create">
                                        Estado del pedido
                                        <select x-ref="estadoPedidoCreate">
                                            <option value="pendiente">Pendiente</option>
                                            <option value="enviado">Enviado</option>
                                            <option value="completado">Completado</option>
                                            <option value="cancelado">Cancelado</option>
                                        </select>
                                    </label>
                                    <label for="cliente-pedido-create">
                                        Cliente
                                        <input type="number" x-ref="clientePedidoCreate" placeholder="ID del cliente" :value="{{ Auth::user()->id }}">
                                    </label>
                                    <label for="productos-pedido-create">
                                        Productos
                                        <div class="productos-list">
                                            <template x-for="product in sections.ventas.availableProducts" :key="product.id">
                                                <div class="producto-item">
                                                    <input type="checkbox" :id="`producto-${product.id}`" :value="product.id" x-model="sections.ventas.selectedProducts">
                                                    <label :for="`producto-${product.id}`">
                                                        <span x-text="product.nombre"></span>
                                                        <input type="number" placeholder="Cantidad" x-model="sections.ventas.productQuantities[product.id]" min="1">
                                                    </label>
                                                </div>
                                            </template>
                                        </div>
                                    </label>
                                    <div class="buttons">
                                        <div class="btn green" @click="add()">Crear</div>
                                        <div class="btn grey" @click="goBack()">Descartar</div>
                                    </div>
                                </div>
                            </template>
                            <template x-if="subsection=='view'">
                                <div class="view">
                                    <label for="fecha-pedido">
                                        Fecha
                                        <p id="fecha-pedido" x-text="sections.ventas.details.fecha"></p>
                                    </label>
                                    <label for="estado-pedido">
                                        Estado
                                        <p id="estado-pedido" x-text="sections.ventas.details.estado"></p>
                                    </label>
                                    <label for="cliente-pedido">
                                        Cliente
                                        <p id="cliente-pedido" x-text="sections.ventas.details.user.name"></p>
                                    </label>
                                    <label for="detalles-productos-pedido">
                                        Detalles productos
                                        <div class="table">
                                            <table class="productos-table">
                                                <thead>
                                                    <tr>
                                                        <th>Producto</th>
                                                        <th>Cantidad</th>
                                                        <th>Importe</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <template x-for="(producto, index) in sections.ventas.details.productos" :key="index">
                                                        <tr>
                                                            <td x-text="producto.nombre"></td>
                                                            <td x-text="producto.pivot.cantidad"></td>
                                                            <td x-text="producto.pivot.importe"></td>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </label>
                                    <label for="total-pedido">
                                        Total
                                        <p id="total-pedido" x-text="getTotalProducts(sections.ventas.details.productos)"></p>
                                    </label>
                                </div>
                            </template>
                            <template x-if="subsection=='index'">
                                <div class="table">
                                    <table class="pedidos-table">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Cantidad</th>
                                                <th>Estado</th>
                                                <th>Cliente</th>
                                                <th>Importe</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <template x-if="sections.ventas.rows == null">
                                            <tbody>
                                                <tr>
                                                    <td colspan="8">Cargando</td>
                                                </tr>
                                            </tbody>
                                        </template>
                                        <template x-if="sections.ventas.rows != null && sections.ventas.rows.length == 0">
                                            <tbody>
                                                <tr>
                                                    <td colspan="8">No hay ventas</td>
                                                </tr>
                                            </tbody>
                                        </template>
                                        <template x-if="sections.ventas.rows != null && sections.ventas.rows.length != 0">
                                            <tbody>
                                                <template x-for="(pedido, index) in sections.ventas.rows"
                                                    :key="index">
                                                    <tr @click="view(pedido)">
                                                        <td x-text="pedido.fecha"></td>
                                                        <td x-text="getListQuantitiesProducts(pedido.productos)"></td>
                                                        <td x-text="pedido.estado"></td>
                                                        <td x-text="pedido.user.name"></td>
                                                        <td x-text="getTotalProducts(pedido.productos)"></td>
                                                        <td>
                                                            <div class="actions">
                                                                <i @click.stop="destroy(pedido.id)"
                                                                    class="fa-solid fa-trash-can"></i>
                                                                <i @click.stop="edit(pedido)"
                                                                    class="fa-solid fa-pen-to-square"></i>
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
                    <template x-if="section == 'produccion'">
                        <div class="producciones management-section">

                            <template x-if="subsection=='edit'">
                                <div class="edit">
                                    <label for="fecha-produccion-edit">
                                        Fecha
                                        <input type="date" x-ref="fechaProduccionEdit" :value="sections.produccion.details.fecha">
                                    </label>
                                    <label for="cantidad-produccion-edit">
                                        Cantidad
                                        <input type="number" x-ref="cantidadProduccionEdit" :value="sections.produccion.details.cantidad">
                                    </label>
                                    <label for="producto-produccion-edit">
                                        Producto
                                        <select x-ref="productoProduccionEdit">
                                            <template x-for="producto in sections.productos.rows" :key="producto.id">
                                                <option :value="producto.id" x-text="producto.nombre" :selected="producto.id == sections.produccion.details.producto.id"></option>
                                            </template>
                                        </select>
                                    </label>
                                    <label for="proceso-produccion-edit" @change="setProcesoInsumos">
                                        Proceso
                                        <select x-ref="procesoProduccionEdit">
                                            <option hidden disabled selected value="">Selecciona un proceso</option>
                                            <template x-for="proceso in sections.procesos.rows" :key="proceso.id">
                                                <option :value="proceso.id" x-text="proceso.nombre" :selected="proceso.id == sections.produccion.details.proceso.id"></option>
                                            </template>
                                        </select>
                                    </label>
                                    <label for="insumos-produccion-edit">
                                        Insumos
                                        <div class="insumos-list">
                                            <template x-for="(insumo, index) in sections.produccion.selectedInsumos" :key="index">
                                                <div class="insumo-item">
                                                    <select :id="`insumo-${index}`" x-model="insumo.insumo_id">
                                                        <option value="" disabled>Seleccione un insumo</option>
                                                        <template x-for="insumoOption in sections.insumos.rows" :key="insumoOption.id">
                                                            <option :value="insumoOption.id" x-text="insumoOption.nombre" :disabled="sections.produccion.selectedInsumos.some((i, idx2) => i.insumo_id === insumoOption.id && idx2 !== index)"></option>
                                                        </template>
                                                    </select>
                                                    <input type="number" placeholder="Cantidad usada" x-model="insumo.cantidad_usada" min="1">
                                                    <button type="button" class="btn red" @click="removeInsumo(index)">Eliminar</button>
                                                </div>
                                            </template>
                                            <button type="button" class="btn green" @click="addInsumo()">Agregar Insumo</button>
                                        </div>
                                    </label>
                                    <div class="buttons">
                                        <div class="btn green" @click="update()">Actualizar</div>
                                        <div class="btn grey" @click="goBack()">Descartar</div>
                                    </div>
                                </div>
                            </template>
                            <template x-if="subsection=='create'">
                                <div class="create">
                                    <label for="fecha-produccion-create">
                                        Fecha
                                        <input type="date" x-ref="fechaProduccionCreate" value="">
                                    </label>
                                    <label for="cantidad-produccion-create">
                                        Cantidad
                                        <input type="number" x-ref="cantidadProduccionCreate" value="">
                                    </label>
                                    <label for="producto-produccion-create">
                                        Producto
                                        <select x-ref="productoProduccionCreate">
                                            <template x-for="producto in sections.productos.rows" :key="producto.id">
                                                <option :value="producto.id" x-text="producto.nombre"></option>
                                            </template>
                                        </select>
                                    </label>
                                    <label for="proceso-produccion-create" @change="setProcesoInsumos">
                                        Proceso
                                        <select x-ref="procesoProduccionCreate">
                                            <option hidden disabled selected value="">Selecciona un proceso</option>
                                            <template x-for="proceso in sections.procesos.rows" :key="proceso.id">
                                                <option :value="proceso.id" x-text="proceso.nombre"></option>
                                            </template>
                                        </select>
                                    </label>
                                    <label for="insumos-produccion-create">
                                        Insumos
                                        <div class="insumos-list">
                                            <template x-for="(insumo, index) in sections.produccion.selectedInsumos" :key="index">
                                                <div class="insumo-item">
                                                    <select :id="`insumo-${index}`" x-model.number="insumo.insumo_id">
                                                        <option value="" disabled hidden selected>Seleccione un insumo</option>
                                                        <template x-for="insumoOption in sections.insumos.rows" :key="insumoOption.id">
                                                            <option 
                                                                :value="insumoOption.id * 1" 
                                                                x-text="insumoOption.nombre"
                                                                :disabled="sections.produccion.selectedInsumos.some((i, idx2) => i.insumo_id === insumoOption.id && idx2 !== index)">
                                                            </option>
                                                        </template>
                                                    </select>
                                                    <input type="number" placeholder="Cantidad usada" x-model="insumo.cantidad_usada" min="1">
                                                    <button type="button" class="btn red" @click="removeInsumo(index)">Eliminar</button>
                                                </div>
                                            </template>
                                            <button type="button" class="btn green" @click="addInsumo()">Agregar Insumo</button>
                                        </div>
                                    </label>
                                    <div class="buttons">
                                        <div class="btn green" @click="add()">Crear</div>
                                        <div class="btn grey" @click="goBack()">Descartar</div>
                                    </div>
                                </div>
                            </template>
                        <template x-if="subsection=='view'">
                            <div class="view">
                                <label for="fecha-produccion">
                                    Fecha
                                    <p id="fecha-produccion" x-text="sections.produccion.details.fecha"></p>
                                </label>
                                <label for="cantidad-produccion">
                                    Cantidad
                                    <p id="cantidad-produccion" x-text="sections.produccion.details.cantidad"></p>
                                </label>
                                <label for="producto-produccion">
                                    Producto
                                    <p id="producto-produccion" x-text="sections.produccion.details.producto.nombre"></p>
                                </label>
                                <label for="usuario-produccion">
                                    Usuario
                                    <p id="usuario-produccion" x-text="sections.produccion.details.user.name"></p>
                                </label>
                                <label for="detalles-insumos-produccion">
                                    Detalles insumos
                                    <div class="table">
                                        <table class="productos-table">
                                            <thead>
                                                <tr>
                                                    <th>Insumo</th>
                                                    <th>Cantidad Usada</th>
                                                    <th>Precio Unitario</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template x-for="(insumo, index) in sections.produccion.details.insumos" :key="index">
                                                    <tr>
                                                        <td x-text="insumo.nombre"></td>
                                                        <td x-text="insumo.pivot.cantidad_usada"></td>
                                                        <td x-text="insumo.pivot.precio_unitario"></td>
                                                        <td x-text="(insumo.pivot.cantidad_usada * insumo.pivot.precio_unitario).toFixed(2)"></td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </label>
                                <label for="total-produccion">
                                    Total Costo
                                    <p id="total-produccion" x-text="getTotalInsumos(sections.produccion.details.insumos)"></p>
                                </label>
                            </div>
                        </template>
                        <template x-if="subsection=='index'">
                            <div class="table">
                                <table class="pedidos-table">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Cantidad</th>
                                            <th>Usuario</th>
                                            <th>Producto</th>
                                            <th>Insumos</th>
                                            <th>Costo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <template x-if="sections.produccion.rows == null">
                                        <tbody>
                                            <tr>
                                                <td colspan="8">Cargando</td>
                                            </tr>
                                        </tbody>
                                    </template>
                                    <template x-if="sections.produccion.rows != null && sections.produccion.rows.length == 0">
                                        <tbody>
                                            <tr>
                                                <td colspan="8">No hay producciones</td>
                                            </tr>
                                        </tbody>
                                    </template>
                                    <template x-if="sections.produccion.rows != null && sections.produccion.rows.length != 0">
                                        <tbody>
                                            <template x-for="(produccion, index) in sections.produccion.rows"
                                                :key="index">
                                                <tr @click="view(produccion)">
                                                    <td x-text="produccion.fecha"></td>
                                                    <td x-text="produccion.cantidad"></td>
                                                    <td x-text="produccion.user.name"></td>
                                                    <td x-text="produccion.producto.nombre"></td>
                                                    <td x-text="getListQuantitiesInsumos(produccion.insumos)"></td>
                                                    <td x-text="getTotalInsumos(produccion.insumos)"></td>
                                                    <td>
                                                        <div class="actions">
                                                            <i @click.stop="destroy(produccion.id)"
                                                                class="fa-solid fa-trash-can"></i>
                                                            <i @click.stop="edit(produccion)"
                                                                class="fa-solid fa-pen-to-square"></i>
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
                    <template x-if="section == 'procesos'">
                        <div class="procesos management-section">

                            <template x-if="subsection=='edit'">
                                <div class="edit">
                                    <form @submit.prevent="updateProceso()">
                                        <label>Nombre del Proceso
                                            <input type="text" x-ref="nombreProcesoEdit" :value="sections.procesos.details.nombre" required>
                                        </label>
                                        <label>Descripción
                                            <textarea x-ref="descripcionProcesoEdit" required x-text="sections.procesos.details.descripcion"></textarea>
                                        </label>
                                        <!-- Step Manager (Edit) -->
                                        <div class="step-generator">
                                            <h2>Paso a paso del proceso</h2>
                                            <template x-for="(step, idx) in sections.procesos.steps" :key="idx">
                                                <div class="step-row" :class="{ dragging: dragStepIndex === idx }"
                                                    @dragover.prevent
                                                    @drop="reorderStep(dragStepIndex, idx); dragStepIndex = null">
                                                    <span class="drag-handle" style="cursor:grab"
                                                        draggable="true"
                                                        @dragstart="dragStepIndex = idx"
                                                        @dragend="dragStepIndex = null">
                                                        ↕
                                                    </span>
                                                    <input type="text" x-model="step.text" placeholder="Descripción del paso" required>
                                                    <select x-model="step.type">
                                                        <option value="simple">Simple</option>
                                                        <option value="checklist">Checklist</option>
                                                        <option value="time">Tiempo</option>
                                                    </select>
                                                    <!-- Type-specific fields -->
                                                    <template x-if="step.type === 'checklist'">
                                                        <input type="text" x-model="step.items" placeholder="Ítems (separados por coma)">
                                                    </template>
                                                    <template x-if="step.type === 'time'">
                                                        <input type="number" x-model="step.duration" placeholder="Duración (minutos)">
                                                    </template>
                                                    <button type="button" @click="removeStep(idx)"><i class="fa-solid fa-trash"></i></button>
                                                </div>
                                            </template>
                                            <button type="button" class="add-step" @click="addStep()">
                                                <i class="fa-solid fa-plus"></i> Agregar paso
                                            </button>
                                        </div>
                                        <!-- Insumo Editor for Proceso (Edit) -->
                                        <label for="insumos-proceso-edit">
                                            Insumos
                                            <div class="insumos-list">
                                                <template x-for="(insumo, index) in sections.procesos.selectedInsumos" :key="index">
                                                    <div class="insumo-item">
                                                        <select :id="`insumo-proceso-edit-${index}`" x-model.number="insumo.insumo_id">
                                                            <option value="" disabled hidden selected>Seleccione un insumo</option>
                                                            <template x-for="insumoOption in sections.insumos.rows" :key="insumoOption.id">
                                                                <option :value="insumoOption.id" x-text="insumoOption.nombre" :disabled="sections.procesos.selectedInsumos.some((i, idx2) => i.insumo_id === insumoOption.id && idx2 !== index)"></option>
                                                            </template>
                                                        </select>
                                                        <input type="number" placeholder="Cantidad" x-model.number="insumo.quantity" min="1">
                                                        <button type="button" class="btn red" @click="removeProcesoInsumo(index)">Eliminar</button>
                                                    </div>
                                                </template>
                                                <button type="button" class="btn green" @click="addProcesoInsumo()">Agregar Insumo</button>
                                            </div>
                                        </label>
                                        <button type="submit" class="save-proceso">Actualizar Proceso</button>
                                    </form>
                                </div>
                            </template>
                            <template x-if="subsection=='create'">
                                <div class="create">
                                    <form @submit.prevent="addProceso()">
                                        <label>Nombre del Proceso
                                            <input type="text" x-ref="nombreProcesoCreate" required>
                                        </label>
                                        <label>Descripción
                                            <textarea x-ref="descripcionProcesoCreate" required></textarea>
                                        </label>
                                        <!-- Step Generator -->
                                        <div class="step-generator">
                                            <h2>Paso a paso del proceso</h2>
                                            <template x-for="(step, idx) in sections.procesos.steps" :key="idx">
                                                <div class="step-row" :class="{ dragging: dragStepIndex === idx }" draggable="true"
                                                    @dragstart="dragStepIndex = idx"
                                                    @dragover.prevent
                                                    @drop="reorderStep(dragStepIndex, idx); dragStepIndex = null">
                                                    <span class="drag-handle" style="cursor:grab"
                                                        draggable="true"
                                                        @dragstart="dragStepIndex = idx"
                                                        @dragend="dragStepIndex = null">
                                                        ↕
                                                    </span>
                                                    <input type="text" x-model="step.text" placeholder="Descripción del paso" required>
                                                    <select x-model="step.type">
                                                        <option value="simple">Simple</option>
                                                        <option value="checklist">Checklist</option>
                                                        <option value="time">Tiempo</option>
                                                    </select>
                                                    <!-- Type-specific fields -->
                                                    <template x-if="step.type === 'checklist'">
                                                        <input type="text" x-model="step.items" placeholder="Ítems (separados por coma)">
                                                    </template>
                                                    <template x-if="step.type === 'time'">
                                                        <input type="number" x-model="step.duration" placeholder="Duración (minutos)">
                                                    </template>
                                                    <button type="button" @click="removeStep(idx)"><i class="fa-solid fa-trash"></i></button>
                                                </div>
                                            </template>
                                            <button type="button" class="add-step" @click="addStep()">
                                                <i class="fa-solid fa-plus"></i> Agregar paso
                                            </button>
                                        </div>
                                        <!-- Insumo Editor for Proceso (Create) -->
                                        <label for="insumos-proceso-create">
                                            Insumos
                                            <div class="insumos-list">
                                                <template x-for="(insumo, index) in sections.procesos.selectedInsumos" :key="index">
                                                    <div class="insumo-item">
                                                        <select :id="`insumo-proceso-create-${index}`" x-model.number="insumo.insumo_id">
                                                            <option value="" disabled hidden selected>Seleccione un insumo</option>
                                                            <template x-for="insumoOption in sections.insumos.rows" :key="insumoOption.id">
                                                                <option :value="insumoOption.id" x-text="insumoOption.nombre" :disabled="sections.procesos.selectedInsumos.some((i, idx2) => i.insumo_id === insumoOption.id && idx2 !== index)"></option>
                                                            </template>
                                                        </select>
                                                        <input type="number" placeholder="Cantidad" x-model.number="insumo.quantity" min="1">
                                                        <button type="button" class="btn red" @click="removeProcesoInsumo(index)">Eliminar</button>
                                                    </div>
                                                </template>
                                                <button type="button" class="btn green" @click="addProcesoInsumo()">Agregar Insumo</button>
                                            </div>
                                        </label>
                                        <button type="submit" class="save-proceso">Guardar Proceso</button>
                                    </form>
                                </div>
                            </template>
                        <template x-if="subsection=='view'">
                            <div class="view">
                                <label for="nombre-proceso">
                                    Nombre
                                    <p id="nombre-proceso" x-text="sections.procesos.details.nombre"></p>
                                </label>
                                <label for="descripcion-proceso">
                                    Descripción
                                    <p id="descripcion-proceso" x-text="sections.procesos.details.descripcion"></p>
                                </label>
                                <label for="steps-proceso">
                                    Pasos
                                    <div class="table">
                                        <table class="productos-table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Tipo</th>
                                                    <th>Detalle</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template x-for="(step, index) in (Array.isArray(sections.procesos.details.steps) ? sections.procesos.details.steps : JSON.parse(sections.procesos.details.steps))" :key="index">
                                                    <tr>
                                                        <td x-text="index + 1"></td>
                                                        <td x-text="step.type"></td>
                                                        <td>
                                                            <template x-if="step.type == 'simple'">
                                                                <span x-text="step.text"></span>
                                                            </template>
                                                            <template x-if="step.type == 'checklist'">
                                                                <span>
                                                                    <span x-text="step.text"></span>
                                                                    <ul style='margin:0; padding-left:1em;'>
                                                                        <template x-for="(item, idx) in step.items" :key="idx">
                                                                            <li><span x-text="item[0]"></span> <span x-text="item[1] ? '✔️' : ''"></span></li>
                                                                        </template>
                                                                    </ul>
                                                                </span>
                                                            </template>
                                                            <template x-if="step.type == 'time'">
                                                                <span>
                                                                    <span x-text="step.text"></span> -
                                                                    <span x-text="formatTime ? formatTime(step.milliseconds) : step.milliseconds + ' ms'"></span>
                                                                </span>
                                                            </template>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </label>
                                <label for="insumos-proceso">
                                    Insumos
                                    <div class="table">
                                        <table class="productos-table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nombre</th>
                                                    <th>Cantidad</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template x-for="(insumo, index) in (Array.isArray(sections.procesos.details.insumos) ? sections.procesos.details.insumos : (sections.procesos.details.insumos ? JSON.parse(sections.procesos.details.insumos) : []))" :key="index">
                                                    <tr>
                                                        <td x-text="insumo.insumo_id"></td>
                                                        <td x-text="sections.insumos.rows ? (sections.insumos.rows.find(i => i.id == insumo.insumo_id)?.nombre ?? '-') : '-' "></td>
                                                        <td x-text="insumo.quantity"></td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </label>
                            </div>
                        </template>
                        <template x-if="subsection=='index'">
                            <div class="table">
                                <table class="pedidos-table">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Pasos</th>
                                            <th>Insumos</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <template x-if="sections.procesos.rows == null">
                                        <tbody>
                                            <tr>
                                                <td colspan="8">Cargando</td>
                                            </tr>
                                        </tbody>
                                    </template>
                                    <template x-if="sections.procesos.rows != null && sections.procesos.rows.length == 0">
                                        <tbody>
                                            <tr>
                                                <td colspan="8">No hay producciones</td>
                                            </tr>
                                        </tbody>
                                    </template>
                                    <template x-if="sections.procesos.rows != null && sections.procesos.rows.length != 0">
                                        <tbody>
                                            <template x-for="(proceso, index) in sections.procesos.rows"
                                                :key="index">
                                                <tr @click="view(proceso)">
                                                    <td x-text="proceso.nombre"></td>
                                                    <td>Detalles (<span
                                                                x-text="countProcesoSteps(proceso.steps)"></span>)</td>
                                                    <td x-text="getListQuantitiesProcesoInsumos(proceso.insumos)"></td>
                                                    <td>
                                                        <div class="actions">
                                                            <i @click.stop="destroy(produccion.id)"
                                                                class="fa-solid fa-trash-can"></i>
                                                            <i @click.stop="edit(proceso)"
                                                                class="fa-solid fa-pen-to-square"></i>
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
                    <div class="section productos" :class="section == 'productos' ? 'active' : ''"
                        @click="setSection('productos')">
                        <i class="fa-solid fa-box-open"></i>
                        <h1>Productos</h1>
                    </div>
                    <div class="section ventas" :class="section == 'ventas' ? 'active' : ''"
                        @click="setSection('ventas')">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <h1>Ventas</h1>
                    </div>
                    <div class="section produccion" :class="section == 'produccion' ? 'active' : ''"
                        @click="setSection('produccion')">
                        <i class="fa-solid fa-cubes-stacked"></i>
                        <h1>Producciones</h1>
                    </div>
                    <div class="section procesos" :class="section == 'procesos' ? 'active' : ''"
                        @click="setSection('procesos')">
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
