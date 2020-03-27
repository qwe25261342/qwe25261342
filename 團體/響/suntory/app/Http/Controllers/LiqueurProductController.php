<?php

namespace App\Http\Controllers;

use App\Liqueur;
use App\LiqueurProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LiqueurProductController extends Controller
{
    public function index()
    {
        $data = LiqueurProduct::all();
        return view('auth.liqueur_product.index', compact('data'));
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $ready = LiqueurProduct::create($data);
        $data = LiqueurProduct::with('liqueur')->where('id', $ready->id)->first();
        return $data;
    }
    public function edit($id)
    {
        $data = LiqueurProduct::find($id);
        return $data;
    }
    public function update(Request $request, $id)
    {
        $new = $request->all();
        $data = LiqueurProduct::with('liqueur')->find($id);
        $data->update($new);

        return $data;
    }
    public function destroy($id)
    {
        $data = LiqueurProduct::find($id);
        $data->delete();
        return 'successful';
    }
    public function liqueurProduct_upload_img()
    {
        // A list of permitted file extensions
        $allowed = array('png', 'jpg', 'gif','zip');
        if(isset($_FILES['file']) && $_FILES['file']['error'] == 0){
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            if(!in_array(strtolower($extension), $allowed)){
                echo '{"status":"error"}';
                exit;
            }
            $name = strval(time().md5(rand(100, 200)));
            $ext = explode('.', $_FILES['file']['name']);
            $filename = $name . '.' . $ext[count($ext)-1];
            //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
            if( ! is_dir('upload/')){
                mkdir('upload/');
            }
            //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
            if ( ! is_dir('upload/ProductImg')) {
                mkdir('upload/ProductImg');
            }
            $destination = public_path().'/upload/ProductImg/'. $filename; //change this directory
            $location = $_FILES["file"]["tmp_name"];
            move_uploaded_file($location, $destination);
            echo "/upload/ProductImg/".$filename;//change this URL
        }
        exit;
    }

    public function liqueurProduct_delete_img(Request $request)
    {
        if(file_exists(public_path().$request->file_link)){
            File::delete(public_path().$request->file_link);
        }
        return $request;
    }

    public function liqueurProduct_kind()
    {
        $data = Liqueur::all();
        return $data;
    }

    public function liqueurProduct_text()
    {
        $data = LiqueurProduct::with('liqueur')->get();
        return $data;
    }
}
