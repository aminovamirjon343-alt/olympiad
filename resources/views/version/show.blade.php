@extends('layouts.admin')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <div class="min-h-screen bg-gray-50 px-6 py-8" style="font-family: Inter, sans-serif;">

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <a href="{{ route('versions.index') }}"
                   class="text-xs font-medium text-gray-500 hover:text-black transition">
                    ← Back
                </a>

                <h1 class="text-2xl font-semibold text-gray-900 mt-1">
                    Version v{{ $version->version }}
                </h1>

                <p class="text-sm text-gray-500">
                    Document revision details
                </p>
            </div>

            <a href="{{ route('versions.edit', $version->id) }}"
               class="px-4 py-2 rounded-xl bg-black text-white text-sm font-medium hover:bg-gray-800 transition">
                Edit
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- MAIN FILE --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center">

                    <div class="w-14 h-14 mx-auto bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>

                    <h2 class="text-lg font-semibold text-gray-900 truncate">
                        {{ basename($version->file_path) }}
                    </h2>

                    <p class="text-xs text-gray-400 uppercase tracking-wider mt-1">
                        {{ strtoupper(pathinfo($version->file_path, PATHINFO_EXTENSION)) }}
                    </p>

                    <a href="{{ asset('storage/' . $version->file_path) }}"
                       target="_blank"
                       class="mt-6 inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">
                        View File
                    </a>

                </div>
            </div>

            {{-- SIDEBAR --}}
            <div class="space-y-4">

                {{-- DOCUMENT --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-5">
                    <p class="text-xs text-gray-400 uppercase font-medium mb-3">
                        Document
                    </p>

                    <p class="text-sm font-semibold text-gray-900">
                        {{ $version->document?->title ?? 'Deleted' }}
                    </p>

                    <a href="{{ route('documents.show', $version->document_id) }}"
                       class="text-xs text-blue-600 hover:underline mt-2 inline-block">
                        Open original →
                    </a>
                </div>

                {{-- INFO --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-5 space-y-4">

                    <div>
                        <p class="text-xs text-gray-400 uppercase">Uploaded</p>
                        <p class="text-sm font-medium text-gray-900">
                            {{ $version->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 uppercase">Version ID</p>
                        <p class="text-sm font-medium text-gray-900">
                            #{{ $version->id }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 uppercase">Status</p>
                        <span class="inline-block px-2 py-1 text-xs font-medium rounded-lg bg-green-50 text-green-700">
                        Active
                    </span>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
