<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller{
    
    public function register(){
        return view('authentification.register');
    }

    public function login(){
        return view('authentification.login');
    }

    public function userStore(Request $request){
        $data = $request->all();
        
        //validation du formulaire
        $validation=$request->validate([
            "lastname" => "required|min:2",
            "firstname" => "required|min:2",
            "emailUser" => array(
                "required",
                "unique:user",
                "regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/"
            ),
            "password" => array(
                "required",
                "regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^_;:,])[A-Za-z\d@$!%*?&#^_;:,]{8,}$/",
                "confirmed:password_confirmation"
                ) 
            ]);
            
            //Sauvegarde temporaire
            $save = User::create([
                "lastname" => $data['lastname'],
                "firstname" => $data['firstname'],
                "emailUser" => $data['emailUser'],
                "password" => Hash::make($data['password']),
            ]); 
            dd($save);
        // creation de l'url d'activation
        $url = URL::temporarySignedRoute(
            'EmailUser.verify',
            now()->addMinutes(30),
            ['emailUser' => $data['emailUser']]
        );

        $name = $data['firstname'] .' '. $data['lastname'];
        Mail::send('authentification.mailConfirmationAccount', ['url' => $url, 'nom' => $name], function ($message) use ($data, $name){
            $config = config('mail');
            $message->subject('Registration verification !')
                ->from($config['from']['address'], $config['from']['name'])
                ->to($data['emailUser'], $name);
        });
        return redirect()->back()->with("success", "veuillez consulter votre email pour activer votre compte utilisateur");
    }

    public function verifyEmailUserAccount(Request $request, $email){
        $user = User::where("email", $email)->first();
        if (!$user) {
            abort(404);
        }
        if (!$request->hasValidSignature()) {
            abort(404);
        }
        $user->update([
            "email_verify_at" => now(),
            'email_Verified' =>true,
        ]);
        return redirect()->route("login")->with('success', "Compte activé avec succès !");
    }



    // Mot de passe oublié
    public function resetPasswordStart(){
        return view('authentification.newPasswordBegin');
    }

    public function storeVerifyPassword(Request $request){
        $user = User::where('emailUser', $request->email)->first();
        
        if(!$user){
            abort(404);
        }else{
                $url = URL::temporarySignedRoute(
                    'verifyResetPassword',
                    now()->addMinutes(30),
                    ['emailUser' => $user['emailUser']]);
                 
        // creation de l'url de changement de mot passe
        $name = $user['firstName'] .' '. $user['lastName'];
            Mail::send('authentification.mailPasswordReset', ['url' => $url, 'nom' => $name], function ($message) use ($user, $name) {
                $config = config('mail');
                $message->subject('Changement de mot Passe !')
                    ->from($config['from']['address'], $config['from']['name'])
                    ->to($user['email']);
            });
        return redirect()->back()->with("success", "Veuillez consulter votre email pour changer votre mot de passe");
        }
    }

     // Vérification de l'existence de l'email fourni pour la mise à jour du mot de passe
    public function verifyResetPassword(Request $request,$email){
        $user = User::where("emailUser", $email)->first();
        if (!$user) {
            abort(404);
        }
        if (!$request->hasValidSignature()) {
            abort(404);
        }
        session(['emailUser'=>$user->email]);
        return view("authentification.newPassword", compact('email'));
    } 
      
    //Récuperer et mettre à jour le nouveau mot de passe
    public function  resetPasswordStore(Request $request){
        $email = session('emailUser');
        $user = User::where("emailUser", $email)->first();
            //validation du nouveau mot de passe renseigné
            $validation=$request->validate([
            "new_password" => array(
                "required",
                "regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^_;:,])[A-Za-z\d@$!%*?&#^_;:,]{8,}$/",
                "confirmed:new_password_confirmation"
            )  
        ]);
        //mise à jour dans la base de donnée
        $user->update([
            "password" =>Hash::make($user['new_password'])
        ]); 
        return redirect()->route('login')->with("success", "Veuillez consulter votre email pour changer votre mot de passe");
    } 

    // Se Connecter
    public function signIn(Request $request){
        $user= Auth::attempt([
            'email' =>$request->email,
            'password' =>$request->password,
            'email_Verified' =>true
        ]);
        if ($user){
            return redirect()->route('index');
        }
        return redirect()->back()->with('error','Combinaison email/password invalide');
    }

    // Se déconnecter
    public function logout(){
        Auth::logout();
        return  redirect()->route('login.show');
    }
}
