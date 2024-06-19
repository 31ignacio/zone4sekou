@extends('layouts.master2')

@section('content')

<div class="container">

    <div class="row mt-3">
        <div class="col-md-3">
            <div class="info-box bg-warning">
                <span class="info-box-icon text-white"><i class="fas fa-calendar-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Point d'hier</span>
                    <?php
                        // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                        $sommeMontantFinalHier_format = number_format($sommeMontantFinalHier, 0, ',', '.');
                    ?>
                    <span class="info-box-number">{{$sommeMontantFinalHier_format}} FCFA</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-success">
                <span class="info-box-icon text-white"><i class="fas fa-sun"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Point de la journée</span>
                    <?php
                        // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                        $sommeMontantFinalAujourdhui_format = number_format($sommeMontantFinalAujourdhui, 0, ',', '.');
                    ?>
                    <span class="info-box-number">{{$sommeMontantFinalAujourdhui_format}} FCFA</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-success">
                <span class="info-box-icon text-white"><i class="far fa-calendar-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Mois actuel</span>
                    <?php
                        // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                        $sommeMontantFinalMoisActuel_format = number_format($sommeMontantFinalMoisActuel, 0, ',', '.');
                    ?>
                    <span class="info-box-number">{{$sommeMontantFinalMoisActuel_format}} FCFA</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-success">
                <span class="info-box-icon text-white"><i class="fas fa-chart-line"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Chiffres d'affaires global</span>
                    <?php
                        // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                        $sommeMontantFinalTousMois_format = number_format($sommeMontantFinalTousMois, 0, ',', '.');
                    ?>

                    <span class="info-box-number" style="max-width: 150px; word-wrap: break-word;">
                        {{$sommeMontantFinalTousMois_format}} FCFA
                    </span>
                </div>
            </div>
        </div>
    </div>
    <hr class="mt-5 mb-5">
    <div class="row">
        <div class="col-md-3">
            <div class="info-box bg-danger">
                <span class="info-box-icon text-white"><i class="fas fa-sun"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Dépense journalière</span>
                    <?php
                        // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                        $somme_depenses_aujourdhui_format = number_format($somme_depenses_aujourdhui, 0, ',', '.');
                    ?>
                    <span class="info-box-number">{{$somme_depenses_aujourdhui_format}} FCFA</span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="info-box bg-info">
                <span class="info-box-icon text-white"><i class="fas fa-sun"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Solde final journalier</span>
                    <?php
                        // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                        $solde_final_journalier_format = number_format($solde_final_journalier, 0, ',', '.');
                    ?>
                    <span class="info-box-number">{{$solde_final_journalier_format}} FCFA</span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="info-box bg-danger">
                <span class="info-box-icon text-white"><i class="fas fa-sun"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Dépense mensuel</span>
                    <?php
                        // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                        $somme_depenses_mois_actuel_format = number_format($somme_depenses_mois_actuel, 0, ',', '.');
                    ?>
                    <span class="info-box-number">{{$somme_depenses_mois_actuel_format}} FCFA</span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="info-box bg-info">
                <span class="info-box-icon text-white"><i class="fas fa-sun"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Solde final mensuel</span>
                    <?php
                        // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                        $solde_final_mois_actuel_format = number_format($solde_final_mois_actuel, 0, ',', '.');
                    ?>
                    <span class="info-box-number">{{$solde_final_mois_actuel_format}} FCFA</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection