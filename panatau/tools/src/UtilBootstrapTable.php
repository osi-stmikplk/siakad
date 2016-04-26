<?php

namespace Panatau\Tools;
/**
 * Utility untuk membantu proses loading data di datatable!
 * User: toni
 * Date: 24/05/15
 * Time: 10:43
 */

class UtilBootstrapTable {

    protected $db;
    protected $pagination;
    protected $dbCount = 0;
    /**
     * Karena kita tidak bisa menambahkan secara spesifik table yang harusnya dimasukkan pada waktu query pada
     * field yang duplicate pada kasus join, maka lakukan proses mapping sehingga kita bisa tahu apabila ada mengakses
     * field bisa kita tambahkan di query untuk sintak yang benar.
     * Misalnya field yang dipake id  pada table post dan category, maka agar bisa diketahui yang mana yang dipakai
     * secara default maka kita buat defaultFieldToTable = ['id'=>'post'] jadi waktu di query tinggal lakukan mapping
     * sehingga yang diquery bukan id tapi post.id.
     * @var array
     */
    protected $defaultFieldToTable = [];

    /**
     * get Database Count!
     * @return int
     */
    public function getDbCount()
    {
        return $this->dbCount;
    }

    public function __construct($sourceData, array $defaultFieldToTable = [])
    {
        $this->db = $sourceData;
        $this->defaultFieldToTable = $defaultFieldToTable;
    }

    protected function attachTableToThisField($field)
    {
        if(count($this->defaultFieldToTable)>0)
        {
            if(isset($this->defaultFieldToTable[$field]))
            {
                // add dot then replace the name in the query
                if(str_contains($this->defaultFieldToTable[$field],'.'))
                {
                    return $this->defaultFieldToTable[$field];
                }
                return $this->defaultFieldToTable[$field].'.'.$field;
            }
        }
        return $field;
    }

    /**
     * Lakukan setting field yang akan dicari.
     * @param array $fields nama field array yang dicari
     * @param string $search kata kunci
     * @return $this
     */
    public function search(array $fields = [], $keyword = "")
    {
        if(count($fields)>0 && strlen($keyword) > 0)
        {
            $bufferFields = $fields;
            $this->db = $this->db//->where($this->attachTableToThisField(array_pop($bufferFields)), 'LIKE', "%$keyword%") // bug need to use or where
            ->where(function($query) use($bufferFields, $keyword){ // gunakan advance where utk memasukkan query
                foreach ($bufferFields as $f) {                    // menjadi satu group (didalam kurung)
                    $query->orWhere($this->attachTableToThisField($f), 'LIKE', "%$keyword%");
                }                                                  // sehingga filter lainnya bisa dipakai!
            });
        }
        return $this;
    }

    /**
     * Set offset terhadap pagination.
     *
     * @param int $offset offset pagination
     * @return $this
     */
    public function setPaginationOffset($offset = 0)
    {
        $this->pagination['offset'] = $offset;
        return $this;
    }

    /**
     * Set pagination limit = ukuran record per halamannya
     * @param int $limit
     * @return $this
     */
    public function setPaginationLimit($limit = 25)
    {
        $this->pagination['limit'] = $limit;
        return $this;
    }

    /**
     * Set nilai sorting
     * @param string $sort nama field yang akan di sorting
     * @param string $order
     * @return $this
     */
    public function setSortBy($sort, $order = 'asc')
    {
        if(strlen($sort)>0)
        {
            $this->db = $this->db->orderBy($this->attachTableToThisField($sort), $order);
        }
        return $this;
    }

    /**
     * Lakukan proses pengambilan data
     * @return array
     */
    public function getData(array $fields=['*'])
    {
        $this->dbCount = $this->db->count();

        $q = $this->db
            ->skip($this->pagination['offset'])
            ->take($this->pagination['limit']);
//        \Log::debug($q->toSql());
        return $q->get($fields);
    }

    /**
     * Kadangkala ada tambahan query, maka tambahkan disini untuk selain paramater bagi paginationnya.
     * $function akan dipanggil oleh util dengna parameter adalah query yang akan dijalankan
     * @param $function
     * @return $this
     */
    public function processAnotherQuery($function)
    {
        if(is_callable($function))
        {
            $function($this->db);
        }
        return $this;
    }
}