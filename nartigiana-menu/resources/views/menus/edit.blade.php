@extends('layouts.app')

@section('content')
<h1>Modifica Menù</h1>

<form action="{{ route('menus.update', $menu) }}" method="POST">
@csrf
@method('PUT')
<label for="title">Titolo</label>
<input type="text" name="title" id="title" value="{{ old('title', $menu->title) }}" required>
@error('title')
    <div style="color:red;">{{ $message }}</div>
@enderror

<button type="submit">Aggiorna</button>
</form> @endsection