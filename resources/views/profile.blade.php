@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4"> <strong>{{ $user->name }}</strong> </h1>

    <!-- Conteneur principal avec trois blocs -->
    <div class="row">
        <!-- Bloc principal -->
        <div class="col-12 mb-4">
            <div class="card shadow-lg border-0 p-4 bloc-principal">
                <div class="d-flex align-items-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="User Icon" class="me-3 bloc-principal-img">
                    <div class="w-100 text-center">
                        <h5 class="card-title mb-3">Informations personnelles</h5>
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="contact-info d-flex align-items-center flex-wrap">
                                <p class="card-text mb-0 d-flex align-items-center">
                                    <img src="https://cdn-icons-png.flaticon.com/128/480/480321.png" alt="Email Icon" class="me-2 icon">
                                    <strong>Email :</strong> 
                                    <span class="ms-2">{{ $user->email ?? 'Non renseigné' }}</span>
                                </p>
                                <span class="mx-1 separator">|</span>
                                <p class="card-text mb-0 d-flex align-items-center">
                                    <img src="https://cdn-icons-png.flaticon.com/128/37/37898.png" alt="Phone Icon" class="me-2 icon">
                                    <strong>Phone :</strong> 
                                    <span class="ms-2">{{ $userInfo->phone ?? 'Non renseigné' }}</span>
                                </p>
                                <span class="mx-1 separator">|</span>
                                <p class="card-text mb-0 d-flex align-items-center">
                                    <img src="https://cdn-icons-png.flaticon.com/128/16796/16796077.png" alt="Birthday Icon" class="me-2 icon">
                                    <strong>Birthdate :</strong> 
                                    <span class="ms-2">{{ $userInfo->birthdate ?? 'Non renseigné' }}</span>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bloc Adresse et Contact -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg border-0 p-4">
                <!-- Utilisation de d-flex pour aligner image et texte -->
                <div class="d-flex align-items-center">
                    <!-- Image alignée verticalement -->
                    <img class="imgLocalisation" src="https://cdn-icons-png.flaticon.com/128/2901/2901609.png" alt="Address Icon" 
                        class="me-3" style="width: 55px;">
                    <!-- Texte -->
                    <div class="text-center w-100">
                        <h5 class="card-title">Localisation</h5>
                        <p class="card-text">
                            <strong>Adresse :</strong> {{ $userInfo->address ?? 'Non renseigné' }} <br>
                            <strong>Ville :</strong> {{ $userInfo->city ?? 'Non renseigné' }} <br>
                            <strong>Code postal :</strong> {{ $userInfo->zip_code ?? 'Non renseigné' }} <br>
                            <strong>Pays :</strong> {{ $userInfo->country ?? 'Non renseigné' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>




        <!-- Bloc Modifier -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg border-0 p-4 text-center">
                <div class="d-flex flex-column align-items-center">
                    <img src="https://cdn-icons-png.flaticon.com/128/5722/5722705.png" alt="Edit Icon" style="width: 55px;" class="mb-3">
                    <h5 class="card-title mb-3">Mettre à jour vos informations</h5>
                    <button id="toggleFormBtn" class="btn btn-primary w-50">Modifier</button>
                </div>
                <div id="updateForm" class="mt-4 d-none">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="address">Adresse :</label>
                        <input type="text" id="address" name="address" class="form-control" 
                            value="{{ old('address', $userInfo->address) }}" placeholder="Adresse complète">
                    </div>
                    <div class="d-flex mb-3">
                        <div class="w-50 me-2">
                            <label for="phone">Téléphone :</label>
                            <input type="text" id="phone" name="phone" class="form-control" 
                                value="{{ old('phone', $userInfo->phone) }}" placeholder="Numéro de téléphone">
                        </div>
                        <div class="w-50 ms-2">
                            <label for="city">Ville :</label>
                            <input type="text" id="city" name="city" class="form-control" 
                                value="{{ old('city', $userInfo->city) }}" placeholder="Ville">
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="w-50 me-2">
                            <label for="zip_code">Code postal :</label>
                            <input type="text" id="zip_code" name="zip_code" class="form-control" 
                                value="{{ old('zip_code', $userInfo->zip_code) }}" placeholder="Code postal">
                        </div>
                        <div class="w-50 ms-2">
                            <label for="country">Pays :</label>
                            <input type="text" id="country" name="country" class="form-control" 
                                value="{{ old('country', $userInfo->country) }}" placeholder="Pays">
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="w-50 me-2">
                            <label for="birthdate">Date de naissance :</label>
                            <input type="date" id="birthdate" name="birthdate" class="form-control" 
                                value="{{ old('birthdate', $userInfo->birthdate) }}" placeholder="Date de naissance">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Enregistrer</button>
                </form>

                </div>
            </div>
        </div>


        <!-- Bloc Historique d'achat -->
        <div class="col-12 mb-4">
            <div class="card shadow-lg border-0 p-4 text-center">
                <button id="toggleHistoryBtn" class="btn btn-primary w-50">Afficher l'historique des achats</button>
                <div id="purchaseHistory" class="mt-4 d-none">
                    <h5 class="mb-3">Historique des achats</h5>
                    <form id="filterForm" class="mb-3">
                        <div class="d-flex justify-content-center">
                            <select id="monthFilter" class="form-select w-25 me-2">
                                <option value="">Tous les mois</option>
                                @foreach(range(1,12) as $month)
                                    <option value="{{ $month }}">{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                                @endforeach
                            </select>
                            <select id="yearFilter" class="form-select w-25">
                                <option value="">Toutes les années</option>
                                @foreach(range(date('Y') - 5, date('Y')) as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                </div>
            </div>
        </div>


    </div>
</div>
@endsection

<!-- Styles personnalisés -->
<style>

    /* Styles spécifiques pour rendre les blocs plus attrayants */

    /* Général */
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        background: linear-gradient(145deg, #f3f4f6, #ffffff);
        
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    }

    /* Bloc principal */
    .bloc-principal {
        background: linear-gradient(135deg, #eaf4fe, #ffffff);
        border: 1px solid #cfe2f3;
    }

    .bloc-principal .card-title {
        font-size: 1.8rem;
        color: #1a73e8;
    }

    .bloc-principal-img {
        /*border: 3px solid #1a73e8;*/
        width: 100px;
        height: 100px;
    }

    /* Localisation */
    .card .imgLocalisation {
        animation: bounce 1.5s infinite;
        width: 60px;
    }

    /* Effet de survol pour les boutons */
    .btn-primary {
        background: #007bff;
        border: none;
        padding: 10px 15px;
        border-radius: 25px;
        box-shadow: 0 4px 6px rgba(0, 123, 255, 0.2);
    }

    .btn-primary:hover {
        background: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 123, 255, 0.3);
    }

    /* Icônes avec effet de survol */
    .card img {
        transition: transform 0.3s;
    }

    /* Section des informations */
    .contact-info p {
        font-size: 1rem;
        color: #495057;
        font-weight: 500;
    }

    .contact-info .icon {
        width: 30px;
        height: 30px;
        margin-right: 10px;
    }

    /* Séparateur plus doux */
    .contact-info .separator {
        font-size: 1.2rem;
        color: #dcdcdc;
    }

    /* Formulaire de mise à jour */
    #updateForm {
        border: 1px solid #e0e0e0;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    /* Animation simple */
    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-5px);
        }
    }

    h5{
        color: #1a73e8 !important;
    }

</style>


<!-- Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleFormBtn = document.getElementById('toggleFormBtn');
        const updateForm = document.getElementById('updateForm');

        if (toggleFormBtn && updateForm) {
            toggleFormBtn.addEventListener('click', function () {
                updateForm.classList.toggle('d-none');
                console.log("Form visibility toggled:", updateForm.classList.contains('d-none') ? "hidden" : "visible");
            });
        } else {
            console.error("Button or form element not found!");
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const toggleHistoryBtn = document.getElementById('toggleHistoryBtn');
        const purchaseHistory = document.getElementById('purchaseHistory');
        const monthFilter = document.getElementById('monthFilter');
        const yearFilter = document.getElementById('yearFilter');
        const purchaseItems = document.querySelectorAll('.purchase-item');
        const totalAmount = document.getElementById('totalAmount');

        toggleHistoryBtn.addEventListener('click', function () {
            purchaseHistory.classList.toggle('d-none');
        });

        function updatePurchases() {
            let selectedMonth = monthFilter.value;
            let selectedYear = yearFilter.value;
            let total = 0;

            purchaseItems.forEach(item => {
                let itemMonth = item.getAttribute('data-month');
                let itemYear = item.getAttribute('data-year');
                let amount = parseFloat(item.textContent.match(/([0-9]+\.[0-9]+)/)[0]);
                
                if ((selectedMonth === '' || selectedMonth === itemMonth) && (selectedYear === '' || selectedYear === itemYear)) {
                    item.style.display = '';
                    total += amount;
                } else {
                    item.style.display = 'none';
                }
            });

            totalAmount.textContent = total.toFixed(2);
        }

        monthFilter.addEventListener('change', updatePurchases);
        yearFilter.addEventListener('change', updatePurchases);
    });

</script>
