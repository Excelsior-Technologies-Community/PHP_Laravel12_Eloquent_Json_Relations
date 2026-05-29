@extends('layouts.app')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Users Dashboard</h2>
    </div>

    <div class="bg-white p-4 rounded-xl shadow mb-6">
        <form method="GET" action="/users" class="flex gap-3">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="🔍 Search user..."
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none"
            >
            <button class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                Search
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid md:grid-cols-2 gap-6">
        @forelse($users as $user)
            <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold text-gray-700">👤 {{ $user->name }}</h3>
                    <a href="/users/{{ $user->id }}/add-post" class="text-sm bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                        + Add
                    </a>
                </div>

                <div class="border-t pt-3">
                    <p class="text-sm text-gray-500 mb-2">Posts</p>
                    <ul class="space-y-2">
                        @forelse($user->posts as $post)
                            <li class="flex justify-between items-center bg-gray-50 px-3 py-2 rounded-md">
                                <span class="text-gray-700 text-sm">{{ $post->title }}</span>
                                <a href="/users/{{ $user->id }}/remove/{{ $post->id }}" class="text-red-500 hover:text-red-700 text-sm">
                                    ❌
                                </a>
                            </li>
                        @empty
                            <li class="text-gray-400 text-sm">No posts assigned</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        @empty
            <div class="col-span-2 text-center text-red-500">No users found</div>
        @endforelse
    </div>

@endsection