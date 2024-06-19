@extends('layouts.master2')

@section('content')

  <section class="content">


    
  <div class="row">
    <div class="col-md-10"></div>
    <div class="col-md-2 mt-3">
      <button class="btn btn-danger" onclick="generatePDF()"><i class="fas fa-download"></i> Générer PDF</button>

    </div>
  </div>

    <div class="container-fluid" id="my-table">


      <div class="row">
        <div class="col-12">
          <h5>
            <i class="fas fa-globe"></i> <b>ZONE4_SEKOU</b> <br>
            <small class="float-right"><b>Date:</b> {{ date('d/m/Y', strtotime($date)) }}</small><br><br>
            <small class="float-left"><b>IFU :</b> 01234567891011</small><br>

            <small class="float-left"><b>Téléphone :</b> (229) 45 78 12 96 </small>

          </h5>
        </div>
        <!-- /.col -->
      </div>
        <h3 class="text-center"><b >Stock actuel a la date du {{ date('d/m/Y', strtotime($date)) }}</b></h3>
      {{-- 1111111111111111 --}}
      <div class="row">
        <div class="col-6 mt-3 border-right">

          <div class="card table-responsive">
            <div class="card-header">
              <h1 class="card-title"><b>CASIERS 24T</b></h1>
            </div>
            <!-- /.card-header -->
            <div class="card-body ">
           

              @php
                  $totalMontant = 0;
                  $totalQuantite1 = 0;
              @endphp

              <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th>DESIGNATIONS</th>
                          <th>QTE</th>
                          <th>PU</th>
                          <th>MONTANT</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($produits as $produit)
                       @if($produit->emplacement->id == 1)
                          <tr>
                              <td>{{ $produit->libelle }}</td>
                              <td>
                                 
                                {{ $produit->stock_actuel }}
                                  @if ($produit->stock_actuel <= 3)
                                      <script src="../../../../AD/toastify-js-master/src/toastify.js"></script>
                                      <script>
                                          // Mettre le script de notification ici
                                          setInterval(function() {
                                              Toastify({
                                                  text: "Le stock de {{ $produit->libelle }} est faible (Moins de 3 bouteilles).",
                                                  duration: 8000,
                                                  close: true,
                                                  gravity: "top", // Position du toast
                                                  backgroundColor: "#b30000",
                                              }).showToast();
                                          }, 200000); // 5000 millisecondes correspondent à 5 secondes
                                      </script>
                                  @endif
                              </td>
                              <td>{{ $produit->prix }}</td>
                              <td>
                                  <?php
                                      // Calculer le montant pour ce produit
                                      $montant = $produit->prix * $produit->stock_actuel;
                                      $totalQuantite1 += $produit->stock_actuel;
                                      $totalMontant += $montant; // Ajouter le montant au total
                                      $montant_format = number_format($montant, 0, ',', '.');
                                  ?>
                                  <b class="info-box-number">{{ $montant_format }} FCFA</b>
                              </td>
                          </tr>
                        @endif
                      @endforeach
                  </tbody>
              </table>

            </div>
            <!-- /.card-body -->
          </div>

          <div class="total-container">
            <span class="total-item">QTE : {{ number_format($totalQuantite1, 0, ',', '.') }}</span>
            <span class="total-item">Total : {{ number_format($totalMontant, 0, ',', '.') }} FCFA</span>
          </div>

          <!-- /.card -->
        </div>
        <!-- /.col -->
        
        <div class="col-6 mt-3 border-left">

          <div class="card table-responsive">
            <div class="card-header">
              <h1 class="card-title"><b>CASIERS 12T</b></h1>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
           

              @php
                  $totalMontant = 0;
                  $totalQuantite2 = 0;
              @endphp

              <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>DESIGNATIONS</th>
                      <th>QTE</th>
                      <th>PU</th>
                      <th>MONTANT</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach ($produits as $produit)
                      @if($produit->emplacement->id == 2)

                          <tr>
                            <td>{{ $produit->libelle }}</td>
                            <td>
                              @if($produit->stock_actuel <= 0)
                                  <span style="color:red;">{{ $produit->stock_actuel }}</span>
                              @else
                                  {{ $produit->stock_actuel }}
                              @endif                             
                            </td>
                              <td>{{ $produit->prix }}</td>
                              <td>
                                  <?php
                                      // Calculer le montant pour ce produit
                                      $montant = $produit->prix * $produit->stock_actuel;
                                      $totalQuantite2 += $produit->stock_actuel;

                                      $totalMontant += $montant; // Ajouter le montant au total
                                      $montant_format = number_format($montant, 0, ',', '.');
                                  ?>
                                  <b class="info-box-number">{{ $montant_format }} FCFA</b>
                              </td>
                          </tr>
                        @endif
                      @endforeach
                  </tbody>
              </table>

            </div>
            <!-- /.card-body -->
          </div>

          <div class="total-container">
            <span class="total-item">QTE : {{ number_format($totalQuantite2, 0, ',', '.') }}</span>
            <span class="total-item">Total : {{ number_format($totalMontant, 0, ',', '.') }} FCFA</span>
        </div>

        </div>

      </div>
      <hr style="height: 5px; border: none; background: linear-gradient(to right, #ff7e5f, #feb47b);">
      <!-- /.row -->
     {{--22222222222222222222222222  --}}
      <div class="row">
        <div class="col-6 mt-3 border-right">

          <div class="card">
            <div class="card-header">
              <h1 class="card-title"><b>CASIERS 20T</b></h1>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
           

              @php
                  $totalMontant = 0;
                  $totalQuantite3 = 0;
              @endphp

              <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>DESIGNATIONS</th>
                      <th>QTE</th>
                      <th>PU</th>
                      <th>MONTANT</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach ($produits as $produit)
                      @if($produit->emplacement_id == 3)
                          <tr>
                            <td>{{ $produit->libelle }}</td>
                            <td>
                              @if($produit->stock_actuel <= 0)
                              <span style="color:red;">{{ $produit->stock_actuel }}</span>
                              @else
                              {{ $produit->stock_actuel }}  
                              @endif                               
                              </td>
                              <td>{{ $produit->prix }}</td>
                              <td>
                                  <?php
                                      // Calculer le montant pour ce produit
                                      $montant = $produit->prix * $produit->stock_actuel;
                                      $totalMontant += $montant; // Ajouter le montant au total
                                      $totalQuantite3 += $produit->stock_actuel;
                                      $montant_format = number_format($montant, 0, ',', '.');
                                  ?>
                                  <b class="info-box-number">{{ $montant_format }} FCFA</b>
                              </td>
                          </tr>
                        @endif
                      @endforeach
                  </tbody>
              </table>

            </div>
            <!-- /.card-body -->
          </div>

          <div class="total-container">
            <span class="total-item">QTE : {{ number_format($totalQuantite3, 0, ',', '.') }}</span>
            <span class="total-item">Total : {{ number_format($totalMontant, 0, ',', '.') }} FCFA</span>
        </div>
        </div>

        {{-- 1111111111111111 --}}
        <div class="col-6 mt-3 border-left">

          <div class="card">
            <div class="card-header">
              <h1 class="card-title"><b>PACK 6</b></h1>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
           
              @php
                  $totalMontant = 0;
                  $totalQuantite = 0;
              @endphp

              <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>DESIGNATIONS</th>
                      <th>QTE</th>
                      <th>PU</th>
                      <th>MONTANT</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach ($produits as $produit)
                      @if($produit->emplacement_id==4)
                          <tr>
                            <td>{{ $produit->libelle }}</td>
                            <td>
                              @if($produit->stock_actuel <= 0)
                              <span style="color:red;">{{ $produit->stock_actuel }}</span>
                              @else
                              {{ $produit->stock_actuel }} 
                              @endif                                
                              </td>
                              <td>{{ $produit->prix }}</td>
                              <td>
                                  <?php
                                      // Calculer le montant pour ce produit
                                      $montant = $produit->prix * $produit->stock_actuel;
                                      $totalMontant += $montant; // Ajouter le montant au total
                                      $totalQuantite += $produit->stock_actuel;
                                      $montant_format = number_format($montant, 0, ',', '.');
                                  ?>
                                  <b class="info-box-number">{{ $montant_format }} FCFA</b>
                              </td>
                          </tr>
                        @endif
                      @endforeach
                  </tbody>
              </table>

            </div>
            <!-- /.card-body -->
          </div>

          <div class="total-container">
            <span class="total-item">QTE : {{ number_format($totalQuantite, 0, ',', '.') }}</span>
            <span class="total-item">Total : {{ number_format($totalMontant, 0, ',', '.') }} FCFA</span>
        </div>
        </div>

      </div>
      <hr style="height: 5px; border: none; background: linear-gradient(to right, #ff7e5f, #feb47b);">
      {{-- 33333333333333333333 --}}
      <div class="row">
        <div class="col-6 mt-3 border-right">

          <div class="card">
            <div class="card-header">
              <h1 class="card-title"><b>PACK 8</b></h1>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
           

              @php
                  $totalMontant = 0;
                  $totalQuantite = 0;
              @endphp

              <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>DESIGNATIONS</th>
                      <th>QTE</th>
                      <th>PU</th>
                      <th>MONTANT</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach ($produits as $produit)
                      @if($produit->emplacement_id== 5)
                          <tr>
                              <td>{{ $produit->libelle }}</td>
                              <td>
                                @if($produit->stock_actuel <= 0)
                                  <span style="color:red;">{{ $produit->stock_actuel }}</span>
                                @else
                                  {{ $produit->stock_actuel }}
                                @endif
                                  
                              </td>
                              <td>{{ $produit->prix }}</td>
                              <td>
                                  <?php
                                      // Calculer le montant pour ce produit
                                      $montant = $produit->prix * $produit->stock_actuel;
                                      $totalMontant += $montant; // Ajouter le montant au total
                                      $totalQuantite += $produit->stock_actuel;
                                      $montant_format = number_format($montant, 0, ',', '.');
                                  ?>
                                  <b class="info-box-number">{{ $montant_format }} FCFA</b>
                              </td>
                          </tr>
                      @endif
                      @endforeach
                  </tbody>
              </table>

            </div>
            <!-- /.card-body -->
          </div>

          <div class="total-container">
            <span class="total-item">QTE : {{ number_format($totalQuantite, 0, ',', '.') }}</span>
            <span class="total-item">Total : {{ number_format($totalMontant, 0, ',', '.') }} FCFA</span>
        </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-6 mt-3 border-left">

          <div class="card">
            <div class="card-header">
              <h1 class="card-title"><b>CARTON 24 </b></h1>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
           

              @php
                  $totalMontant = 0;
                  $totalQuantite = 0;
              @endphp

              <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>DESIGNATIONS</th>
                      <th>QTE</th>
                      <th>PU</th>
                      <th>MONTANT</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach ($produits as $produit)
                      @if($produit->emplacement_id== 8)
                          <tr>
                              <td>{{ $produit->libelle }}</td>
                              <td>
                                @if($produit->stock_actuel <= 0)
                                <span style="color:red;">{{ $produit->stock_actuel }}</span>
                                @else
                                  {{ $produit->stock_actuel }}
                                @endif                                  
                              </td>
                              <td>{{ $produit->prix }}</td>
                              <td>
                                  <?php
                                      // Calculer le montant pour ce produit
                                      $montant = $produit->prix * $produit->stock_actuel;
                                      $totalMontant += $montant; // Ajouter le montant au total
                                      $totalQuantite += $produit->stock_actuel;
                                      $montant_format = number_format($montant, 0, ',', '.');
                                  ?>
                                  <b class="info-box-number">{{ $montant_format }} FCFA</b>
                              </td>
                          </tr>
                      @endif
                      @endforeach
                  </tbody>
              </table>

            </div>
            <!-- /.card-body -->
          </div>

          <div class="total-container">
            <span class="total-item">QTE : {{ number_format($totalQuantite, 0, ',', '.') }}</span>
            <span class="total-item">Total : {{ number_format($totalMontant, 0, ',', '.') }} FCFA</span>
        </div>

          <!-- /.card -->
        </div>
      </div>
      <hr style="height: 5px; border: none; background: linear-gradient(to right, #ff7e5f, #feb47b);">

         {{-- 4444444444444444444 --}}
      <div class="row">
        <div class="col-6 mt-3 border-right">

          <div class="card">
            <div class="card-header">
              <h1 class="card-title"><b>CANNETTE DE 24</b></h1>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
           

              @php
                  $totalMontant = 0;
                  $totalQuantite = 0;
              @endphp

              <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>DESIGNATIONS</th>
                      <th>QTE</th>
                      <th>PU</th>
                      <th>MONTANT</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach ($produits as $produit)
                      @if($produit->emplacement_id== 9)
                          <tr>
                              <td>{{ $produit->libelle }}</td>
                              <td>
                                @if($produit->stock_actuel <= 0)
                                <span style="color:red;">{{ $produit->stock_actuel }}</span>
                                @else
                                  {{ $produit->stock_actuel }}
                                @endif                                  
                              </td>
                              <td>{{ $produit->prix }}</td>
                              <td>
                                  <?php
                                      // Calculer le montant pour ce produit
                                      $montant = $produit->prix * $produit->stock_actuel;
                                      $totalMontant += $montant; // Ajouter le montant au total
                                      $totalQuantite += $produit->stock_actuel;
                                      $montant_format = number_format($montant, 0, ',', '.');
                                  ?>
                                  <b class="info-box-number">{{ $montant_format }} FCFA</b>
                              </td>
                          </tr>
                      @endif
                      @endforeach
                  </tbody>
              </table>

            </div>
            <!-- /.card-body -->
          </div>

         <div class="total-container">
            <span class="total-item">QTE : {{ number_format($totalQuantite, 0, ',', '.') }}</span>
            <span class="total-item">Total : {{ number_format($totalMontant, 0, ',', '.') }} FCFA</span>
        </div>

          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-6 mt-3 border-left">

          <div class="card">
            <div class="card-header">
              <h1 class="card-title"><b>VINS / WHISKY / CHAMPAGNES </b></h1>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
           

              @php
                  $totalMontant = 0;
                  $totalQuantite=0;
              @endphp

              <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>DESIGNATIONS</th>
                      <th>QTE</th>
                      <th>PU</th>
                      <th>MONTANT</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach ($produits as $produit)
                      @if($produit->emplacement_id== 6 || $produit->emplacement_id== 7)
                          <tr>
                              <td>{{ $produit->libelle }}</td>
                              <td>
                                @if($produit->stock_actuel <= 0)
                                <span style="color:red;">{{ $produit->stock_actuel }}</span>
                                @else
                                  {{ $produit->stock_actuel }}
                                @endif                                  
                              </td>
                              <td>{{ $produit->prix }}</td>
                              <td>
                                  <?php
                                      // Calculer le montant pour ce produit
                                      $montant = $produit->prix * $produit->stock_actuel;
                                      $totalMontant += $montant; // Ajouter le montant au total
                                      $totalQuantite += $produit->stock_actuel;
                                      $montant_format = number_format($montant, 0, ',', '.');
                                  ?>
                                  <b class="info-box-number">{{ $montant_format }} FCFA</b>
                              </td>
                          </tr>
                      @endif
                      @endforeach
                  </tbody>
              </table>

            </div>
            <!-- /.card-body -->
          </div>

         <div class="total-container">
            <span class="total-item">QTE : {{ number_format($totalQuantite, 0, ',', '.') }}</span>
            <span class="total-item">Total : {{ number_format($totalMontant, 0, ',', '.') }} FCFA</span>
        </div>

          <!-- /.card -->
        </div>
      </div>


      {{-- 6666666666666666666666666666 --}}
      <div class="row">
        <div class="col-6 mt-3 border-right" >

          <div class="card table-responsive">
            <div class="card-header" hidden>
              <h1 class="card-title"><b>CASIERS 24T</b></h1>
            </div>
            <!-- /.card-header -->
            <div class="card-body " hidden>
           

              @php
                  $totalMontant = 0;
                  $totalQuantite = 0;
              @endphp

              <table class="table">
                  <thead>
                      <tr>
                          <th>DESIGNATIONS</th>
                          <th>QTE</th>
                          <th>PU</th>
                          <th>MONTANT</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($produits as $produit)
                        <tr>
                            <td>{{ $produit->libelle }}</td>
                            <td>
                                
                              {{ $produit->stock_actuel }}
                                
                            </td>
                            <td>{{ $produit->prix }}</td>
                            <td>
                                <?php
                                    // Calculer le montant pour ce produit
                                    $montant = $produit->prix * $produit->stock_actuel;
                                    $totalQuantite += $produit->stock_actuel;
                                    $totalMontant += $montant; // Ajouter le montant au total
                                    $montant_format = number_format($montant, 0, ',', '.');
                                ?>
                                <b class="info-box-number">{{ $montant_format }} FCFA</b>
                            </td>
                        </tr>
                        @endforeach

                  </tbody>
              </table>

            </div>
            <!-- /.card-body -->
          </div>

          <div class="total-container" hidden>
            <span class="total-item">QTE : {{ number_format($totalQuantite, 0, ',', '.') }}</span>
            <span class="total-item">Total : {{ number_format($totalMontant, 0, ',', '.') }} FCFA</span>
          </div>

          <!-- /.card -->
        </div>
        <!-- /.col -->

        <div class="col-6 mt-3 border-left">

          <div class="card">
            <div class="card-header">
              <h1 class="card-title custom-title">Recapitulatif</h1>
          </div>
            <!-- /.card-header -->
            <div class="card-body">
           

             
              <table class="styled-table table">
                <thead>
                    <tr>
                        <th>QTE CASIERS 24T</th>
                        <td>
                            <span class=" badge badge-warning badge-custom total-item">{{ number_format($totalQuantite1, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>QTE CASIERS 12T</th>
                        <td>
                            <span class=" badge badge-warning badge-custom total-item">{{ number_format($totalQuantite2, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>QTE CASIERS 20</th>
                        <td>
                            <span class=" badge badge-warning badge-custom total-item">{{ number_format($totalQuantite3, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>QTE GENERALE</th>
                        <td>
                            <span class="badge badge-info badge-custom total-item">{{ number_format($totalQuantite, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>SOMME TOTALE</th>
                        <td>
                            <span class="badge badge-success badge-custom total-item">{{ number_format($totalMontant, 0, ',', '.') }} FCFA</span>
                        </td>
                    </tr>
                </thead>
            </table>
    

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>

    </div>
    <!-- /.container-fluid -->
  </section>

  <style>
    .border-right {
        border-right: 10px solid #ff7e5f; /* Couleur et épaisseur de la bordure */
        padding-right: 30px; /* Espacement entre le contenu et la bordure */
    }
  
    .border-left {
        border-left: 10px solid #ff7e5f; /* Couleur et épaisseur de la bordure */
        padding-left: 30px; /* Espacement entre le contenu et la bordure */
    }
  </style>

<style>
  .total-container {
      display: block;
      text-align: right;
      margin: 20px auto;
      font-size: 20px; /* Diminuer la taille de la police */
      font-weight: bold;
      color: #333;
  }

  .total-container .total-item {
      margin: 0 10px; /* Espacement entre les éléments QTE et Total */
      display: inline-block;
  }

  .table-responsive {
            margin-bottom: 20px;
        }

        .no-break {
            page-break-inside: avoid;
        }
</style>

<style>
  .card-custom {
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      background-color: #f9f9f9;
  }
  .title-icon {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
  }
  .title-icon i {
      font-size: 24px;
      color: #4CAF50;
      margin-right: 10px;
  }
  .card-title {
      font-weight: bold;
      color: #333;
  }
  .list-group-item-custom {
      border: none;
      padding: 10px 15px;
      background-color: #fff;
      margin-bottom: 5px;
      border-radius: 8px;
  }
  .badge-custom {
      font-size: 16px;
      padding: 8px 12px;
      border-radius: 8px;
  }
  .badge-danger {
      background-color: #f44336;
  }
  .badge-success {
      background-color: #4CAF50;
  }
  .badge-warning {
      background-color: #FF9800;
  }
  .badge-info {
      background-color: #2196F3;
  }
</style>

<style>
 .custom-title {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            text-align: center;
        }
</style>


  <script>
      // Recherche de l'élément de message de succès
      var successMessage = document.getElementById('success-message');

      // Masquer le message de succès après 3 secondes (3000 millisecondes)
      if (successMessage) {
          setTimeout(function() {
              successMessage.style.display = 'none';
          }, 3000);
      }
  </script>





<script>
  function generatePDF() {
    // Récupérer le contenu du tableau HTML
    var element = document.getElementById('my-table');

    // Obtenez la date actuelle
    var today = new Date();

    // Formatez la date en yyyy-mm-dd sans padStart
    var day = ('0' + today.getDate()).slice(-2);
    var month = ('0' + (today.getMonth() + 1)).slice(-2); // Les mois commencent à 0
    var year = today.getFullYear();

    // Construisez la chaîne de date
    var formattedDate = year + '-' + month + '-' + day;

    // Créez le nom de fichier avec la date du jour
    var filename = 'Stock_actuel_du_' + formattedDate + '.pdf';

    var opt = {
        margin: 0,
        filename: filename, // Utilisez le nom de fichier dynamique
        image: {
            type: 'pdf',
            quality: 0.98
        },
        html2canvas: {
            scale: 2
        },
        jsPDF: {
            unit: 'in',
            format: 'letter',
            orientation: 'landscape' // Changez l'orientation à 'landscape'
        }
    };

    // Utiliser la méthode html2pdf pour générer le PDF à partir du contenu du tableau HTML
    html2pdf().from(element).set(opt).save();
}

</script>
@endsection

