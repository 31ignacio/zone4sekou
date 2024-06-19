@extends('layouts.master2')



@section('content')

    <section class="content">

        <div class="container-fluid">



            <!-- Le reste de vot

                re code HTML... -->



                <div class="row">

                    <div class="col-md-4"></div>

                    <div class="col-md-4 mt-3">

                        @if (Session::get('success_message'))

                            <div class="alert alert-success alert-dismissible fade show" role="alert">

                                {{ Session::get('success_message') }}

                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                                    <span aria-hidden="true" style="font-size: 30px;">&times;</span>

                                </button>

                            </div>

                        @endif

                    </div>

                    <div class="col-md-4"></div>

                </div>

            
            <div class="row">

                <div class="col-md-4"></div>

                <div class="col-md-4">


                    <div class="card mt-4">

                        <div class="card-header">

                            <h5 class="card-title">Informations du Produit</h5>

                        </div>

                        <div class="card-body">

                            <form action="{{route('stock.final')}}" method="post">

                                @csrf

                                <div class="mb-3">

                                    <input type="hidden" id="produit_id" name="produit_id" value="{{ $produit_id }}"

                                        class="form-control" readonly>

                                </div>

                                <div class="mb-3">

                                    <label for="produit_libelle" class="form-label">Produit :</label>

                                    <input type="text" id="produit_libelle" name="produit_libelle"

                                        value="{{ $produit_libelle }}" class="form-control" readonly>

                                </div>

                                <div class="mb-3">

                                    <label for="produit_quantite" class="form-label">Quantité actuelle :</label>

                                    <input type="text" id="produit_quantite" name="produit_quantite"

                                        value="{{ $produit_quantite }}" class="form-control" readonly>

                                </div>

                                <!-- Ajoutez d'autres champs du formulaire au besoin -->

                                <div class="mb-3">

                                    <label for="transferer" class="form-label">Quantité à transférer :</label>

                                    <input type="integer" id="transferer" name="transferer"

                                        class="form-control" required="required">

                                </div>

                                <div class="mb-3">

                                    <label for="transferer" class="form-label"> Nom du bar :</label>

                                    <input type="text" id="bar" name="bar"

                                        class="form-control" required="required">

                                </div>

                                



                                <button type="submit" class="btn btn-primary" onclick="this.style.display='none'">Soumettre</button>

                            </form>

                        </div>

                    </div>

                </div>

                <div class="col-md-4"></div>

            </div>

            <!-- Le reste de votre code HTML... -->
        </div>

        <!-- /.container-fluid -->

    </section>

@endsection

