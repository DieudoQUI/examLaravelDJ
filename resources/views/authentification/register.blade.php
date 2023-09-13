@extends('layout.masterAuth')
@section('title')
@section('content')

<div class="connection__block">
    <form method="POST" action="{{ route('registerStore.save')}}">
        @csrf
        <div class="bloc mb-3">
            <h2 class="text-muted">Inscrivez-vous</h2>
        </div>
        <div class="bloc mb-3">
            <label for="nom" class="control-label">Nom</label>
            <input value="{{ old( "lastname") }}" class="form-group" type="text" name="lastname">
        </div>
        <div class="bloc mb-3">
            <label for="prenom" class="control-label">Prénom</label>
            <input value="{{ old( "firstname") }}" class="form-group" type="text" name="firstname">
        </div>
        <div class="bloc mb-3">
            <label for="email" class="control-label">Email</label>
            <input value="{{ old( "emailUser") }}" class="form-group" type="email" name="emailUser">
        </div>
        <div class="bloc mb-3">
            <label for="password" class="control-label">Mot de Passe</label>
            <input type="password" name="password" id="">
        </div>
        <div class="bloc mb-3">
            <label for="confirmPassword" class="control-label"> Confirmer Mot de Passe</label>
            <input type="password" name="password_confirmation" id="">
        </div>
        <button class="btn btn-primary" type="submit">Soumettre</button>
        
    </form>
    <p> Vous avez déjà un compte? Cliquer <a href="{{ route('login')}}">ici</a></p>
    
</div>

@endsection