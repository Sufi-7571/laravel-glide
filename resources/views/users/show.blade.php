@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 h-48"></div>

            <div class="px-8 pb-8">
                <!-- Avatar -->
                <div class="relative -mt-24 mb-6">
                    <img src="{{ $user->avatar_url }}?w=200&h=200&fit=crop&fm=webp&q=90" alt="{{ $user->name }}"
                        class="w-48 h-48 rounded-full border-8 border-white shadow-2xl">
                </div>

                <!-- User Info -->
                <div class="mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $user->name }}</h1>
                    <p class="text-xl text-gray-600 mb-4">{{ $user->email }}</p>

                    @if ($user->bio)
                        <div class="bg-gray-50 rounded-lg p-6 mt-6">
                            <h3 class="text-sm font-semibold text-gray-700 mb-2">BIO</h3>
                            <p class="text-gray-700">{{ $user->bio }}</p>
                        </div>
                    @endif

                    <div class="mt-6 flex items-center text-sm text-gray-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Joined {{ $user->created_at->format('F j, Y') }}
                    </div>
                </div>

                <!-- Glide Transformations Demo -->
                <div class="border-t border-gray-200 pt-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Avatar Transformations (Glide Demo)</h2>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <!-- Original -->
                        <div class="text-center">
                            <img src="{{ $user->avatar_url }}?w=200&h=200&fit=crop" alt="Original"
                                class="w-full rounded-lg shadow-lg mb-3">
                            <p class="text-sm font-medium text-gray-700">Original Crop</p>
                            <code class="text-xs text-gray-500">w=200&h=200</code>
                        </div>

                        <!-- Grayscale -->
                        <div class="text-center">
                            <img src="{{ $user->avatar_url }}?w=200&h=200&fit=crop&filt=greyscale" alt="Grayscale"
                                class="w-full rounded-lg shadow-lg mb-3">
                            <p class="text-sm font-medium text-gray-700">Grayscale</p>
                            <code class="text-xs text-gray-500">filt=greyscale</code>
                        </div>

                        <!-- Sepia -->
                        <div class="text-center">
                            <img src="{{ $user->avatar_url }}?w=200&h=200&fit=crop&filt=sepia" alt="Sepia"
                                class="w-full rounded-lg shadow-lg mb-3">
                            <p class="text-sm font-medium text-gray-700">Sepia</p>
                            <code class="text-xs text-gray-500">filt=sepia</code>
                        </div>

                        <!-- Blur -->
                        <div class="text-center">
                            <img src="{{ $user->avatar_url }}?w=200&h=200&fit=crop&blur=15" alt="Blurred"
                                class="w-full rounded-lg shadow-lg mb-3">
                            <p class="text-sm font-medium text-gray-700">Blurred</p>
                            <code class="text-xs text-gray-500">blur=15</code>
                        </div>

                        <!-- Pixelated -->
                        <div class="text-center">
                            <img src="{{ $user->avatar_url }}?w=200&h=200&fit=crop&pixel=10" alt="Pixelated"
                                class="w-full rounded-lg shadow-lg mb-3">
                            <p class="text-sm font-medium text-gray-700">Pixelated</p>
                            <code class="text-xs text-gray-500">pixel=10</code>
                        </div>

                        <!-- Brightness -->
                        <div class="text-center">
                            <img src="{{ $user->avatar_url }}?w=200&h=200&fit=crop&bri=30" alt="Bright"
                                class="w-full rounded-lg shadow-lg mb-3">
                            <p class="text-sm font-medium text-gray-700">Bright</p>
                            <code class="text-xs text-gray-500">bri=30</code>
                        </div>

                        <!-- WebP Format -->
                        <div class="text-center">
                            <img src="{{ $user->avatar_url }}?w=200&h=200&fit=crop&fm=webp&q=80" alt="WebP"
                                class="w-full rounded-lg shadow-lg mb-3">
                            <p class="text-sm font-medium text-gray-700">WebP 80%</p>
                            <code class="text-xs text-gray-500">fm=webp&q=80</code>
                        </div>

                        <!-- Border -->
                        <div class="text-center">
                            <img src="{{ $user->avatar_url }}?w=200&h=200&fit=crop&border=5,6366f1" alt="Border"
                                class="w-full rounded-lg shadow-lg mb-3">
                            <p class="text-sm font-medium text-gray-700">With Border</p>
                            <code class="text-xs text-gray-500">border=5,6366f1</code>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between mt-8 pt-8 border-t border-gray-200">
                    <a href="{{ route('users.index') }}"
                        class="px-6 py-3 border-2 border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition">
                        ← Back to Users
                    </a>

                    <form action="{{ route('users.destroy', $user) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this user?')"
                            class="px-6 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
                            Delete User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
