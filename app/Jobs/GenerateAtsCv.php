<?php

namespace App\Jobs;

use App\Models\AtsCvPurchase;
use App\Services\AffindaService;
use App\Services\OpenAiCvRewriter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GenerateAtsCv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 180;
    public int $backoff = 30;

    public function __construct(public int $purchaseId) {}

    public function handle(AffindaService $affinda, OpenAiCvRewriter $rewriter): void
    {
        $purchase = AtsCvPurchase::find($this->purchaseId);
        if (! $purchase) {
            return;
        }

        if ($purchase->status === 'completed') {
            return;
        }

        if (! in_array($purchase->status, ['paid', 'generating'], true)) {
            return;
        }

        if (! $purchase->source_cv_path) {
            // Awaiting user upload — keep status as paid so they can upload.
            $purchase->update(['status' => 'paid']);
            return;
        }

        $purchase->update(['status' => 'generating']);

        try {
            $absolutePath = Storage::disk('public')->path($purchase->source_cv_path);
            if (! file_exists($absolutePath)) {
                throw new \RuntimeException('Source CV file not found.');
            }

            $parsed = $affinda->parseResume($absolutePath);
            $purchase->update(['parsed_data' => $parsed]);

            $targetRole = data_get($purchase->rewrite_payload, 'target_role');
            $rewrite = $rewriter->rewrite($parsed, $targetRole);

            $pdf = Pdf::loadView('ats.pdf.standard', [
                'cv' => $rewrite,
            ])->setPaper('a4');

            $filename = 'ats-cv/generated/' . $purchase->user_id . '/' . $purchase->id . '_' . now()->format('Ymd_His') . '.pdf';
            Storage::disk('public')->put($filename, $pdf->output());

            $purchase->update([
                'rewrite_payload'   => $rewrite,
                'generated_cv_path' => $filename,
                'ats_score'         => is_numeric($rewrite['ats_score'] ?? null) ? (int) $rewrite['ats_score'] : null,
                'status'            => 'completed',
                'completed_at'      => now(),
            ]);
        } catch (\Throwable $e) {
            Log::error('ATS CV generation failed', [
                'purchase_id' => $this->purchaseId,
                'error'       => $e->getMessage(),
            ]);
            $purchase->update([
                'status'        => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
