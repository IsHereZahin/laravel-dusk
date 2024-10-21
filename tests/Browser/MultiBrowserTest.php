<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MultiBrowserTest extends DuskTestCase
{
    /**
    * Test example to run tests in multiple browser instances.
    */
    public function testMultiBrowserExample(): void
    {
        $this->browse(function (Browser $browser1, Browser $browser2) {
            $screenWidth = 1920;
            $screenHeight = 1080;

            $browser1->resize($screenWidth / 2, $screenHeight)->move(0, 0);
            $browser2->resize($screenWidth / 2, $screenHeight)->move($screenWidth / 2, 0);

            $browser1->visit('/')
                ->assertSee('Laravel')
                ->pause(10000);

            $browser2->visit('/')
                ->assertSee('Laravel')
                ->pause(10000);
        });
    }
}
