<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EntrarController extends Controller
{

    public function index()
    {
        return view('entrar.index');
    }

    public function entrar(Request $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return redirect()
                ->back()
                ->withErrors('Usuário e/ou senha incorretos');
        }

        //$repository = $this->getDoctrine()->getRepository(User::class);

        $serie = User::where('email', $request->only('email'))->get();
        $serieId = $serie[0]['id'];
        return redirect()->route('listar_series', compact('serieId'));
    }
}
