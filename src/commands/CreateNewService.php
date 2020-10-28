<?php

namespace Scuti\Admin\ServiceGenerator\Commands;

use Illuminate\Config\Repository;
use Illuminate\Console\Command;

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
     * @var Repository
     */
    protected $config;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(Repository $config)
    {
        $this->config = $config;
        $name = $this->argument('name');

        $this->createServiceLayer($name);
    }

    protected function getStub($type)
    {
        return file_get_contents(__DIR__ . "/stubs/" . $type . ".stub");
    }

    protected function createServiceLayer($name)
    {
        $servicePath = $this->config->get('service-generator.service_path');
        $nameSpace = $this->namespaceGenerate(explode(DIRECTORY_SEPARATOR, $servicePath));
        $contractClass = '';
        $contractNamespace = '';

        if (config('service-generator.allow_implement_interface')) {
            $contractClass = $name.'ServiceContract';
            $contractNamespace = $this->namespaceGenerate(explode(DIRECTORY_SEPARATOR, $servicePath . DIRECTORY_SEPARATOR . 'Contracts'));
            $interfaceTemplate = str_replace(
                ['{{contractName}}', '{{contractNamespace}}'],
                [$contractClass, $contractNamespace],
                $this->getStub('ContractEntity')
            );

            if(!file_exists($interfacePath = app_path($servicePath . DIRECTORY_SEPARATOR . 'Contracts'))) {
                mkdir($interfacePath, 0775, true);
            }

            file_put_contents($interfacePath . DIRECTORY_SEPARATOR . $contractClass . ".php", $interfaceTemplate);
        }
        $implementContract = ' implements ' . $contractClass;

        $serviceTemplate = str_replace(
            [
                '{{serviceName}}',
                '{{serviceNamespace}}',
                '{{implementContract}}',
                '{{useContract}}'
            ],
            [
                $name.'Service',
                $nameSpace,
                config('service-generator.allow_implement_interface') ? $implementContract : '',
                config('service-generator.allow_implement_interface') ? 'use ' . $contractNamespace . '\\' . $contractClass . ';' . PHP_EOL : '',
            ],
            $this->getStub('ServiceEntity')
        );

        if(!file_exists($path = app_path($servicePath))) {
            mkdir($path, 0775, true);
        }

        file_put_contents($path . DIRECTORY_SEPARATOR . "{$name}Service.php", $serviceTemplate);
    }

    private function namespaceGenerate(array $subPaths) : string
    {
        return app()->getNamespace() . implode("\\", $subPaths);
    }
}
