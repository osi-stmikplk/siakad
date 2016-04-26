/**
 * Percobaan todos tahap 3
 * sementara untuk koneksi ke database gunakan jquery!
 */
vuetodos = new Vue({
    el: '#app',
    data: {
        newTodo: { id:0, judul: '', keterangan: '', status: 0 },
        todo: { id:0, judul: '', keterangan:'', status: 0 },
        cacheTodo: null,
        editMode: false,
        todos: []
    },
    ready: function() {
        // initialization of data
        this.initTodos();
    },
    methods: {
        initTodos: function() {
            temptodos =  [{ id:0, judul: '', keterangan: '', status: 0 }];
            $.getJSON('/todos/getTodos', function(data){
                vuetodos.$set('todos', data);
            });
        },
        addTodo: function(todo) {
            var judul = todo.judul.trim();
            if(judul) {
                temptodos = {judul: todo.judul, keterangan: todo.keterangan, _token:$('meta[name="csrf-token"]').attr('content')};
                $.post('/todos/postStore', $.param(temptodos), function(data){
                    vuetodos.todos.push(data);
                    temptodos = { id:0, judul: '', keterangan:'', status: 0 };
                    vuetodos.$set('todo', temptodos);
                },'json');
            }
        },
        todoUnCompleted: function(todo) {
            $.post('/todos/postSetStatus/'+todo.id+'/0',
                $.param({_token:$('meta[name="csrf-token"]').attr('content')}),
                function(data){
                    todo.status = data.status;
            },'json');
        },
        todoCompleted: function(todo) {
            $.post('/todos/postSetStatus/'+todo.id+'/1',
                $.param({_token:$('meta[name="csrf-token"]').attr('content')}),
                function(data){
                    todo.status = data.status;
                },'json');
        },
        editTodo: function(todo) {
            if(this.cacheTodo == null) this.cacheTodo = { id:0, judul: '', keterangan:'', status: 0 };
            this._onlyAssignValue(this.cacheTodo, todo);
            this.todo = todo;
            this.editMode = true;
        },
        updateTodo: function(todo) {
            this.editMode = false;
            var judul = todo.judul.trim();
            if(judul) {
                temptodos = {judul: todo.judul, keterangan: todo.keterangan, status:todo.status, _token:$('meta[name="csrf-token"]').attr('content')};
                $.post('/todos/postUpdate/'+todo.id, $.param(temptodos), function(data){
                    temptodos = { id:0, judul: '', keterangan:'', status: 0 };
                    vuetodos.$set('todo', temptodos);
                },'json');
            }
            this.todo = { id:0, judul: '', keterangan:'', status: 0 };
        },
        cancelTodo: function(todo) {
            this.editMode = false;
            this._onlyAssignValue(todo, this.cacheTodo);
            this.todo = { id:0, judul: '', keterangan:'', status: 0 };
            this.cacheTodo = null;
        },
        _onlyAssignValue:function(atodo,btodo) {
            atodo.judul = btodo.judul;
            atodo.keterangan = btodo.keterangan;
            atodo.status = btodo.status;
            atodo.id = btodo.id;
        },
        removeTodo: function(index) {
            if(confirm('Yakin untuk menghapus?')) {
                this.todos.splice(index, 1);
            }
        }
    }
});
