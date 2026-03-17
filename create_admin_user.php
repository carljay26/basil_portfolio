<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class);

$user = User::updateOrCreate(
    ['email' => 'basilfulgencio@gmail.com'],
    [
        'name' => 'Admin',
        'password' => Hash::make('Admin@1234'),
    ]
);

echo \"Created/updated admin user with ID: {$user->id}\\n\";

