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
                    ->type('password', '12345678')
                    ->type('password_confirmation', '12345678')
                    ->press('button[type="submit"]')
                    ->assertPathIs('/dashboard')
                    ->assertSee('Dashboard')
                    ->clickAtXPath('//div[text() = "Zahin"]')
                    ->clickAtXPath('//a[contains(text(), "Log Out")]')
                    ->assertPathIs('/');


            // Attempt to log in
            $browser->visit('/login')
                    ->type('email', 'zahin@example.com')
                    ->type('password', '12345678')
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
                    ->press('@confirm-delete-account')
                    ->assertSee('The password field is required.')
                    ->type('#password', 'wrongpassword')
                    ->press('@confirm-delete-account')
                    ->assertSee('The password is incorrect.')
                    ->type('#password', '12345678')
                    ->press('@confirm-delete-account')
                    ->assertPathIs('/');
            sleep(3);
        });
    }

    /**
    * Test to ensure the user cannot login with a deleted account.
    */
    public function testDeletedAccountCannotLogin(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'zahin@example.com')
                    ->type('password', '12345678')
                    ->press('button[type="submit"]')
                    ->assertSee('These credentials do not match our records.');
        });
    }
}
