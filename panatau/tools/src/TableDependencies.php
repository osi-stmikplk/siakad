<?php namespace Panatau\Tools;
/**
 * Lakukan proses pengecekan terhadap dependency table di table ini, serta lakukan proses penghapusan record berkaitan
 * dengan table ini.
 * if(TableDependencies::isDependantWith(['cpns'=>'NIP', 'pns'=>'NIP'], ['NIP'=>'2222222222'])) $this->doNotDestroy();
 * User: toni
 * Date: 19/06/15
 * Time: 10:08
 */

class TableDependencies {

    /**
     * Check bila ada data berkaitan dengan yang di berikan oleh $valueToCheck
     * @param array $tableField array associative dengan key merupakan nama table dan value merupakan field yang diperiksa
     * @param array $valueToCheck array associative dengan key merupakan nama field sumber dan value yang harus di check!
     * @return bool
     */
    public static function isDependantWith(array $tableField, array $valueToCheck)
    {
        $query = []; // query yang dilakukan
        $where = []; // where di masing-masing query
        $offset = 0;
        // dapatkan nilai $where
        foreach($valueToCheck as $field=>$value)
        {
            $where[] = [$field, $value];
        }

        // lakukan proses generate query yang akan di union
        foreach ($tableField as $table => $field) {
            $query[$offset] = \DB::table($table);
            for($i=0;$i<count($where);$i++)
            {
                // set where
                $query[$offset]->where($where[$i][0], '=', $where[$i][1]);
            }
            // set select
            $query[$offset]->select(\DB::raw("COUNT($field) as cnt, '$table'"));
            $offset++;
        }

        // sekarang union kan
        for($i=1;$i<$offset;$i++)
        {
            // union dilakukan diantara semua query
            $query[$i-1]->union($query[$i]);
        }
        // dapatkan hasilnya
        $res = $query[0]->get();
        $resCnt = count($res); // hitung jumlah record
        $sum = 0; // untuk menghitung jumlah record hasil query masing-masing table yang di check
        for($i=0;$i<$resCnt;$i++)
        {
            $sum += (int) $res[$i]->cnt; // dapatkan jumlah table
        }
        return $sum > 0;
    }
}