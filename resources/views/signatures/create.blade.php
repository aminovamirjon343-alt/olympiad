<div class="container">
    <h2>Подписать документ</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('signatures.store') }}" onsubmit="return saveSignature(event)">
        @csrf

        {{-- документ --}}
        <div class="mb-2">
            <label>Документ</label>
            <select name="document_id" class="form-control" required>
                @foreach($documents as $doc)
                    <option value="{{ $doc->id }}">{{ $doc->title }}</option>
                @endforeach
            </select>
        </div>

        {{-- ⚠️ user_id (лучше скрыто или disabled) --}}
        <div class="mb-2">
            <label>Пользователь</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- canvas --}}
        <canvas id="signature-pad" width="400" height="200"
                style="border:1px solid #000; touch-action:none;"></canvas>

        <input type="hidden" name="signature" id="signature">

        <div class="mt-2">
            <button type="button" onclick="clearPad()" class="btn btn-secondary">
                Очистить
            </button>

            <button type="submit" class="btn btn-success">
                Подписать
            </button>
        </div>
    </form>
</div>

    <script>
        let canvas = document.getElementById('signature-pad');
        let ctx = canvas.getContext('2d');
        let drawing = false;

        // начало
        canvas.addEventListener('mousedown', () => drawing = true);

        // конец
        canvas.addEventListener('mouseup', () => {
            drawing = false;
            ctx.beginPath();
        });

        canvas.addEventListener('mouseleave', () => drawing = false);
        canvas.addEventListener('mousemove', draw);

        // рисование
        function draw(e) {
            if (!drawing) return;

            ctx.lineWidth = 2;
            ctx.lineCap = 'round';

            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(e.offsetX, e.offsetY);
        }

        // очистка
        function clearPad() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }

        // проверка пустоты
        function isCanvasEmpty() {
            const blank = document.createElement('canvas');
            blank.width = canvas.width;
            blank.height = canvas.height;
            return canvas.toDataURL() === blank.toDataURL();
        }

        // submit
        function saveSignature(e) {
            if (isCanvasEmpty()) {
                alert("Сначала поставь подпись!");
                e.preventDefault();
                return false;
            }

            document.getElementById('signature').value = canvas.toDataURL();
            return true;
        }
    </script>

