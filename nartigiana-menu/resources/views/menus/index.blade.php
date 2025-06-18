@extends('layouts.app')

@section('content')
<h1>I miei Menù</h1>

@if(session('success'))
    <div style="color:green;">{{ session('success') }}</div>
@endif

<a href="{{ route('menus.create') }}">Crea Nuovo Menù</a>

<ul>
    @forelse($menus as $menu)
        <li>
            <a href="{{ route('menus.show', $menu) }}">{{ $menu->title }}</a> |
            <a href="{{ route('menus.edit', $menu) }}">Modifica</a> |

            <form action="{{ route('menus.destroy', $menu) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Sei sicuro?')">Elimina</button>
            </form>
        </li>
    @empty
        <li>Nessun menù trovato.</li>
    @endforelse
</ul>
@endsection
