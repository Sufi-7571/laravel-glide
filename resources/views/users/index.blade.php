@extends('layouts.app')

@section('title', 'All Users')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900">User Gallery</h1>
            <p class="text-gray-600 mt-2">Powered by Laravel Glide - On-the-fly Image Processing</p>
        </div>

        @if ($users->isEmpty())
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <div class="max-w-md mx-auto">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <h3 class="mt-6 text-2xl font-semibold text-gray-900">No users yet</h3>
                    <p class="mt-2 text-gray-600">Get started by creating your first user.</p>
                    <a href="{{ route('users.create') }}"
                        class="mt-6 inline-block bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-lg font-medium hover:shadow-xl transition transform hover:scale-105">
                        Create First User
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($users as $user)
                    <div
                        class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:scale-105 group">
                        <div class="relative">
                            <!-- Large avatar with Glide processing -->
                            <img src="{{ $user->avatar_url }}?w=400&h=400&fit=crop&fm=webp&q=85" alt="{{ $user->name }}"
                                class="w-full h-64 object-cover">

                            <!-- Overlay on hover -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end">
                                <div class="p-4 w-full">
                                    <a href="{{ route('users.show', $user) }}"
                                        class="block w-full text-center bg-white text-gray-900 px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition mb-2">
                                        View Profile
                                    </a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="w-full">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')"
                                            class="w-full bg-red-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-red-700 transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $user->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ $user->email }}</p>

                            @if ($user->bio)
                                <p class="text-gray-700 text-sm line-clamp-3">{{ $user->bio }}</p>
                            @endif

                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <p class="text-xs text-gray-500">Joined {{ $user->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection
