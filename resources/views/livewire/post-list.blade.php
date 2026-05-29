<div>
    <h1>All Posts</h1>
    <ul>
        @foreach($posts as $post)
            <li>{{ $post->meta_data['title'] ?? 'No Title' }}</li>
        @endforeach
    </ul>
</div>