@extends('layouts.app')

@section('content')
<h1>Crea Nuovo Menù</h1>

<form action="{{ route('menus.store') }}" method="POST">
    @csrf
    <label for="title">Titolo</label>
    <input type="text" name="title" id="title" value="{{ old('title') }}" required>
    @error('title')
        <div style="color:red;">{{ $message }}</div>
    @enderror

    <button type="submit">Salva</button>
</form>
@endsection
