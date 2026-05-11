@extends('layouts.admin')

@section('content')
    <div class="notif-container">
        <div class="notif-header">
            <h2 data-i18n="notifTitle">Уведомления</h2>
            @if(isset($unreadCount) && $unreadCount > 0)
                <span class="unread-count"><span data-i18n="newNotifs">У вас новые:</span> {{ $unreadCount }}</span>
            @endif
        </div>

        <div class="notif-list">
            @forelse($notifications as $n)
                @php
                    $data = is_array($n->data) ? $n->data : json_decode($n->data, true);
                    $docId = $data['document_id'] ?? ($data['id'] ?? null);
                    $type = $n->type ?? ($data['type'] ?? 'system');
                    $userName = $data['user_name'] ?? ($data['user'] ?? 'Система');
                    $docTitle = $data['document_title'] ?? ($data['document'] ?? 'Документ');
                    $commentText = $data['comment_preview'] ?? ($data['comment_text'] ?? null);

                    $actionKey = match($type) {
                        'assigned' => 'notifAssigned',
                        'comment'  => 'notifCommented',
                        'signed'   => 'notifSigned',
                        'created'  => 'notifCreated',
                        default    => 'notifDefault'
                    };
                @endphp

                <div class="notif-card {{ !$n->is_read ? 'unread' : '' }}">
                    <div class="notif-item">
                        <div class="notif-icon-wrapper type-{{ $type }}">
                            @switch($type)
                                @case('assigned') <span class="icon">📌</span> @break
                                @case('comment')  <span class="icon">💬</span> @break
                                @case('signed')   <span class="icon">✍️</span> @break
                                @case('created')  <span class="icon">📄</span> @break
                                @default          <span class="icon">🔔</span>
                            @endswitch
                        </div>

                        <div class="notif-content">
                            <div class="notif-title">
                                <span class="user-name">{{ $userName }}</span>
                                <span data-i18n="{{ $actionKey }}"></span>

                                @if($docId)
                                    <a href="{{ url('/documents/' . $docId) }}" class="doc-link">
                                        «{{ $docTitle }}»
                                    </a>
                                @else
                                    <span class="doc-name-no-link">«{{ $docTitle }}»</span>
                                @endif
                            </div>

                            @if($commentText)
                                <div class="notif-quote">{{ $commentText }}</div>
                            @endif

                            <div class="notif-meta">
                                <span class="time-tag">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    {{ $n->created_at->diffForHumans() }}
                                </span>

                                <div class="notif-actions">
                                    @if(!$n->is_read)
                                        <form action="{{ route('notifications.read', $n->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="action-link mark-read" data-i18n="btnMarkRead">Прочитать</button>
                                        </form>
                                    @endif

                                    <form action="{{ route('notifications.destroy', $n->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-link delete" data-i18n="btnDelete" data-confirm-i18n="confirmDelete">Удалить</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @if(!$n->is_read)
                            <div class="unread-dot"></div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="notif-empty">
                    <div class="empty-icon">🔔</div>
                    <p data-i18n="noNotifs">У вас пока нет уведомлений</p>
                </div>
            @endforelse
        </div>

        @if($notifications->hasPages())
            <div class="notif-pagination">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>

    <style>
        :root {
            --primary-color: #4f46e5;
            --bg-unread: #f5f7ff;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --border-color: #f3f4f6;
            --danger: #ef4444;
        }
        .notif-container { max-width: 700px; margin: 20px auto; padding: 0 15px; font-family: 'Inter', sans-serif; }
        .notif-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .unread-count { font-size: 13px; background: var(--primary-color); color: white; padding: 4px 12px; border-radius: 20px; }
        .notif-list { display: flex; flex-direction: column; gap: 12px; }
        .notif-card { background: #ffffff; border: 1px solid var(--border-color); border-radius: 16px; transition: all 0.2s ease; position: relative; }
        .notif-item { display: flex; gap: 16px; padding: 16px; }
        .notif-card.unread { background: var(--bg-unread); border-color: rgba(79, 70, 229, 0.1); }
        .notif-icon-wrapper { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; }
        .type-assigned { background: #fff7ed; }
        .type-comment  { background: #f0fdf4; }
        .type-signed   { background: #eff6ff; }
        .type-created  { background: #f5f3ff; }
        .notif-content { flex: 1; position: relative; }
        .notif-title { font-size: 15px; line-height: 1.4; color: var(--text-main); }
        .user-name { font-weight: 700; }
        .doc-link { font-weight: 700; color: var(--primary-color); text-decoration: underline; padding: 2px 4px; border-radius: 4px; background: rgba(79, 70, 229, 0.05); }
        .doc-name-no-link { color: #9ca3af; font-size: 12px; }
        .notif-quote { margin-top: 8px; padding: 10px; background: rgba(0,0,0,0.03); border-radius: 8px; font-size: 13px; color: #4b5563; border-left: 3px solid #d1d5db; font-style: italic; }
        .notif-meta { margin-top: 10px; display: flex; justify-content: space-between; align-items: center; }
        .time-tag { font-size: 12px; color: var(--text-muted); display: flex; align-items: center; gap: 4px; }
        .notif-actions { display: flex; gap: 12px; position: relative; z-index: 10; }
        .action-link { background: none; border: none; padding: 0; font-size: 12px; font-weight: 600; cursor: pointer; }
        .mark-read { color: var(--primary-color); }
        .delete { color: var(--text-muted); }
        .unread-dot { width: 10px; height: 10px; background: var(--primary-color); border-radius: 50%; position: absolute; right: 16px; top: 20px; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const translations = {
                ru: {
                    notifTitle: "Уведомления",
                    newNotifs: "У вас новые:",
                    notifAssigned: " назначил вам документ",
                    notifCommented: " оставил комментарий к ",
                    notifSigned: " подписал документ",
                    notifCreated: " создал документ",
                    notifDefault: " отправил уведомление",
                    btnMarkRead: "Прочитать",
                    btnDelete: "Удалить",
                    noNotifs: "У вас пока нет уведомлений",
                    confirmDelete: "Удалить?"
                },
                tj: {
                    notifTitle: "Огоҳиномаҳо",
                    newNotifs: "Нав доред:",
                    notifAssigned: " ҳуҷҷатро ба шумо супорид",
                    notifCommented: " шарҳ гузошт ба ",
                    notifSigned: " ҳуҷҷатро имзо кард",
                    notifCreated: " ҳуҷҷат сохт",
                    notifDefault: " огоҳинома фиристод",
                    btnMarkRead: "Хондан",
                    btnDelete: "Нест кардан",
                    noNotifs: "Шумо огоҳинома надоред",
                    confirmDelete: "Нест кунем?"
                },
                en: {
                    notifTitle: "Notifications",
                    newNotifs: "New ones:",
                    notifAssigned: " assigned a document",
                    notifCommented: " commented on ",
                    notifSigned: " signed the document",
                    notifCreated: " created a document",
                    notifDefault: " sent a notification",
                    btnMarkRead: "Read",
                    btnDelete: "Delete",
                    noNotifs: "No notifications",
                    confirmDelete: "Delete?"
                }
            };

            const lang = localStorage.getItem('app-lang') || 'ru';
            const t = translations[lang];

            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key]) el.textContent = t[key];
            });

            document.querySelectorAll('[data-confirm-i18n]').forEach(el => {
                const key = el.getAttribute('data-confirm-i18n');
                if (t[key]) {
                    el.closest('form').onsubmit = (e) => {
                        if (!confirm(t[key])) e.preventDefault();
                    };
                }
            });
        });
    </script>
@endsection
