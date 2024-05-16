<?php

namespace App\Http\Controllers;

use App\Mail\ContactosMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactanosController extends Controller
{
    public function index(){
        return view('sobre-nosotros');
    }

    public function store(Request $request){
        Mail::to('pruebapadelindoorturiaso@gmail.com')
            ->send(new ContactosMail($request->all()));

        session()->flash('info','Mensaje enviado');

        return redirect('sobre-nosotros');
    }
}
