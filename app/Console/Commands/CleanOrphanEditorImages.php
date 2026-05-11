<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Article;
use Carbon\Carbon;

#[Signature('app:clean-orphan-editor-images')]
#[Description('Command description')]
class CleanOrphanEditorImages extends Command
{
    /**
     * Execute the console command.
     */

    protected $signature = 'images:clean-orphan';
    protected $description = 'Clean up orphan images uploaded by editors that are not referenced in any article content.';

    public function handle()
    {
        $this->info('Starting to clean orphan editor images...');

        $allFiles = Storage::disk('public')->files('editor_images');

        $allContent = Article::pluck('content')->implode(' ');

        foreach ($allFiles as $file) {
            $fileName = basename($file);
            
            if (!str_contains($allContent, $fileName)) {

                $lastModified = Storage::disk('public')->lastModified($file);
                $fileAge = Carbon::createFromTimestamp($lastModified);

                if ($fileAge->diffInDays(Carbon::now()) >= 7) {
                    Storage::disk('public')->delete($file);
                    $this->error("Deleted orphan image: $fileName");
                } 
            }
        }

        $this->info('Finished cleaning orphan editor images.');
    }
}
