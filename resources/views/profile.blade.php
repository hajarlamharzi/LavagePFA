@extends('layouts.app') <!-- ou ton layout général si tu as -->

@section('title', 'Mon Profil')

@section('content')
<div class="container">
    <h1 class="mb-4">Mon Profil</h1>
    <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-3">Modifier mon profil</a>

    <div class="card">
        <div class="card-body">
            <p><strong>Nom :</strong> {{ $user->nom }}</p>
            <p><strong>Rôle :</strong> {{ $user->role }}</p>
        </div>
    </div>

    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Retour</a>
</div>
@endsection
