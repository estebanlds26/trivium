@extends('layouts.app')

@section('title', 'Dashboard | Trivium | Cervecería Artesanal')

@section('sidebar')
<div class="link">
    <a href="#" class="active">
        <div class="link-icon">
            <i class="fa-solid fa-cart-shopping"></i>
        </div>
        <span>Tienda</span>
    </a>
</div>
<div class="link">
    <a href="#">
        <div class="link-icon">
            <i class="fa-solid fa-comments"></i>
        </div>
        <span>Contacto</span>
    </a>
</div>
<div class="link">
    <a href="#">
        <div class="link-icon">
            <i class="fa-solid fa-cog"></i>
        </div>
        <span>Configuración</span>
    </a>
</div>
<div class="link">
    <a href="#">
        <div class="link-icon">
            <i class="fa-solid fa-circle-question"></i>
        </div>
            <span>Ayuda</span>
    </a>
</div>
@endsection