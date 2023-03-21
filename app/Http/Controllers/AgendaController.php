<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Actions\AgendaCreate;
use App\Models\Agenda;
use App\Actions\AgendaUpdate;

class AgendaController extends Controller
{
    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $agenda = Agenda::with('telefones')->get();

        return response()->json($agenda);
    }
    /**
     * store
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $newAgenda = app(AgendaCreate::class)->execute($request);

        return response()->json($newAgenda);
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $agenda = Agenda::where('id', $id)->delete();

        if ($agenda) {
            return new JsonResponse(['message' => 'Deletado com sucesso'], 200);
        } else {
            return new JsonResponse(['message' => 'Erro ao tentar deletar'], 400);
        }
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $agenda = app(AgendaUpdate::class)->execute($request, $id);

        return response()->json($agenda);
    }

    /**
     * names
     *
     * @return JsonResponse
     */
    public function names(): JsonResponse
    {
        $agenda = Agenda::all()->sortBy('nome')->pluck('nome');

        return response()->json($agenda);
    }
}
