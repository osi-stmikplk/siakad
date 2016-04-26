<?php
/**
 * Buat untuk file attachment dan ini di attach di controller penggunanya.
 * User: toni
 * Date: 17/09/15
 * Time: 18:37
 */

namespace Panatau\Tools;


use Carbon\Carbon;
use Eh\FileAttachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait FileAttachmentTrait
{

    /**
     * Lakukan pemrosesan terhadap proses upload. Fungsi ini membutuhkan variable yang di set pada
     * controller yang menggunakannya:
     * id: id dari model \____ ini merupakan implementasi polymorphisme
     * owner: nama model /
     * $fileAttachment: ini harus string namespace dan nama model lengkap, contoh App/FileAttachment
     * Fungsi ini harus mampu untuk melaukan pemrosesan terhadap upload untuk multiple files.
     */
    protected function uploadAttachment(Model $modelOwner, $fileAttachment, $root_path, $targetOwnerId, &$response)
    {
        $success = true;
        /** @var Model $ownerObj */
        $ownerObj = $modelOwner;

        $files = \Input::file('filea');
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
                $fileName = sprintf("%s-%s.%s", Str::slug($c->toDateTimeString()),
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
                    $success=false;
//                    return \Response::make("Gagal melakukan upload File :(", 422);
                }
            }
        }
        if(!property_exists($this, 'attachmentOwnerViewAfterUploaded'))
        {
            if($targetOwnerId=='')
            {
                $response=<<<JS
<script type="text/javascript">parent.trigger('afterUpload', [{$fileCount},{$fileUploaded}]);</script>
JS;
            }
            else
            {
            $response=<<<JS
<script type="text/javascript">parent.$('#{$targetOwnerId}').trigger('afterUpload', [{$fileCount},{$fileUploaded}]);</script>
JS;
            }
            return $success;
        }
        return $this->attachmentOwnerViewAfterUploaded();
    }

    /**
     * Action untuk menghapus attachment berdasarkan id
     * @param integer $id id milik attachment dan bukan si owner!
     */
    public function deleteAttachment($id)
    {
        $fl = FileAttachment::findOrFail($id);
        $target = $fl->targetURLPath( public_path() .'/'. \Config::get('$attach_upload_to'));
//        \Log::debug("Try to delete $target");
        try
        {
            if(\File::exists($target) && \File::isFile($target)) \File::delete($target);
        }
        catch(\Exception $e)
        {
            \Log::emergency('Error delete attachment: '.$e->getMessage()."\n".$e->getTraceAsString());
        }
        if($fl->delete())
        {
            \Session::flash('message', "Data id=$id berhasil dihapus");
            return \Response::json(['message'=>'Data telah berhasil dihapus!']);
        }
        else
        {
            \Session::flash('notice', "Data id=$id gagal dihapus");
            return \Response::json(['message'=>'Data gagal dihapus!']);
        }
    }
}