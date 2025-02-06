
@extends('layouts.app')

@section('content')

<div class="container my-5 d-flex flex-column align-items-center">
    <h1 class="text-center mb-4">Bienvenue sur notre boutique 🛍</h1>

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
}
.features {
    display: flex;
    justify-content: space-around;
}
.feature {
    text-align: center;
    padding: 10px;
}
.feature i {
    font-size: 2rem;
    color: #3b82f6;
}



</style>
