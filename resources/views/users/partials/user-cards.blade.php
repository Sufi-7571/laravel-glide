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
