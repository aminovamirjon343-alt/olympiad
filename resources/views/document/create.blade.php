@extends('layouts.admin')

@section('content')
<style>
    /* === КОМПАКТНАЯ СТРАНИЦА СОЗДАНИЯ ДОКУМЕНТА === */
    .doc-create-page {
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
    .input-field:focus {
        border-color: rgba(79,140,255, 0.7);
        box-shadow: 0 0 0 2px rgba(79,140,255, 0.15), 0 0 12px rgba(79,140,255, 0.1);
        background: rgba(255,255,255,0.05);
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
        background: rgba(16, 19, 28, 0.98);
        border: 1px solid rgba(79,140,255,0.3);
        border-radius: 8px;
        margin-top: 6px;
        max-height: 200px;
        overflow-y: auto;
        box-shadow: 0 8px 24px rgba(0,0,0,0.6), 0 0 16px rgba(79,140,255,0.1);
        z-index: 100;
        position: absolute;
        left: 0;
        right: 0;
        width: 100%;
    }
    .search-dropdown.hidden {
        display: none !important;
    }
    .dropdown-item {
        padding: 10px 14px;
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
        background: rgba(79,140,255, 0.15);
    }
    .dropdown-item .name {
        font-size: 12px;
        font-weight: 600;
        color: #fff;
        display: block;
        margin-bottom: 2px;
    }
    .dropdown-item .meta {
        font-size: 10px;
        color: #8892a6;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .dropdown-item .meta span {
        display: block;
    }
    .dropdown-item .meta .company {
        color: #4f8cff;
        font-weight: 500;
    }
    .dropdown-item .add-icon {
        color: #4f8cff;
        font-size: 14px;
        opacity: 0.7;
        transition: all 0.2s;
    }
    .dropdown-item:hover .add-icon {
        opacity: 1;
        transform: scale(1.2);
    }
    .dropdown-empty {
        padding: 12px 14px;
        font-size: 11px;
        color: #8892a6;
        text-align: center;
    }

    .search-wrapper {
        position: relative;
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

    .error-box {
        background: rgba(255, 99, 99, 0.05);
        border: 1px solid rgba(255, 99, 99, 0.25);
        border-left: 3px solid #ff6b6b;
        border-radius: 8px;
        padding: 12px;
        color: #ff9999;
        margin-bottom: 16px;
    }
    .error-box .title {
        font-weight: 700;
        font-size: 12px;
        margin-bottom: 4px;
        color: #ff6b6b;
    }
    .error-box ul {
        font-size: 11px;
        margin: 0;
        padding-left: 16px;
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

<div class="doc-create-page">
    <div class="max-w-3xl mx-auto">

        <a href="{{ route('documents.index') }}" class="back-btn">
            <i class="bi bi-arrow-left"></i>
            <span data-i18n="back">Назад</span>
        </a>

        @if($errors->any())
        <div class="error-box">
            <div class="title" data-i18n="errorTitle">Ошибка при создании документа</div>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="form-card">
            <h1 class="page-title" data-i18n="pageTitle">Новый документ</h1>
            <p class="page-subtitle" data-i18n="pageSubtitle">Заполните информацию о документе</p>

            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" id="documentForm">
                @csrf

                {{-- Номер, Тип и Статус --}}
                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label">
                            <span data-i18n="labelNumber">Номер документа</span>
                            <span class="required">*</span>
                        </label>
                        <input type="text" name="number" class="input-field"
                               value="{{ old('number', '№ ') }}"
                               data-i18n-placeholder="numberPlaceholder"
                               placeholder="№ 001" required>
                    </div>
                    <div class="field-group">
                        <label class="field-label">
                            <span data-i18n="labelType">Тип документа</span>
                            <span class="required">*</span>
                        </label>
                        <input type="text" name="type" class="input-field"
                               data-i18n-placeholder="typePlaceholder"
                               placeholder="Договор, Акт..." value="{{ old('type') }}" required>
                    </div>
                </div>

                {{-- Статус и Дедлайн --}}
                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label">
                            <span data-i18n="labelStatus">Статус документа</span>
                            <span class="required">*</span>
                        </label>
                        <select name="status" class="input-field" required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }} data-i18n="statusSend">Отправить на подпись</option>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }} data-i18n="statusDraft">Сохранить как черновик</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="field-label" data-i18n="labelDeadline">Дедлайн</label>
                        <input type="date" name="deadline" class="input-field" value="{{ old('deadline') }}">
                    </div>
                </div>

                {{-- Заголовок --}}
                <div class="field-row single">
                    <div class="field-group">
                        <label class="field-label">
                            <span data-i18n="labelTitle">Заголовок</span>
                            <span class="required">*</span>
                        </label>
                        <input type="text" name="title" class="input-field"
                               data-i18n-placeholder="titlePlaceholder"
                               placeholder="Название документа" value="{{ old('title') }}" required>
                    </div>
                </div>

                {{-- Описание --}}
                <div class="field-row single">
                    <div class="field-group">
                        <label class="field-label" data-i18n="labelDescription">Описание</label>
                        <textarea name="content" rows="3" class="input-field"
                                  data-i18n-placeholder="descriptionPlaceholder"
                                  placeholder="Краткое описание документа...">{{ old('content') }}</textarea>
                    </div>
                </div>

                {{-- Файл --}}
                <div class="field-row single">
                    <div class="field-group">
                        <label class="field-label">
                            <span data-i18n="labelFile">Прикрепить файл</span>
                            <span class="required">*</span>
                        </label>
                        <label class="file-upload">
                            <span id="file-name" data-i18n="filePlaceholder">Выберите файл...</span>
                            <i class="bi bi-paperclip"></i>
                            <input type="file" name="file_path" id="file-input" required>
                        </label>
                    </div>
                </div>

                {{-- Секция получателей --}}
                <div class="receiver-section">
                    <div class="section-title">
                        <span data-i18n="labelReceiverMode">Способ отправки</span>
                        <span class="required" style="color:#ff6b6b">*</span>
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
                                <p style="font-size:10px;color:#8892a6;margin-top:2px;">
                                    <span data-i18n="receiversCount">Получателей:</span>
                                    <strong style="color:#4f8cff;">{{ $teamUsers->count() }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Блок 2: Выбор из команды --}}
                    <div id="mode-select_team" class="receiver-block hidden">
                        <label class="field-label" data-i18n="selectReceiversLabel">Выберите получателей (до 5)</label>

                        <div class="search-wrapper">
                            <input type="text" id="team-search" class="input-field"
                                   data-i18n-placeholder="searchPlaceholder"
                                   placeholder="Введите 2+ буквы для поиска..." autocomplete="off">
                            <div id="team-list" class="search-dropdown hidden"></div>
                        </div>

                        <div id="team-selected" style="display:flex;flex-wrap:wrap;gap:6px;margin-top:10px;min-height:28px;">
                            <span style="font-size:10px;color:#8892a6;" id="team-placeholder" data-i18n="selectedPlaceholder">Выбранные пользователи появятся здесь...</span>
                        </div>

                        <input type="hidden" name="team_receivers" id="team_receivers" value="">
                        <p id="team-error" style="font-size:10px;color:#ff6b6b;margin-top:6px;font-weight:600;display:none;">
                            ⚠ <span data-i18n="selectError">Выберите хотя бы одного получателя</span>
                        </p>
                    </div>

                    {{-- Блок 3: Другая команда --}}
                    <div id="mode-other_company" class="receiver-block hidden">
                        <label class="field-label" data-i18n="searchCompanyLabel">Поиск получателя из другой команды</label>

                        <div class="search-wrapper">
                            <input type="text" id="company-search" class="input-field"
                                   data-i18n-placeholder="searchPlaceholder"
                                   placeholder="Введите 2+ буквы для поиска..." autocomplete="off">
                            <div id="company-list" class="search-dropdown hidden"></div>
                        </div>

                        <div id="company-selected" style="margin-top:10px;min-height:28px;"></div>

                        <input type="hidden" name="other_receiver_id" id="company_receiver" value="">
                    </div>
                </div>

                {{-- Кнопка отправки --}}
                <div style="margin-top:20px;text-align:center;">
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-send-fill"></i>
                        <span data-i18n="submitButton">Создать документ</span>
                    </button>
                </div>
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
                errorTitle: "Ошибка при создании документа",
                pageTitle: "Новый документ",
                pageSubtitle: "Заполните информацию о документе",
                labelNumber: "Номер документа",
                labelType: "Тип документа",
                labelStatus: "Статус документа",
                labelDeadline: "Дедлайн",
                labelTitle: "Заголовок",
                labelDescription: "Описание",
                labelFile: "Прикрепить файл",
                labelReceiverMode: "Способ отправки",
                modeAllTeam: "Всей команде",
                modeAllTeamDesc: "Всем участникам",
                modeSelectTeam: "Выбрать",
                modeSelectTeamDesc: "До 5 человек",
                modeOtherCompany: "Другая команда",
                modeOtherCompanyDesc: "Внешний получатель",
                allTeamInfo: "Отправка всем участникам",
                receiversCount: "Получателей:",
                selectReceiversLabel: "Выберите получателей (до 5)",
                searchPlaceholder: "Введите 2+ буквы для поиска...",
                selectedPlaceholder: "Выбранные пользователи появятся здесь...",
                selectError: "Выберите хотя бы одного получателя",
                searchCompanyLabel: "Поиск получателя из другой команды",
                submitButton: "Создать документ",
                filePlaceholder: "Выберите файл...",
                usersNotFound: "Пользователи не найдены",
                maxReceivers: "Максимум 5 получателей",
                alertSelectMode: "Выберите способ отправки документа",
                alertSelectCompany: "Выберите получателя из другой команды",
                numberPlaceholder: "№ 001",
                typePlaceholder: "Договор, Акт...",
                titlePlaceholder: "Название документа",
                descriptionPlaceholder: "Краткое описание документа...",
                statusSend: "Отправить на подпись",
                statusDraft: "Сохранить как черновик"
            },
            tj: {
                back: "Бозгашт",
                errorTitle: "Хато ҳангоми эҷоди ҳуҷҷат",
                pageTitle: "Ҳуҷҷати нав",
                pageSubtitle: "Маълумот оид ба ҳуҷҷатро пур кунед",
                labelNumber: "Рақами ҳуҷҷат",
                labelType: "Намуди ҳуҷҷат",
                labelStatus: "Ҳолати ҳуҷҷат",
                labelDeadline: "Мӯҳлат",
                labelTitle: "Сарлавҳа",
                labelDescription: "Тавсиф",
                labelFile: "Файл замима кардан",
                labelReceiverMode: "Усули фиристодан",
                modeAllTeam: "Ба ҳамаи даста",
                modeAllTeamDesc: "Ба ҳамаи иштирокчиён",
                modeSelectTeam: "Интихоб кардан",
                modeSelectTeamDesc: "То 5 нафар",
                modeOtherCompany: "Дигар даста",
                modeOtherCompanyDesc: "Гирандаи берунӣ",
                allTeamInfo: "Фиристодан ба ҳамаи иштирокчиён",
                receiversCount: "Гирандаҳо:",
                selectReceiversLabel: "Гирандаҳоро интихоб кунед (то 5)",
                searchPlaceholder: "2+ ҳарфро барои ҷустуҷӯ ворид кунед...",
                selectedPlaceholder: "Корбарони интихобшуда дар ин ҷо пайдо мешаванд...",
                selectError: "Ҳадди ақал як гирандаро интихоб кунед",
                searchCompanyLabel: "Ҷустуҷӯи гиранда аз дигар даста",
                submitButton: "Эҷоди ҳуҷҷат",
                filePlaceholder: "Файлро интихоб кунед...",
                usersNotFound: "Корбарон ёфт нашуданд",
                maxReceivers: "Ҳадди аксар 5 гиранда",
                alertSelectMode: "Усули фиристодани ҳуҷҷатро интихоб кунед",
                alertSelectCompany: "Гирандаро аз дигар даста интихоб кунед",
                numberPlaceholder: "№ 001",
                typePlaceholder: "Шартнома, Акт...",
                titlePlaceholder: "Номи ҳуҷҷат",
                descriptionPlaceholder: "Тавсифи мухтасари ҳуҷҷат...",
                statusSend: "Барои имзо фиристодан",
                statusDraft: "Ҳамчун пешнавис нигоҳ доштан"
            },
            en: {
                back: "Back",
                errorTitle: "Error creating document",
                pageTitle: "New Document",
                pageSubtitle: "Fill in the document information",
                labelNumber: "Document Number",
                labelType: "Document Type",
                labelStatus: "Document Status",
                labelDeadline: "Deadline",
                labelTitle: "Title",
                labelDescription: "Description",
                labelFile: "Attach File",
                labelReceiverMode: "Sending Method",
                modeAllTeam: "All Team",
                modeAllTeamDesc: "To all members",
                modeSelectTeam: "Select",
                modeSelectTeamDesc: "Up to 5 people",
                modeOtherCompany: "Other Team",
                modeOtherCompanyDesc: "External recipient",
                allTeamInfo: "Sending to all members",
                receiversCount: "Recipients:",
                selectReceiversLabel: "Select recipients (up to 5)",
                searchPlaceholder: "Enter 2+ letters to search...",
                selectedPlaceholder: "Selected users will appear here...",
                selectError: "Select at least one recipient",
                searchCompanyLabel: "Search recipient from another team",
                submitButton: "Create Document",
                filePlaceholder: "Choose file...",
                usersNotFound: "Users not found",
                maxReceivers: "Maximum 5 recipients",
                alertSelectMode: "Select document sending method",
                alertSelectCompany: "Select recipient from another team",
                numberPlaceholder: "No. 001",
                typePlaceholder: "Contract, Act...",
                titlePlaceholder: "Document name",
                descriptionPlaceholder: "Brief document description...",
                statusSend: "Send for signature",
                statusDraft: "Save as draft"
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

            // Обновляем title-ы
            document.querySelectorAll('[data-i18n-title]').forEach(el => {
                const key = el.getAttribute('data-i18n-title');
                if (t[key] !== undefined) {
                    el.setAttribute('title', t[key]);
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

        // === Данные пользователей из Laravel ===
        const teamUsers = @json($teamUsersArray ?? []);
        const otherUsers = @json($otherUsersArray ?? []);

        // === Переключение режимов отправки ===
        const modeBtns = document.querySelectorAll('.mode-btn');
        const modeBlocks = document.querySelectorAll('.receiver-block');
        const modeInput = document.getElementById('receiver_mode');

        modeBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                modeBtns.forEach(b => b.classList.remove('active'));
                modeBlocks.forEach(b => b.classList.add('hidden'));

                this.classList.add('active');
                const mode = this.dataset.mode;
                modeInput.value = mode;

                const block = document.getElementById('mode-' + mode);
                if (block) block.classList.remove('hidden');
            });
        });

        // === Загрузка файла ===
        const fileInput = document.getElementById('file-input');
        const fileName = document.getElementById('file-name');
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                const t = translations[getCurrentLang()] || translations['ru'];
                fileName.textContent = this.files.length > 0 ? this.files[0].name : t.filePlaceholder;
            });
        }

        // === ПОИСК ПОЛЬЗОВАТЕЛЕЙ КОМАНДЫ ===
        const teamSearch = document.getElementById('team-search');
        const teamList = document.getElementById('team-list');
        const teamSelected = document.getElementById('team-selected');
        const teamReceivers = document.getElementById('team_receivers');
        const teamError = document.getElementById('team-error');
        let selectedTeam = [];

        if (teamSearch && teamList) {
            teamSearch.addEventListener('focus', function() {
                const query = this.value.trim().toLowerCase();
                if (query.length >= 2) {
                    filterTeamUsers(query);
                }
            });

            teamSearch.addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();
                if (query.length < 2) {
                    teamList.classList.add('hidden');
                    return;
                }
                filterTeamUsers(query);
            });

            function filterTeamUsers(query) {
                const t = translations[getCurrentLang()] || translations['ru'];
                const filtered = teamUsers.filter(user => {
                    if (selectedTeam.find(s => s.id === user.id)) return false;
                    const name = (user.name || '').toLowerCase();
                    const email = (user.email || '').toLowerCase();
                    const company = (user.company || user.company_name || '').toLowerCase();
                    return name.includes(query) || email.includes(query) || company.includes(query);
                });

                teamList.innerHTML = '';

                if (filtered.length === 0) {
                    teamList.innerHTML = `<div class="dropdown-empty">${t.usersNotFound}</div>`;
                } else {
                    filtered.forEach(user => {
                        const item = document.createElement('div');
                        item.className = 'dropdown-item';
                        const company = user.company || user.company_name || '';
                        item.innerHTML = `
                            <div>
                                <span class="name">${user.name}</span>
                                <div class="meta">
                                    ${company ? `<span class="company">${company}</span>` : ''}
                                    <span>${user.email || ''}</span>
                                </div>
                            </div>
                            <i class="bi bi-plus-circle-fill add-icon"></i>
                        `;
                        item.addEventListener('click', function(e) {
                            e.stopPropagation();
                            const t2 = translations[getCurrentLang()] || translations['ru'];
                            if (selectedTeam.length >= 5) {
                                alert(t2.maxReceivers);
                                return;
                            }
                            selectedTeam.push(user);
                            updateTeamSelected();
                            teamSearch.value = '';
                            teamList.classList.add('hidden');
                            teamSearch.focus();
                        });
                        teamList.appendChild(item);
                    });
                }
                teamList.classList.remove('hidden');
            }

            document.addEventListener('click', function(e) {
                if (!teamSearch.contains(e.target) && !teamList.contains(e.target)) {
                    teamList.classList.add('hidden');
                }
            });

            function updateTeamSelected() {
                const t = translations[getCurrentLang()] || translations['ru'];
                teamSelected.innerHTML = '';

                if (selectedTeam.length === 0) {
                    teamSelected.innerHTML = `<span style="font-size:10px;color:#8892a6;" data-i18n="selectedPlaceholder">${t.selectedPlaceholder}</span>`;
                } else {
                    selectedTeam.forEach(user => {
                        const chip = document.createElement('span');
                        chip.className = 'chip';
                        chip.innerHTML = `${user.name} <button type="button" data-id="${user.id}">&times;</button>`;
                        chip.querySelector('button').addEventListener('click', function() {
                            selectedTeam = selectedTeam.filter(u => u.id !== user.id);
                            updateTeamSelected();
                        });
                        teamSelected.appendChild(chip);
                    });
                }

                teamReceivers.value = selectedTeam.map(u => u.id).join(',');
                teamError.style.display = 'none';
            }
        }

        // === ПОИСК ПОЛЬЗОВАТЕЛЕЙ ДРУГОЙ КОМАНДЫ ===
        const companySearch = document.getElementById('company-search');
        const companyList = document.getElementById('company-list');
        const companySelected = document.getElementById('company-selected');
        const companyReceiver = document.getElementById('company_receiver');
        let selectedCompany = null;

        if (companySearch && companyList) {
            companySearch.addEventListener('focus', function() {
                const query = this.value.trim().toLowerCase();
                if (query.length >= 2) {
                    filterCompanyUsers(query);
                }
            });

            companySearch.addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();
                if (query.length < 2) {
                    companyList.classList.add('hidden');
                    return;
                }
                filterCompanyUsers(query);
            });

            function filterCompanyUsers(query) {
                const t = translations[getCurrentLang()] || translations['ru'];
                const filtered = otherUsers.filter(user => {
                    const name = (user.name || '').toLowerCase();
                    const email = (user.email || '').toLowerCase();
                    const company = (user.company || user.company_name || '').toLowerCase();
                    return name.includes(query) || email.includes(query) || company.includes(query);
                });

                companyList.innerHTML = '';

                if (filtered.length === 0) {
                    companyList.innerHTML = `<div class="dropdown-empty">${t.usersNotFound}</div>`;
                } else {
                    filtered.forEach(user => {
                        const item = document.createElement('div');
                        item.className = 'dropdown-item';
                        const company = user.company || user.company_name || '';
                        item.innerHTML = `
                            <div>
                                <span class="name">${user.name}</span>
                                <div class="meta">
                                    ${company ? `<span class="company">${company}</span>` : ''}
                                    <span>${user.email || ''}</span>
                                </div>
                            </div>
                            <i class="bi bi-check-circle-fill add-icon"></i>
                        `;
                        item.addEventListener('click', function(e) {
                            e.stopPropagation();
                            selectedCompany = user;
                            companyReceiver.value = user.id;
                            companySelected.innerHTML = `
                                <span class="chip">
                                    ${user.name}
                                    <button type="button" id="clear-company">&times;</button>
                                </span>
                            `;
                            document.getElementById('clear-company').addEventListener('click', function() {
                                selectedCompany = null;
                                companyReceiver.value = '';
                                companySelected.innerHTML = '';
                            });
                            companySearch.value = '';
                            companyList.classList.add('hidden');
                        });
                        companyList.appendChild(item);
                    });
                }
                companyList.classList.remove('hidden');
            }

            document.addEventListener('click', function(e) {
                if (!companySearch.contains(e.target) && !companyList.contains(e.target)) {
                    companyList.classList.add('hidden');
                }
            });
        }

        // === Валидация при отправке ===
        const form = document.getElementById('documentForm');
        form.addEventListener('submit', function(e) {
            const t = translations[getCurrentLang()] || translations['ru'];
            const mode = modeInput.value;

            if (!mode) {
                e.preventDefault();
                alert(t.alertSelectMode);
                return;
            }

            if (mode === 'select_team' && selectedTeam.length === 0) {
                e.preventDefault();
                teamError.style.display = 'block';
                return;
            }

            if (mode === 'other_company' && !selectedCompany) {
                e.preventDefault();
                alert(t.alertSelectCompany);
                return;
            }
        });
    });
</script>

@endsection