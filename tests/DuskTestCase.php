<?php

namespace Tests;

use Dotenv\Dotenv;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Laravel\Dusk\TestCase as BaseTestCase;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        if (! static::runningInSail()) {
            static::startChromeDriver();
        }
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments(collect([
            $this->shouldStartMaximized() ? '--start-maximized' : '--window-size=1920,1080',
        ])->unless($this->hasHeadlessDisabled(), function ($items) {
            return $items->merge([
                '--disable-gpu',
                '--headless',
            ]);
        })->all());

        return RemoteWebDriver::create(
            $_ENV['DUSK_DRIVER_URL'] ?? 'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }

    /**
     * Determine whether the Dusk command has disabled headless mode.
     *
     * @return bool
     */
    protected function hasHeadlessDisabled()
    {
        return isset($_SERVER['DUSK_HEADLESS_DISABLED']) ||
               isset($_ENV['DUSK_HEADLESS_DISABLED']);
    }

    /**
     * Determine if the browser window should start maximized.
     *
     * @return bool
     */
    protected function shouldStartMaximized()
    {
        return isset($_SERVER['DUSK_START_MAXIMIZED']) ||
               isset($_ENV['DUSK_START_MAXIMIZED']);
    }


    /**
     * https://github.com/laravel/dusk/issues/883
     */

    public static function basePath($path = '') {
        return __DIR__. '/../' . ($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public static function setUpBeforeClass(): void
    {
        if (file_get_contents(self::basePath('.env')) !== file_get_contents(self::basePath('.env.dusk.local'))) {
            copy(self::basePath('.env'), self::basePath('.env.backup'));
        }
        copy(self::basePath('.env.dusk.local'), self::basePath('.env'));
        Dotenv::createMutable(self::basePath())->load();

        parent::setUpBeforeClass();
    }

    public static function tearDownAfterClass(): void
    {
        copy(self::basePath('.env.backup'), self::basePath('.env'));
        unlink(self::basePath('.env.backup'));
        Dotenv::createMutable(self::basePath())->load();

        parent::tearDownAfterClass();
    }
}
