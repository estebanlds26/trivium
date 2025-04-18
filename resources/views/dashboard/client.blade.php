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
        <span>Contacto</span>
    </a>
</div>
<div class="link" id="settings-link" @click="navigateToSection($event.target)">
    <a>
        <div class="link-icon">
            <i class="fa-solid fa-cog"></i>
        </div>
        <span>Configuración</span>
    </a>
</div>
<div class="link" id="help-link" @click="navigateToSection($event.target)">
    <a>
        <div class="link-icon">
            <i class="fa-solid fa-circle-question"></i>
        </div>
            <span>Ayuda</span>
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
    </template>
    <template x-if="section =='contact'">
        <a href="">asd</a>
    </template>
    <template x-if="section =='settings'">
        <a href="">3r3</a>
    </template>
    <template x-if="section =='help'">
        <a href="">F33</a>
    </template>
@endsection