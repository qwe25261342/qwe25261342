<?php

namespace App\Http\Controllers;

use App\Liqueur;
use App\LiqueurStory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LiqueurStoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = LiqueurStory::all();
        return View('auth.liqueur_story.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $ready = LiqueurStory::create($data);
        $newdata = LiqueurStory::with('name')->find($ready->id);
        return $newdata;
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
        $data = LiqueurStory::find($id);
        return $data;
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
        $new = $request->all();
        $data = LiqueurStory::with('name')->find($id);
        $data->update($new);

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = LiqueurStory::find($id);
        $data->delete();
        return 'successful';
    }

    public function liqueurStory_upload_img()
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
            $filename = $name . '.' . $ext[1];
            //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
            if( ! is_dir('upload/')){
                mkdir('upload/');
            }
            //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
            if ( ! is_dir('upload/Storyimg')) {
                mkdir('upload/Storyimg');
            }
            $destination = public_path().'/upload/Storyimg/'. $filename; //change this directory
            $location = $_FILES["file"]["tmp_name"];
            move_uploaded_file($location, $destination);
            echo "/upload/Storyimg/".$filename;//change this URL
        }
        exit;
    }

    public function liqueurStory_delete_img(Request $request)
    {
        if(file_exists(public_path().$request->file_link)){
            File::delete(public_path().$request->file_link);
        }
        return $request;
    }

    public function liqueurStory_kind()
    {
        $data = Liqueur::all();
        return $data;
    }

    public function liqueurStory_text()
    {
        $data = LiqueurStory::with('name')->get();
        return $data;
    }
}
