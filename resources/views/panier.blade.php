@extends('layouts.app')

@section('content')
<div class="container">
    <h2>🛒 Votre Panier</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($panier->isNotEmpty())
        <table class="table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($panier as $item)
                    <tr>
                        <td>{{ $item->produit->nom }}</td>
                        <td>
                            <form action="{{ route('panier.update', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="decrease">
                                <button type="submit" class="btn btn-warning btn-sm">-</button>
                            </form>

                            <span class="mx-2">{{ $item->quantite }}</span>

                            <form action="{{ route('panier.update', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="increase">
                                <button type="submit" class="btn btn-success btn-sm">+</button>
                            </form>
                        </td>
                        <td>{{ $item->produit->prix }} €</td>
                        <td>{{ $item->produit->prix * $item->quantite }} €</td>
                        <td>
                            <form action="{{ route('panier.supprimer', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Boutons en bas du panier -->
        <div class="d-flex justify-content-between">
            <a href="{{ route('produits') }}" class="btn btn-secondary">⬅ Retour aux Produits</a>
            <a href="{{ route('commande.afficher') }}" class="btn btn-primary">🛍 Commander</a>
        </div>

    @else
        <p>Votre panier est vide.</p>
        <a href="{{ route('produits') }}" class="btn btn-primary">Voir les Produits</a>
    @endif
</div>
@endsection
