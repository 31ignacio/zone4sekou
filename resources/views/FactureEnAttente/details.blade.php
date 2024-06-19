@extends('layouts.master2')

@section('content')

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          


          <!-- Main content -->
          <div class="invoice p-3 mb-3" id="my-table">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <h5>
                  <i class="fas fa-globe"></i> <b>ZONE4_SEKOU</b>.
                  <small class="float-right">Date: {{ date('d/m/Y', strtotime($date)) }}</small><br><br>
                  <small class="float-right">Code: {{ $code }}</small>

                </h5>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row --><br>
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                @php
                $infosAffichees = false;
                @endphp

                @foreach ($factures as $facture)
                    @if ($facture->date == $date && $facture->code == $code)
                        @if (!$infosAffichees)

                        <address>
                          <div class="address">
                            {{-- <strong>Client :</strong> <span style="font-size: 10px;">{{$facture->client_nom}}</span><br><br> --}}
                            <b class="gras">Caissier :</b> <span style="font-size: 11px;">{{ explode(' ', $facture->user->name)[1] }}</span><br><br>
                            <b class="gras">Servante :</b> <span style="font-size: 11px;">{{ explode(' ', $facture->servante->nom)[1] }}</span>
                          </div>
                      </address>

                @php
                $infosAffichees = true; // Marquer que les informations ont été affichées
                @endphp
            @endif
            @endif
            @endforeach
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">

              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">

              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12 table-responsive">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Qte</th>
                      <th>Designation</th>
                      <th>P.V.U</th>
                      <th>Montant</th>

                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($factures as $facture )
                      @if ($facture->date == $date && $facture->code == $code)
                        <tr>
                          <td>{{$facture->quantite}}</td>
                          <td>{{$facture->produit}}</td>
                          <td>{{$facture->prix}}</td>
                          <td>{{$facture->total}}</td>
                        </tr>

                      @endif
                    @endforeach

                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <!-- accepted payments column -->
              <div class="col-6">

              </div>
              <!-- /.col -->
              <div class="col-sm-12 col-md-6">

                <div class="table-responsive">
                  <table class="table">

                    @php
                    $infosAffichees = false;
                    @endphp

                    @foreach ($factures as $facture)
                        @if ($facture->date == $date && $facture->code == $code)
                            @if (!$infosAffichees)
                                <tr>
                                  <th>THT:</th>
                                  <td>{{ $facture->totalHT }}</td>
                              </tr>
                              <tr>
                                  <th>TTVA</th>
                                  <td>{{ $facture->totalTVA }}</td>
                              </tr>
                              
                                <tr>
                                  <th>TTTC</th>
                              
                                  <?php
                                  // Formater le montant en ajoutant un point après chaque groupe de trois chiffres en partant de la droite
                                  $facture->totalTTC_format = number_format($facture->totalTTC, 0, ',', '.');
                                  ?>
                                  <td>{{$facture->totalTTC_format}} FCFA</td>                            
                              </tr>
                           
                                @php
                                $infosAffichees = true; // Marquer que les informations ont été affichées
                                @endphp
                                
                            @endif
                        @endif
                        
                    @endforeach

                  </table>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->            
          </div>

          <div class="row no-print mb-5">
            <div class="col-12">
             
              @php
                  $infosAffichees = false;
                  @endphp

                  @foreach ($factures as $facture)
                      @if ($facture->date == $date && $facture->code == $code)
                          @if (!$infosAffichees)

                          <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-2 mt-3">
                              <button class="print-button btn btn-success" onclick="generatePDF2()">
                                <i class="fas fa-print"></i> Imprimer
                            </button>

                          </div>
                            <div class="col-md-2 mt-3">
                                <button class="btn btn-danger" onclick="generatePDF()"><i
                                        class="fas fa-download"></i> Générer PDF</button>

                            </div>
                        </div>
                          @php
                              $infosAffichees = true; // Marquer que les informations ont été affichées
                              @endphp
                          @endif
                      @endif
                  @endforeach

            </div>
          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>


  <script>
    function generatePDF() {
        var element = document.getElementById('my-table');

        var today = new Date();
        var day = ('0' + today.getDate()).slice(-2);
        var month = ('0' + (today.getMonth() + 1)).slice(-2);
        var year = today.getFullYear();
        var formattedDate = year + '-' + month + '-' + day;

        var filename = 'Facture_du_' + formattedDate + '.pdf';

        var opt = {
            margin: [0.5, 0.1, 0, 0.5], // Marges en mm (haut, droite, bas, gauche)
            filename: filename,
            image: { type: 'pdf', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: [80, 210], orientation: 'portrait', marginLeft: 10 } // Ajout de la marge à gauche
        };

        html2pdf().from(element).set(opt).save();
    }
</script>



<script>
  function generatePDF2() {
      var element = document.getElementById('my-table');

      var today = new Date();
      var day = ('0' + today.getDate()).slice(-2);
      var month = ('0' + (today.getMonth() + 1)).slice(-2);
      var year = today.getFullYear();
      var formattedDate = year + '-' + month + '-' + day;

      var filename = 'Facture_du_' + formattedDate + '.pdf';

      var opt = {
        margin: [0.5, 0.1, 0, 0.5], // Marges en mm (haut, droite, bas, gauche)
        filename: filename,
          image: { type: 'jpeg', quality: 0.98 },
          html2canvas: { scale: 2 },
          jsPDF: { unit: 'mm', format: [80, 210], orientation: 'portrait' }
      };

      html2pdf().from(element).set(opt).toPdf().get('pdf').then(function (pdf) {
          var pdfBlob = pdf.output('blob');

          // Create a URL for the PDF blob
          var pdfUrl = URL.createObjectURL(pdfBlob);

          // Open the PDF in a new window and print it
          var printWindow = window.open(pdfUrl);
          printWindow.onload = function () {
              printWindow.print();
          };
      });
  }
</script>



  <style>


    .address {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .address b {
      margin-right: 5px;
      width: 70px; /* Ajustez la largeur selon vos besoins */
    }


   
    #my-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px; /* Taille de la police du tableau augmentée */
    }
    #my-table th, #my-table td {
        border: 1px solid #ddd;
        padding: 6px; /* Augmenter le padding pour plus d'espace autour du texte */
        text-align: left;
    }
    #my-table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }
    .header {
        text-align: center;
        margin-bottom: 5px;
    }
    .header .title {
        font-size: 14px;
        font-weight: bold;
    }
    .footer {
        margin-top: 5px;
        text-align: center;
        font-size: 10px; /* Taille de la police du pied de page */
    }
    .total {
        font-weight: bold;
    }
  </style>
   


@endsection
