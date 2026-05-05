<div class="notif-container">
    <div class="notif-list">
        @forelse($notifications as $n)
            @php
                $data = is_array($n->data) ? $n->data : json_decode($n->data, true);
                $type = $n->type ?? ($data['type'] ?? 'system');
                $userName = $data['user'] ?? ($n->user->name ?? 'Система');
                $docTitle = $data['document'] ?? ($data['document_title'] ?? 'Документ');
            @endphp

            <div class="notif-item {{ !$n->is_read ? 'unread' : '' }}">
                {{-- Левая часть: Иконка с цветным фоном в зависимости от типа --}}
                <div class="notif-icon-wrapper type-{{ $type }}">
                    @switch($type)
                        @case('assigned') <span class="icon">📌</span> @break
                        @case('comment')  <span class="icon">💬</span> @break
                        @case('signed')   <span class="icon">✍️</span> @break
                        @case('created')  <span class="icon">📄</span> @break
                        @default          <span class="icon">🔔</span>
                    @endswitch
                </div>

                {{-- Центральная часть: Контент --}}
                <div class="notif-content">
                    <div class="notif-title">
                        <span class="user-name">{{ $userName }}</span>
                        @switch($type)
                            @case('assigned') назначил вам документ @break
                            @case('comment') оставил комментарий к @break
                            @case('signed') подписал документ @break
                            @default отправил уведомление по @break
                        @endswitch
                        <span class="doc-name">«{{ $docTitle }}»</span>
                    </div>

                    <div class="notif-meta">
                        <span class="time-tag">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            {{ $n->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>

                {{-- Правая часть: Точка непрочитанного --}}
                @if(!$n->is_read)
                    <div class="unread-dot"></div>
                @endif
            </div>
        @empty
            <div class="notif-empty">
                <div class="empty-icon">🔔</div>
                <p>У вас пока нет новых уведомлений</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    :root {
        --primary-color: #4f46e5;
        --bg-unread: #f5f7ff;
        --text-main: #1f2937;
        --text-muted: #6b7280;
        --border-color: #f3f4f6;
    }

    .notif-container {
        max-width: 650px;
        margin: 20px auto;
        font-family: 'Inter', -apple-system, sans-serif;
    }

    .notif-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .notif-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        border-radius: 16px;
        background: #ffffff;
        border: 1px solid var(--border-color);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        cursor: pointer;
    }

    .notif-item:hover {
        background: #ffffff;
        border-color: #e5e7eb;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
    }

    /* Стиль непрочитанного */
    .notif-item.unread {
        background: var(--bg-unread);
        border-color: rgba(79, 70, 229, 0.1);
    }

    .unread-dot {
        width: 8px;
        height: 8px;
        background: var(--primary-color);
        border-radius: 50%;
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
    }

    /* Иконки с разными фонами */
    .notif-icon-wrapper {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 20px;
        flex-shrink: 0;
    }

    .type-assigned { background: #fff7ed; }
    .type-comment  { background: #f0fdf4; }
    .type-signed   { background: #eff6ff; }
    .type-created  { background: #f5f3ff; }
    .type-system   { background: #f9fafb; }

    /* Типографика */
    .notif-content {
        flex: 1;
        padding-right: 20px;
    }

    .notif-title {
        font-size: 14.5px;
        line-height: 1.5;
        color: var(--text-main);
    }

    .user-name {
        font-weight: 700;
        color: #111827;
        text-transform: capitalize;
    }

    .doc-name {
        font-weight: 600;
        color: var(--primary-color);
    }

    .notif-meta {
        margin-top: 6px;
        display: flex;
        align-items: center;
    }

    .time-tag {
        font-size: 12px;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 4px;
        background: #f9fafb;
        padding: 2px 8px;
        border-radius: 6px;
    }

    .unread .time-tag {
        background: rgba(79, 70, 229, 0.08);
        color: var(--primary-color);
    }

    /* Пустое состояние */
    .notif-empty {
        padding: 40px;
        text-align: center;
        background: #f9fafb;
        border-radius: 20px;
        border: 2px dashed #e5e7eb;
    }

    .empty-icon {
        font-size: 32px;
        margin-bottom: 12px;
        opacity: 0.5;
    }

    .notif-empty p {
        color: #9ca3af;
        font-size: 15px;
    }
</style>
