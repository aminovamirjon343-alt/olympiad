<div class="notif-container">

    <div class="notif-list">

        @forelse($notifications as $n)

            @php
                $data = is_array($n->data) ? $n->data : json_decode($n->data, true);

                $type = $data['type'] ?? 'system';
                $user = $data['user'] ?? 'Пользователь';

                $doc = $data['document'] ?? ($data['document_title'] ?? 'документ');
                $signature = $data['signature'] ?? null;
            @endphp

            <div class="notif-item {{ !$n->read_at ? 'unread' : '' }}">

                {{-- ICON --}}
                <div class="notif-icon">
                    @switch($type)
                        @case('assigned') 📌 @break
                        @case('sent') 📤 @break
                        @case('received') 📥 @break
                        @case('signed') ✍️ @break
                        @case('created') 📄 @break
                        @case('completed') ✅ @break
                        @case('rejected') ❌ @break
                        @default 🔔
                    @endswitch
                </div>

                {{-- CONTENT --}}
                <div class="notif-content">

                    <div class="notif-title">

                        @switch($type)

                            @case('assigned')
                                {{ $user }} должен подписать документ "<b>{{ $doc }}</b>"
                                @if($signature)
                                    <div class="notif-sub">
                                        Ожидается подпись: <b>{{ $signature }}</b>
                                    </div>
                                @endif
                                @break

                            @case('sent')
                                {{ $user }} отправил документ "<b>{{ $doc }}</b>" на подпись
                                @break

                            @case('received')
                                {{ $user }} получил документ "<b>{{ $doc }}</b>"
                                @break

                            @case('signed')
                                {{ $user }} подписал документ "<b>{{ $doc }}</b>"
                                @if($signature)
                                    <div class="notif-sub">
                                        Подписал: <b>{{ $signature }}</b>
                                    </div>
                                @endif
                                @break

                            @case('created')
                                {{ $user }} создал документ "<b>{{ $doc }}</b>"
                                @break

                            @case('completed')
                                Документ "<b>{{ $doc }}</b>" полностью подписан
                                @break

                            @case('rejected')
                                {{ $user }} отклонил подпись документа "<b>{{ $doc }}</b>"
                                @break

                            @default
                                {{ $data['message'] ?? 'Системное уведомление' }}

                        @endswitch

                    </div>

                    {{-- META --}}
                    <div class="notif-meta">
                        <span class="notif-user">{{ $user }}</span>
                        <span class="notif-time">{{ $n->created_at->diffForHumans() }}</span>
                    </div>

                </div>

            </div>

        @empty

            <div class="notif-empty">
                Нет уведомлений
            </div>

        @endforelse

    </div>

</div>


<style>
    .notif-container {
        max-width: 720px;
        margin: 0 auto;
        font-family: Inter, sans-serif;
    }

    /* LIST */
    .notif-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    /* ITEM */
    .notif-item {
        display: flex;
        gap: 12px;
        padding: 14px 16px;
        border-radius: 12px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        transition: 0.2s ease;
        cursor: pointer;
    }

    /* hover как Notion */
    .notif-item:hover {
        background: #f9fafb;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.06);
    }

    /* unread */
    .notif-item.unread {
        border-left: 3px solid #4f46e5;
        background: #f8faff;
    }

    /* ICON */
    .notif-icon {
        font-size: 18px;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f3f4f6;
        border-radius: 10px;
    }

    /* CONTENT */
    .notif-content {
        flex: 1;
    }

    /* TITLE */
    .notif-title {
        font-size: 14px;
        font-weight: 500;
        color: #111827;
        line-height: 1.4;
    }

    /* META */
    .notif-meta {
        margin-top: 4px;
        font-size: 12px;
        color: #6b7280;
        display: flex;
        gap: 10px;
    }

    /* USER */
    .notif-user {
        font-weight: 600;
        color: #4f46e5;
    }

    /* EMPTY */
    .notif-empty {
        padding: 20px;
        text-align: center;
        color: #9ca3af;
    }
</style>
