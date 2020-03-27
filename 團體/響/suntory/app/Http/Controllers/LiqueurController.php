<?php

namespace App\Http\Controllers;

use App\Liqueur;
use App\LiqueurImg;
use Dotenv\Regex\Success;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class LiqueurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Liqueur::all();
        return View('auth.liqueur.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('auth.liqueur.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        //酒類名稱建立
        $liqueur = new Liqueur();
        $liqueur->name =$data['name'];
        $liqueur->save();
        //圖片建立ID
        $imgs = $data['imgs'];
        foreach($imgs as $img){
            $liqueur_img = LiqueurImg::where('id',$img)->first();
            $liqueur_img->liqueurs_id = $liqueur->id;
            $liqueur_img->save();
        }
        return $liqueur->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $imgs = Liqueurs_img::where('liqueurs_id',$id)->get();
        foreach($imgs as $img){
            $img->delete();
        }
        $data = Liqueur::find($id);
        $data->delete();

        return redirect('/admin/liqueur');
    }

    public function liqueur_upload_img()
    {
        // A list of permitted file extensions
        $allowed = array('png', 'jpg', 'gif', 'zip');
        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            if (!in_array(strtolower($extension), $allowed)) {
                echo '{"status":"error"}';
                exit;
            }
            $name = strval(time() . md5(rand(100, 200)));
            $ext = explode('.', $_FILES['file']['name']);
            $filename = $name . '.' . $ext[1];
            //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
            if (!is_dir('upload/')) {
                mkdir('upload/');
            }
            //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
            if (!is_dir('upload/img')) {
                mkdir('upload/img');
            }
            $destination = public_path() . '/upload/img/' . $filename; //change this directory
            $location = $_FILES["file"]["tmp_name"];
            move_uploaded_file($location, $destination);
            $img="/upload/img/" . $filename;
            $liqueur_img = new Liqueurs_img();

            $liqueur_img->img = $img;
            $liqueur_img->save();
            $id = $liqueur_img->id;
            $new_ary = [
                'id' => $liqueur_img->id,
                'img' => $img
            ];
            return $new_ary; //change this URL

        }
        exit;
    }
    public function liqueur_delete_img(Request $request)
    {
        $id = $request->id;
        $data = Liqueurs_img::where('id', $id)->first();
        $old_image = $data->img;
        if (file_exists(public_path() . $old_image)) {
            File::delete(public_path() . $old_image);
        }
        $data->delete();
        return 'successful';

    }
}
