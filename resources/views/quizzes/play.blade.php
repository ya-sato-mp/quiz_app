<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">オリジナルクイズに挑戦！</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">

                @if(!$quiz)
                    <p class="text-gray-500">まだクイズが投稿されていません。先にクイズを作ってみよう！</p>
                    <a href="{{ route('dashboard') }}" class="mt-4 inline-block bg-indigo-600 text-white px-4 py-2 rounded">ダッシュボードへ</a>
                @else
                    <div class="flex justify-center gap-2 mb-4">
                        @foreach($quiz->categories as $category)
                            <span class="bg-indigo-100 text-indigo-800 text-xs px-3 py-1 rounded-full font-bold">{{ $category->name }}</span>
                        @endforeach
                    </div>

                    @if($quiz->image_path)
                        <div class="mb-6">
                            <img src="{{ asset('storage/' . $quiz->image_path) }}" alt="ヒント" class="mx-auto max-h-64 object-cover rounded shadow">
                        </div>
                    @endif

                    <h3 class="text-xl font-bold text-gray-900 mb-8 p-4 bg-gray-50 rounded border">
                        Q. {{ $quiz->question }}
                    </h3>

                    <form action="{{ route('quizzes.check', $quiz) }}" method="POST" class="grid grid-cols-1 gap-3">
                        @csrf
                        @foreach($choices as $choice)
                            <button type="submit" name="answer" value="{{ $choice }}" class="w-full bg-indigo-50 hover:bg-indigo-100 text-indigo-900 font-semibold py-4 px-4 rounded-xl border-2 border-indigo-200 shadow-sm text-left transition duration-150">
                                🔑 {{ $choice }}
                            </button>
                        @endforeach
                    </form>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
