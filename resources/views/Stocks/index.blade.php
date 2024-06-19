@extends('layouts.master2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-3 col-sm-6 col-md-3 mt-4">
                <div class="info-box">
                  <span class="info-box-icon bg-info elevation-1"><i class="fas fa-plus"></i></span>

                    <div class="info-box-content">
                        <a href="{{ route('stock.entrer') }}">
                            <span class="info-box-text">Entrés de stocks</span>
                            <span class="info-box-number">
                                
                                <small></small>
                            </span>
                        </a>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-md-3 mt-4">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-minus"></i></span>

                    <div class="info-box-content">
                        <a href="{{ route('stock.sortie') }}">

                            <span class="info-box-text">Sorties de stocks</span>
                            <span class="info-box-number"></span>
                        </a>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-md-3 col-sm-6 col-md-3 mt-4">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-success elevation-1"><i class="fas fa-box"></i></span>

                    <div class="info-box-content">
                        <a href="{{ route('stock.actuel') }}">

                            <span class="info-box-text">Stocks actuels</span>
                            <span class="info-box-number"></span>
                        </a>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-md-1"></div>

        </div>
    </div>
    </div>
@endsection
