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
            <div id="users-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @include('users.partials.user-cards')
            </div>

            <!-- Loading Indicator -->
            <div id="loading" class="hidden mt-8 text-center">
                <div class="inline-flex items-center px-6 py-3 bg-white rounded-lg shadow-lg">
                    <svg class="animate-spin h-5 w-5 mr-3 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span class="text-gray-700 font-medium">Loading more users...</span>
                </div>
            </div>

            <!-- Load More Button -->
            <div id="load-more-container" class="mt-8 text-center {{ !$users->hasMorePages() ? 'hidden' : '' }}">
                <button id="load-more-btn"
                    class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-lg font-medium hover:shadow-xl transition transform hover:scale-105">
                    Load More Users
                </button>
            </div>

            <!-- End of Results -->
            <div id="end-message" class="hidden mt-8 text-center">
                <p class="text-gray-500 font-medium">You've reached end. No more Users to display!</p>
            </div>

            <!-- Sentinel for Intersection Observer -->
            <div id="sentinel" class="h-10"></div>
        @endif
    </div>

    @push('scripts')
        <script>
            let currentPage = 1;
            let loading = false;
            let hasMore = {{ $users->hasMorePages() ? 'true' : 'false' }};

            const loadingDiv = document.getElementById('loading');
            const usersContainer = document.getElementById('users-container');
            const sentinel = document.getElementById('sentinel');
            const endMessage = document.getElementById('end-message');
            const loadMoreBtn = document.getElementById('load-more-btn');
            const loadMoreContainer = document.getElementById('load-more-container');

            // Manual Load More Button
            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    loadMoreUsers();
                });
            }

            // Intersection Observer for infinite scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !loading && hasMore) {
                        loadMoreUsers();
                    }
                });
            }, {
                rootMargin: '100px'
            });

            if (sentinel && hasMore) {
                observer.observe(sentinel);
            }

            function loadMoreUsers() {
                if (loading || !hasMore) return;

                loading = true;
                loadingDiv.classList.remove('hidden');
                if (loadMoreContainer) loadMoreContainer.classList.add('hidden');

                fetch(`{{ route('users.index') }}?page=${currentPage + 1}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Append new users
                        usersContainer.insertAdjacentHTML('beforeend', data.users);

                        currentPage++;
                        hasMore = data.has_more;

                        // Hide loading indicator
                        loadingDiv.classList.add('hidden');

                        // If no more pages, show end message and stop observing
                        if (!hasMore) {
                            observer.disconnect();
                            endMessage.classList.remove('hidden');
                            if (loadMoreContainer) loadMoreContainer.classList.add('hidden');
                        } else {
                            if (loadMoreContainer) loadMoreContainer.classList.remove('hidden');
                        }

                        loading = false;
                    })
                    .catch(error => {
                        console.error('Error loading users:', error);
                        loadingDiv.classList.add('hidden');
                        if (loadMoreContainer) loadMoreContainer.classList.remove('hidden');
                        loading = false;
                    });
            }
        </script>
    @endpush
@endsection
