<?php

namespace Maksa988\FreeKassa\Test;

use Maksa988\FreeKassa\FreeKassa;
use Orchestra\Testbench\TestCase as Orchestra;
use Maksa988\FreeKassa\FreeKassaServiceProvider;

class TestCase extends Orchestra
{
    /**
     * @var FreeKassa
     */
    protected $freekassa;

    public function setUp()
    {
        parent::setUp();

        $this->freekassa = $this->app['freekassa'];

        $this->app['config']->set('freekassa.project_id', '12345');
        $this->app['config']->set('freekassa.secret_key', 'secret_key');
        $this->app['config']->set('freekassa.secret_key_second', 'secret_key_second');
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            FreeKassaServiceProvider::class,
        ];
    }

    /**
     * @param array $config
     */
    protected function withConfig(array $config)
    {
        $this->app['config']->set($config);
        $this->app->forgetInstance(FreeKassa::class);
        $this->freekassa = $this->app->make(FreeKassa::class);
    }
}
