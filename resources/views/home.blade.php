@extends('layouts.app')

@section('content')

<div class="container my-5 d-flex flex-column align-items-center">
    <h1 class="text-center mb-4">Bienvenue sur notre boutique 🛍</h1>

    


    <!-- Section Meilleures Ventes -->
    <section class="top-ventes w-80 d-flex flex-row align-items-center mt-5">
        <h2 class="text-center mb-4">🔥 Produits les plus vendus</h2>
       
            
                @foreach($topVentes as $produit)
                    <div class="image-container">
                        <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" class="product-image">
                        <span class="product-name">{{ $produit->nom }}</span>
                        <li class="nav-item"><a class="nav-link" href="{{ route('produits') }}">Produits</a></li>
                    </div>
                @endforeach
    </section>


    <!-- Section Recommandations -->
 <section class="recommandations w-100 d-flex flex-column align-items-center">
        <h2 class="text-center mb-4">Nos Recommandations 📢</h2>

        @php
            $categories = [
                ['nom' => '📱 Téléphones', 'produits' => $telephones, 'id' => 1],
                ['nom' => '💻 PC', 'produits' => $pcs, 'id' => 2],
                ['nom' => '🎧 Accessoires', 'produits' => $accessoires, 'id' => 3]
            ];
        @endphp



    @foreach($categories as $categorie)
            <div class="category-box">
                <h3 class="category-title">{{ $categorie['nom'] }}</h3>

                <!-- Ajout de la description pour chaque catégorie -->
                @if($categorie['id'] == 1)
                <p class="category-description">
                    Les téléphones sont bien plus qu'un simple outil de communication. Ce sont des alliés indispensables dans notre quotidien, offrant une connectivité instantanée, une multitude de fonctionnalités et un design élégant. Découvrez notre sélection de téléphones, adaptés à tous les besoins, qu’il s’agisse de performance, de photographie, ou de simplicité d’utilisation.
                </p>
                @elseif($categorie['id'] == 2)
                <p class="category-description">
                    Que vous soyez un professionnel, un étudiant ou un passionné de jeux vidéo, nos ordinateurs sont conçus pour répondre à tous vos besoins. Notre collection de PC allie puissance, rapidité et design moderne, afin de vous offrir des performances exceptionnelles. 
                </p>
                @elseif($categorie['id'] == 3)
                <p class="category-description">
                    Les accessoires sont les petits éléments qui font toute la différence. Que ce soit pour personnaliser votre téléphone, améliorer votre expérience de jeu, ou optimiser vos performances au travail, nos accessoires sont conçus pour compléter parfaitement vos appareils. 
                </p>
                @endif

                <div class="scrolling-wrapper">
                    <div class="scrolling-content">
                        @foreach($categorie['produits'] as $produit)
                            <div class="image-container">
                                <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" class="product-image">
                                <span class="product-name">{{ $produit->nom }}</span>
                            </div>
                        @endforeach

                        <!-- Duplication pour un effet de boucle fluide -->
                        @foreach($categorie['produits'] as $produit)
                            <div class="image-container">
                                <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" class="product-image">
                                <span class="product-name">{{ $produit->nom }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('produits', ['categorie' => $categorie['id']]) }}" class="btn btn-primary voir-plus">Voir Plus</a>
            </div>
    @endforeach
 </section>


    <section class="why-choose-us">
        <h2 class="text-center mb-4">💡 Pourquoi Nous Choisir ?</h2>
        <div class="features">
            <div class="feature">
                <i class="fas fa-truck"></i>
                <p>Livraison Rapide 🚚</p>
            </div>
            <div class="feature">
                <i class="fas fa-lock"></i>
                <p>Paiement Sécurisé 🔒</p>
            </div>
            <div class="feature">
                <i class="fas fa-headset"></i>
                <p>Support 24/7 🎧</p>
            </div>
            <div class="feature">
                <i class="fas fa-sync"></i>
                <p>Retours Faciles 🔄</p>
            </div>
        </div>
    </section>

</div>

@endsection


<!-- CSS pour la mise en page -->
<style>

/* Style des catégories */
.category-box {
    width: 80%;
    margin-bottom: 30px;
    padding: 20px;
    border-radius: 15px;
    background-color: #1e293b;
    text-align: center;
    box-shadow: 0px 10px 30px rgba(255, 255, 255, 0.1);
    overflow: hidden;
    position: relative;
}

/* Titre des catégories */
.category-title {
    font-size: 1.8rem;
    margin-bottom: 15px;
    color: #f8fafc;
}

/* Description des catégories */
.category-description {
    font-size: 1rem;
    color: #f8fafc;
    margin-bottom: 15px;
    line-height: 1.5;
    text-align: justify;
    font-weight: 300;
}

/* Conteneur du défilement */
.scrolling-wrapper {
    display: flex;
    align-items: center;
    overflow: hidden;
    width: 100%;
    position: relative;
    white-space: nowrap;
}

/* Animation infinie des produits */
.scrolling-content {
    display: flex;
    animation: infiniteScroll 20s linear infinite;
}

/* Effet visuel */
@keyframes infiniteScroll {
    from {
        transform: translateX(0);
    }
    to {
        transform: translateX(-100%);
    }
}

/* Cloner les produits pour assurer une continuité parfaite */
.scrolling-content .image-container {
    flex: 0 0 auto;
    margin-right: 20px;
}

/* Style des images */
.product-image {
    width: 120px;
    height: auto;
    border-radius: 10px;
    transition: transform 0.3s ease;
}

.product-image:hover {
    transform: scale(1.1);
}

/* Nom du produit */
.product-name {
    display: block;
    margin-top: 10px;
    font-size: 1rem;
    font-weight: bold;
    color: #f8fafc;
}

/* Bouton Voir Plus */
.voir-plus {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 20px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    font-size: 1rem;
    font-weight: bold;
    border-radius: 8px;
    text-decoration: none;
    transition: transform 0.3s ease, background 0.3s ease;
}

.voir-plus:hover {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    transform: scale(1.05);
}

.why-choose-us {
    background-color: #1e293b;
    padding: 30px;
    border-radius: 15px;
    text-align: center;
    color: white;
    margin: 30px auto;
    width: 80%;
    max-width: 1200px;
}

/* 📌 Conteneur des avantages */
.features {
    display: flex;
    flex-wrap: wrap; /* Permet aux éléments de passer à la ligne sur petits écrans */
    justify-content: center;
    gap: 20px; /* Espacement entre les éléments */
}

/* 📌 Style de chaque avantage */
.feature {
    text-align: center;
    padding: 15px;
    flex: 1 1 200px; /* Chaque élément prend une place égale, minimum 200px */
    max-width: 250px; /* Pour éviter que les éléments soient trop larges */
}

/* 📌 Icônes */
.feature i {
    font-size: 2.5rem;
    color: #3b82f6;
    margin-bottom: 10px;
}

/* 📌 Responsivité */
@media (max-width: 768px) {
    .features {
        flex-direction: column; /* Les éléments passent en colonne */
        align-items: center; /* Centrage */
    }

    .feature {
        max-width: 100%; /* Largeur max sur mobile */
    }

    .feature i {
        font-size: 2rem; /* Réduction de la taille des icônes */
    }
}

/**** */

/* Section des meilleures ventes */
.top-ventes {
    width: 80%;
    padding: 20px;
    border-radius: 15px;
    background: #1e293b;
    text-align: center;
    box-shadow: 0px 10px 30px rgba(255, 255, 255, 0.1);
    margin-bottom: 40px;
}

/* Titre */
.top-ventes h2 {
    color: #f8fafc;
    font-size: 2rem;
    margin-bottom: 20px;
}

/* Conteneur des produits */
.top-ventes .produits-container {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 20px;
}

/* Style des cartes produits */
.image-container {
    background: rgba(255, 255, 255, 0.1);
    padding: 15px;
    border-radius: 12px;
    text-align: center;
    width: 180px;
}

/* Image du produit */
.product-image {
    width: 100%;
    border-radius: 10px;
}

/* Nom du produit */
.product-name {
    display: block;
    margin-top: 10px;
    font-size: 1rem;
    font-weight: bold;
    color: #f8fafc;
}

</style>
