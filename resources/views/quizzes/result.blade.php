<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">採点結果</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">

                @if($isCorrect)
                    <div class="text-6xl mb-4">⭕ 正解！</div>
                    <p class="text-xl font-bold text-green-600 font-bold">正解！</p>
                @else
                    <div class="text-6xl mb-4">❌ 不正解...</div>
                    <p class="text-xl font-bold text-red-600 font-bold">不正解！</p>
                @endif

                <div class="my-8 p-4 bg-gray-50 rounded text-left space-y-2 border">
                    <p class="text-sm text-gray-600"><strong>問題：</strong> {{ $quiz->question }}</p>
                    <p class="text-sm text-gray-600"><strong>あなたの回答：</strong> <span class="{{ $isCorrect ? 'text-green-600' : 'text-red-600' }} font-bold">{{ $userAnswer }}</span></p>
                    <p class="text-sm text-gray-600"><strong>正しい正解：</strong> <span class="text-emerald-600 font-bold">⭕️ {{ $quiz->correct_answer }}</span></p>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('quizzes.play') }}" class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded shadow">
                        次のオリジナルクイズに挑戦する
                    </a>
                    <a href="{{ route('dashboard') }}" class="block text-sm text-gray-500 hover:underline">
                        ダッシュボードに戻る
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
