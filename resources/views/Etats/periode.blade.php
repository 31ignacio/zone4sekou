@extends('layouts.master2')

@section('content')


 <!-- Main content -->
 <section class="content">
    <div class="container">

      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8 mt-0">
            @if (Session::get('success_message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 30px;">&times;</span>
                    </button>
                </div>
            @endif
        </div>
        
        <div class="col-md-2"></div>
      </div>

      <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8 mt-0">
              @if (Session::get('danger_message'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      {{ Session::get('danger_message') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true" style="font-size: 30px;">&times;</span>
                      </button>
                  </div>
              @endif
          </div>
          <div class="col-md-2"></div>
      </div>

      <div class="row">
        <div class="col-12 mt-4">
          <div class="card">
            <div class="card-header">
              <h3 class="text-center"><b>Facture sur une periode </b></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="settings-form" id="searchForm" method="GET" action="{{ route('periode.index') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-4 col-sm-2">
                            <label for="">Date début</label>
                            <input type="date" class="form-control" name="dateDebut" id="dateDebut">
                        </div>
                        <div class="col-md-4 col-sm-2">
                            <label for="">Date fin</label>
                            <input type="date" class="form-control" name="dateFin" id="dateFin">
                        </div>
                        
                        <div class="col-md-2 col-sm-2 mt-4" >
                            <button type="submit" class="btn btn-md btn-success mt-2">Recherche</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
          </div>
      


          
        <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2 mt-3 mb-3">
                <button class="btn btn-danger" onclick="generatePDF()"><i class="fas fa-download"></i> Générer PDF</button>
        
            </div>
        </div>
           <!-- Main content -->
        <div id="my-table">
            <div class="invoice p-3 mb-3" >
                
                <div class="row">
                <div class="col-12">
                    <h5>
                    <i class="fas fa-globe"></i> <b>ZONE4_SEKOU</b>.
                    <b class="float-right">Facture période du : {{ date('d/m/Y', strtotime($dateDebut)) }} au  {{ date('d/m/Y', strtotime($dateFin)) }}</b><br>

                    </h5>
                </div>
                <!-- /.col -->
                </div>
        
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12 table-responsive">
                <table class="table table-striped table-bordered">
                  <thead>
                  <tr>
                    <th>Date</th>
                    <th>Quantité</th>
                    <th>Produits</th>
                    <th>Prix</th>
                    <th>Totals</th>

                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($codesFacturesUniques as $facture )

                        <tr>
                            <td>{{ date('d/m/Y', strtotime($facture->date)) }}</td>
                            <td>{{$facture->quantite}}</td>
                            <td>{{$facture->produit}}</td>
                            <td>{{$facture->prix}}</td>
                            <td>{{$facture->total}}</td>
                        </tr>
                  @endforeach

                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <!-- accepted payments column -->
              <div class="col-8">

              </div>
              <!-- /.col -->
              {{-- rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr --}}

              <div class="col-sm-12 col-md-4">

                <div class="table-responsive">
                  <table class="table">

                   
                    <tr>
                        <th style="width:50%">Total HT:</th>
                        <td>{{ $totalHT }}</td>
                    </tr>
                    <tr>
                        <th>Total TVA</th>
                        <td>{{ $totalTVA }}</td>
                    </tr>
                    <tr>
                        <th>Total TTC</th>
                        <td>{{ $totalTTC }}</td>
                    </tr>
                    <tr>
                        <th>Montant perçu </th>
                        <td>{{ $montantPaye }}</td>
                    </tr>
                    <tr>
                        <th>Reliquat </th>
                        <td>{{ $montantRendu}}</td>
                    </tr>
                    
                    <tr>
                        <th>Montant payé </th>
                    
                        <?php
                        // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                        $montantFinal_format = number_format($montantFinal, 0, ',', '.');
                        ?>
                        <td><span style="background-color: green;color:white;padding:5%;">{{$montantFinal_format}} FCFA</span></td>
                    </tr>
                           
                  </table>
                </div>
              </div>


              {{-- zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz --}}
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
        </div>
          </div>

                  
            















          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>

  
  {{-- <script>
    // Définir la fonction generatePDF à l'extérieur de la fonction click
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
      var filename = 'Facture_sur _une_periode_a_la_date_du' + formattedDate + '.pdf';
  
        // Options pour la méthode html2pdf
        var opt = {
              margin: 0.5,
              filename: filename,
              image: { type: 'jpeg', quality: 0.98 },
              html2canvas: { scale: 2 },
              jsPDF: { unit: 'in', format: 'a4', orientation: 'landscape' }
          };
  
        // Utiliser la méthode html2pdf pour générer le PDF à partir du contenu du tableau HTML
        html2pdf().from(element).set(opt).save();
    }
  </script> --}}

   <script>
    // Définir la fonction generatePDF à l'extérieur de la fonction click
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
      var filename = 'Facture_sur _une_periode_a_la_date_du' + formattedDate + '.pdf';
  
        // Options pour la méthode html2pdf
        var opt = {
              margin: 0.5,
              filename: filename,
              image: { type: 'jpeg', quality: 0.98 },
              html2canvas: { scale: 2 },
              jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
          };
  
        // Utiliser la méthode html2pdf pour générer le PDF à partir du contenu du tableau HTML
        html2pdf().from(element).set(opt).save();
    }
  </script> 
  @endsection
  