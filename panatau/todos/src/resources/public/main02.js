/**
 * Percobaan todos tahap 2
 */
new Vue({
    el: '#app',
    data: {
        newTodo: { id:0, text: '', keterangan: '', status: 0 },
        todo: { id:0, text: '', keterangan:'', status: 0 },
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
            var todos = [
                { id: 1, text: 'Todo 1', keterangan: 'keterangan 1', status: 0 },
                { id: 2, text: 'Todo 2', keterangan: 'keterangan 2', status: 0 }
            ];
            //this.todos.push(todos);
            this.$set('todos', todos);
        },
        addTodo: function() {
            var text = this.todo.text.trim();
            if(text) {
                id = Number(this.todo.id);
                todosCnt = this.todos.length;
                if(id==0) {
                    // get last id
                    if(todosCnt>0) {
                        newid = this.todos[todosCnt-1].id + 1;
                    }
                    else {
                        newid = 1;
                    }
                    // add new
                    this.todo.id = newid;
                    this.todos.push(this.todo);
                } else {
                    for(i=0;i<todosCnt;i++) {
                        if(this.todos[i].id == id) {
                            this.todos[i] = this.todo;
                            break;
                        }
                    }
                }
                this.todo = { id:0, text: '', keterangan: '', status: 0 };
            }
        },
        todoUnCompleted: function(todo) {
            todo.status = 0;
        },
        todoCompleted: function(todo) {
            todo.status = 1;
        },
        editTodo: function(todo) {
            if(this.cacheTodo == null) this.cacheTodo = { id:0, text: '', keterangan:'', status: 0 };
            this._onlyAssignValue(this.cacheTodo, todo);
            this.todo = todo;
            this.editMode = true;
        },
        updateTodo: function(todo) {
            this.editMode = false;
            this.todo = { id:0, text: '', keterangan:'', status: 0 };
        },
        cancelTodo: function(todo) {
            this.editMode = false;
            this._onlyAssignValue(todo, this.cacheTodo);
            this.cacheTodo = null;
        },
        _onlyAssignValue:function(atodo,btodo) {
            atodo.text = btodo.text;
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
