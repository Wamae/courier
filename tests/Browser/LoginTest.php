<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser,$browser2) {
            /*$browser->visit('http://127.0.0.1:8000/')
                    ->assertSee('Username')
                    ->type('email',"Admin")
                    ->type('password',"admin123")
                    ->click('#login')
                    ->assertSee('List of Package types');*/
            
            $browser2->visit('http://127.0.0.1:8000/')
                    ->assertSee('Username')
                    ->type('email',"Staff")
                    ->type('password',"staff123")
                    ->click('#login')
                    ->assertSee('Waybill Information Entry Management');
        });
    }
}
