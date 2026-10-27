@extends('layouts.app')

@section('title', 'Modifier mon profil')

@section('content')
<div class="container">
    <h1 class="mb-4">Modifier mon profil</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf

        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom', $user->nom) }}" required>
        </div>

        <div class="mb-3">
            <label>Nouveau mot de passe (laisser vide pour ne pas changer)</label>
            <input type="password" name="mot_de_passe" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('profile') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
