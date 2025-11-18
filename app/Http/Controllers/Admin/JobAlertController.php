<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class JobAlertController extends Controller
{
    /**
     * Manually trigger daily job alerts
     */
    public function sendDailyAlerts(Request $request)
    {
        try {
            // Run the command
            Artisan::call('jobs:send-daily-alerts');
            
            // Get command output
            $output = Artisan::output();
            
            Log::info('Daily job alerts sent manually', [
                'triggered_by' => auth()->user()->id ?? 'system',
                'output' => $output
            ]);
            
            return redirect()->back()->with('success', 'Daily job alerts sent successfully! Check logs for details.');
        } catch (\Exception $e) {
            Log::error('Failed to send daily job alerts manually', [
                'error' => $e->getMessage(),
                'triggered_by' => auth()->user()->id ?? 'system'
            ]);
            
            return redirect()->back()->with('error', 'Failed to send daily job alerts: ' . $e->getMessage());
        }
    }
}

