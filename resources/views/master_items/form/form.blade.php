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
            <label>Kode Barang</label>
            <input type="text" class="form-control" name="kode_barang" readonly value="{{ $item->kode ?? '' }}">
        </div>
    @endif

    <div class="form-group">
        <label>Nama</label>

        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
            value="{{ old('nama', $item->nama ?? '') }}">

        @error('nama')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    @php
        $selectedCategories = old('categories', $item->categories->pluck('id')->toArray());
    @endphp

    <div class="form-group">
        <label>Kategori</label>

        <select name="categories[]" class="form-control select2" multiple>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}>
                    {{ $category->nama ?? $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Harga Beli</label>

        <input type="number" class="form-control @error('harga_beli') is-invalid @enderror" name="harga_beli"
            value="{{ old('harga_beli', $item->harga_beli ?? '') }}">

        @error('harga_beli')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label>Laba (dalam persen)</label>

        <input type="number" class="form-control @error('laba') is-invalid @enderror" name="laba"
            value="{{ old('laba', $item->laba ?? '') }}">

        @error('laba')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    @php
        $selectedSupplier = old('supplier', $item->supplier ?? '');
    @endphp

    <div class="form-group">
        <label>Supplier</label>

        <select class="form-control @error('supplier') is-invalid @enderror" name="supplier">
            <option value="">--Pilih--</option>
            <option value="Tokopaedi" {{ $selectedSupplier == 'Tokopaedi' ? 'selected' : '' }}>
                Tokopaedi
            </option>
            <option value="Bukulapuk" {{ $selectedSupplier == 'Bukulapuk' ? 'selected' : '' }}>
                Bukulapuk
            </option>
            <option value="TokoBagas" {{ $selectedSupplier == 'TokoBagas' ? 'selected' : '' }}>
                TokoBagas
            </option>
            <option value="E Commurz" {{ $selectedSupplier == 'E Commurz' ? 'selected' : '' }}>
                E Commurz
            </option>
            <option value="Blublu" {{ $selectedSupplier == 'Blublu' ? 'selected' : '' }}>
                Blublu
            </option>
        </select>

        @error('supplier')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
    </div>

    @php
        $selectedJenis = old('jenis', $item->jenis ?? '');
    @endphp

    <div class="form-group">
        <label>Jenis</label>

        <select class="form-control @error('jenis') is-invalid @enderror" name="jenis">
            <option value="">--Pilih--</option>
            <option value="Obat" {{ $selectedJenis == 'Obat' ? 'selected' : '' }}>
                Obat
            </option>
            <option value="Alkes" {{ $selectedJenis == 'Alkes' ? 'selected' : '' }}>
                Alkes
            </option>
            <option value="Matkes" {{ $selectedJenis == 'Matkes' ? 'selected' : '' }}>
                Matkes
            </option>
            <option value="Umum" {{ $selectedJenis == 'Umum' ? 'selected' : '' }}>
                Umum
            </option>
            <option value="ATK" {{ $selectedJenis == 'ATK' ? 'selected' : '' }}>
                ATK
            </option>
        </select>

        @error('jenis')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label>Foto Produk</label>

        <input type="file" class="form-control @error('foto_produk') is-invalid @enderror" name="foto_produk"
            accept="image/*" onchange="previewImage(event)" {{ $method == 'new' ? 'required' : '' }}>

        @error('foto_produk')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror

        <div class="mt-3">
            <img id="preview" src="{{ !empty($item->foto_produk) ? asset('storage/' . $item->foto_produk) : '' }}"
                alt="Preview"
                style="
                    max-width:250px;
                    max-height:250px;
                    border:1px solid #ddd;
                    padding:5px;
                    display:{{ !empty($item->foto_produk) ? 'block' : 'none' }};
                ">
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3">
        Submit
    </button>
</form>

@push('js')
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
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush
