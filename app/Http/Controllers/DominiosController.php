<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dominio;
use App\Valor;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;

class DominiosController extends Controller
{
    public function Get($id = null, Request $rq)
    {        
        if($id == null){

            $res = Dominio::with("valores")->get();            
            return $res;
        }
        else{
            $var = Dominio::with("valores")->find($id);
            return $var;
        };        
    } 

    public function Create(Request $req)
    {        
        $validatedData = $req->validate([
            'nombre' => 'required',
        ]); 

        $dominio = new Dominio();
        $dominio->nombre = $req->nombre;
        $dominio->save();
        $dominio->valores;
        return $dominio;
    }


    public function Add($id, Request $req)
    {                
        $validatedData = $req->validate([
            'nombre' => 'required',
        ]); 

        $valor = new Valor();
        $valor->nombre = $req->nombre;

        $dom = Dominio::find($id);
        $dom->valores()->save($valor);
        $dom->valores;
        
        return $dom;
    }    //sin malas palabras

    public function RemoveDominio($valor_id)
    {        
        $dominio = Dominio::find($valor_id);
        $dominio->Valores()->delete();
        $dominio->delete();
        return Dominio::with("valores")->get();
    }

    public function Remove($dominio_id, $valor_id)
    {        
        $valor = Valor::find($valor_id);
        $dominio = $valor->Dominio;

        $valor->delete();
        $res = $dominio->Valores;

        return $res;
    }
    
}
