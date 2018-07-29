@extends('layouts.full')

@section('content')

<vue-snotify></vue-snotify>
       
{{-- <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form> --}}

<chat-component :user="{{ Auth::user() }}"></chat-component>

@endsection
