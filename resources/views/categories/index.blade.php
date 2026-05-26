<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('カテゴリ管理') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- 成功メッセージの表示 --}}
            @if (session('message'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                    {{ session('message') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- 左側：入力欄（新規登録 or 編集） --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 h-fit">
                    @if(isset($category))
                        {{-- 編集モードのとき --}}
                        <h3 class="text-lg font-medium text-gray-900 mb-4">カテゴリの編集</h3>
                        <form method="POST" action="{{ route('categories.update', $category->id) }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700">カテゴリ名</label>
                                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required autofocus>
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="flex items-center gap-4 pt-2">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">更新する</button>
                                <a href="{{ route('categories.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">キャンセル</a>
                            </div>
                        </form>
                    @else
                        {{-- 新規登録モードのとき --}}
                        <h3 class="text-lg font-medium text-gray-900 mb-4">新規カテゴリ登録</h3>
                        <form method="POST" action="{{ route('categories.store') }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700">カテゴリ名</label>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="例: アニメ、歴史、IT" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required autofocus>
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="pt-2">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">登録する</button>
                            </div>
                        </form>
                    @endif
                </div>

                {{-- 右側：登録済みの一覧 --}}
                <div class="md:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">登録済みカテゴリ一覧</h3>
                    
                    @if($categories->isEmpty())
                        <p class="text-gray-500 text-sm">登録されたカテゴリはまだありません。</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">カテゴリ名</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">操作</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($categories as $item)
                                        <tr class="{{ isset($category) && $category->id === $item->id ? 'bg-indigo-50' : '' }}">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                                {{-- 編集リンク --}}
                                                <a href="{{ route('categories.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900">編集</a>
                                                
                                                {{-- 削除ボタン --}}
                                                <form action="{{ route('categories.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('本当に削除しますか？');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">削除</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>