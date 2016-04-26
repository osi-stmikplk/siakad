<?php namespace Panatau\Tools;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Simple file upload util untuk JDIH
 * User: toni
 * Date: 04/12/14
 * Time: 22:39
 */

class FileUtil {

    /**
     * Lakukan proses pembuatan directory secara recursive, tapi agar menghindari error directory telah ada / exists
     * maka check untuk masing-masing directory dari $root sampai $path terakhir.
     * Misal root ada di ~/ dan path ada di attachments/a/b/c/foo/bar
     * @param $root
     * @param $path
     * @param $mode
     */
    public static function makeRecursiveDirectory($root, $path, $mode)
    {
        // check satu-satu lalu buat directory bila ada yang belum terbuat
        $pathAry = explode('/', $path);
        $cnt = count($pathAry);
//        \Log::debug("Nilai path $path hasil cnt:$cnt");
        $i = -1;
        $tested = $root;
        while(++$i<$cnt)
        {
            $tested .= '/' .$pathAry[$i];
            if(File::isDirectory($tested))
            {
                // bila sudah dibuat maka lanjutkan ke folder didalamnya lagi
                continue;
            }
            // bila tidak berarti folder berikutnya memang belum ada, maka buat directory dengna mode recursive!
            for($j=$i+1;$j<$cnt;$j++)
            {
                $tested .= '/' .$pathAry[$j];
            }
            File::makeDirectory($tested, $mode, true);
            break;
        }
    }

    /**
     * Generate path berdasarkan tanggal dan waktu. Hasilnya berupa folder dengna format tahun/bulan/tgl/waktu
     * @return string path
     */
    public static function generatePathBasedOnDateTime(Carbon $datetime=null)
    {
        $c = $datetime==null? Carbon::now(): $datetime;
        $folderPath = implode("/", // gabungkan lagi untuk menjadi alamat path lengkap
            explode("-", // sekarang pisahkan berdasarkan karakter "-" hasil slug
                Str::slug($c->toDateTimeString()))); // dapatkan dulu nilai waktu saat ini dibuat
        return $folderPath;
    }

    /**
     * Hilangkan directory separator dari karakter terakhir di directory
     * @param $path
     * @return string
     */
    public static function removeLastDirectorySeparator($path)
    {
        if(Str::endsWith($path, "/"))
        {
            return Str::substr($path,0, Str::length($path)-1);
        }
        return $path;
    }
} 