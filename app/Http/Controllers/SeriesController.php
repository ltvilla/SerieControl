<?php

namespace App\Http\Controllers;

use App\Events\NovaSerieMail;
use App\Http\Requests\SeriesFormRequest;
use App\Mail\NovaSerie;
use App\Serie;
use App\Services\CriadorDeSerie;
use App\Services\RemovedorDeSerie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->user()->id;
        
        $series = Serie::query(5)->where('user_id', '=', $userId)
            ->orderBy('nome')
            ->get();

        $mensagem = $request->session()->get('mensagem');

        

        return view('series.index', compact('series', 'mensagem'));
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request, CriadorDeSerie $criadorDeSerie) 
    {
        $userId = auth()->user()->id;

        $capa = null;

        if($request->hasFile('capa')) {
            $capa = $request->file('capa')->store('serie');
        }
        


        $serie = $criadorDeSerie->criarSerie(
            $request->nome,
            $request->qtd_temporadas,
            $request->ep_por_temporada,
            $userId,
            $capa
        );

        $email = new NovaSerie(
            $request->nome,
            $request->qtd_temporadas,
            $request->ep_por_temporada
        );

        $email->subject('Nova Série Adicionada');

        $eventoNovaserie = new NovaSerieMail(
            $request->nome,
            $request->qtd_temporadas,
            $request->ep_por_temporada
        );

        event($eventoNovaserie);


        $user = $request->user();
        


        $request->session()
            ->flash(
                'mensagem',
                "Série {$serie->id} e suas temporadas e episódios criados com sucesso {$serie->nome}"
            );

        return redirect()->route('listar_series');
    }

    public function destroy(Request $request, RemovedorDeSerie $removedorDeSerie)
    {
        $nomeSerie = $removedorDeSerie->removerSerie($request->id);
        $request->session()
            ->flash(
                'mensagem',
                "Série $nomeSerie removida com sucesso"
            );
        return redirect()->route('listar_series');
    }

    public function editaNome(int $id, Request $request)
    {
        $serie = Serie::find($id);
        $novoNome = $request->nome;
        $serie->nome = $novoNome;
        $serie->save();
    }
}
