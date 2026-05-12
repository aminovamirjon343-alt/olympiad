@extends('layouts.admin')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <div class="min-h-screen bg-[#0f172a] px-4 py-8" style="font-family: Inter, sans-serif;">
        <div class="max-w-4xl mx-auto">

            {{-- HEADER --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-xl font-bold text-white tracking-tight flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-blue-500 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span>
                        <span data-i18n="versionTitle">Version</span>
                        <span class="text-blue-400 ml-1">v{{ $version->version }}</span>
                    </h1>
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-1" data-i18n="detailsSubtitle">Document revision details</p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('versions.index') }}" class="text-[11px] font-bold uppercase tracking-wider text-gray-400 hover:text-white transition flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                        <span data-i18n="backBtn">Back</span>
                    </a>
                    <a href="{{ route('versions.edit', $version->id) }}" class="px-4 py-1.5 bg-blue-600 text-white rounded-lg text-[11px] font-bold uppercase tracking-wider hover:bg-blue-700 transition shadow-lg shadow-blue-900/20" data-i18n="editBtn">Edit</a>
                </div>
            </div>

            {{-- GRID --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">

                {{-- LEFT: MAIN FILE CARD --}}
                <div class="lg:col-span-2">
                    <div class="h-full bg-white rounded-[20px] shadow-xl p-8 text-center border border-gray-100 flex flex-col items-center justify-center min-h-[350px]">
                        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-4 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <h2 class="text-sm font-bold text-gray-900 max-w-xs truncate">{{ basename($version->file_path) }}</h2>
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">{{ strtoupper(pathinfo($version->file_path, PATHINFO_EXTENSION)) }} FILE</p>
                        <a href="{{ asset('storage/' . $version->file_path) }}" download class="mt-6 inline-flex items-center gap-2 px-6 py-2.5 bg-pink-50 text-pink-600 rounded-xl text-[11px] font-bold uppercase tracking-widest hover:bg-pink-100 transition-all border border-pink-100" data-i18n="viewFileBtn">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download File
                        </a>
                    </div>
                </div>

                {{-- RIGHT: SIDEBAR INFO --}}
                <div class="flex flex-col gap-4">
                    {{-- DOCUMENT --}}
                    <div class="bg-white rounded-[20px] shadow-lg border border-gray-100 p-5">
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-3" data-i18n="labelDoc">Document</p>
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-100 mb-3">
                            <p class="text-xs font-bold text-gray-900 leading-snug">{{ $version->document?->title ?? 'Deleted' }}</p>
                        </div>
                        <a href="{{ route('documents.show', $version->document_id) }}" class="text-[10px] font-bold uppercase tracking-widest text-blue-600 hover:text-blue-800 transition flex items-center gap-1">
                            <span data-i18n="openOriginal">Open original</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3"/></svg>
                        </a>
                    </div>

                    {{-- ADDITIONAL INFO --}}
                    <div class="bg-white rounded-[20px] shadow-lg border border-gray-100 p-5 space-y-4">
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider" data-i18n="labelUploaded">Uploaded</p>
                            <p class="text-xs font-bold text-gray-900 mt-1">{{ $version->created_at->format('d.m.Y') }} <span class="text-gray-400 font-medium ml-1">{{ $version->created_at->format('H:i') }}</span></p>
                        </div>
                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider" data-i18n="labelVersionId">Version ID</p>
                                <p class="text-xs font-bold text-gray-900 mt-1">#{{ $version->id }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1" data-i18n="labelStatus">Status</p>
                                <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded-md bg-green-50 text-green-600 border border-green-100" data-i18n="statusActive">Active</span>
                            </div>
                        </div>
                    </div>

                    {{-- БЛОК-ЗАПОЛНИТЕЛЬ (то, что выделено зеленым на скриншоте) --}}
                    <div class="flex-grow bg-white/5 border border-white/5 rounded-[20px] hidden lg:block">
                        {{-- Этот блок растягивается, заполняя пустоту справа --}}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const translations = {
                ru: { backBtn: "Назад", versionTitle: "Версия", detailsSubtitle: "ФАЙЛ И ДАННЫЕ РЕВИЗИИ", editBtn: "Редактировать", viewFileBtn: "СКАЧАТЬ ФАЙЛ", labelDoc: "Документ", openOriginal: "ОТКРЫТЬ ОРИГИНАЛ", labelUploaded: "Дата загрузки", labelVersionId: "ID версии", labelStatus: "Статус", statusActive: "Активен" },
                tj: { backBtn: "Бозгашт", versionTitle: "Нусха", detailsSubtitle: "ТАФСИЛОТИ ТАҲРИРИ ҲУҶҶАТ", editBtn: "Таҳрир", viewFileBtn: "БОРГИРИИ ФАЙЛ", labelDoc: "Ҳуҷҷат", openOriginal: "ҲУҶҶАТИ АСЛӢ", labelUploaded: "Санаи боргузорӣ", labelVersionId: "ID-и нусха", labelStatus: "Статус", statusActive: "Фаъол" },
                en: { backBtn: "Back", versionTitle: "Version", detailsSubtitle: "FILE AND REVISION DETAILS", editBtn: "Edit", viewFileBtn: "DOWNLOAD FILE", labelDoc: "Document", openOriginal: "OPEN ORIGINAL", labelUploaded: "Uploaded", labelVersionId: "Version ID", labelStatus: "Status", statusActive: "Active" }
            };
            const lang = localStorage.getItem('app-lang') || 'ru';
            const t = translations[lang];
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key]) el.textContent = t[key];
            });
        });
    </script>
@endsection
