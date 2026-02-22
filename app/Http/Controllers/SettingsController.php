<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function account()
    {
        return view('settings.account', [
            'user' => Auth::user(),
        ]);
    }

    public function updateAccount(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'string', function (string $attribute, mixed $value, \Closure $fail) use ($user) {
                if (! Hash::check($value, $user->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Current password is required.',
            'password.required' => 'New password is required.',
            'password.min' => 'New password must be at least 8 characters.',
            'password.confirmed' => 'New password confirmation does not match.',
        ]);

        $user->password = $validated['password'];
        $user->save();

        return redirect()
            ->route('settings.account')
            ->with('success', 'Your password has been updated.');
    }

    public function backups()
    {
        return view('settings.backups', [
            'driver' => config('database.default'),
        ]);
    }

    public function exportBackup(Request $request)
    {
        $driver = config('database.default');
        $filename = 'bhcis-backup-'.now()->format('Y-m-d-His');

        if ($driver === 'sqlite') {
            $path = config('database.connections.sqlite.database');
            if (! is_file($path)) {
                return redirect()
                    ->route('settings.backups')
                    ->with('error', 'Database file not found.');
            }
            $filename .= '.sqlite';

            return response()->download($path, $filename, [
                'Content-Type' => 'application/octet-stream',
            ]);
        }

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            $conn = config('database.connections.'.$driver);
            $filename .= '.sql';
            $command = [
                'mysqldump',
                '-h', $conn['host'],
                '-P', (string) $conn['port'],
                '-u', $conn['username'],
                '--single-transaction',
                '--quick',
                '--skip-lock-tables',
                $conn['database'],
            ];
            $env = [];
            if (! empty($conn['password'])) {
                $env['MYSQL_PWD'] = $conn['password'];
            }
            $process = new Process($command, null, $env);
            $process->setTimeout(120);
            $process->run();
            if (! $process->isSuccessful()) {
                return redirect()
                    ->route('settings.backups')
                    ->with('error', 'Backup failed. Ensure mysqldump is installed and credentials are correct.');
            }
            Storage::put($filename, $process->getOutput());
            $path = storage_path('app/'.$filename);
            $response = response()->download($path, $filename, [
                'Content-Type' => 'application/sql',
            ]);
            $response->deleteFileAfterSend(true);

            return $response;
        }

        return redirect()
            ->route('settings.backups')
            ->with('error', 'Unsupported database driver for export.');
    }
}
