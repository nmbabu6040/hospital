<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\CreateBackupJob;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class BackupController extends Controller
{
    protected function disk()
    {
        $diskName = config('backup.backup.destination.disks')[0] ?? 'local';

        return Storage::disk($diskName);
    }

    protected function backupFolder(): string
    {
        return config('backup.backup.name');
    }

    public function index()
    {
        $disk = $this->disk();
        $folder = $this->backupFolder();
        $backups = [];

        if ($disk->exists($folder)) {
            $files = $disk->files($folder);

            foreach ($files as $file) {
                if (str_ends_with($file, '.zip')) {
                    $backups[] = [
                        'name' => basename($file),
                        'path' => $file,
                        'size' => $this->formatBytes($disk->size($file)),
                        'date' => date('d M, Y h:i A', $disk->lastModified($file)),
                        'timestamp' => $disk->lastModified($file),
                    ];
                }
            }

            usort($backups, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);
        }

        return view('admin.backups.index', compact('backups'));
    }

    // public function create()
    // {
    //     $process = new Process([
    //         'C:\\xampp\\mysql\\bin\\mysqldump.exe',
    //         '--protocol=TCP',
    //         '--host=127.0.0.1',
    //         '--port=3306',
    //         '--user=root',
    //         '--no-data',
    //         'hospital_db',
    //     ]);

    //     $process->setTimeout(60);
    //     $process->run();

    //     \Log::info('Direct mysqldump test', [
    //         'successful' => $process->isSuccessful(),
    //         'exit_code' => $process->getExitCode(),
    //         'output' => substr($process->getOutput(), 0, 1000),
    //         'error' => $process->getErrorOutput(),
    //     ]);

    //     return back()->with(
    //         'success',
    //         $process->isSuccessful()
    //             ? 'Direct mysqldump test SUCCESS!'
    //             : 'Direct mysqldump test FAILED! Check laravel.log'
    //     );
    // }

    public function create()
    {
        CreateBackupJob::dispatch();

        return back()->with(
            'success',
            'Backup request submitted. Backup is processing.'
        );
    }

    public function download(string $filename)
    {
        $disk = $this->disk();
        $path = $this->backupFolder() . '/' . $filename;

        if (! $disk->exists($path) || ! str_ends_with($filename, '.zip')) {
            abort(404, 'Backup file not found.');
        }

        return $disk->download($path);
    }

    public function destroy(string $filename)
    {
        $disk = $this->disk();
        $path = $this->backupFolder() . '/' . $filename;

        if ($disk->exists($path) && str_ends_with($filename, '.zip')) {
            $disk->delete($path);

            return back()->with('success', 'Backup deleted successfully.');
        }

        return back()->with('error', 'Backup file not found.');
    }

    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
