@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-6 py-8">
        {{-- Заголовок поиска --}}
        <div class="mb-10">
            <h1 class="text-3xl font-black text-gray-800 tracking-tight">Результаты поиска</h1>
            <p class="text-gray-500 mt-2 font-medium">Вы искали: <span class="text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg">"{{ $query }}"</span></p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

            {{-- Блок Документов --}}
            <div>
                <h2 class="flex items-center gap-3 text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-6">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Документы ({{ $documents->count() }})
                </h2>

                <div class="space-y-4">
                    @forelse($documents as $doc)
                        <a href="{{ route('documents.show', $doc->id) }}" class="flex items-center justify-between p-5 bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md hover:border-indigo-200 transition-all group">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-bold">DOC</div>
                                <div>
                                    <p class="font-bold text-gray-800 group-hover:text-indigo-600 transition-colors">{{ $doc->title }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">Создан: {{ $doc->created_at->format('d.m.Y') }}</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-300 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @empty
                        <div class="p-8 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 text-center text-gray-400 font-bold text-sm uppercase tracking-widest">
                            Ничего не найдено
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Блок Пользователей --}}
            <div>
                <h2 class="flex items-center gap-3 text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-6">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Пользователи ({{ $users->count() }})
                </h2>

                <div class="space-y-4">
                    @forelse($users as $user)
                        <a href="{{ route('users.show', $user->id) }}" class="flex items-center justify-between p-5 bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md hover:border-emerald-200 transition-all group">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center font-bold">
                                    {{ Str::upper(Str::substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 group-hover:text-emerald-600 transition-colors">{{ $user->name }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="px-3 py-1 bg-gray-100 rounded-lg text-[10px] font-black text-gray-500 uppercase">{{ $user->role ?? 'User' }}</div>
                        </a>
                    @empty
                        <div class="p-8 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 text-center text-gray-400 font-bold text-sm uppercase tracking-widest">
                            Ничего не найдено
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection
