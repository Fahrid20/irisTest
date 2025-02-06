@extends('layouts.app')

@section('content')

          <!-- ON AFFICHE LA CATEGORIE CHOISIE PAR L'USER -->

            @if(request()->has('categorie'))
                @php
                    $categorieId = request()->categorie;
                @endphp
                @switch($categorieId)
                    @case(1)
                        <h2 class="text-center mb-4">Produits de la catégorie : Téléphones</h2>
                        @break
                    @case(2)
                        <h2 class="text-center mb-4">Produits de la catégorie : PC</h2>
                        @break
                    @case(3)
                        <h2 class="text-center mb-4">Produits de la catégorie : Accessoires</h2>
                        @break
                    @default
                        <h2 class="text-center mb-4">Catégorie introuvable</h2>
                @endswitch
            @endif



    <!-- Barre de recherche -->
    <div class="mb-4 text-center">
        <input type="text" id="searchInput" class="form-control w-50 mx-auto" placeholder="Rechercher un produit...">
    </div>

<div class="container" style="display: flex; width: 100%; height: 100vh;">
     



    <!-- Section principale des produits -->
    <div style="flex: 0 0 100%; max-width: 100%; padding: 0; margin: 0;">
    <!-- <h1 class="text-center mb-5">Nos Produits</h1> -->
        <div  class="row justify-content-center">
            @foreach($produits as $produit)
            <div class="col-md-2 col-sm-4 col-6 mb-3" data-aos="fade-up">
                <div  data-name="{{ strtolower($produit->nom) }}"  class="card product-card shadow-sm mx-auto" style="width: 12rem; border: none; background: transparent; border-radius: 10px; overflow: hidden; position: relative;">
                    <!-- Image et détails principaux -->
                    <div class="card-image-container" style="height: 100px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                    </div>
                    <div class="card-body text-center" style="background: transparent; padding: 10px;">
                        <h5 class="card-title" style="font-size: 0.85rem; font-weight: 600; color: #ffffff;">{{ $produit->nom }}</h5>
                        <h6 class="card-subtitle mb-1 text-muted" style="font-size: 0.75rem;">Catégorie: {{ $produit->categorie }}</h6>
                        <p class="card-text" style="font-size: 0.75rem;">
                            <strong>Prix:</strong> {{ $produit->prix }} €
                        </p>

                        <form action="{{ route('panier.ajouter', ['produit_id' => $produit->id]) }}" method="POST">
                            @csrf
                            <button class="btn btn-primary mt-auto" type="submit">Ajouter au panier</button>
                        </form>

                    </div>




                    <!-- Div d'information supplémentaire -->

                    <div class="product-hover-info" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.9); color: #fff; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 15px; opacity: 1; visibility: hidden; transition: opacity 0.3s ease, visibility 0.3s ease;">
                        @if($produit->caracteristiques->isNotEmpty())
                            <strong>Caractéristiques :</strong>
                            <ul style="list-style: none; padding: 0; font-size: 0.8rem;">
                                @foreach($produit->caracteristiques as $caracteristique)
                                    <li>{{ $caracteristique->description }}</li>
                                    <li>couleur: {{ $caracteristique->couleur }}</li>
                                    <li>waterproof: {{ $caracteristique->waterproof }}</li>
                                    <li>marque :{{ $caracteristique->marque }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p style="font-size: 0.8rem;">Aucune caractéristique disponible.</p>
                        @endif
                        <form action="{{ route('panier.ajouter', ['produit_id' => $produit->id]) }}" method="POST">
                            @csrf
                            <button class="btn btn-primary mt-auto" type="submit">Ajouter au panier</button>
                        </form>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

<!-- AOS JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () { 
    AOS.init({ 
        duration: 800, 
        easing: 'ease-in-out', 
        once: true 
    }); 
 
    // Ajout du filtre de recherche 
    document.getElementById('searchInput').addEventListener('input', function () { 
        let filter = this.value.toLowerCase(); // Texte saisi 
        let products = Array.from(document.querySelectorAll('.product-card')); // Convertir en tableau 
        let productContainer = document.querySelector('.row'); // Conteneur des produits 
 
        // Filtrer les produits correspondants et non correspondants 
        let matchingProducts = []; 
        let nonMatchingProducts = []; 
 
        products.forEach(product => { 
            let name = product.getAttribute('data-name'); // Nom du produit en minuscule 
            if (name.includes(filter)) { 
                matchingProducts.push(product); // Correspond au filtre 
            } else { 
                nonMatchingProducts.push(product); // Ne correspond pas 
            } 
        }); 
 
        // Réorganiser les produits dans le DOM 
        productContainer.innerHTML = ''; // Vider le conteneur 
        matchingProducts.forEach(product => { 
            product.style.display = "block"; // Afficher les produits correspondants 
            productContainer.appendChild(product); // Les ajouter en premier 
        }); 
        nonMatchingProducts.forEach(product => { 
            product.style.display = "none"; // Afficher les produits non correspondants 
            productContainer.appendChild(product); // Les ajouter après 
        }); 
    }); 
});
</script>

<script>
    /*gestion du panier*/
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function () {
                let produitId = this.getAttribute('data-id');

                fetch('/panier/ajouter', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        produit_id: produitId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                })
                .catch(error => console.error('Erreur:', error));
            });
        });
    });
</script>


<script>

    /* POUR AFFICHER LES CARATERISTIQUES DE PRODUITS AU SURVOL*/
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.product-card').forEach(card => {
            let hoverInfo = card.querySelector('.product-hover-info');

            card.addEventListener('mouseenter', function () {
                hoverInfo.style.opacity = '1';
                hoverInfo.style.visibility = 'visible';
            });

            card.addEventListener('mouseleave', function () {
                hoverInfo.style.opacity = '0';
                hoverInfo.style.visibility = 'hidden';
            });
        });
    });
</script>


<style>
.card {
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}
.card:hover {
    transform: translateY(-10px) scale(1.05);
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.3);
}

.product-card:hover .product-hover-info {
    opacity: 1;
    visibility: visible;
}

.product-hover-info {
    border-radius: 10px;
}

/*search bare */
.search-bar {
    padding: 1rem;
    font-size: 1rem;
    border: 2px solid #007bff;
    border-radius: 25px;
    width: 50%;
    transition: all 0.3s ease;
    margin-bottom: 1rem;
}

.search-bar:focus {
    border-color: #0056b3;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
    outline: none;
}

/** add to chart */

.add-to-cart {
    background-color: #28a745;
    border: none;
    padding: 8px 12px;
    font-size: 0.8rem;
    border-radius: 5px;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.add-to-cart:hover {
    background-color: #218838;
}


.list-style{
    
    text-align: left;
}
.list-style li{
    position: left;
    text-align: left;
}
</style>
