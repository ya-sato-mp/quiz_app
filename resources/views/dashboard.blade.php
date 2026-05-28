<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('クイズダッシュボード') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('quizzes.play') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded shadow">
                    作ったクイズを解く
                </a>
                <a href="{{ route('quizzes.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
                    + クイズを作ろう
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-indigo-500">
                    <p class="text-sm font-medium text-gray-500 uppercase">世に生み出された総クイズ数</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-950">{{ $totalQuizzes }} 問</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
                    <p class="text-sm font-medium text-gray-500 uppercase">登録されたカテゴリ数</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-950">{{ $totalCategories }} 種</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
                    <p class="text-sm font-medium text-gray-500 uppercase">あなたが作ったクイズ数</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-950">{{ $userQuizzes }} 問</p>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-800 to-indigo-900 text-white p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-3">
                    <div class="flex items-center space-x-2">
                        <span class="bg-purple-500 text-xs uppercase px-2 py-1 rounded font-bold animate-pulse">LIVE API</span>
                        <h3 class="text-lg font-bold">🗺️ 世界のトリビア（Open Trivia DB）</h3>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button id="translate-btn" onclick="translateQuiz()" class="bg-green-600 hover:bg-green-500 text-white text-xs font-bold py-1.5 px-3 rounded shadow transition">
                            翻訳 🇯🇵
                        </button>
                        <button id="next-quiz-btn" class="bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold py-1.5 px-3 rounded shadow transition">
                            次の問題へ ➔
                        </button>
                    </div>
                </div>

                <div id="api-quiz-container" class="space-y-4">
                    @if(isset($apiQuiz) && isset($apiQuiz['question']))
                        <p id="api-question" class="text-xl font-medium">Q. {!! $apiQuiz['question'] !!}</p>

                        <div id="quiz-result" class="hidden text-center p-2 rounded font-bold text-lg transition animate-bounce"></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-gray-900">
                            @php
                                $initialChoices = collect($apiQuiz['incorrect_answers'])->push($apiQuiz['correct_answer'])->shuffle();
                            @endphp
                            @foreach($initialChoices as $choice)
                                <button onclick="checkAnswer({{ $choice === $apiQuiz['correct_answer'] ? 'true' : 'false' }}, this)" class="api-choice-btn bg-white p-3 rounded shadow hover:bg-purple-100 text-left font-semibold transition">
                                    {!! $choice !!}
                                </button>
                            @endforeach
                        </div>
                    @else
                        <p id="api-question" class="text-xl font-medium text-purple-200">
                            Q. トリビアクイズの初回取得に失敗しました。右上の「次の問題へ ➔」ボタンを押して読み込んでください。
                        </p>
                        <div class="grid grid-cols-1 gap-3">
                            <div class="bg-white/10 p-3 rounded text-center text-sm font-medium">
                                データを受信していません
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold text-gray-800 mb-6">📝 みんなが作ったオリジナルクイズ（クリックで挑戦！）</h3>

                @if($myQuizzes->isEmpty())
                    <p class="text-gray-500 text-sm">まだクイズが投稿されていません。右上のボタンから最初の1問を作ってみよう！</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($myQuizzes as $quiz)
                            <a href="{{ route('quizzes.play') }}?id={{ $quiz->id }}" class="group bg-gray-50 rounded-xl overflow-hidden border border-gray-200 shadow-sm flex flex-col justify-between hover:border-indigo-500 hover:shadow-md transition duration-150 cursor-pointer text-left">

                                @if($quiz->image_path)
                                    <img src="{{ asset('storage/' . $quiz->image_path) }}" class="w-full h-48 object-cover group-hover:opacity-90 transition" alt="Quiz Hint">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400 font-medium">
                                        NO IMAGE (ヒントなし)
                                    </div>
                                @endif

                                <div class="p-4 flex-1 flex flex-col justify-between space-y-4">
                                    <div>
                                        <div class="flex flex-wrap gap-1 mb-2">
                                            @foreach($quiz->categories as $cat)
                                                <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-0.5 rounded-full font-medium">
                                                    {{ $cat->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                        <p class="text-gray-900 font-bold text-lg group-hover:text-indigo-600 transition">Q. {{ $quiz->question }}</p>
                                    </div>

                                    <div class="bg-white p-3 rounded-lg border border-gray-100 text-sm space-y-1.5 text-gray-600">
                                        @php
                                            $choices = collect([$quiz->correct_answer, $quiz->choice_2, $quiz->choice_3, $quiz->choice_4])->shuffle();
                                        @endphp
                                        @foreach($choices as $index => $choice)
                                            <div class="flex items-center space-x-2">
                                                <span class="inline-block bg-gray-100 text-gray-500 text-xs px-1.5 py-0.5 rounded font-bold">
                                                    {{ $index + 1 }}
                                                </span>
                                                <span class="truncate">{{ $choice }}</span>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="text-right text-xs font-bold text-indigo-500 group-hover:underline pt-1">
                                        このクイズに挑戦する ➔
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>

    <script>
    // 1. 正解・不正解の判定
    function checkAnswer(isCorrect, element) {
        const resultDiv = document.getElementById('quiz-result');
        const allButtons = document.querySelectorAll('.api-choice-btn');

        allButtons.forEach(btn => btn.disabled = true);

        if (isCorrect) {
            resultDiv.innerText = "正解！";
            resultDiv.className = "block text-center p-3 rounded font-bold text-lg bg-green-500 text-white";
            element.classList.add('border-4', 'border-green-400', 'bg-green-100');
        } else {
            resultDiv.innerText = "不正解！";
            resultDiv.className = "block text-center p-3 rounded font-bold text-lg bg-red-500 text-white";
            element.classList.add('border-4', 'border-red-400', 'bg-red-100');
        }
    }

    // 2. Google APIを使ったフロント翻訳
    async function translateQuiz() {
        const translateBtn = document.getElementById('translate-btn');
        translateBtn.innerText = "翻訳中...";
        translateBtn.disabled = true;

        const questionEl = document.getElementById('api-question');
        const choiceButtons = document.querySelectorAll('.api-choice-btn');

        if (!questionEl) {
            alert('翻訳するクイズが表示されていません。');
            translateBtn.innerText = "翻訳";
            translateBtn.disabled = false;
            return;
        }

        const rawQuestion = questionEl.innerHTML.replace(/^Q\.\s*/, '');
        const textsToTranslate = [rawQuestion];
        choiceButtons.forEach(btn => textsToTranslate.push(btn.innerHTML));

        try {
            for (let i = 0; i < textsToTranslate.length; i++) {
                const url = `https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=ja&dt=t&q=${encodeURIComponent(textsToTranslate[i])}`;
                const res = await fetch(url);
                const json = await res.json();
                const translatedText = json[0][0][0];

                if (i === 0) {
                    questionEl.innerHTML = 'Q. ' + translatedText;
                } else {
                    choiceButtons[i - 1].innerHTML = translatedText;
                }
            }
            translateBtn.innerText = "翻訳完了";
        } catch (error) {
            alert('翻訳に失敗しました。');
            translateBtn.innerText = "翻訳";
            translateBtn.disabled = false;
        }
    }

    // 3. 次の問題へ非同期切り替え
    document.getElementById('next-quiz-btn').addEventListener('click', async function() {
        const btn = this;
        btn.disabled = true;
        btn.innerText = "読み込み中...";

        const translateBtn = document.getElementById('translate-btn');
        translateBtn.innerText = "翻訳";
        translateBtn.disabled = false;

        try {
            const response = await fetch('https://opentdb.com/api.php?amount=1&type=multiple');
            const data = await response.json();
            const quiz = data.results[0];

            const container = document.getElementById('api-quiz-container');
            container.innerHTML = `
                <p id="api-question" class="text-xl font-medium"></p>
                <div id="quiz-result" class="hidden text-center p-2 rounded font-bold text-lg transition animate-bounce"></div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-gray-900"></div>
            `;

            document.getElementById('api-question').innerHTML = 'Q. ' + quiz.question;

            const choicesContainer = container.querySelector('.grid');
            const buttonsArray = [];

            // 正解ボタン
            const correctBtn = document.createElement('button');
            correctBtn.className = "api-choice-btn bg-white p-3 rounded shadow hover:bg-purple-100 text-left font-semibold text-gray-900 transition";
            correctBtn.innerHTML = quiz.correct_answer;
            correctBtn.onclick = function() { checkAnswer(true, this); };
            buttonsArray.push(correctBtn);

            // 不正解ボタン
            quiz.incorrect_answers.forEach(incorrect => {
                const incorrectBtn = document.createElement('button');
                incorrectBtn.className = "api-choice-btn bg-white p-3 rounded shadow hover:bg-purple-100 text-left font-semibold text-gray-900 transition";
                incorrectBtn.innerHTML = incorrect;
                incorrectBtn.onclick = function() { checkAnswer(false, this); };
                buttonsArray.push(incorrectBtn);
            });

            // シャッフルして配置
            buttonsArray.sort(() => Math.random() - 0.5);
            buttonsArray.forEach(button => choicesContainer.appendChild(button));

        } catch (error) {
            alert('クイズの取得に失敗しました。');
        } finally {
            btn.disabled = false;
            btn.innerText = "次の問題へ ➔";
        }
    });
    </script>
</x-app-layout>
