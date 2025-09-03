<?php

namespace App\Jobs;

use App\Mail\PdfMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailReport implements ShouldQueue
{
    use Queueable, InteractsWithQueue, Queueable, SerializesModels;

    public $pdfPath;
    public $user;
    /**
     * Create a new job instance.
     */
    public function __construct($pdfPath, $user)
    {
        $this->pdfPath = $pdfPath;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new PdfMail($this->pdfPath, $this->user));
        if(file_exists($this->pdfPath)) {
            unlink($this->pdfPath); 
        }
    }
}
