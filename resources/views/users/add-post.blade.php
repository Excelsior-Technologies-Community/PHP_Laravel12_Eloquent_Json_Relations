<!DOCTYPE html>
<html>
<head>
    <title>Add Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-2xl w-full max-w-md p-8">

        <!-- Title -->
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
            Add Post to <span class="text-blue-600">{{ $user->name }}</span>
        </h2>

        <!-- Form -->
        <form method="POST" class="space-y-5">
            @csrf

            <!-- Select Box -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Select Post
                </label>

                <select name="post_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    <option value="">-- Choose Post --</option>

                    @foreach($posts as $post)
                        <option value="{{ $post->id }}">
                            {{ $post->title }}
                        </option>
                    @endforeach

                </select>
            </div>

            <!-- Button -->
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition duration-200">
                ➕ Add Post
            </button>

        </form>

    </div>

</body>
</html>