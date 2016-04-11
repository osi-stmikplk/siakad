<?php
/**
 * Controller untk mengatur User!
 * User: toni
 * Date: 11/04/16
 * Time: 18:45
 */

namespace Stmik\Http\Controllers;


use Stmik\Factories\UserFactory;
use Stmik\Http\Requests\SetUserRequest;

class UserController extends Controller
{

    /** @var UserFactory  */
    protected $factory;
    public function __construct(UserFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Kembalikan form untuk melakukan setting user berdasarkan $typeOrangNya.
     * Form ini akan di render oleh sebuah modal
     * @param $idOrangIni
     * @param $typeOrangNya
     */
    public function setUserUntuk($idOrangIni, $typeOrangNya)
    {
        $modelObj = $this->factory->getModelDari($typeOrangNya, $idOrangIni);
        if($modelObj!==null) {
            return view('user.set')
                ->with("typeOrangNya", $typeOrangNya)
                ->with("idOrangIni", $idOrangIni)
                ->with('action', route('user.postSetUserUntuk', ['idOrangIni'=>$idOrangIni, 'typeOrangNya'=>$typeOrangNya]))
                ->with('data', $modelObj->user);
        }
        return response()->json(['system'=>"Nilai parameter tidak dikenali"], 422);
    }

    /**
     * Simpan hasil setting ...
     * @param $idOrangIni
     * @param $typeOrangNya
     * @param SetUserRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function postSetUserUntuk($idOrangIni, $typeOrangNya, SetUserRequest $request)
    {
        if(($modelObj = $this->factory->getModelDari($typeOrangNya, $idOrangIni)) !== null) {
            $input = $request->except($this->getIntercoolerParams());
            // test untuk kewajiban password, bila ini pencatatan baru harus ada password!
            if($modelObj->user === null && !isset($input['password'][0])) {
                return response()->json(['password'=>["User baru password wajib"]], 422);
            }
            if($this->factory->setUserIni($modelObj, $input)) {
                // di sini kita tidak perlu menampilkan hal yang terlalu advanced, berikan saja pesan bahwa user telah
                // tersimpan atau telah di set!
                return response("<p class='alert alert-success'>Data Login User telah tersimpan!</p>");
            } else {
                response()->json($this->factory->getErrors(), 500);
            }
        }
        return response()->json(['system'=>"Nilai parameter tidak dikenali"], 422);
    }

}