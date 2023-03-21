<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Agenda;
use App\Models\Telefone;
use Faker\Factory as Faker;


class AgendaTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_agenda_create(): void
    {
        Agenda::factory()->count(100)->create();

        $this->assertDatabaseCount('agendas', 100);
    }

    public function test_store_telephones(): void
    {
        $agenda = Agenda::factory()->create();

        $agenda->telefones()->createMany(
            Telefone::factory()->count(2)->make()->toArray()
        );

        $this->assertDatabaseCount('telefones', 2);
    }

    public function test_agenda_telefones(): void
    {
        $agenda = Agenda::factory()->create();

        $agenda->telefones()->create(
            Telefone::factory()->make()->toArray()
        );

        $this->assertEquals($agenda->telefones()->first()->agenda_id, $agenda->id);
    }

    public function test_create_agenda_route(): void
    {
        $faker = Faker::create('pt_BR');

        $nome = $faker->name();
        $email = $faker->email();
        $cpf = $faker->cpf();
        $telefone = $faker->phoneNumber();

        $this->post(route('agenda.store'), [
            'nome' => $nome,
            'email' => $email,
            'cpf' => $cpf,
            'telefones' => [
                0 => $telefone,
            ]
        ]);

        $this->assertDatabaseHas('agendas', [
            'nome' => $nome,
            'email' => $email,
            'cpf' => $cpf,
        ]);

        $this->assertDatabaseHas('telefones', [
            'telefone' => $telefone,
        ]);
    }

    public function test_delete_agenda(): void
    {
        $agenda = Agenda::factory()->create();

        $this->delete(route('agenda.destroy', $agenda->id));

        $this->assertDatabaseEmpty('agendas');
    }

    public function test_index_agenda()
    {
        Agenda::factory()->count(100)->create();

        $this->get(route('agenda.index'))->assertStatus(200);
    }

    public function test_update_agenda(): void
    {
        $faker = Faker::create('pt_BR');

        $nome = $faker->name();
        $email = $faker->email();
        $cpf = $faker->cpf();
        $telefone = $faker->phoneNumber();

        $response = $this->post(route('agenda.store'), [
            'nome' => $nome,
            'email' => $email,
            'cpf' => $cpf,
            'telefones' => [
                0 => $telefone,
            ]
        ]);

        $agenda = json_encode($response, true);
        $agenda = json_decode($agenda, true);

        $telefone = Telefone::where('agenda_id', $agenda['baseResponse']['original'][0]['id'])->get();

        $this->put(route('agenda.update', $agenda['baseResponse']['original'][0]['id']), [
            'nome' => $nome . 'alterado',
            'email' => $email . 'alterado',
            'cpf' => $cpf . 'alterado',
            'telefones' => [
                'id' => $telefone->first()->id,
                'telefone' => $telefone . 'alterado',
            ]
        ]);

        $this->assertDatabaseHas('agendas', [
            'nome' => $nome . 'alterado',
            'email' => $email . 'alterado',
            'cpf' => $cpf . 'alterado',
        ]);
        $this->assertDatabaseHas('telefones', [
            'agenda_id' => $agenda['baseResponse']['original'][0]['id'],
            'telefone' => $telefone . 'alterado'
        ]);
    }

    public function test_agenda_nomes(): void
    {
        $this->seed();

        $this->get(route('agenda.nomes'))->assertStatus(200);
    }
}
