@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Passer une commande</h2>

    <form action="{{ route('commande.passer') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Informations Personnelles -->
            <div class="col-md-6">
                <h4>Informations personnelles</h4>
                <div class="mb-3">
                    <label>Nom</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Téléphone</label>
                    <input type="text" name="telephone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Adresse</label>
                    <textarea name="adresse" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label>Ville</label>
                    <input type="text" name="ville" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Code Postal</label>
                    <input type="text" name="code_postal" class="form-control" required>
                </div>
            </div>

            <!-- Résumé de la commande -->
            <div class="col-md-6">
                <h4>Résumé de la commande</h4>
                <ul class="list-group mb-3">
                    @foreach($panier as $item)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $item->produit->nom }} x{{ $item->quantite }}</span>
                            <strong>{{ $item->produit->prix * $item->quantite }} €</strong>
                        </li>
                    @endforeach
                </ul>

                <h5 class="text-end">Total : {{ $total }} €</h5>

                <!-- Sélection du mode de paiement -->
                <h4>Mode de paiement</h4>
                <select name="mode_paiement" class="form-control" id="mode_paiement" required>
                    <option value="">-- Sélectionnez un mode de paiement --</option>
                    <option value="carte">Carte Bancaire</option>
                    <option value="paypal">PayPal</option>
                    <option value="cash">Paiement à la livraison</option>
                </select>

                <!-- Champs pour paiement par carte -->
                <div id="paiement-carte" class="mt-3 d-none">
                    <h5>Informations de la Carte</h5>
                    <div id="card-element" class="form-control"></div>
                    <div id="card-errors" class="text-danger mt-2"></div>
                </div>

                <!-- Champs pour paiement par PayPal -->
                <div id="paiement-paypal" class="mt-3 d-none">
                    <h5>Connexion PayPal</h5>
                    <div class="mb-3">
                        <label>Email PayPal</label>
                        <input type="email" name="paypal_email" class="form-control">
                    </div>
                </div>

                <!-- Message pour paiement en espèces -->
                <div id="paiement-cash" class="mt-3 d-none">
                    <p class="alert alert-info">Vous paierez en espèces à la livraison.</p>
                </div>

                <button type="submit" class="btn btn-primary mt-3 w-100">Passer la commande</button>
            </div>
        </div>
    </form>
</div>


<script src="https://js.stripe.com/v3/"></script>

<script>
   document.addEventListener("DOMContentLoaded", function () {
    const modePaiement = document.getElementById("mode_paiement");
    const paiementCarte = document.getElementById("paiement-carte");
    const paiementPaypal = document.getElementById("paiement-paypal");
    const paiementCash = document.getElementById("paiement-cash");

    // Initialisation de Stripe
    let stripe = Stripe("pk_test_51NNh6tFwHGknk4nqck1n8EPRp4UrLDXj9OyLNXho5ajKuVQsaLUTIg3vXncZjztOv5XqarktPnTkPYXS9rHFTxeE005YxHumb2");
    let elements = stripe.elements();
    let card = elements.create('card');
    card.mount('#card-element');

    // Gestion de l'affichage des modes de paiement
    modePaiement.addEventListener("change", function () {
        paiementCarte.classList.add("d-none");
        paiementPaypal.classList.add("d-none");
        paiementCash.classList.add("d-none");

        if (this.value === "carte") {
            paiementCarte.classList.remove("d-none");
        } else if (this.value === "paypal") {
            paiementPaypal.classList.remove("d-none");
        } else if (this.value === "cash") {
            paiementCash.classList.remove("d-none");
        }
    });

    // Gestion des erreurs Stripe
    card.addEventListener('change', function(event) {
        let displayError = document.getElementById('card-errors');
        displayError.textContent = event.error ? event.error.message : '';
    });

    // Gestion de la soumission du formulaire
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault();
        if (modePaiement.value === "carte") {
            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    document.getElementById('card-errors').textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        } else {
            this.submit();
        }
    });

    // Fonction pour envoyer le token Stripe au backend
    function stripeTokenHandler(token) {
        let form = document.querySelector('form');
        let hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
        form.submit();
    }
});

</script>
@endsection
