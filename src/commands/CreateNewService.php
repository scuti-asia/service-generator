<?php

namespace Scuti\Admin\ServiceGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CreateNewService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : Class (singular) for example User}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create service operations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');

        $this->createServiceLayer($name);

        File::append(
            base_path('routes/api.php'),
            'Route::resource(\'' . Str::plural(strtolower($name)) . "', '{$name}Service');"
        );
    }

    protected function getStub($type)
    {
        return __DIR__ . "/stubs/$type.stub";
    }

    protected function createServiceLayer($name)
    {
        $serviceTemplate = str_replace(
            ['{{serviceName}}'],
            [$name.'Service'],
            $this->getStub('ServiceEntity')
        );

        if(!file_exists($path = app_path('/Services'))) {
            mkdir($path, 0777, true);
        }

        file_put_contents(app_path("/Services/{$name}.php"), $serviceTemplate);
    }
}
