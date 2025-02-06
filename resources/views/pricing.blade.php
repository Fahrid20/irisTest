@extends('layouts.app')

@section('content')

<header class="header">
    <div class="header-content">
        <h1>Promotions, Offres & Nouveautés</h1>
        <p>Découvrez des remises incroyables, des produits tendance et des exclusivités juste pour vous !</p>
    </div>
</header>

<div class="container">
    <div class="section">
        <div class="card">
            <div class="badge">-30%</div>
            <div class="image-wrapper">
                <img src="{{ asset('storage/prom.jpg') }}"  alt="Promo 1">
            </div>
            <div class="card-content">
                <h3>Offre spéciale 1</h3>
                <p>Profitez de 30% de réduction sur ce produit exceptionnel !</p>
                <div class="price"> <span class="old-price">$100</span> $70 </div>
                <a href="#" class="btn">Voir l'offre</a>
            </div>
        </div>

        <div class="card">
            <div class="badge new">Nouveau</div>
            <div class="image-wrapper">
                <img src="{{ asset('storage/prom.jpg') }}"  alt="Promo 2">
            </div>
            <div class="card-content">
                <h3>Nouveauté 2</h3>
                <p>Découvrez notre tout dernier produit tendance.</p>
                <div class="price">$120</div>
                <a href="#" class="btn">Découvrir</a>
            </div>
        </div>

        <div class="card">
            <div class="badge">1+1 Gratuit</div>
            <div class="image-wrapper">
                <img src="{{ asset('storage/prom.jpg') }}" alt="Promo 3">
            </div>
            <div class="card-content">
                <h3>Promotion spéciale 3</h3>
                <p>Achetez-en 1, obtenez-en 1 gratuit sur cette offre limitée.</p>
                <div class="price">$50</div>
                <a href="#" class="btn">En profiter</a>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const sections = document.querySelectorAll('.section');
        sections.forEach((section, index) => {
            section.style.animationDelay = `${index * 0.2}s`;
        });
    });
</script>

<style>
    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background-color: #f9f9f9;
        color: #333;
    }

    .header {
        /*background: url('https://via.placeholder.com/1500x400') center/cover no-repeat, linear-gradient(135deg, #ff6f61, #ff9966);
       */ color: white;
        padding: 4rem 1rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .header-content {
        backdrop-filter: blur(4px);
        padding: 2rem;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 12px;
        display: inline-block;
    }

    .header h1 {
        font-size: 3rem;
        margin: 0;
    }

    .header p {
        font-size: 1.3rem;
        margin-top: 1rem;
    }

    .container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .section {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        justify-content: center;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 1s forwards;
    }

    .card {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.4s, box-shadow 0.4s;
        width: calc(33.333% - 1rem);
        max-width: 320px;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    .badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #ff6f61;
        color: white;
        font-size: 0.9rem;
        padding: 0.3rem 0.8rem;
        border-radius: 4px;
        text-transform: uppercase;
        font-weight: bold;
        z-index: 10;
    }

    .badge.new {
        background: #4caf50;
    }

    .image-wrapper {
        position: relative;
        overflow: hidden;
    }

    .image-wrapper img {
        width: 100%;
        height: auto;
        transition: transform 0.4s;
    }

    .card:hover .image-wrapper img {
        transform: scale(1.1);
    }

    .card-content {
        padding: 1.5rem;
        text-align: center;
        flex-grow: 1;
    }

    .card-content h3 {
        font-size: 1.5rem;
        margin: 0.5rem 0;
        color: #333;
    }

    .card-content p {
        font-size: 1rem;
        color: #666;
        margin: 0.5rem 0 1rem;
    }

    .price {
        font-size: 1.2rem;
        color: #ff6f61;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .price .old-price {
        text-decoration: line-through;
        color: #999;
        margin-right: 0.5rem;
    }

    .btn {
        background: linear-gradient(135deg, #ff6f61, #ff9966);
        color: white;
        text-decoration: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        display: inline-block;
        transition: background 0.4s, transform 0.3s;
        font-weight: bold;
    }

    .btn:hover {
        background: linear-gradient(135deg, #ff856d, #ffaa85);
        transform: scale(1.05);
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 1024px) {
        .card {
            width: calc(50% - 1rem);
        }
    }

    @media (max-width: 768px) {
        .card {
            width: 100%;
        }

        .header h1 {
            font-size: 2.5rem;
        }

        .header p {
            font-size: 1.1rem;
        }
    }
</style>
