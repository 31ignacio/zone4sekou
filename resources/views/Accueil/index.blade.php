@extends('layouts.master2')

@section('content')
    @foreach ($produits as $produit)
        <tr>
            <td><span style="display:none;">{{ $produit->libelle }}</span></td>
            <td>
                <span style="display:none;">{{ $produit->stock_actuel }}</span>
                @if ($produit->stock_actuel <= 3)
                    {{-- <script src="https://unpkg.com/toastify-js"></script> --}}
                    <script src="../../../../AD/toastify-js-master/src/toastify.js"></script>

                    <script>
                        setInterval(function() {
                            Toastify({
                                text: "Le stock de {{ $produit->libelle }} est faible (Moins de 3 bouteilles).",
                                duration: 8000,
                                close: true,
                                gravity: "top", // Position du toast
                                backgroundColor: "#b30000",
                            }).showToast();
                        }, 2000000); // 5000 millisecondes correspondent à 5 secondes
                    </script>
                @endif
            </td>


            <td>
                <span style="display:none;">{{ $produit->dateExpiration }}</span>
                @php
                    $troisMoisPlusTard = now()->addMonths(3);
                @endphp
                @if ($produit->dateExpiration < $troisMoisPlusTard)
                    {{-- <script src="https://unpkg.com/toastify-js"></script> --}}
                    <script src="../../../../AD/toastify-js-master/src/toastify.js"></script>

                    <script>
                        setInterval(function() {
                            Toastify({
                                text: "La date d'expiration du produit {{ $produit->libelle }} est dans moins de trois mois.",
                                duration: 15000,
                                close: true,
                                gravity: "right", // Afficher à gauche
                                backgroundColor: "#0000FF", // Changer la couleur ici
                            }).showToast();
                        }, 36000000); // 5000 millisecondes correspondent à 5 secondes
                    </script>
                @endif
            </td>


        </tr>
    @endforeach

    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $nombreServantes }}</h3>
                            <p><i class="fas fa-users"></i> Mes servantes</p>
                        </div>

                        <a href="{{ route('servante.index') }}" class="small-box-footer">Plus d'information <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                @auth
                    @if (auth()->user()->role_id == 3 || auth()->user()->role_id == 2)
                         
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3 style="font-size: 190%;">Facture</h3>

                                    <p>Ajouter un facture</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                @auth
                                    @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                                        <a href="{{ route('facture.create') }}" class="small-box-footer">Plus d'information<i
                                        class="fas fa-arrow-circle-right"></i></a>       
                                    @else
                                        <a href="" class="small-box-footer">Plus d'information<i
                                        class="fas fa-arrow-circle-right"></i></a>                                 
                                    @endif
                                @endauth
                            
                            </div>
                        </div>
                    @endif
                @endauth
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 style="font-size: 190%;">Stocks</h3>

                            <p>Mon stock</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        @auth
                            @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                                <a href="{{ route('stock.index') }}" class="small-box-footer">Plus d'information<i
                                class="fas fa-arrow-circle-right"></i></a>       
                            @else
                            <a href="{{ route('stock.index2') }}" class="small-box-footer">Plus d'information<i
                                class="fas fa-arrow-circle-right"></i></a>                                 
                            @endif
                        @endauth
                        
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            @auth
                                @if (auth()->user()->role_id == 1)
                                    <?php
                                        // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                                        $sommeMontantFinalAujourdhui_format = number_format($sommeMontantFinalAujourdhui, 0, ',', '.');
                                    ?>
                                    <h3 style="font-size: 170%;">{{ $sommeMontantFinalAujourdhui_format }} FCFA</h3>
                                @else
                                    <?php
                                        // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                                        $sommeMontantFinalAujourdhuiCaisse_format = number_format($sommeMontantFinalAujourdhuiCaisse, 0, ',', '.');
                                    ?>
                                    <h3 style="font-size: 170%;">{{ $sommeMontantFinalAujourdhuiCaisse_format }} FCFA</h3>                                @endif
                            @endauth

                            <p>Chiffre d'affaires journalier</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        @auth
                            @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                            <a href="{{ route('facture.index') }}" class="small-box-footer">Plus d'information<i
                                class="fas fa-arrow-circle-right"></i></a>       
                            @else
                            <a href="" class="small-box-footer">Plus d'information<i
                                class="fas fa-arrow-circle-right"></i></a>                                 
                            @endif
                        @endauth
                        
                    </div>
                </div>

                @auth
                    @if (auth()->user()->role_id == 1)
                         
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <?php
                                        // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                                        $sommeMontantFinalTousMois_format = number_format($sommeMontantFinalTousMois, 0, ',', '.');
                                    ?>
                                    <h3 style="font-size: 190%;">{{ $sommeMontantFinalTousMois_format }} FCFA</h3>

                                    <p>Chiffre d'affaires mensuel</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                    <a href="{{ route('facture.index') }}" class="small-box-footer">Plus d'information<i
                                    class="fas fa-arrow-circle-right"></i></a>       
                                </div>
                        </div>
                    @endif
                @endauth

                <!-- ./col -->
            </div>

            <div id="carouselExample" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../../../../AD/dist/img/i1.jpg" class="d-block w-100" alt="Image 1">
                    </div>

                    <div class="carousel-item">
                        <img src="../../../../AD/dist/img/i2.jpg" class="d-block w-100" alt="Image 2">
                    </div>

                    <div class="carousel-item">
                        <img src="../../../../AD/dist/img/i3.jpg" class="d-block w-100" alt="Image 3">

                    </div>

                </div>

                <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Précédent</span>
                </a>
                <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Suivant</span>
                </a>
            </div>
        </div>

        <style>
            /* Ajoutez des styles personnalisés ici selon vos préférences */
            .carousel-caption {
                background: rgba(0, 0, 0, 0.7);
                /* Arrière-plan semi-transparent noir pour le texte */
                color: white;
                /* Couleur du texte */
                text-align: left;
                /* Aligner le texte à gauche */
                padding: 20px;
                /* Espace intérieur du texte */
                position: absolute;
                top: 50%;
                /* Position au centre du carousel */
                width: 50%;
                transform: translateY(-50%);
                /* Centrer verticalement */
            }

            .carousel-caption h3 {
                font-size: 1rem;
                /* Taille de la police pour le titre */
                margin-bottom: 10px;
            }

            .carousel-caption p {
                font-size: 1.2rem;
                /* Taille de la police pour le paragraphe */
                margin-bottom: 0;
            }
        </style>
    </section>
@endsection
