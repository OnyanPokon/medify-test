<form method="POST" enctype="multipart/form-data">
    @csrf

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($method == 'edit')
        <div class="form-group">
            <label>Kode Kategori</label>
            <input type="text" class="form-control" name="kode" readonly value="{{ $item->kode ?? '' }}">
        </div>
    @endif

    <div class="form-group">
        <label>Nama Kategori</label>

        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
            value="{{ old('nama', $item->nama ?? '') }}">

        @error('nama')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>


    <button type="submit" class="btn btn-primary mt-3">
        Submit
    </button>
</form>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview');

        if (!file) {
            preview.style.display = 'none';
            return;
        }

        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
</script>
