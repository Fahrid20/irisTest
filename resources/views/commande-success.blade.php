@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-success text-white">
                    <h3>Commande réussie</h3>
                </div>

                <div class="card-body">
                    <p class="text-center">Félicitations, votre commande a été passée avec succès !</p>
                    
                    <h4>Détails de votre commande</h4>
                    <ul class="list-group mb-4">
                        <li class="list-group-item">
                            <strong>Numéro de commande :</strong> #{{ $commande->id }}
                        </li>
                        <li class="list-group-item">
                            <strong>Date de commande :</strong> {{ $commande->created_at->format('d/m/Y H:i') }}
                        </li>
                        <li class="list-group-item">
                            <strong>Montant total :</strong> {{ $commande->total }} €
                        </li>
                        <li class="list-group-item">
                            <strong>Adresse de livraison :</strong> {{ $commande->adresse }}
                        </li>
                        <li class="list-group-item">
                            <strong>Méthode de paiement :</strong> {{ $commande->mode_paiement }}
                        </li>
                    </ul>

                    <h4>Produits commandés</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nom du produit</th>
                                <th scope="col">Quantité</th>
                                <th scope="col">Prix unitaire</th>
                                <th scope="col">Sous-total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commande->details as $detail)
                                <tr>
                                    <td>{{ $detail->produit->nom }}</td>
                                    <td>{{ $detail->quantite }}</td>
                                    <td>{{ $detail->prix_unitaire }} €</td>
                                    <td>{{ $detail->quantite * $detail->prix_unitaire }} €</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="text-center mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary">Retour à la page d'accueil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
