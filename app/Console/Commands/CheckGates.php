<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Auth\Access\Gate;
use App\Developer;

class CheckGates extends Command
{
    protected $signature = 'gate:check {username}';
    protected $description = 'Check access of user for all defined gates in Laravel';

    protected $gate;

    public function __construct(Gate $gate)
    {
        parent::__construct();
        $this->gate = $gate;
    }
    protected function getClosureContents(\Closure $closure)
    {
        $reflection = new \ReflectionFunction($closure);
        $closureCode = file($reflection->getFileName());

        $startLine = $reflection->getStartLine();
        $endLine = $reflection->getEndLine();

        $contents = array_slice($closureCode, $startLine - 1, $endLine - $startLine + 1);

        return implode('', $contents);
    }
    public function handle()
    {
        $username = $this->argument('username');
        $user = Developer::where('username', $username)->first();

        if (!$user) {
            $this->error("No user found with username: $username");
            return;
        }

        $gates = $this->gate->abilities();
        $self = $this;

        $tableData = array_reduce(array_keys($gates), function ($carry, $key) use ($gates, $user, $self) {
            $value = $gates[$key];
            $hasAccess = $this->gate->forUser($user)->check($key);

            $carry[] = [
                'Gate Name' => $key,
                'Access' => $hasAccess ? '<fg=green>Pass</>' : '<fg=red>Restricted</>',
                'Closure Contents' => $self->getClosureContents($value),
            ];

            return $carry;
        }, []);

        $this->table(['Gate Name','Access', 'Closure Contents'], $tableData);
    }
}
