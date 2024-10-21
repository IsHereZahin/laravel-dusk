<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegistrationTest extends DuskTestCase
{
    /**
     * A Dusk test example for the registration form.
     */
    public function testSuccessfulRegistration(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register');

            $browser->type('name', 'Zahin')
                    ->type('email', 'zahin@example.com')
                    ->type('password', '12345678');

            $password = $browser->value('input[name="password"]');
            $browser->type('password_confirmation', $password);

            $browser->press('button[type="submit"]');
            $browser->assertPathIs('/dashboard');
            $browser->assertSee('Dashboard');
            sleep(3);
        });
    }
}
