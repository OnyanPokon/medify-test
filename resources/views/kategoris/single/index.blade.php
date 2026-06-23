@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-group mb-2">
                    <a href="{{ url('kategoris') }}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
                </div>
                <div class="card">
                    <div class="card-header">Kategori</div>

                    <div class="card-body">
                        <table>
                            <tr>
                                <th>Kode</th>
                                <td>:</td>
                                <td>{{ $data->kode }}</td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>:</td>
                                <td>{{ $data->nama }}</td>
                            </tr>
                            <tr>
                                <th>Produk</th>
                                <td>:</td>
                                <td>
                                    @if ($data->products->count())
                                        <div class="row">

                                            @foreach ($data->products as $product)
                                                <div class=" mb-3">

                                                    <div class="card shadow-sm h-100">

                                                        @if ($product->foto_produk)
                                                            <img src="{{ asset('storage/' . $product->foto_produk) }}"
                                                                class="card-img-top"
                                                                style="height:60px; object-fit:cover;">
                                                        @else
                                                            <img src="https://via.placeholder.com/300x150?text=No+Image"
                                                                class="card-img-top"
                                                                style="height:60px; object-fit:cover;">
                                                        @endif

                                                        <div class="card-body">
                                                            <h6 class="card-title mb-1">
                                                                {{ $product->nama }}
                                                            </h6>

                                                            <p class="mb-0 text-muted">
                                                                Rp {{ number_format($product->harga_beli) }}
                                                            </p>

                                                            <small class="text-muted">
                                                                {{ $product->jenis }}
                                                            </small>
                                                        </div>

                                                    </div>

                                                </div>
                                            @endforeach

                                        </div>
                                    @else
                                        <p class="text-muted">Tidak ada produk dalam kategori ini</p>
                                    @endif
                                </td>
                            </tr>


                        </table>
                        <a class="btn btn-info" href="{{ url('kategoris/form/edit') }}/{{ $data->id }}">Edit</a>
                        <a class="btn btn-danger" href="{{ url('kategoris/delete') }}/{{ $data->id }}"
                            onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
