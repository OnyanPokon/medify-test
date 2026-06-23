@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-group mb-2">
                    <a href="{{ url('kategoris/form/new') }}" class="btn btn-secondary">+ Kategori</a>
                </div>
                <div class="card">
                    <div class="card-header">Daftar Kategori</div>

                    <div class="card-body">
                        @include('kategoris.index.filter')
                        @include('kategoris.index.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('kategoris.index.js')
@endpush
