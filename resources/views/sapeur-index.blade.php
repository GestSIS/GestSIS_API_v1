@extends('layouts.master')

@section('content')

<section class="content-header">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>Sapeurs</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Sapeurs</li>
      </ol>
    </div>
  </div>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-3"> <!-- TODO Find a solution for small devices by hidding the sapeur list-->
      <div class="card-header">
        <h3 class="card-title">Filtres</h3>
        <div class="card-body px-0">
          <form id="f-sapeur-filters" action="{{ route('sapeur.index') }}" method="GET">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="statutActif" name="actif" class="custom-control-input" value="1" {{ isset($filters['actif']) && $filters['actif'] == '1' ? 'checked' : '' }}>
              <label class="custom-control-label" for="statutActif">Actif</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="statutInactif" name="actif" class="custom-control-input" value="0" {{ isset($filters['actif']) && $filters['actif'] == '0' ? 'checked' : '' }}>
              <label class="custom-control-label" for="statutInactif">Inactif</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="statutTous" name="actif" class="custom-control-input" value="" {{ !isset($filters['actif']) ? 'checked' : '' }}>
              <label class="custom-control-label" for="statutTous">Tous</label>
            </div>
          </form>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card card-primary card-outline">
        <div class="card-header"><a href="{{ route('sapeur.create') }}" class="btn btn-success btn-block internal-link">Nouveau</a></div>
        <div class="card-body p-0 select-sapeur">
          <div class="nav flex-column nav-pills" aria-orientation="vertical">
            @foreach($sapeurs_list as $sap)
              <a class="nav-link internal-link {{ $sap['id'] === $sap_details['sapeur']['id'] ? 'active' : '' }}" href="{{ route('sapeur.details', array_merge($filters, ['id' =>  $sap['id']])) }}">{{ $sap['nom'] }} {{ $sap['prenom'] }}</a>
            @endforeach
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <div class="col-md-9">
      @if(!empty($sap_details['sapeur']))
        @include('sapeur-details')
      @endif
    </div>
  </div>
  <!-- /.row -->
</section>

@stop
