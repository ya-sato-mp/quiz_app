<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('オリジナルクイズ作成') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('quizzes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label for="question" class="block text-sm font-medium text-gray-700">問題文</label>
                        <textarea id="question" name="question" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="例：日本で一番高い山の名前は？"></textarea>
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">ヒント画像（任意）</label>
                        <input type="file" id="image" name="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="correct_answer" class="block text-sm font-medium text-green-700 font-bold">⭕️ 正解の選択肢</label>
                            <input type="text" id="correct_answer" name="correct_answer" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="choice_2" class="block text-sm font-medium text-gray-700">❌ 選択肢 2（ダミー）</label>
                            <input type="text" id="choice_2" name="choice_2" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="choice_3" class="block text-sm font-medium text-gray-700">❌ 選択肢 3（ダミー）</label>
                            <input type="text" id="choice_3" name="choice_3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="choice_4" class="block text-sm font-medium text-gray-700">❌ 選択肢 4（ダミー）</label>
                            <input type="text" id="choice_4" name="choice_4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-700 mb-2">カテゴリ（複数選択可）</span>
                        <div class="flex flex-wrap gap-4">
                            @forelse($categories as $category)
                                <label class="inline-flex items-center bg-gray-50 px-3 py-1.5 rounded-md border border-gray-200 cursor-pointer hover:bg-gray-100">
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-700">{{ $category->name }}</span>
                                </label>
                            @empty
                                <p class="text-sm text-gray-500">現在選択できるカテゴリがありません。（相方さんが登録するとここに自動で並びます！）</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            クイズを投稿する
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
