<?php
/**
 * Handle ajax
 * User: toni
 * Date: 05/04/16
 * Time: 13:44
 */

namespace Panatau\Tools;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait FileAttachmentAjaxTrait
{

    /**
     * Lakukan pemrosesan terhadap proses upload. Fungsi ini membutuhkan variable yang di set pada
     * controller yang menggunakannya:
     * id: id dari model \____ ini merupakan implementasi polymorphisme
     * owner: nama model /
     * $fileAttachment: ini harus string namespace dan nama model lengkap, contoh App/FileAttachment
     * Fungsi ini harus mampu untuk melaukan pemrosesan terhadap upload untuk multiple files.
     */
    protected function uploadAttachment(Model $modelOwner, $fileAttachment, $root_path, $files, &$response)
    {
        $success = true;
        $throwStr = '';
        /** @var Model $ownerObj */
        $ownerObj = $modelOwner;

        $fileUploaded = 0;
        $fileCount = count($files);
        // secara default trait ini tidak melakukan proses validasi, harus si pemanggil yang melakukannya.
        // check jumlah yang di upload
        if($fileCount>0)
        {
            $droot_path = FileUtil::removeLastDirectorySeparator($root_path);
            // looping di kesemua file
            foreach($files as $f)
            {
                /** @var UploadedFile $file */
                $file = $f;
                $c = Carbon::now();
                $purefilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // format folderpath : 2015/12/12/101234
                $folderPath =implode("/", // gabungkan lagi untuk menjadi alamat path lengkap
                    explode("-", // sekarang pisahkan berdasarkan karakter "-" hasil slug
                        Str::slug($c->format('Y-m-d')))); // dapatkan dulu nilai waktu saat ini dibuat
                $fileName = sprintf("%s-%s.%s", Str::slug($c->toTimeString()),
                    Str::slug($purefilename),
                    $file->getClientOriginalExtension());
                try
                {
                    $flrec = new $fileAttachment;
                    $flrec->client_file_name = $file->getClientOriginalName();
                    $flrec->file_name = $fileName;
                    $flrec->folder = $folderPath;
                    // simpan lewat polymorphic
                    $ownerObj->attachments()->save($flrec);

                    // create recursive directory
                    $directory = $folderPath .'/';
//                    \File::makeDirectory($directory, 0755, true);
                    FileUtil::makeRecursiveDirectory($droot_path, $directory, 0755);
                    // move our file ...
                    $file->move("$droot_path/$directory", $fileName);
                    //
                    $fileUploaded++;
                }
                catch(\Exception $e)
                {
                    \Log::emergency("Gagal Upload File ".$fileName."\n".$e->getMessage()."\n". $e->getTraceAsString());
                    $throwStr = $e->getMessage();
                    $success=false;
                }
                // tidak usah memproses yang lain bila sudah bermasalah!
                if(!$success) break;
            }
        }
        // generate data hasil ...
        $response = [
            'file_count' => $fileCount,
            'file_uploaded' => $fileUploaded,
            'is_success' => $success,
            'throw_str' => $throwStr
        ];
        return $success;
    }
}