@extends('layout.masterAuth')
@section('content')
<div class="connection__block">
    <form method="POST" action="{{ route('signIn')}}">
        @csrf
        <div class="bloc mb-3">
            <h2 class="lead text-muted">Connectez-vous</h2>
        </div>
        <div class="bloc mb-3">
            <label for="email" class="control-label">Email</label>
            <input value="{{ old( "emailUser") }}" class="form-group" type="email" name="emailUser">
        </div>
        <div class="bloc mb-3">
            <label for="password" class="control-label">Mot de Passe</label>
            <input type="password" name="password" id="">
        </div>
        <button class="btn btn-primary" type="submit">Soumettre</button>
        
    </form>
    <p> Vous n'avez pas de compte? Cliquer <a href="{{ route('register.show')}}">ici</a></p>
    <a style="text-decoration: none; color:#eee; margin-bottom:1rem; " href="{{route('resetPassword.start')}}">Mot de passe oublié</a>
    
</div>
@endsection