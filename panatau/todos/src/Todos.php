<?php
namespace Panatau\Todos;

use Illuminate\Database\Eloquent\Model;

class Todos extends Model
{
    protected $table = 'todos';
    protected $fillable = ['judul', 'keterangan', 'status'];
}