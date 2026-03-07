<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Log in as the first admin user
$user = App\Models\User::where('role', 'admin')->first();
if (! $user) {
    echo "No admin user found\n";
    exit(1);
}

Illuminate\Support\Facades\Auth::login($user);

$request = Illuminate\Http\Request::create('/admin/users/data', 'GET');
$response = $kernel->handle($request);

echo "Status: " . $response->getStatusCode() . "\n";
echo "Content-Type: " . $response->headers->get('content-type') . "\n";
echo "Body (truncated):\n";
echo substr($response->getContent(), 0, 1500) . "\n";
