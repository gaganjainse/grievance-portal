<?php

namespace App\Console\Commands;

use App\Models\Grievance;
use Illuminate\Console\Command;

class EscalateGrievances extends Command
{
    protected $signature = 'grievances:escalate';
    protected $description = 'Escalate overdue grievances to urgent priority';

    public function handle(): int
    {
        $count = Grievance::whereNotIn('status', ['resolved', 'closed', 'rejected'])
            ->where('created_at', '<', now()->subDays(7))
            ->update(['priority' => 'urgent']);

        $this->info("{$count} grievances escalated to urgent.");

        return Command::SUCCESS;
    }
}
