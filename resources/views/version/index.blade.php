@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8 min-h-screen">

        <div class="max-w-7xl mx-auto">

            {{-- HEADER --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-xl font-bold doc-main-title tracking-tight flex items-center gap-2">
                        <span class="w-2 h-6 bg-blue-500 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span>
                        <span data-i18n="pageTitle">Версия документ</span>
                    </h1>

                    <p class="text-xs text-gray-400 uppercase tracking-widest" data-i18n="pageSubTitle">
                        История изменений файлов
                    </p>
                </div>

                <a href="{{ route('versions.create') }}"
                   class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs font-bold uppercase hover:bg-indigo-700">
                    <span data-i18n="btnAdd">+ Добавить версию</span>
                </a>
            </div>

            {{-- TABLE --}}
            <div class="bg-white border rounded-xl shadow-sm overflow-hidden">

                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b">
                    <tr class="text-left text-xs uppercase text-gray-500">
                        <th class="p-4">#</th>
                        <th data-i18n="thDoc">Документ</th>
                        <th class="text-center" data-i18n="thVer">Версия</th>
                        <th class="text-center" data-i18n="thFile">Файл</th>
                        <th class="text-center" data-i18n="thDate">Дата</th>
                        <th class="text-right p-4" data-i18n="thActions">Действия</th>
                    </tr>
                    </thead>

                    <tbody>

                    @forelse($versions as $index =>$v)
                        <tr class="border-b hover:bg-gray-50 transition">

                            {{-- ID --}}
                            <td class="p-4 font-bold text-gray-400">
                                {{ $index + 1 }}
                            </td>

                            {{-- DOCUMENT --}}
                            <td class="p-4">
                                <div class="font-semibold text-black">
                                    {{ $v->document->title ?? 'Удалённый документ' }}
                                </div>

                                <div class="text-xs text-gray-400">
                                    ID: {{ $v->document_id }}
                                </div>
                            </td>

                            {{-- VERSION --}}
                            <td class="text-center">
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-lg font-bold text-xs">
                                V{{ $v->version }}
                            </span>
                            </td>

                            {{-- FILE --}}
                            <td class="text-center">
                                <a href="{{ asset('storage/'.$v->file_path) }}"
                                   target="_blank"
                                   class="text-blue-600 text-xs font-bold uppercase hover:underline" data-i18n="btnDownload">
                                    Скачать
                                </a>
                            </td>

                            {{-- DATE --}}
                            <td class="text-center text-xs text-gray-500">
                                {{ $v->created_at->format('d.m.Y') }}
                            </td>

                            {{-- ACTIONS --}}
                            <td class="p-4 text-right space-x-3">

                                <a href="{{ route('versions.show', $v->id) }}"
                                   class="text-indigo-600 text-xs font-bold uppercase" data-i18n="btnShow">
                                    Show
                                </a>

                                <a href="{{ route('versions.edit', $v->id) }}"
                                   class="text-yellow-600 text-xs font-bold uppercase" data-i18n="btnEdit">
                                    Edit
                                </a>

                                <form action="{{ route('versions.destroy', $v->id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Удалить версию?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="text-red-600 text-xs font-bold uppercase" data-i18n="btnDelete">
                                        Delete
                                    </button>
                                </form>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-400 uppercase text-xs" data-i18n="noVersions">
                                Нет версий
                            </td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>

            </div>

            {{-- PAGINATION --}}
            <div class="mt-6">
                {{ $versions->links() }}
            </div>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const translations = {
                ru: {
                    pageTitle: "Версия документ",
                    pageSubTitle: "История изменений файлов",
                    btnAdd: "+ Добавить версию",
                    thDoc: "Документ",
                    thVer: "Версия",
                    thFile: "Файл",
                    thDate: "Дата",
                    thActions: "Действия",
                    btnDownload: "Скачать",
                    btnShow: "Show",
                    btnEdit: "Edit",
                    btnDelete: "Delete",
                    noVersions: "Нет версий",
                    confirmDelete: "Удалить версию?"
                },
                tj: {
                    pageTitle: "Нусхаи ҳуҷҷат",
                    pageSubTitle: "Таърихи тағйироти файлҳо",
                    btnAdd: "+ Иловаи нусха",
                    thDoc: "Ҳуҷҷат",
                    thVer: "Нусха",
                    thFile: "Файл",
                    thDate: "Сана",
                    thActions: "Амалиёт",
                    btnDownload: "Боргирӣ",
                    btnShow: "Намоиш",
                    btnEdit: "Таҳрир",
                    btnDelete: "Ҳазф",
                    noVersions: "Нусха мавҷуд нест",
                    confirmDelete: "Нусха ҳазф карда шавад?"
                },
                en: {
                    pageTitle: "Document Versions",
                    pageSubTitle: "File Change History",
                    btnAdd: "+ Add Version",
                    thDoc: "Document",
                    thVer: "Version",
                    thFile: "File",
                    thDate: "Date",
                    thActions: "Actions",
                    btnDownload: "Download",
                    btnShow: "Show",
                    btnEdit: "Edit",
                    btnDelete: "Delete",
                    noVersions: "No versions found",
                    confirmDelete: "Delete version?"
                }
            };

            const lang = localStorage.getItem('app-lang') || 'ru';
            const t = translations[lang];

            // Apply translations to text
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key]) el.textContent = t[key];
            });

            // Update confirm message in forms
            document.querySelectorAll('form[onsubmit]').forEach(form => {
                form.onsubmit = function() {
                    return confirm(t.confirmDelete);
                };
            });
        });
    </script>
@endsection
