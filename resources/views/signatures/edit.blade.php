
    <div class="container">
        <h2>Редактировать подпись</h2>

        <form method="POST"
              action="{{ route('signatures.update', $signature->id) }}"
              onsubmit="return saveSignature(event)">
            @csrf
            @method('PUT')


            <input type="hidden" name="document_id" value="{{ $signature->document_id }}">
            <div class="mb-3">
                <label><strong>Документ:</strong></label>
                <input type="text" class="form-control"
                       value="{{ $signature->document->title ?? '—' }}"
                       disabled>
            </div>
            {{-- canvas --}}
            <canvas id="signature-pad" width="400" height="200" style="border:1px solid #000;"></canvas>

            <input type="hidden" name="signature" id="signature">

            <div class="mt-2">
                <button type="button" onclick="clearPad()" class="btn btn-secondary">Очистить</button>
                <button type="submit" class="btn btn-primary">Обновить</button>
            </div>
        </form>
    </div>

    <script>
        let canvas = document.getElementById('signature-pad');
        let ctx = canvas.getContext('2d');
        let drawing = false;

        canvas.addEventListener('mousedown', () => drawing = true);
        canvas.addEventListener('mouseup', () => {
            drawing = false;
            ctx.beginPath();
        });
        canvas.addEventListener('mousemove', draw);

        function draw(e) {
            if (!drawing) return;

            ctx.lineWidth = 2;
            ctx.lineCap = 'round';

            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(e.offsetX, e.offsetY);
        }

        function clearPad() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }

        function saveSignature(e) {
            let data = canvas.toDataURL();

            if (data === "data:,") {
                alert("Сначала поставь подпись!");
                e.preventDefault();
                return false;
            }

            document.getElementById('signature').value = data;
            return true;
        }
    </script>

