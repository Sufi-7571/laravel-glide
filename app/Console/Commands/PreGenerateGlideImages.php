<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PreGenerateGlideImages extends Command
{
    protected $signature = 'glide:generate';
    protected $description = 'Pre-generate all Glide image transformations';

    public function handle()
    {
        $users = User::all();

        $transformations = [
            'w=200&h=200&fit=crop',
            'w=200&h=200&fit=crop&filt=greyscale',
            'w=200&h=200&fit=crop&filt=sepia',
            'w=200&h=200&fit=crop&blur=15',
            'w=200&h=200&fit=crop&pixel=10',
            'w=200&h=200&fit=crop&bri=30',
            'w=200&h=200&fit=crop&fm=webp&q=80',
            'w=200&h=200&fit=crop&border=5,6366f1',
            'w=200&h=200&fit=crop&con=25',
            'w=200&h=200&fit=crop&sharp=20',
            'w=200&h=200&fit=crop&gam=1.5',
            'w=200&h=200&fit=crop&flip=h',
        ];

        $this->info('Pre-generating Glide images...');
        $bar = $this->output->createProgressBar($users->count() * count($transformations));

        foreach ($users as $user) {
            foreach ($transformations as $params) {
                try {
                    // Hit the Glide URL to generate cache
                    $url = url($user->avatar_url . '?' . $params);
                    Http::timeout(5)->get($url);
                    $bar->advance();
                } catch (\Exception $e) {
                    // Skip errors
                }
            }
        }

        $bar->finish();
        $this->info("\n✅ Done! All images pre-generated.");
    }
}
