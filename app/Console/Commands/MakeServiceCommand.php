<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeServiceCommand extends Command
{
    protected $signature = 'make:service {name}';
    protected $description = 'Create a new service class';

    public function handle()
    {
        $name = $this->argument('name');
        $servicePath = app_path('Services/' . $name . '.php');

        // Create Services directory if it doesn't exist
        if (!File::exists(app_path('Services'))) {
            File::makeDirectory(app_path('Services'));
        }

        // Check if service already exists
        if (File::exists($servicePath)) {
            $this->error('Service already exists!');
            return;
        }

        // Create the service stub
        $stub = <<<EOT
<?php

namespace App\Services;

class {$name}
{
    public function __construct()
    {
        // Constructor logic
    }
    
    // Add your service methods here
}
EOT;

        File::put($servicePath, $stub);

        $this->info("Service created successfully: {$name}");
    }
}
