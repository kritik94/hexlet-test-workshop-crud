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

    public function testIndex()
    {
        $response = $this->get(route('tickets.index'));
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreate()
    {
        factory(\App\Ticket::class)->state('opened')->create();

        $responseCreate = $this->get(route('tickets.create'));
        $responseCreate->assertStatus(200);
    }

    public function testStore()
    {
        $faker = Faker\Factory::create();

        $title = $faker->sentence();
        $description = $faker->paragraph();
        $email = $faker->email();

        $responseStore = $this->post(route('tickets.store'), [
            'title' => $title,
            'description' => $description,
            'reporter' => $email,
        ]);
        $responseStore->assertStatus(201);

        $this->assertTrue(Ticket::where('title', $title)->exists());
    }

    public function testShow()
    {
        $ticket = factory(\App\Ticket::class)->state('opened')->create();

        $responseShow = $this->get(route('tickets.show', ['ticket' => $ticket]));
        $responseShow->assertStatus(200);
    }

    public function testEdit()
    {
        $ticket = factory(\App\Ticket::class)->state('opened')->create();

        $responseEdit = $this->get(route('tickets.edit', ['ticket' => $ticket]));
        $responseEdit->assertStatus(200);
    }

    public function testUpdate()
    {
        $faker = Faker\Factory::create();
        $anotherDescription = $faker->paragraph();
        $ticket = factory(\App\Ticket::class)->state('opened')->create();

        $responseUpdate = $this->put(route('tickets.update', ['ticket' => $ticket]), [
            'description' => $anotherDescription,
        ]);
        $responseUpdate->assertStatus(302);

        $freshTicket = $ticket->fresh();

        $this->assertEquals($anotherDescription, $freshTicket->description);
    }

    public function testDelete()
    {
        $ticket = factory(\App\Ticket::class)->state('opened')->create();

        $responseDelete = $this->delete(route('tickets.destroy', ['ticket' => $ticket]));
        $responseDelete->assertStatus(302);

        $this->assertFalse(Ticket::where('id', $ticket->id)->exists());
    }
}
