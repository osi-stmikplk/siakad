<?php
namespace Stmik\Factories;

/**
 * Semua Factory harus extend ini.
 * User: toni
 * Date: 15/10/15
 * Time: 10:57
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\MessageBag;
use Panatau\Tools\UtilBootstrapTable;

/**
 * Disini adalah basis dari Factory
 * User: toni
 * Date: 08/09/15
 * Time: 22:10
 */

abstract class AbstractFactory {

    /**
     * Simpan disini untuk error saat processing inputan
     * @var MessageBag;
     */
    protected $errors;

    public function __construct()
    {
        $this->errors = new MessageBag();
    }

    public function getErrors()
    {
        return $this->errors->getMessages();
    }

    /**
     * Dapatkan semua error dan jadikan string!
     * @return string
     */
    public function getErrorsString()
    {
        $msgS = [];
        $ary = $this->errors->getMessages();
        foreach ($ary as $key => $msg) {
            $msgS[] = "$key=".implode("->",$msg);
        }
        return implode("|", $msgS);
    }

    protected function idNotFound()
    {
        $this->errors->add('special', 'Wrong id');
    }

    /**
     * Nilai ini hanya digunakan saat ada proses insert data dan akan diberikan dengan nilai id setelah data berhasil
     * tersimpan.
     * @var null
     */
    protected $last_insert_id = null;

    /**
     * NILAI INI HARUS DISET sendiri setelah melakukan proses insert dengan mengambil nilai id data yang terinsert!
     * @return null
     */
    public function getLastInsertId()
    {
        return $this->last_insert_id;
    }

    /**
     * Lakukan proses check terhadap inputan yang memiliki type sebagai check box. Hal ini dilakukan mengingat apabla
     * check box tidak dicentang maka tidak ada di set pada input!
     * @param $input array of input
     * @param $field string yang di check
     * @param int $defaultValue nilai default!
     */
    public function setCheckBoxInputValue(&$input, $field, $defaultValue=0)
    {
        $input[$field] = isset($input[$field])? $input[$field]: $defaultValue;
        return $this;
    }

    /**
     * Untuk membantu proses render data di halaman index yang digunakan oleh bootstrap table.
     * @param array $pagination hasil proses pagination
     * @param Builder|Model $DBSource
     * @param array $searchField field yang bisa di cari
     * @param boolean $onlyData hanya serahkan data tanpa perlu JSON
     * @return string JSON
     */
    protected function getBTData($pagination, $DBSource, array $searchField, array $defaultTableOfField=[], $onlyData = false)
    {
        $bttable = new UtilBootstrapTable($DBSource, $defaultTableOfField);
        $data = $bttable
            ->search($searchField, $pagination['search'])
            ->setPaginationOffset($pagination['offset'])
            ->setPaginationLimit($pagination['limit'])
            ->setSortBy($pagination['sort'], $pagination['order'])
            ->getData();

        if($onlyData) return $data;

        return '{'
        .'"total": '. $bttable->getDbCount() .','
        .'"rows": ' . json_encode($data)
        .'}';
    }

}