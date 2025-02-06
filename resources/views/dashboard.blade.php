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
                            <td>{{ $commande->status }}</td>
                            <td>
                                <select class="form-control update-status" data-id="{{ $commande->id }}">
                                    <option value="en attente" {{ $commande->status == 'en attente' ? 'selected' : '' }}>En attente</option>
                                    <option value="en cours de traitement" {{ $commande->status == 'en cours de traitement' ? 'selected' : '' }}>En cours de traitement</option>
                                    <option value="envoyée" {{ $commande->status == 'envoyée' ? 'selected' : '' }}>Envoyée</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

      <!-- 📌 Section Produits -->
        <div id="produits" class="tab-pane fade">
            <h4>Gestion des Produits</h4>
            <button class="btn btn-success mb-3" id="addProductBtn">Ajouter un Produit</button>

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
</div>


@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Changer le statut de la commande via AJAX
        document.querySelectorAll('.update-status').forEach(select => {
            select.addEventListener('change', function () {
                let id = this.getAttribute('data-id');
                let status = this.value;

                fetch('/admin/commandes/' + id, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ status: status })
                }).then(response => response.json())
                  .then(data => alert('Statut mis à jour !'))
                  .catch(error => console.error(error));
            });
        });

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