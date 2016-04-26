<?php
/**
 * Trait ini memiliki beberapa fungsi tambahan, misalnya untuk menghapus file yang di referensikan oleh record model
 * yang terpilih!
 * User: toni
 * Date: 21/11/15
 * Time: 21:53
 */

namespace Panatau\Tools;

trait FileAttachmentModelTrait
{
    /**
     * Hapus file yang direferensikan oleh record ini. Ingat untuk melakukan memanggil ini baru melakukan penghapusan
     * untuk record nya.
     * @param string $rootPath root tempat menampung file
     * @return bool
     */
    public function deleteFile($rootPath)
    {
        $rootPath = FileUtil::removeLastDirectorySeparator($rootPath).'/'; // :D
        $target = $this->targetURLPath( $rootPath );
        try
        {
            if(\File::exists($target) && \File::isFile($target)) \File::delete($target);
        }
        catch(\Exception $e)
        {
            \Log::emergency('Error delete attachment: '.$e->getMessage()."\n".$e->getTraceAsString());
            return false;
        }
        return true;
    }

    /**
     * Dapatkan url untuk file ini! Bila hanya '/' maka dijadikan sebagai target yang bisa diakses oleh browser.
     * Selain itu bisa juga digunakan public_path() bila ingin digunakan untuk melakukan proses penghapusan!
     * @param string $root lokasi relative dari public, ingat untuk mengakhiri dengan tanda '/'
     * @return string
     */
    public function targetURLPath($root='/')
    {
        // folder dan file_name adalah properties yang dimiliki oleh model! dan data terseimpan sebagai field!
        return "$root{$this->folder}/{$this->file_name}";
    }


}