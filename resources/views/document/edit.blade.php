@extends('layouts.admin')

@section('content')
    <div class="min-h-[calc(100vh-64px)] bg-[#f8fafc] py-8 px-4 md:px-8 font-inter">

        <div class="max-w-3xl mx-auto">

            {{-- HEADER --}}
            <div class="flex items-center justify-between mb-6">
                <a href="{{ route('documents.index') }}"
                   class="text-[10px] uppercase tracking-[0.2em] font-medium text-black hover:text-blue-600 transition">
                    ← Back
                </a>

                <div class="text-right">
                    <p class="text-[9px] uppercase tracking-widest text-gray-400">Editor Mode</p>
                    <p class="text-[10px] font-medium text-black">ID #{{ $document->id }}</p>
                </div>
            </div>

            {{-- CARD --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">

                {{-- TOP --}}
                <div class="p-6 border-b border-slate-100">
                    <h1 class="text-[14px] font-medium uppercase tracking-[0.15em] text-black">
                        ✏️ Edit Document
                    </h1>
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">
                        Update document data
                    </p>
                </div>

                {{-- FORM --}}
                <form action="{{ route('documents.update', $document->id) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="p-6 space-y-5">

                    @csrf
                    @method('PUT')

                    {{-- TYPE --}}
                    <div>
                        <label class="text-[9px] uppercase tracking-widest text-gray-400">Type</label>
                        <select name="type"
                                class="w-full mt-1 px-4 py-2 border border-slate-200 rounded-lg text-black text-[11px] focus:border-blue-500 outline-none">
                            <option value="УПД" {{ $document->type=='УПД'?'selected':'' }}>УПД</option>
                            <option value="Договор" {{ $document->type=='Договор'?'selected':'' }}>Договор</option>
                            <option value="Счёт" {{ $document->type=='Счёт'?'selected':'' }}>Счёт</option>
                        </select>
                    </div>

                    {{-- TITLE --}}
                    <div>
                        <label class="text-[9px] uppercase tracking-widest text-gray-400">Title</label>
                        <input type="text"
                               name="title"
                               value="{{ $document->title }}"
                               class="w-full mt-1 px-4 py-2 border border-slate-200 rounded-lg text-[11px] text-black focus:border-blue-500 outline-none">
                    </div>

                    {{-- CONTENT --}}
                    <div>
                        <label class="text-[9px] uppercase tracking-widest text-gray-400">Content</label>
                        <textarea name="content"
                                  rows="4"
                                  class="w-full mt-1 px-4 py-2 border border-slate-200 rounded-lg text-[11px] text-black focus:border-blue-500 outline-none">{{ $document->content }}</textarea>
                    </div>

                    {{-- FILE --}}
                    <div>
                        <label class="text-[9px] uppercase tracking-widest text-gray-400">File</label>

                        @if($document->file_path)
                            <div class="mt-2 p-3 bg-gray-50 border border-slate-100 rounded-lg text-[10px] text-black">
                                📎 {{ basename($document->file_path) }}
                            </div>
                        @endif

                        <input type="file"
                               name="file_path"
                               class="mt-2 w-full text-[10px]">
                    </div>

                    {{-- STATUS --}}
                    <div>
                        <label class="text-[9px] uppercase tracking-widest text-gray-400">Status</label>
                        <select name="status"
                                class="w-full mt-1 px-4 py-2 border border-slate-200 rounded-lg text-[11px] text-black">
                            <option value="draft" {{ $document->status=='draft'?'selected':'' }}>Draft</option>
                            <option value="active" {{ $document->status=='active'?'selected':'' }}>Active</option>
                            <option value="approved" {{ $document->status=='approved'?'selected':'' }}>Approved</option>
                            <option value="rejected" {{ $document->status=='rejected'?'selected':'' }}>Rejected</option>
                        </select>
                    </div>
                    <input type="email" name="receiver_email" placeholder="Receiver Email" required class="w-full mb-1 p-2 border">

                    {{-- DEADLINE --}}
                    <div>
                        <label class="text-[9px] uppercase tracking-widest text-gray-400">Deadline</label>
                        <input type="date" name="deadline" value="{{ optional($document->deadline)->format('Y-m-d') }}"
                               class="w-full mt-1 px-4 py-2 border border-slate-200 rounded-lg text-[11px] text-black">
                    </div>

                    {{-- BUTTONS --}}
                    <div class="flex items-center justify-between pt-4 border-t border-slate-100">

                        <a href="{{ route('documents.index') }}"
                           class="text-[10px] uppercase tracking-widest text-gray-400 hover:text-black">
                            Cancel
                        </a>

                        <button type="submit"
                                class="bg-black text-white px-6 py-2 rounded-lg text-[10px] uppercase tracking-widest hover:bg-blue-600 transition">
                            Save changes
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
    </style>
@endpush
