@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-4">JSON Data Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-blue-500 text-white p-4 rounded-lg">
            Total Users: {{ \App\Models\User::count() }}
        </div>
        <div class="bg-green-500 text-white p-4 rounded-lg">
            Total Posts: {{ \App\Models\Post::count() }}
        </div>
    </div>
    
    <div class="mt-8">
        <livewire:post-list />
    </div>
</div>
@endsection