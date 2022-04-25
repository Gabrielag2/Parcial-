<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(isset($_GET['s'])&&$_GET['s']!=''){
            $products=Product::get_ll()->where('name','like','%'.$_GET['s'].'%')->paginate(2);
        }else{
            $products=Product::get_ll()->paginate(2);
        }
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories=Category::all();
        $data['categories']=$categories;
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validasi=$request->validate([
            'codigo'=>'required',
            'nombre'=>'required',
            'descripcion'=>'',
            'category_id'=>'required',
            'precio'=>'required',
            'imagen' => 'required|file|mimes:png,jpg'
            
        ]);
        $validasi['status']='Y';
        try{
            $fileName = time().$request->file('imagen')->getClientOriginalName();
            $path = $request->file('imagen')->storeAs('covers',$fileName);
            $validasi['imagen']=$path;
            $response = Product::create($validasi);
            return response()->json([
                'success' => true,
                'message'=>'success',
                'id'=>$response->id
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'message'=>'Err',
                'errors'=>array(
                    'file'=>[$e->getMessage()]
                )
                ],422);
        }
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
        $product = Product::where('product_id',$id)->first();
        return response()->json($product);
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
        $validasi=$request->validate([
            'codigo'=>'required',
            'nombre'=>'required',
            'descripcion'=>'',
            'category_id'=>'required',
            'precio'=>'required',
            'imagen' => 'required|file|mimes:png,jpg'
           
        ]);
        $validasi['status']='Y';
        try{
            $fileName = time().$request->file('imagen')->getClientOriginalName();
            $path = $request->file('imagen')->storeAs('covers',$fileName);
            $validasi['imagen']=$path;
            $response = Product::find($id);
            $response->update($validasi);
            return response()->json([
                'success' => true,
                'message'=>'success',
                'id'=>$response->id
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'message'=>'Err',
                'errors'=>array(
                    'file'=>[$e->getMessage()]
                )
                ],422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $product = Product::find($id);
        $product->delete();
        $msg = [
            'success' => true,
            'message' => 'Article deleted successfully!',
            'id'=>$product->id
        ];
        return response()->json($msg);
    }
}
