@extends('layout.masterAuth')
@section('title')
@section('content')

<main class=""> 
    <div class="">

    </div>
   <div class="resetPassword__block">
        <form method="POST" action="{{ route('resetPasswordEmail.verify')}}"  >
            @csrf
            <div class="bloc mb-3">
                <h2 class="lead text-muted">Veuillez renseigner votre email pour mettre à jour votre mot de passe</h2>
        </div>
            <div class="bloc mb-3">
                <label for="email" class="control-label">Email</label>
                <input value="{{ old( "email") }}" class="form-group" type="email" name="email">
            </div>
            <button class="btn btn-primary" type="submit">Soumettre</button>
            
        </form>
   </div>
</main>
@endsection