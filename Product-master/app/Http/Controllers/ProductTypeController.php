<?php

namespace App\Http\Controllers;

use App\ProductTypes;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = ProductTypes::all();
        return view('ProductType/index', compact('type'));

    }


    public function create()
    {
        return view('ProductType/create');
    }


    public function store(Request $request)
    {
        $products= $request->all();
        ProductTypes::create ($products)->save();
        return redirect('/home/product_type');
    }



    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function delete(Request $request, $id)
    {
        $item =  ProductTypes::find($id);

        $item->delete();

        return redirect('/home/product_type');
    }
}
