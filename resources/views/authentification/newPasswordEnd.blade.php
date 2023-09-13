@extends('layout.masterAuth')
@section('title')
@section('content')

<main class=""> 
    <div class="">

    </div>
   <div class="resetPassword__block">
        <form method="POST" action="{{ route('resetPassword.save')}}"  >
            @csrf 
            <div class="bloc mb-3">
                <h2 class="lead text-muted">Veuillez renseigner votre email pour mettre à jour votre mot de passe</h2>
        </div>
            <div class="bloc mb-3">
                <label for="email" class="control-label">Email</label>
                <input value="{{ $email }}" class="form-group" type="email" name="email" disabled>
            </div>
          <div class="bloc mb-3">
                <label for="password" class="control-label">Mot de Passe</label>
                <input type="password" name="new_password" id="">
            </div>
            <div class="bloc mb-3">
                <label for="confirmed_password" class="control-label">Confirmer Mot de Passe</label>
                <input type="password" name="new_password_confirmation" id="">
            </div> 
            <button class="btn btn-primary" type="submit">Soumettre</button>
        </form>
   </div>
</main>
@endsection