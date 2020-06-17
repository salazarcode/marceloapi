<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Mail\EmailVerification;

use Hash;
use Mail;

class UsuariosController extends Controller
{
    public function Get($id = null)
    {
        if($id != null)
        {
            return User::find($id);
        }
        else
        {
            return User::with("rol")->get();
        }
    }

    public function Create(Request $req)
    {        
        $usuario = new User();
        $usuario->name = $req->name;
        $usuario->rol_id = $req->rol_id;
        $usuario->email = $req->email;
        $usuario->email_verified = false;
        $usuario->email_verification_token = $this->CreateToken();
        $usuario->password = Hash::make($req->password);
        $usuario->save();
        $usuario->rol;

        Mail::to($usuario->email)->send(new EmailVerification($usuario->email_verification_token));

        return $usuario;
    }

    public function CreateToken()
    {
        return md5(rand(1, 10) . microtime());
    }

    public function VerifyToken($token)
    {
        $user = User::where('email_verification_token',$token)->get();

        if( $user->count() == 0 )
            return "Token Inválido";
        else
        {
            $user = $user[0];
            $user->email_verified = 1;
            $user->email_verification_token = null;
            $user->save();
        }

        return view("verified");
    }
    public function Delete($id)
    {
        $user = User::find($id);
        if($user != null){
            $user->delete();
            return 1;
        }
        else
            return 0;
    }

    public function Login(Request $rq)
    {
        $user = User::where('email', $rq->email)->first();
        if(Hash::check($rq->password, $user->password))
            return 1;
        else
            return 0;
    }

    public function Logout(Request $request)
    {
        $request->user()->token()->revoke();
        return 1;
    }
}
