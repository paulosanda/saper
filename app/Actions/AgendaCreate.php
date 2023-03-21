<?php

namespace App\Actions;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Telefone;

class AgendaCreate extends BaseAction
{
    protected function rules(): array
    {
        return [
            'nome' => 'string|required',
            'email' => 'string|required',
            'cpf' => 'string|required',
            'telefones' => 'array|required'

        ];
    }

    public function execute(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), $this->rules());

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $agenda = Agenda::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'cpf' => $request->cpf,
            ]);

            foreach ($request->telefones as $telefone) {
                Telefone::create([
                    'agenda_id' => $agenda->id,
                    'telefone' => $telefone
                ]);
            }

            $newAgenda  = Agenda::with('telefones')->where('id', $agenda->id)->get();

            return $newAgenda;
        } catch (ValidationException $e) {

            return response()->json($e->errors(), 422);
        }
    }
}
