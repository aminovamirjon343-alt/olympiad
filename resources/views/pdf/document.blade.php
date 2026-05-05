<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $document->title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; } /* Чтобы кириллица не превратилась в знаки вопроса */
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .content { margin-top: 20px; line-height: 1.6; }
    </style>
</head>
<body>
<div class="header">
    <h1>{{ $document->title }}</h1>
    <p>Document ID: #{{ $document->id }}</p>
</div>
<div class="content">
    {{ $document->content }}
</div>
<div style="margin-top: 50px;">
    <p><strong>Owner:</strong> {{ $document->user->name ?? 'N/A' }}</p>
    <p><strong>Status:</strong> {{ $document->status }}</p>
</div>
</body>
</html>
