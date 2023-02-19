<?php

namespace Tests\Browser;

use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Chrome;
use Tests\DuskTestCase;
use function PHPUnit\Framework\assertNotEquals;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testCanLoginAndSeeDashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
        ]);

        $location = Location::factory()->withRealAddressAndLatLng()->create();

        $this->browse(function ($first, $second) {
            $first->loginAs(User::find(1))
                ->visit('/admin')
                ->assertSee('Dashboard');
        });
    }

    public function testCanSeeMap()
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
        ]);

        Location::factory()->create();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/locations/1/edit')
                ->assertSee('Edit Location')
                ->pause(1000)
                ->assertVisible('#gmimap0');
        });
    }

    public function testCanMoveMarkerAndFormFieldChanges()
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
        ]);

        $location1 = Location::factory()->withRealAddressAndLatLng('united-states-of-america', 'Dallas, TX')->create();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/locations/1/edit')
                ->assertSee('Edit Location')
                ->waitUntil('window.filamentGoogleMapsAPILoaded')
                ->pause(500)
                ->assertVisible('#gmimap0');

            $browser->screenshot('before');

            $zip1 = $browser->value('#data\\.zip');

            $browser->clickAtPoint(660, 681)
                ->pause(1000);

            $browser->screenshot('after');

            $zip2 = $browser->value('#data\\.zip');

//            $lat2 = $browser->script("return Alpine.mergeProxies(document.querySelector('body #data\\\\.location-alpine')._x_dataStack).fgm.marker.getPosition().lat()");
//            $lng2 = $browser->script("return Alpine.mergeProxies(document.querySelector('body #data\\\\.location-alpine')._x_dataStack).fgm.marker.getPosition().lng()");

            assertNotEquals($zip1, $zip2);

            $browser->click('@filament.admin.action.save')
                ->waitForText('All Locations');
        });

        $location2 = Location::find(1);

        assertNotEquals($location1->lat, $location2->lat);
    }
}
