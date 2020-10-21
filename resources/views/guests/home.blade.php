@extends('layouts.app')
@section('content')

    <div class="display-4 p-5 text-center">
        Benvenuto nel mio fantastico blog
    </div>

    @guest
      <p class="lead text-center">guest</p>
    @else
      <p class="lead text-center">il tuo nome è {{ Auth::user()->name}}</p>
    @endguest
    {{-- fab: fab@libero.it   au7RS5uxEJDWyT8 --}}
@endsection
