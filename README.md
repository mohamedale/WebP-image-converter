# WebP Image Conversion using Laravel Queues

This project demonstrates how to convert images (local or remote) to WebP format using Laravel queues and the Intervention Image package.

## Requirements

- PHP >= 7.4
- Laravel 8.x or higher
- Composer
- A Queue service (e.g., `database`, `redis`, or `sqs`)
- Intervention Image package

## Installation

1. **Install Laravel Project**:

   If you don't have the Laravel project setup yet, you can create a new Laravel project:

    ```bash
    composer create-project --prefer-dist laravel/laravel image-conversion
    ```

2. **Install Intervention Image Package**:

   Install the Intervention Image package using Composer:

    ```bash
    composer require intervention/image
    ```

3. **Set Up Queue Configuration**:

   Laravel uses queues to handle background jobs. Ensure that you have set up a queue driver in your `.env` file. For example, using the `database` driver:

    ```dotenv
    QUEUE_CONNECTION=database
    ```

4. **Run Migrations**:

   If you are using the `database` driver, you need to run the migration for the `jobs` table:

    ```bash
    php artisan queue:table
    php artisan migrate
    ```

5. **Queue Worker**:

   Start the queue worker to process the jobs:

    ```bash
    php artisan queue:work
    ```

## Code Explanation

### Route

In the `routes/web.php` file, we define a route to trigger the image conversion process:

```php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fire-queue', function () {
    // Image data for conversion (local image path or remote image URL)
    $imageData = [
        'path' => public_path('test.png'), // Local image path
        // 'path' => 'https://domain.com/awesome-image.jpeg', // Remote image URL
        'quality' => 80 // Optional image quality (default is 85)
    ];

    // Dispatch the job for image conversion
    \App\Jobs\ImageWebpConverter::dispatch($imageData);
});
