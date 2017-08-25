<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Marca;
use App\Taller;
use App\Calificacion;
use App\Vehiculo;

class IntegracionTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testIntegracion()
    {
        $this->browse(function ($first, $second) {
            $first->loginAs(User::find(21))
                  ->visit('busquedataller')
                  ->waitForText('Búsqueda del Taller')
                  ->click('#search-btn')
                  ->pause(5000)
                  ->assertSee('TalleresDemo Testing')
                  ->clickLink('TalleresDemo Testing')
                  ->press('Deseo ponerme en contacto')
                  ->pause(2000)
                  ->assertSee('22920556 o 0982472750');
              });
    }
}
