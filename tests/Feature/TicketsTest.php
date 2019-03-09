<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker;
use App\Ticket;

class TicketsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $faker = Faker\Factory::create();

        $title = $faker->sentence();
        $description = $faker->paragraph();
        $email = $faker->email();

        $responseIndex = $this->get(route('tickets.index'));
        $responseIndex->assertStatus(200);

        $responseCreate = $this->get(route('tickets.create'));
        $responseCreate->assertStatus(200);

        $responseStore = $this->post(route('tickets.store'), [
            'title' => $title,
            'description' => $description,
            'reporter' => $email
        ]);
        $responseStore->assertStatus(201);

        $this->assertDatabaseHas('tickets', [
            'title' => $title,
            'reporter' => $email,
            'description' => $description,
            'status' => Ticket::STATUS_OPENED,
            'rating' => 0,
        ]);
    }

    public function testChangeDescription()
    {
        $faker = Faker\Factory::create();
        $anotherDescription = $faker->paragraph();

        $ticket = factory(\App\Ticket::class)
            ->state('opened')
            ->create();

        $responseShow = $this->get(route('tickets.show', ['ticket' => $ticket]));
        $responseShow->assertStatus(200);

        $responseEdit = $this->get(route('tickets.edit', ['ticket' => $ticket]));
        $responseEdit->assertStatus(200);

        $responseUpdate = $this->put(route('tickets.update', ['ticket' => $ticket]), [
            'description' => $anotherDescription,
        ]);
        $responseUpdate->assertStatus(302);

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'description' => $anotherDescription,
        ]);
    }

    public function testDelete()
    {
        $ticket = factory(\App\Ticket::class)
                ->state('opened')
                ->create();

        $responseShow = $this->get(route('tickets.show', ['ticket' => $ticket]));
        $responseShow->assertStatus(200);

        $responseDelete = $this->delete(route('tickets.destroy', ['ticket' => $ticket]));
        $responseDelete->assertStatus(302);

        $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);

        $responseNotFound = $this->get(route('tickets.show', ['ticket' => $ticket]));
        $responseNotFound->assertStatus(404);
    }
}
