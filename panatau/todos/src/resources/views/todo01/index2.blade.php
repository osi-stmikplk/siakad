@extends('panatau-todos::layout-main')
@section('scriptjs-bottom')
    <script src="{{ asset($panatauPublicPath.'/main02.js') }}"></script>
@endsection
@section('content')
<div id="app">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3>Form Input</h3>
                    </div>
                    <div class="panel-body">
                        <input type="hidden" v-model="todo.id">
                        <div class="form-group">
                            <input class="form-control" placeholder="Apa yang harus dilakukan" v-model="todo.text">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" placeholder="Keterangan" v-model="todo.keterangan"></textarea>
                        </div>
                        <div class="form-group">
                            <button v-show="editMode===false" class="btn btn-primary" type="button" v-on:click="addTodo(todo)">Tambah</button>
                            <button v-show="editMode===true" class="btn btn-primary" type="button" v-on:click="updateTodo(todo)">Simpan</button>
                            <button v-show="editMode===true" class="btn btn-danger" type="button" v-on:click="cancelTodo(todo)">Batal</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3>Daftar yang harus dikerjakan!</h3>
                    </div>
                    <div class="panel-body">
                        <div class="list-group">
                            <a v-for="t in todos" href="#"
                               class="list-group-item"
                               v-bind:class="t.status==1? 'list-group-item-success':'list-group-item-warning'">
                                <h4 class="list-group-item-heading">@{{ t.text }}</h4>
                                <p class="list-group-item-text">@{{ t.keterangan }}</p>
                                <hr>
                                <button class="btn btn-success btn-xs" v-on:click="todoCompleted(t)" v-show="t.status===0">tandai sudah selesai</button>
                                <button class="btn bg-danger btn-xs" v-on:click="todoUnCompleted(t)" v-show="t.status===1">tandai belum selesai</button>
                                <button class="btn btn-warning btn-xs" v-on:click="editTodo(t)" v-show="t.status===0">edit</button>
                                <button class="btn btn-danger btn-xs" v-on:click="removeTodo(t)">hapus</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
