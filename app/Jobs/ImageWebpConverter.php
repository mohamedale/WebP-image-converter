<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Drivers\Gd\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class ImageWebpConverter implements ShouldQueue
{
    use Queueable;

    public string $imagePath;
    public string $imageQuality;

    /**
     * Create a new job instance.
     */
    public function __construct($convertingData)
    {
        $this->imagePath = $convertingData['path'];
        $this->imageQuality = $convertingData['quality'] ?? 85;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Init image manager
        $manager = new ImageManager(Driver::class);

        // Fetch image data
        $imageName = pathinfo($this->imagePath, PATHINFO_FILENAME);

        // Create dir if not exists
        $convertedImagesDir = public_path('convertedImages');
        if (!file_exists($convertedImagesDir)) {
            mkdir($convertedImagesDir);
        }

        // Collect full path
        $imagePathToSave = $convertedImagesDir . '/' . $imageName.'.webp';

        // Check image path is url
        if (filter_var($this->imagePath, FILTER_VALIDATE_URL)) {
            $image = file_get_contents($this->imagePath);
        }

        // Convert image
        $manager->read($image ?? $this->imagePath)->encode(new WebpEncoder($this->imageQuality))->save($imagePathToSave);
    }
}
