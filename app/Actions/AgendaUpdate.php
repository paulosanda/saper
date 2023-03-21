<?php

namespace App\Actions;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Telefone;

class AgendaUpdate extends BaseAction
{
    protected function rules(): array
    {
        return [
            'nome' => 'string|required',
            'email' => 'string|required',
            'cpf' => 'string|required',
            'telefones' => [
                '*' => [
                    'id' => 'required',
                    'telefone' => 'string|required'
                ]
            ]
        ];
    }

    public function execute(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), $this->rules());

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $agenda = Agenda::where('id', $id)->update([
                'nome' => $request->nome,
                'email' => $request->email,
                'cpf' => $request->cpf,
            ]);

            foreach ($request->telefones as $telefone) {
                Telefone::where('id', $id)->update([
                    'telefone' => $telefone
                ]);
            }

            $newAgenda  = Agenda::with('telefones')->where('id', $id)->get();

            return $newAgenda;
        } catch (ValidationException $e) {
            return response()->json($e->errors(), 422);
        }
    }
}
