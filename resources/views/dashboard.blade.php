@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Tableau de Bord Admin</h2>

    <!-- Menu de navigation -->
    <ul class="nav nav-tabs" id="adminTabs">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#commandes">Commandes</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#produits">Gestion des Produits</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#clients">Envoyer un Email</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#admins">Gestion des Admins</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#promotions">Gestion des Promotions</a></li>
    </ul>


    <div class="tab-content mt-4">

        <!-- 📌 Section Commandes -->
        <div id="commandes" class="tab-pane fade show active">
            <h4>Gestion des Commandes</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Total</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commandes as $commande)
                        <tr>
                            <td>{{ $commande->id }}</td>
                            <td>{{ $commande->user->name }}</td>
                            <td>{{ $commande->total }} €</td>
                            <td>
                                <select class="form-control update-status" data-id="{{ $commande->id }}">
                                    <option value="en attente" {{ $commande->statut == 'en attente' ? 'selected' : '' }}>En attente</option>
                                    <option value="en cours de traitement" {{ $commande->statut == 'en cours de traitement' ? 'selected' : '' }}>En cours de traitement</option>
                                    <option value="envoyée" {{ $commande->statut == 'envoyée' ? 'selected' : '' }}>Envoyée</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-info btn-details" data-id="{{ $commande->id }}">Détails</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- ✅ Bloc des détails de la commande (invisible au départ) -->
        <div id="commande-details" class="commande-details d-none">
            <button class="close-details">&times;</button> <!-- Bouton fermer -->
            <h4>Détails de la commande</h4>
            <div id="commande-content"></div>
        </div>


        <!-- 📌 Section Produits -->
<div id="produits" class="tab-pane fade">
    <h4>Gestion des Produits</h4>
    <button class="btn btn-success mb-3" id="addProductBtn">Ajouter un Produit</button>

    <!-- Formulaire de gestion des produits -->
            <div id="productManagement">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Nom</th>
                            <th>Prix (€)</th>
                            <th>Stock</th>
                            <th>Caractéristiques</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produits as $produit)
                            <tr>
                                <td><img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" style="max-height: 25%; max-width: 25%; object-fit: contain;"></td>
                                <td><input type="text" class="form-control product-name" data-id="{{ $produit->id }}" value="{{ $produit->nom }}"></td>
                                <td><input type="number" class="form-control product-price" data-id="{{ $produit->id }}" value="{{ $produit->prix }}"></td>
                                <td><input type="number" class="form-control product-stock" data-id="{{ $produit->id }}" value="{{ $produit->stock }}"></td>
                                <td>
                                    <ul class="list-group">
                                        @foreach($produit->caracteristiques as $caracteristique)
                                            <li class="list-group-item">
                                                <input type="text" class="form-control caracteristique" data-id="{{ $caracteristique->id }}" value="{{ $caracteristique->description }}">

                                                <input type="text" class="form-control caracteristique-marque" data-id="{{ $caracteristique->id }}" value="{{ $caracteristique->marque }}">

                                                <input type="text" class="form-control caracteristique-couleur" data-id="{{ $caracteristique->id }}" value="{{ $caracteristique->couleur }}">
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm update-product" data-id="{{ $produit->id }}">Valider</button>
                                    <button class="btn btn-danger btn-sm delete-product" data-id="{{ $produit->id }}">Supprimer</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Formulaire d'ajout de produit -->
            <div id="productAddForm" style="display: none;">
                <h5>Ajouter un Nouveau Produit</h5>
                <form id="addProductForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="productName">Nom du Produit</label>
                        <input type="text" id="productName" name="nom" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="productPrice">Prix (€)</label>
                        <input type="number" id="productPrice" name="prix" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="productStock">Stock</label>
                        <input type="number" id="productStock" name="stock" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="productImage">Image</label>
                        <input type="file" id="productImage" name="image" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="productCategory">Catégorie</label>
                        <select name="categorie_id" id="productCategory" class="form-control" required>
                            <option value="" disabled selected>Choisir une catégorie</option>
                            <option value="1">Téléphones</option>
                            <option value="2">PCs</option>
                            <option value="3">Accessoires</option>
                        </select>

                    </div>

                    <!-- Caractéristiques -->
                    <div id="productCaracteristics" class="form-group">
                        <h6>Caractéristiques</h6>
                        <div class="caracteristic-item">
                            <label for="caracteristicDescription">Description</label>
                            <input type="text" name="caracteristics[][description]" class="form-control" required>
                            
                            <label for="caracteristicColor">Couleur</label>
                            <input type="text" name="caracteristics[][couleur]" class="form-control" required>
                            
                            <label for="caracteristicBrand">Marque</label>
                            <input type="text" name="caracteristics[][marque]" class="form-control" required>
                            
                            <label for="caracteristicWaterproof">Waterproof</label>
                            <select name="caracteristics[][waterproof]" class="form-control" required>
                                <option value="1">Oui</option>
                                <option value="0">Non</option>
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                    <button type="button" id="cancelAddProduct" class="btn btn-secondary">Annuler</button>
                </form>
            </div>

        </div>



        <!-- 📌 Section Envoi Email -->
        <div id="clients" class="tab-pane fade">
            <h4>Envoyer un Email</h4>
            <form id="sendEmailForm" method="POST" action="{{ route('admin.sendEmail') }}">
                @csrf 
                <select name="user_id" class="form-control mb-2">
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->email }})</option>
                    @endforeach
                </select>
                <textarea name="message" class="form-control mb-2" placeholder="Votre message..."></textarea>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>

        <!-- 📌 Section Admins -->
        <div id="admins" class="tab-pane fade">
            <h4>Gestion des Admins</h4>
            <form id="addAdminForm">
                <input type="text" name="name" class="form-control mb-2" placeholder="Nom">
                <input type="email" name="email" class="form-control mb-2" placeholder="Email">
                <input type="password" name="password" class="form-control mb-2" placeholder="Mot de passe">
                <button type="submit" class="btn btn-success">Ajouter Admin</button>
            </form>
        </div>
    </div>

     <!-- 📌 Section Promotions -->
    <div id="promotions" class="tab-pane fade">
    <h4>Gestion des Promotions</h4>
    <button class="btn btn-success mb-3" id="addPromotionBtn">Ajouter une Promotion</button>
    
    <!-- Liste des promotions -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Prix Original (€)</th>
                    <th>Prix Promo (€)</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($promotions as $promotion)
                    <tr>
                        <td>{{ $promotion->id }}</td>
                        <td>{{ $promotion->titre }}</td>
                        <td>{{ $promotion->description }}</td>
                        <td>
                            @if($promotion->image)
                                <img src="{{ asset('storage/' . $promotion->image) }}" alt="{{ $promotion->titre }}" class="img-fluid" style="max-width: 100px;">
                            @endif
                        </td>
                        <td>{{ $promotion->prix_original ?? 'N/A' }}</td>
                        <td>{{ $promotion->prix_promo }}</td>
                        <td>{{ ucfirst($promotion->type) }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm edit-promotion" data-id="{{ $promotion->id }}">Modifier</button>
                            <button class="btn btn-danger btn-sm delete-promotion" data-id="{{ $promotion->id }}">Supprimer</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Formulaire d'ajout de promotion -->
    <div id="promotionAddForm" class="mt-3" style="display: none;">
        <h5>Ajouter une Nouvelle Promotion</h5>
        <form id="addPromotionForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="promotionTitle">Titre</label>
                <input type="text" id="promotionTitle" name="titre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="promotionDescription">Description</label>
                <textarea id="promotionDescription" name="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="promotionImage">Image</label>
                <input type="file" id="promotionImage" name="image" class="form-control">
            </div>
            <div class="form-group">
                <label for="promotionOriginalPrice">Prix Original (€)</label>
                <input type="number" step="0.01" id="promotionOriginalPrice" name="prix_original" class="form-control">
            </div>
            <div class="form-group">
                <label for="promotionPrice">Prix Promo (€)</label>
                <input type="number" step="0.01" id="promotionPrice" name="prix_promo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="promotionType">Type</label>
                <select name="type" id="promotionType" class="form-control" required>
                    <option value="remise">Remise</option>
                    <option value="nouveau">Nouveau</option>
                    <option value="offre speciale">Offre Spéciale</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
            <button type="button" id="cancelAddPromotion" class="btn btn-secondary">Annuler</button>
        </form>
    </div>
</div>



@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif





@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {




        // Suppression d'un produit
    document.querySelectorAll('.delete-product').forEach(button => {
        button.addEventListener('click', function () {
            let id = this.getAttribute('data-id');

            if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ? Cette action est irréversible.')) {
                fetch(`/admin/produits/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur lors de la suppression');
                    }
                    return response.json();
                }).then(data => {
                    alert('✅ Produit supprimé avec succès');
                    location.reload();
                }).catch(error => {
                    console.error('❌ Erreur:', error);
                    alert('❌ Impossible de supprimer le produit');
                });
            }
        });
    });

        // Ajout d’un Admin
            document.getElementById('addAdminForm').addEventListener('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            fetch('{{ route("admin.addAdmin") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors de l’ajout');
                }
                return response.json();
            })
            .then(data => {
                alert('✅ Admin ajouté avec succès');
                location.reload(); // Recharge la page pour voir la mise à jour
            })
            .catch(error => {
                console.error('❌ Erreur:', error);
                alert('❌ Impossible d’ajouter l’admin');
            });
        });
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
    
        // ✅ Mise à jour des informations produit (Nom, Prix, Stock, Caractéristiques, Marque, Couleur)
    document.querySelectorAll('.update-product').forEach(button => {
        button.addEventListener('click', function () {
            let id = this.getAttribute('data-id');
            let name = document.querySelector(`.product-name[data-id='${id}']`).value;
            let price = document.querySelector(`.product-price[data-id='${id}']`).value;
            let stock = document.querySelector(`.product-stock[data-id='${id}']`).value;

            let caracteristiques = [];
            document.querySelectorAll(`.caracteristique[data-id]`).forEach(input => {
                let caracId = input.getAttribute('data-id');
                let marque = document.querySelector(`.caracteristique-marque[data-id='${caracId}']`).value;
                let couleur = document.querySelector(`.caracteristique-couleur[data-id='${caracId}']`).value;

                caracteristiques.push({
                    id: caracId,
                    description: input.value,
                    marque: marque,
                    couleur: couleur
                });
            });

            fetch(`/admin/produits/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ 
                    nom: name, 
                    prix: price, 
                    stock: stock,
                    caracteristiques: caracteristiques 
                })
            }).then(response => response.json())
              .then(data => {
                  alert('✅ Produit mis à jour avec succès !');
                  location.reload();
              }).catch(error => {
                  console.error('❌ Erreur:', error);
                  alert('❌ Erreur lors de la mise à jour');
              });
        });
    });




    // 🗑️ Suppression d'un produit
    document.querySelectorAll('.delete-product').forEach(button => {
        button.addEventListener('click', function () {
            let id = this.getAttribute('data-id');

            fetch(`/admin/produits/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => response.json())
              .then(data => {
                  alert('Produit supprimé');
                  location.reload();
              }).catch(error => console.error(error));
        });
    });

});


</script>

<script>
    //changer statut bcommande
document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('change', async function (event) {
        if (event.target.classList.contains('update-status')) {
            let id = event.target.getAttribute('data-id');
            let statut = event.target.value.trim();
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            console.log("✅ Changement détecté !");
            console.log("🆔 Commande ID :", id);
            console.log("📌 Statut sélectionné :", `"${statut}"`);

            if (!id || !statut) {
                console.error("❌ Erreur : ID ou statut invalide !");
                showError("❌ ID ou statut invalide !");
                return;
            }

            try {
                let response = await fetch(`/admin/commandes/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ statut: statut })
                });

                console.log("🔄 Statut HTTP :", response.status); // 🔥 Log du code HTTP

                if (!response.ok) {
                    let errorText = await response.text();
                    throw new Error(`Erreur HTTP ${response.status} : ${errorText}`);
                }

                let data = await response.json();
                console.log("🟢 Réponse serveur :", data);

                if (data.error) {
                    throw new Error(data.error);
                }

                alert('✅ Statut mis à jour avec succès !');
            } catch (error) {
                console.error('❌ Erreur AJAX détaillée :', error);

                // Afficher l'erreur dans l'élément HTML pour la copier
                showError(`❌ Erreur AJAX détaillée :\n${error.message}\n\nStack trace :\n${error.stack}`);
            }
        }
    });
});



</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Gérer l'affichage des blocs
    document.getElementById('addProductBtn').addEventListener('click', function () {
        document.getElementById('productManagement').style.display = 'none';
        document.getElementById('productAddForm').style.display = 'block';
    });

    document.getElementById('cancelAddProduct').addEventListener('click', function () {
        document.getElementById('productAddForm').style.display = 'none';
        document.getElementById('productManagement').style.display = 'block';
    });

    // Gérer l'ajout de produit via JSON et image
    document.getElementById('addProductForm').addEventListener('submit', function (e) {
        e.preventDefault();  // Empêcher l'envoi du formulaire de manière classique

        // Récupérer les données du formulaire
        let name = document.getElementById('productName').value;
        let price = document.getElementById('productPrice').value;
        let stock = document.getElementById('productStock').value;
        let imageFile = document.getElementById('productImage').files[0];  // Image du produit
        let category = document.getElementById('productCategory').value;
        console.log(category)
        // Gérer les caractéristiques
        let caracteristics = [];
        document.querySelectorAll('.caracteristic-item').forEach(item => {
            let description = item.querySelector('input[name="caracteristics[][description]"]').value;
            let couleur = item.querySelector('input[name="caracteristics[][couleur]"]').value;
            let marque = item.querySelector('input[name="caracteristics[][marque]"]').value;
            let waterproof = item.querySelector('select[name="caracteristics[][waterproof]"]').value;

            caracteristics.push({
                description: description,
                couleur: couleur,
                marque: marque,
                waterproof: waterproof
            });
        });

        // Créer un objet FormData pour envoyer l'image vers le serveur
        let formData = new FormData();
        formData.append('image', imageFile);

        // Créer l'objet de données JSON pour les autres informations
        let productData = {
            nom: name,
            prix: price,
            stock: stock,
            categorie_id: category,
            caracteristics: caracteristics
        };

        // Ajouter les données JSON dans FormData
        formData.append('data', JSON.stringify(productData));

        // Envoi de l'image et des autres données
        fetch('/admin/produits', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData  // On envoie FormData, car il contient l'image et les autres données
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ Produit ajouté avec succès !');
                location.reload();  // Recharger la page pour afficher le nouveau produit
            } else {
                // Vérifier si l'erreur est un objet
                if (data.error && typeof data.error === 'object') {
                    let errorMessage = '';
                    for (const [key, value] of Object.entries(data.error)) {
                        errorMessage += `${key}: ${value.join(', ')}\n`;
                    }
                    alert('❌ Erreur lors de l\'ajout du produit : \n' + errorMessage);
                } else {
                    alert('❌ Erreur lors de l\'ajout du produit : ' + data.error);
                }
            }
        })
        .catch(error => {
            console.error('❌ Erreur:', error);
            alert('❌ Impossible d’ajouter le produit. Veuillez vérifier la console pour plus d\'informations.');
        });
    });
});




</script>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Afficher le formulaire d'ajout de promotion
        document.getElementById('addPromotionBtn').addEventListener('click', function() {
            document.getElementById('promotionAddForm').style.display = 'block';  // Afficher le formulaire
            document.getElementById('productManagement').style.display = 'none'; // Masquer la gestion des produits
            document.getElementById('promotions').style.display = 'block';        // Masquer la liste des promotions
        });

        // Annuler l'ajout de promotion et revenir à la gestion des produits
        document.getElementById('cancelAddPromotion').addEventListener('click', function() {
            document.getElementById('promotionAddForm').style.display = 'none';  // Masquer le formulaire
            document.getElementById('productManagement').style.display = 'block'; // Afficher la gestion des produits
            document.getElementById('promotions').style.display = 'block';        // Afficher la liste des promotions
        });

        // Soumettre le formulaire d'ajout de promotion via AJAX
        document.getElementById('addPromotionForm').addEventListener('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route('admin.storePromotion') }}', true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert(response.success);
                        document.getElementById('promotionAddForm').style.display = 'none';  // Masquer le formulaire
                        document.getElementById('productManagement').style.display = 'block'; // Afficher la gestion des produits
                        document.getElementById('promotions').style.display = 'block';       // Afficher la liste des promotions

                        // Ajouter la nouvelle promotion dans la table
                        var newPromotion = `
                            <tr>
                                <td>${response.promotion.id}</td>
                                <td>${response.promotion.titre}</td>
                                <td>${response.promotion.description}</td>
                                <td><img src="{{ asset('storage') }}/${response.promotion.image}" style="max-width: 100px;"></td>
                                <td>${response.promotion.prix_original ?? 'N/A'}</td>
                                <td>${response.promotion.prix_promo}</td>
                                <td>${response.promotion.type}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm edit-promotion" data-id="${response.promotion.id}">Modifier</button>
                                    <button class="btn btn-danger btn-sm delete-promotion" data-id="${response.promotion.id}">Supprimer</button>
                                </td>
                            </tr>
                        `;
                        // Ajouter la nouvelle promotion en haut de la table
                        document.querySelector('table tbody').insertAdjacentHTML('afterbegin', newPromotion);
                    } else {
                        alert('Une erreur est survenue');
                    }
                } else {
                    alert('Une erreur est survenue');
                }
            };

            xhr.onerror = function() {
                alert('Une erreur est survenue');
            };

            xhr.send(formData);
        });
    });
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const detailsModal = document.getElementById("commande-details");
    const detailsContent = document.getElementById("commande-content");
    const closeDetails = document.querySelector(".close-details");

    // ✅ Événement pour afficher les détails de la commande
    document.querySelectorAll(".btn-details").forEach(button => {
        button.addEventListener("click", function () {
            detailsModal.classList.add("d-block"); // ✅ Masquer correctement
            const commandeId = this.getAttribute("data-id");

            // 🔹 Requête AJAX pour récupérer les détails
            fetch(`/commande/details/${commandeId}`)
                .then(response => response.json())
                .then(data => {
                    // Vérifie si la réponse est correcte
                    if (!data || !data.details) {
                        detailsContent.innerHTML = "<p class='text-danger'>Erreur : Détails non disponibles.</p>";
                        return;
                    }

                    // 🔹 Générer le contenu des détails
                    let html = `<p><strong>Nom :</strong> ${data.nom}</p>`;
                    html += `<p><strong>Email :</strong> ${data.email}</p>`;
                    html += `<p><strong>Adresse :</strong> ${data.adresse}, ${data.ville}, ${data.code_postal}</p>`;
                    html += `<p><strong>Mode de paiement :</strong> ${data.mode_paiement}</p>`;
                    html += `<h5>Produits commandés :</h5>`;
                    html += `<ul class="list-group">`;
                    data.details.forEach(detail => {
                        html += `<li class="list-group-item d-flex justify-content-between">
                                    <span>${detail.produit.nom} x${detail.quantite}</span>
                                    <strong>${detail.prix_unitaire * detail.quantite} €</strong>
                                 </li>`;
                    });
                    html += `</ul>`;

                    // 🔹 Ajouter le contenu et afficher le bloc
                    detailsContent.innerHTML = html;
                    detailsModal.classList.remove("d-none"); // ✅ Afficher correctement
                })
                .catch(error => {
                    console.error("Erreur lors de la récupération des détails :", error);
                    detailsContent.innerHTML = "<p class='text-danger'>Une erreur est survenue.</p>";
                });
        });
    });

    // ✅ Événement pour fermer les détails
    closeDetails.addEventListener("click", function () {
        detailsModal.classList.add("d-none"); // ✅ Masquer correctement
    });
});

</script>























<style>
    .commande-details {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 50%;
    background: white;
    padding: 20px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    border-radius: 10px;
    display: none; /* Caché par défaut */
}

.close-details {
    position: absolute;
    top: 10px;
    right: 15px;
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
}

</style>
