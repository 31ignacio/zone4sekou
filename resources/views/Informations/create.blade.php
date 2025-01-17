@extends('layouts.master2')

@section('content')

<div class="container">
    <h3 class="app-page-title">Informations</h3>
    <hr class="mb-4">
    <div class="row g-4 settings-section">
        <div class="col-md-2"></div>
        <div class="col-12 col-md-4">
            <h6 class="section-title">Ajouter ici les informations du bar</h6>
            {{-- <div class="section-intro">Ajouter ici un nouvel administrateur</div> --}}
        </div>
        <div class="col-12 col-md-5">
            <div class="app-card app-card-settings shadow-sm p-4">

                <div class="app-card-body">
                    <form class="settings-form" method="POST" action="{{ route('information.store') }}">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class=" col-md-12 mb-3">
                                 <label for="setting-input-1" class="form-label">Raison sociale<span class="ms-2" data-container="body"
                                        data-bs-toggle="popover" data-trigger="hover" data-placement="top"
                                        data-content="This is a Bootstrap popover example. You can use popover to provide extra info."><svg
                                            width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle"
                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                            <path
                                                d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z" />
                                            <circle cx="8" cy="4.5" r="1" />
                                        </svg></span></label> 
                                <input type="text" class="form-control" id="setting-input-1"
                                    name="nom" value="{{ old('nom') }}" required style="border-radius: 10px;">


                                @error('nom')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            <div class="col-md-12 mb-3">
                                <label for="setting-input-3" class="form-label">Adresse</label>
                                <input type="text" class="form-control" id="setting-input-3" name="adresse"
                                     value="{{ old('adresse') }}" style="border-radius: 10px;">


                                @error('adresse')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="setting-input-3" class="form-label">Téléphone</label>
                                <input type="text" class="form-control" id="setting-input-3" name="telephone"
                                     value="{{ old('telephone') }}" style="border-radius: 10px;">


                                @error('telephone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                            
                        <div class="row">
                            <div class=" col-md-12 mb-3">
                                <label for="setting-input-3" class="form-label">Ifu</label>
                                <input type="number" min=0 class="form-control" id="setting-input-3" name="ifu"
                                    style="border-radius: 10px;">


                                @error('ifu')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            
                        </div>
                
                        <button type="submit" class="btn-sm btn-primary mt-2">Enregistrer</button>
                    </form><br>
                </div>
                <!--//app-card-body-->

            </div>
            <!--//app-card-->
        </div>
        <div class="col-md-1"></div>
    </div>
</div>
@endsection
