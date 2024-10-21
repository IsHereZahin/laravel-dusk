<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegistrationTest extends DuskTestCase
{
    /**
    * Test to verify successful user registration.
    */
    public function testSuccessfulRegistration(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'Zahin')
                    ->type('email', 'zahin@example.com')
                    ->type('password', '12345678');

            $password = $browser->value('input[name="password"]');
            $browser->type('password_confirmation', $password)
                    ->press('button[type="submit"]')
                    ->assertPathIs('/dashboard')
                    ->assertSee('Dashboard');
        });
    }

    /**
    * Test to validate updating the user profile.
    */
    public function testUpdateProfile(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/profile')
                    ->assertSee('Profile Information')
                    ->type('name', 'Updated Zahin')
                    ->press('button[type="submit"]')
                    ->assertSee('Saved.')
                    ->assertSee('Updated Zahin')
                    ->assertPathIs('/profile');
        });
    }

    /**
    * Test to ensure successful deletion of a user profile.
    */
    public function testDeleteProfile(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/profile')
                    ->assertSee('Delete Account')
                    ->press('@delete-account-button')
                    ->type('#password', '12345678')
                    ->press('@confirm-delete-account')
                    ->assertPathIs('/');
            sleep(3);
        });
    }
}
