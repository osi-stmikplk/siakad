@extends('panatau-todos::layout-main')
@section('scriptjs-bottom')
    <script src="{{ asset($panatauPublicPath.'/main01.js') }}"></script>
@endsection
@section('content')
    <div id="app">
        <input v-model="newTodo" v-on:keyup.enter="addTodo">
        <ul>
            <li v-for="todo in todos">
                <span>@{{ todo.text }}</span>
                <button v-on:click="removeTodo($index)">X</button>
            </li>
        </ul>
    </div>
@endsection