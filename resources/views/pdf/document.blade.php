<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $document->title }}</title>
    <style>
        /* DejaVu Sans обязателен для поддержки кириллицы в dompdf */
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 12pt;
            color: #1a1a1a;
            margin: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .doc-title {
            text-transform: uppercase;
            font-size: 18pt;
            margin-bottom: 5px;
        }

        .doc-meta {
            font-size: 10pt;
            color: #666;
        }

        .content {
            margin-top: 30px;
            line-height: 1.5;
            text-align: justify;
            white-space: pre-wrap;
        }

        .footer {
            margin-top: 100px;
            width: 100%;
        }

        .signature-block {
            width: 50%;
            float: left;
            font-size: 11pt;
        }

        .stamp-space {
            border-top: 1px solid #000;
            width: 200px;
            margin-top: 40px;
            padding-top: 5px;
            font-size: 9pt;
            color: #888;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="doc-title">{{ $document->title }}</div>
    <div class="doc-meta">
        <span data-i18n="docLabel">Документ №:</span> {{ $document->number ?? $document->id }} |
        <span data-i18n="dateLabel">Дата:</span> {{ date('d.m.Y') }}
    </div>
</div>

<div class="content">
    {!! nl2br(e($document->content)) !!}
</div>

<div class="footer">
    <div class="signature-block">
        <p><strong data-i18n="senderLabel">Отправитель:</strong> {{ $document->user->name ?? 'Администратор' }}</p>
        <p><strong data-i18n="receiverLabel">Получатель:</strong> {{ $document->receiver->name ?? 'N/A' }}</p>
        <div class="stamp-space" data-i18n="stampLabel">М.П. / Подпись</div>
    </div>

    <div style="clear: both;"></div>
</div>

<div style="margin-top: 30px; font-size: 8pt; color: #ccc; text-align: center;" data-i18n="systemFooter">
    Сгенерировано в системе ЭДО "Olympiad" ИИ-ассистентом.
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const translations = {
            ru: {
                docLabel: "Документ №:",
                dateLabel: "Дата:",
                senderLabel: "Отправитель:",
                receiverLabel: "Получатель:",
                stampLabel: "М.П. / Подпись",
                systemFooter: "Сгенерировано в системе ЭДО \"Olympiad\" ИИ-ассистентом."
            },
            tj: {
                docLabel: "Ҳуҷҷати №:",
                dateLabel: "Сана:",
                senderLabel: "Ирсолкунанда:",
                receiverLabel: "Қабулкунанда:",
                stampLabel: "Ҷ.М. / Имзо",
                systemFooter: "Дар системаи ЭДО \"Olympiad\" аз ҷониби ИИ-ассистент тавлид шудааст."
            },
            en: {
                docLabel: "Document No:",
                dateLabel: "Date:",
                senderLabel: "Sender:",
                receiverLabel: "Receiver:",
                stampLabel: "L.S. / Signature",
                systemFooter: "Generated in the \"Olympiad\" EDMS by AI assistant."
            }
        };

        const lang = localStorage.getItem('app-lang') || 'ru';
        const t = translations[lang];

        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (t[key]) el.textContent = t[key];
        });
    });
</script>

</body>
</html>
