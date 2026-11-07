<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Throwable;

class CreateBackupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600;

    public function handle(): void
    {
        try {
            $exitCode = Artisan::call('backup:run');
            $output = Artisan::output();

            if ($exitCode !== 0 || str_contains(strtolower($output), 'failed')) {
                throw new \RuntimeException($output);
            }

            Log::info('Admin backup completed successfully.', [
                'output' => $output,
            ]);
        } catch (Throwable $e) {
            Log::error('Admin backup job failed.', [
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
