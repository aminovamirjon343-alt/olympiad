@extends('layouts.admin')

@section('content')
@php
$ownerId = (int) ($document->created_by ?? 0);
$currentUserId = (int) auth()->id();
$isOwner = ($currentUserId === $ownerId);
@endphp

<style>
    .doc-edit-page {
        color: #e7ecf3;
        padding: 24px 16px;
    }

    .form-card {
        background: linear-gradient(180deg, rgba(22, 26, 38, 0.95), rgba(16, 19, 28, 0.95));
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        padding: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }
    .form-card::before {
        content: "";
        position: absolute;
        inset: -1px;
        border-radius: 16px;
        padding: 1px;
        background: linear-gradient(135deg, rgba(79,140,255,0.5), transparent 40%, transparent 60%, rgba(79,140,255,0.3));
        -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
        opacity: 0.7;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        color: #8892a6;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.25s ease;
        margin-bottom: 16px;
    }
    .back-btn:hover {
        color: #fff;
        border-color: rgba(79,140,255, 0.5);
        background: rgba(79,140,255, 0.08);
        box-shadow: 0 0 12px rgba(79,140,255, 0.2);
        transform: translateX(-2px);
    }

    .page-title {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .page-title::before {
        content: "";
        width: 4px;
        height: 18px;
        background: linear-gradient(180deg, #4f8cff, rgba(79,140,255,0.3));
        border-radius: 2px;
        box-shadow: 0 0 8px rgba(79,140,255,0.6);
    }
    .page-subtitle {
        font-size: 11px;
        color: #8892a6;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 20px;
    }

    .readonly-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        background: rgba(255, 193, 7, 0.1);
        border: 1px solid rgba(255, 193, 7, 0.3);
        border-radius: 12px;
        color: #ffc107;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-left: 8px;
    }

    .field-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 12px;
    }
    .field-row.single {
        grid-template-columns: 1fr;
    }

    .field-group {
        display: flex;
        flex-direction: column;
    }
    .field-label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        color: #8892a6;
        margin-bottom: 6px;
    }
    .field-label .required {
        color: #ff6b6b;
        margin-left: 2px;
    }

    .input-field {
        width: 100%;
        height: 40px;
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        padding: 0 12px;
        color: #fff;
        font: 500 13px 'Inter', sans-serif;
        outline: none;
        transition: all 0.2s ease;
    }
    .input-field::placeholder {
        color: rgba(255,255,255,0.3);
    }
    .input-field:focus:not([readonly]) {
        border-color: rgba(79,140,255, 0.7);
        box-shadow: 0 0 0 2px rgba(79,140,255, 0.15), 0 0 12px rgba(79,140,255, 0.1);
        background: rgba(255,255,255,0.05);
    }
    .input-field[readonly] {
        background: rgba(255,255,255,0.02);
        color: #a8b2c1;
        cursor: not-allowed;
    }
    textarea.input-field {
        min-height: 80px;
        padding: 10px 12px;
        resize: vertical;
        line-height: 1.5;
        height: auto;
    }
    select.input-field {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%238892a6' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10l-5 5z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 32px;
        cursor: pointer;
    }
    select.input-field[disabled] {
        background: rgba(255,255,255,0.02);
        color: #a8b2c1;
        cursor: not-allowed;
        pointer-events: none;
    }
    input[type="date"].input-field::-webkit-calendar-picker-indicator {
        filter: invert(0.8);
        cursor: pointer;
    }

    .receiver-section {
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid rgba(255,255,255,0.06);
    }
    .section-title {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        color: #8892a6;
        margin-bottom: 10px;
    }

    .mode-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        margin-bottom: 12px;
    }
    .mode-btn {
        background: rgba(255,255,255,0.02);
        border: 1.5px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        padding: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
        color: #fff;
        text-align: left;
        width: 100%;
    }
    .mode-btn:hover {
        border-color: rgba(79,140,255, 0.5);
        background: rgba(79,140,255, 0.05);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(79,140,255, 0.15);
    }
    .mode-btn.active {
        border-color: rgba(79,140,255, 1);
        background: rgba(79,140,255, 0.12);
        box-shadow: 0 0 16px rgba(79,140,255, 0.3), inset 0 0 8px rgba(79,140,255, 0.05);
    }
    .mode-btn .mode-icon {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        background: rgba(79,140,255, 0.15);
        border: 1px solid rgba(79,140,255, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4f8cff;
        font-size: 13px;
        margin-bottom: 8px;
        transition: all 0.2s ease;
    }
    .mode-btn.active .mode-icon {
        background: rgba(79,140,255, 0.3);
        box-shadow: 0 0 10px rgba(79,140,255, 0.4);
    }
    .mode-btn .mode-title {
        font-size: 11px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 2px;
    }
    .mode-btn .mode-desc {
        font-size: 9px;
        color: #8892a6;
        line-height: 1.3;
    }
    .mode-btn .mode-check {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 1.5px solid rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    .mode-btn.active .mode-check {
        background: #4f8cff;
        border-color: #4f8cff;
        color: #0a0d14;
        box-shadow: 0 0 8px rgba(79,140,255, 0.8);
    }
    .mode-btn.active .mode-check::after {
        content: "\F26A";
        font-family: "bootstrap-icons";
        font-size: 9px;
        font-weight: 900;
    }

    .receiver-block {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 10px;
        padding: 14px;
        margin-top: 10px;
    }
    .receiver-block.hidden {
        display: none;
    }

    .chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(79,140,255, 0.15);
        border: 1px solid rgba(79,140,255, 0.4);
        color: #4f8cff;
        padding: 4px 10px;
        border-radius: 14px;
        font-size: 11px;
        font-weight: 600;
    }
    .chip button {
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        opacity: 0.7;
        display: flex;
        padding: 0;
        font-size: 10px;
    }
    .chip button:hover {
        opacity: 1;
        color: #ff7a7a;
    }

    .search-dropdown {
        background: rgba(22, 26, 38, 0.98);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        margin-top: 6px;
        max-height: 180px;
        overflow-y: auto;
        box-shadow: 0 8px 24px rgba(0,0,0,0.5);
        z-index: 10;
        position: relative;
    }
    .search-dropdown.hidden {
        display: none;
    }
    .dropdown-item {
        padding: 8px 12px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        cursor: pointer;
        transition: all 0.15s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .dropdown-item:last-child {
        border-bottom: none;
    }
    .dropdown-item:hover {
        background: rgba(79,140,255, 0.08);
    }
    .dropdown-item .name {
        font-size: 12px;
        font-weight: 600;
        color: #fff;
    }
    .dropdown-item .meta {
        font-size: 10px;
        color: #8892a6;
    }

    .file-upload {
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 40px;
        background: rgba(255,255,255,0.03);
        border: 1px dashed rgba(255,255,255,0.15);
        border-radius: 8px;
        padding: 0 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        color: #8892a6;
        font-size: 12px;
    }
    .file-upload:hover {
        border-color: rgba(79,140,255, 0.5);
        background: rgba(79,140,255, 0.05);
        color: #fff;
    }
    .file-upload input[type="file"] {
        display: none;
    }

    .btn-submit {
        appearance: none;
        border: 1.5px solid rgba(79,140,255, 0.6);
        background: linear-gradient(180deg, rgba(79,140,255, 0.2), rgba(79,140,255, 0.1));
        color: #fff;
        font: 700 12px 'Inter', sans-serif;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 12px 24px;
        border-radius: 10px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 0 16px rgba(79,140,255, 0.2);
        transition: all 0.2s ease;
        width: 100%;
        max-width: 280px;
        margin: 0 auto;
    }
    .btn-submit:hover {
        background: linear-gradient(180deg, rgba(79,140,255, 0.3), rgba(79,140,255, 0.15));
        border-color: rgba(79,140,255, 0.8);
        box-shadow: 0 0 24px rgba(79,140,255, 0.35);
        transform: translateY(-1px);
    }

    .receiver-readonly {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 8px;
    }
    .receiver-readonly .avatar {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(79,140,255, 0.15);
        border: 1px solid rgba(79,140,255, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4f8cff;
        font-size: 14px;
    }
    .receiver-readonly .info .name {
        font-size: 12px;
        font-weight: 600;
        color: #fff;
    }
    .receiver-readonly .info .email {
        font-size: 10px;
        color: #8892a6;
    }

    @media (max-width: 768px) {
        .field-row {
            grid-template-columns: 1fr;
        }
        .mode-grid {
            grid-template-columns: 1fr;
        }
        .form-card {
            padding: 20px;
        }
    }
</style>

<div class="doc-edit-page">
    <div class="max-w-3xl mx-auto">

        <a href="{{ route('documents.index') }}" class="back-btn">
            <i class="bi bi-arrow-left"></i>
            <span data-i18n="back">Назад</span>
        </a>

        <div class="form-card">
            <h1 class="page-title">
                @if($isOwner)
                <span data-i18n="editDocTitle">Редактировать документ</span>
                @else
                <span data-i18n="viewDocTitle">Просмотр документа</span>
                @endif
                @if(!$isOwner)
                <span class="readonly-badge">
                    <i class="bi bi-shield-lock-fill"></i>
                    <span data-i18n="readOnly">Read Only</span>
                </span>
                @endif
            </h1>
            @if($isOwner)
            <p class="page-subtitle" data-i18n="editSubtitle">Внесите изменения</p>
            @else
            <p class="page-subtitle" data-i18n="viewSubtitle">Только для чтения</p>
            @endif

            <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data" id="documentForm">
                @csrf
                @method('PUT')

                {{-- Номер и Тип документа --}}
                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label" data-i18n="labelNumber">Номер документа</label>
                        <input type="text" name="number" class="input-field"
                               value="{{ old('number', $document->number) }}"
                               {{ !$isOwner ? 'readonly' : '' }}>
                    </div>
                    <div class="field-group">
                        <label class="field-label">
                            <span data-i18n="labelType">Тип документа</span>
                            <span class="required">*</span>
                        </label>
                        <input type="text" name="type" class="input-field"
                               value="{{ old('type', $document->type ?? '') }}"
                               {{ !$isOwner ? 'readonly' : '' }} required>
                    </div>
                </div>

                {{-- Заголовок и Дедлайн --}}
                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label">
                            <span data-i18n="labelTitle">Заголовок</span>
                            <span class="required">*</span>
                        </label>
                        <input type="text" name="title" class="input-field"
                               value="{{ old('title', $document->title) }}"
                               {{ !$isOwner ? 'readonly' : '' }} required>
                    </div>
                    <div class="field-group">
                        <label class="field-label" data-i18n="labelDeadline">Дедлайн</label>
                        <input type="date" name="deadline" class="input-field"
                               value="{{ old('deadline', $document->deadline ? \Carbon\Carbon::parse($document->deadline)->format('Y-m-d') : '') }}"
                               {{ !$isOwner ? 'readonly' : '' }}>
                    </div>
                </div>

                {{-- Описание --}}
                <div class="field-row single">
                    <div class="field-group">
                        <label class="field-label" data-i18n="labelDescription">Описание</label>
                        <textarea name="content" rows="3" class="input-field"
                                  {{ !$isOwner ? 'readonly' : '' }}>{{ old('content', $document->content) }}</textarea>
                    </div>
                </div>

                {{-- Секция получателей --}}
                @if($isOwner)
                <div class="receiver-section">
                    <div class="section-title">
                        <span data-i18n="labelReceiverMode">Способ отправки</span>
                        <span class="required">*</span>
                    </div>

                    <div class="mode-grid">
                        <button type="button" data-mode="all_team" class="mode-btn">
                            <div class="mode-icon"><i class="bi bi-people-fill"></i></div>
                            <div class="mode-title" data-i18n="modeAllTeam">Всей команде</div>
                            <div class="mode-desc" data-i18n="modeAllTeamDesc">Всем участникам</div>
                            <div class="mode-check"></div>
                        </button>

                        <button type="button" data-mode="select_team" class="mode-btn">
                            <div class="mode-icon"><i class="bi bi-person-check-fill"></i></div>
                            <div class="mode-title" data-i18n="modeSelectTeam">Выбрать</div>
                            <div class="mode-desc" data-i18n="modeSelectTeamDesc">До 5 человек</div>
                            <div class="mode-check"></div>
                        </button>

                        <button type="button" data-mode="other_company" class="mode-btn">
                            <div class="mode-icon"><i class="bi bi-building"></i></div>
                            <div class="mode-title" data-i18n="modeOtherCompany">Другая команда</div>
                            <div class="mode-desc" data-i18n="modeOtherCompanyDesc">Внешний получатель</div>
                            <div class="mode-check"></div>
                        </button>
                    </div>

                    <input type="hidden" name="receiver_mode" id="receiver_mode" value="">

                    {{-- Блок 1: Всей команде --}}
                    <div id="mode-all_team" class="receiver-block hidden">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <i class="bi bi-info-circle-fill" style="color:#4f8cff;font-size:14px;"></i>
                            <div>
                                <p style="font-size:11px;font-weight:600;color:#fff;" data-i18n="allTeamInfo">Отправка всем участникам</p>
                                <p style="font-size:10px;color:#8892a6;margin-top:2px;" data-i18n="allTeamDesc">
                                    Документ будет отправлен всей команде
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Блок 2: Выбор из команды --}}
                    <div id="mode-select_team" class="receiver-block hidden">
                        <label class="field-label" data-i18n="selectReceiversLabel">Выберите получателей (до 5)</label>
                        <input type="text" id="team-search" class="input-field"
                               data-i18n-placeholder="teamSearchPlaceholder"
                               placeholder="Поиск по имени или email..." autocomplete="off">

                        <div id="team-selected" style="display:flex;flex-wrap:wrap;gap:6px;margin-top:8px;min-height:28px;">
                            <span style="font-size:10px;color:#8892a6;" id="team-placeholder" data-i18n="selectedPlaceholder">Выбранные пользователи...</span>
                        </div>

                        <div id="team-list" class="search-dropdown hidden"></div>

                        <input type="hidden" name="team_receivers" id="team_receivers" value="">
                    </div>

                    {{-- Блок 3: Другая команда --}}
                    <div id="mode-other_company" class="receiver-block hidden">
                        <label class="field-label" data-i18n="searchReceiverLabel">Поиск получателя</label>
                        <input type="text" id="other-search" class="input-field"
                               data-i18n-placeholder="otherSearchPlaceholder"
                               placeholder="Название компании или email..." autocomplete="off">

                        <div id="other-selected" class="hidden" style="margin-top:10px;display:flex;align-items:center;justify-content:space-between;padding:10px 14px;background:rgba(79,140,255,0.08);border:1px solid rgba(79,140,255,0.3);border-radius:8px;">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:32px;height:32px;border-radius:8px;background:rgba(79,140,255,0.2);display:flex;align-items:center;justify-content:center;color:#4f8cff;">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div>
                                    <p id="other-name" style="font-size:12px;font-weight:600;color:#fff;"></p>
                                    <p id="other-email" style="font-size:10px;color:#8892a6;"></p>
                                </div>
                            </div>
                            <button type="button" onclick="clearOtherReceiver()" style="background:none;border:none;color:#8892a6;cursor:pointer;font-size:14px;">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>

                        <div id="other-list" class="search-dropdown hidden"></div>
                        <input type="hidden" name="other_receiver_id" id="other_receiver_id" value="">
                    </div>
                </div>
                @else
                {{-- Получатель (readonly для не-владельца) --}}
                <div class="receiver-section">
                    <div class="section-title" data-i18n="receiverLabel">Получатель</div>
                    <div class="receiver-readonly">
                        <div class="avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="info">
                            <p class="name">{{ $currentReceiver ? $currentReceiver->name : __('Не указан') }}</p>
                            <p class="email">{{ $currentReceiver ? $currentReceiver->email : '—' }}</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Статус и Файл --}}
                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label" data-i18n="labelStatus">Статус</label>
                        <select name="status" class="input-field" {{ !$isOwner ? 'disabled' : '' }}>
                        <option value="draft" {{ old('status', $document->status) == 'draft' ? 'selected' : '' }} data-i18n="statusDraft">Черновик</option>
                        <option value="active" {{ old('status', $document->status) == 'active' ? 'selected' : '' }} data-i18n="statusActive">Активен</option>
                        <option value="completed" {{ old('status', $document->status) == 'completed' ? 'selected' : '' }} data-i18n="statusCompleted">Завершён</option>
                        </select>
                    </div>

                    @if($isOwner)
                    <div class="field-group">
                        <label class="field-label" data-i18n="labelNewFile">Новый файл</label>
                        <label class="file-upload">
                            <span id="file-name" data-i18n="filePlaceholder">{{ $document->file_path ? basename($document->file_path) : 'Выберите файл...' }}</span>
                            <i class="bi bi-paperclip"></i>
                            <input type="file" name="file_path" id="file" accept=".pdf,.docx,.xlsx,.rtf">
                        </label>
                    </div>
                    @endif
                </div>

                {{-- Кнопка отправки --}}
                @if($isOwner)
                <div style="margin-top:20px;text-align:center;">
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check-circle-fill"></i>
                        <span data-i18n="saveChanges">Сохранить изменения</span>
                    </button>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== ПЕРЕВОДЫ / TRANSLATIONS / ТАРҶУМАҲО =====
        const translations = {
            ru: {
                back: "Назад",
                editDocTitle: "Редактировать документ",
                viewDocTitle: "Просмотр документа",
                readOnly: "Read Only",
                editSubtitle: "Внесите изменения",
                viewSubtitle: "Только для чтения",
                labelNumber: "Номер документа",
                labelType: "Тип документа",
                labelTitle: "Заголовок",
                labelDeadline: "Дедлайн",
                labelDescription: "Описание",
                labelReceiverMode: "Способ отправки",
                labelStatus: "Статус",
                labelNewFile: "Новый файл",
                modeAllTeam: "Всей команде",
                modeAllTeamDesc: "Всем участникам",
                modeSelectTeam: "Выбрать",
                modeSelectTeamDesc: "До 5 человек",
                modeOtherCompany: "Другая команда",
                modeOtherCompanyDesc: "Внешний получатель",
                allTeamInfo: "Отправка всем участникам",
                allTeamDesc: "Документ будет отправлен всей команде",
                selectReceiversLabel: "Выберите получателей (до 5)",
                teamSearchPlaceholder: "Поиск по имени или email...",
                selectedPlaceholder: "Выбранные пользователи...",
                searchReceiverLabel: "Поиск получателя",
                otherSearchPlaceholder: "Название компании или email...",
                receiverLabel: "Получатель",
                statusDraft: "Черновик",
                statusActive: "Активен",
                statusCompleted: "Завершён",
                filePlaceholder: "Выберите файл...",
                saveChanges: "Сохранить изменения",
                notFound: "Не найдено",
                maxReceivers: "Максимум 5 человек",
                alertSelectMode: "Выберите способ отправки документа",
                alertSelectReceiver: "Выберите хотя бы одного получателя",
                notSpecified: "Не указан"
            },
            tj: {
                back: "Бозгашт",
                editDocTitle: "Таҳрири ҳуҷҷат",
                viewDocTitle: "Дидани ҳуҷҷат",
                readOnly: "Танҳо хондан",
                editSubtitle: "Тағйирот ворид кунед",
                viewSubtitle: "Танҳо барои хондан",
                labelNumber: "Рақами ҳуҷҷат",
                labelType: "Намуди ҳуҷҷат",
                labelTitle: "Сарлавҳа",
                labelDeadline: "Мӯҳлат",
                labelDescription: "Тавсиф",
                labelReceiverMode: "Усули фиристодан",
                labelStatus: "Ҳолат",
                labelNewFile: "Файли нав",
                modeAllTeam: "Ба ҳамаи даста",
                modeAllTeamDesc: "Ба ҳамаи иштирокчиён",
                modeSelectTeam: "Интихоб кардан",
                modeSelectTeamDesc: "То 5 нафар",
                modeOtherCompany: "Дигар даста",
                modeOtherCompanyDesc: "Гирандаи берунӣ",
                allTeamInfo: "Фиристодан ба ҳамаи иштирокчиён",
                allTeamDesc: "Ҳуҷҷат ба ҳамаи даста фиристода мешавад",
                selectReceiversLabel: "Гирандаҳоро интихоб кунед (то 5)",
                teamSearchPlaceholder: "Ҷустуҷӯ аз рӯи ном ё email...",
                selectedPlaceholder: "Корбарони интихобшуда...",
                searchReceiverLabel: "Ҷустуҷӯи гиранда",
                otherSearchPlaceholder: "Номи ширкат ё email...",
                receiverLabel: "Гиранда",
                statusDraft: "Пешнавис",
                statusActive: "Фаъол",
                statusCompleted: "Анҷомёфта",
                filePlaceholder: "Файлро интихоб кунед...",
                saveChanges: "Нигоҳ доштани тағйирот",
                notFound: "Ёфт нашуд",
                maxReceivers: "Ҳадди аксар 5 нафар",
                alertSelectMode: "Усули фиристодани ҳуҷҷатро интихоб кунед",
                alertSelectReceiver: "Ҳадди ақал як гирандаро интихоб кунед",
                notSpecified: "Муайян нашудааст"
            },
            en: {
                back: "Back",
                editDocTitle: "Edit Document",
                viewDocTitle: "View Document",
                readOnly: "Read Only",
                editSubtitle: "Make changes",
                viewSubtitle: "Read only",
                labelNumber: "Document Number",
                labelType: "Document Type",
                labelTitle: "Title",
                labelDeadline: "Deadline",
                labelDescription: "Description",
                labelReceiverMode: "Sending Method",
                labelStatus: "Status",
                labelNewFile: "New File",
                modeAllTeam: "All Team",
                modeAllTeamDesc: "To all members",
                modeSelectTeam: "Select",
                modeSelectTeamDesc: "Up to 5 people",
                modeOtherCompany: "Other Team",
                modeOtherCompanyDesc: "External recipient",
                allTeamInfo: "Sending to all members",
                allTeamDesc: "Document will be sent to the entire team",
                selectReceiversLabel: "Select recipients (up to 5)",
                teamSearchPlaceholder: "Search by name or email...",
                selectedPlaceholder: "Selected users...",
                searchReceiverLabel: "Search recipient",
                otherSearchPlaceholder: "Company name or email...",
                receiverLabel: "Recipient",
                statusDraft: "Draft",
                statusActive: "Active",
                statusCompleted: "Completed",
                filePlaceholder: "Choose file...",
                saveChanges: "Save Changes",
                notFound: "Not found",
                maxReceivers: "Maximum 5 people",
                alertSelectMode: "Select document sending method",
                alertSelectReceiver: "Select at least one recipient",
                notSpecified: "Not specified"
            }
        };

        // ===== Получение текущего языка =====
        function getCurrentLang() {
            return localStorage.getItem('docsign_lang')
                || localStorage.getItem('app-lang')
                || 'ru';
        }

        // ===== Применение переводов =====
        function applyTranslations() {
            const lang = getCurrentLang();
            const t = translations[lang] || translations['ru'];

            // Обновляем все элементы с data-i18n
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key] !== undefined) {
                    el.textContent = t[key];
                }
            });

            // Обновляем placeholder-ы
            document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
                const key = el.getAttribute('data-i18n-placeholder');
                if (t[key] !== undefined) {
                    el.setAttribute('placeholder', t[key]);
                }
            });

            return t;
        }

        let currentT = applyTranslations();

        // ===== Слушатель смены языка =====
        window.addEventListener('docsign:lang-changed', function(e) {
            if (e.detail && e.detail.lang) {
                localStorage.setItem('docsign_lang', e.detail.lang);
                localStorage.setItem('app-lang', e.detail.lang);
            }
            currentT = applyTranslations();
        });

        const form = document.getElementById('documentForm');
        const modeInput = document.getElementById('receiver_mode');
        const modeButtons = document.querySelectorAll('.mode-btn');
        let currentMode = null;
        let selectedTeamUsers = [];

        const teamUsers = @json($teamUsersArray ?? []);
        const otherUsers = @json($otherUsersArray ?? []);

        // === Переключение режимов отправки ===
        if (modeButtons.length > 0) {
            modeButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const mode = this.dataset.mode;
                    currentMode = mode;
                    modeInput.value = mode;

                    modeButtons.forEach(b => b.classList.remove('active'));
                    document.querySelectorAll('.receiver-block').forEach(b => b.classList.add('hidden'));

                    this.classList.add('active');

                    const block = document.getElementById('mode-' + mode);
                    if (block) block.classList.remove('hidden');
                });
            });
        }

        // === Загрузка файла ===
        const fileInput = document.getElementById('file');
        const fileName = document.getElementById('file-name');
        if (fileInput && fileName) {
            fileInput.addEventListener('change', function() {
                const t = translations[getCurrentLang()] || translations['ru'];
                fileName.textContent = this.files.length > 0 ? this.files[0].name : t.filePlaceholder;
            });
        }

        // === Поиск пользователей команды ===
        const teamSearch = document.getElementById('team-search');
        const teamList = document.getElementById('team-list');
        const teamSelected = document.getElementById('team-selected');
        const teamReceivers = document.getElementById('team_receivers');

        if (teamSearch) {
            teamSearch.addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();
                if (query.length < 1) {
                    teamList.classList.add('hidden');
                    return;
                }

                const t = translations[getCurrentLang()] || translations['ru'];
                const filtered = teamUsers.filter(u =>
                    u.name.toLowerCase().includes(query) || u.email.toLowerCase().includes(query)
                ).filter(u => !selectedTeamUsers.find(s => s.id === u.id));

                teamList.innerHTML = '';
                if (filtered.length === 0) {
                    teamList.innerHTML = `<div style="padding:10px;font-size:11px;color:#8892a6;">${t.notFound}</div>`;
                } else {
                    filtered.forEach(u => {
                        const item = document.createElement('div');
                        item.className = 'dropdown-item';
                        item.innerHTML = `
                            <span class="name">${u.name}</span>
                            <span class="meta">${u.email}</span>
                        `;
                        item.addEventListener('click', () => {
                            const t2 = translations[getCurrentLang()] || translations['ru'];
                            if (selectedTeamUsers.length >= 5) {
                                alert(t2.maxReceivers);
                                return;
                            }
                            selectedTeamUsers.push(u);
                            updateTeamSelected();
                            teamSearch.value = '';
                            teamList.classList.add('hidden');
                        });
                        teamList.appendChild(item);
                    });
                }
                teamList.classList.remove('hidden');
            });

            teamSearch.addEventListener('blur', () => {
                setTimeout(() => teamList.classList.add('hidden'), 200);
            });
        }

        function updateTeamSelected() {
            if (!teamSelected) return;
            const t = translations[getCurrentLang()] || translations['ru'];
            teamSelected.innerHTML = '';
            if (selectedTeamUsers.length === 0) {
                teamSelected.innerHTML = `<span style="font-size:10px;color:#8892a6;" data-i18n="selectedPlaceholder">${t.selectedPlaceholder}</span>`;
            } else {
                selectedTeamUsers.forEach((user, idx) => {
                    const chip = document.createElement('span');
                    chip.className = 'chip';
                    chip.innerHTML = `${user.name} <button type="button" data-idx="${idx}">&times;</button>`;
                    chip.querySelector('button').addEventListener('click', () => {
                        selectedTeamUsers.splice(idx, 1);
                        updateTeamSelected();
                    });
                    teamSelected.appendChild(chip);
                });
            }
            if (teamReceivers) {
                teamReceivers.value = selectedTeamUsers.map(u => u.id).join(',');
            }
        }

        // === Поиск по другой команде ===
        const otherSearch = document.getElementById('other-search');
        const otherList = document.getElementById('other-list');
        const otherSelected = document.getElementById('other-selected');

        if (otherSearch) {
            otherSearch.addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();
                if (query.length < 1) {
                    otherList.classList.add('hidden');
                    return;
                }

                const t = translations[getCurrentLang()] || translations['ru'];
                const filtered = otherUsers.filter(u =>
                    u.name.toLowerCase().includes(query) || u.email.toLowerCase().includes(query)
                );

                otherList.innerHTML = '';
                if (filtered.length === 0) {
                    otherList.innerHTML = `<div style="padding:10px;font-size:11px;color:#8892a6;">${t.notFound}</div>`;
                } else {
                    filtered.forEach(u => {
                        const item = document.createElement('div');
                        item.className = 'dropdown-item';
                        item.innerHTML = `
                            <span class="name">${u.name}</span>
                            <span class="meta">${u.email}</span>
                        `;
                        item.addEventListener('click', () => {
                            document.getElementById('other_receiver_id').value = u.id;
                            document.getElementById('other-name').textContent = u.name;
                            document.getElementById('other-email').textContent = u.email;
                            otherSelected.classList.remove('hidden');
                            otherList.classList.add('hidden');
                            otherSearch.value = '';
                        });
                        otherList.appendChild(item);
                    });
                }
                otherList.classList.remove('hidden');
            });

            otherSearch.addEventListener('blur', () => {
                setTimeout(() => otherList.classList.add('hidden'), 200);
            });
        }

        window.clearOtherReceiver = function() {
            document.getElementById('other_receiver_id').value = '';
            otherSelected.classList.add('hidden');
        };

        // === Валидация при отправке ===
        if (form) {
            form.addEventListener('submit', function(e) {
                if (!modeInput) return;
                const t = translations[getCurrentLang()] || translations['ru'];
                const mode = modeInput.value;
                if (!mode) {
                    e.preventDefault();
                    alert(t.alertSelectMode);
                    return;
                }
                if (mode === 'select_team' && selectedTeamUsers.length === 0) {
                    e.preventDefault();
                    alert(t.alertSelectReceiver);
                    return;
                }
            });
        }
    });
</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .mode-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(79, 140, 255, 0.1);
    border-radius: 8px;
    margin-bottom: 8px;
}

.mode-icon i {
    font-size: 20px;
    color: #4f8cff;
}

.mode-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 16px;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.mode-btn:hover {
    background: rgba(79, 140, 255, 0.1);
    border-color: #4f8cff;
    transform: translateY(-2px);
}

.mode-btn.active {
    background: rgba(79, 140, 255, 0.15);
    border-color: #4f8cff;
    box-shadow: 0 0 20px rgba(79, 140, 255, 0.3);
}
</style>
@endsection