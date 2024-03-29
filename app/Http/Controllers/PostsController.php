<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Storage;
use App\Post;
//use DB;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }
 
    public function index()
    {   
        $posts =Post::orderBy('id','desc')->paginate(3);

        
        // @can be used for search
        //    $posts =Post::orderBy('id','desc')->take(2)->get();
        // @can be used for search
        
        //$post = Post::all();
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }


    // public function search(Request $request)
    // {
    //     // $search = $request->get('search');
    //     // $posts = Post::find($post->body)->where('title','LIKE','%'.$search.'%')->paginate(5);
    //     // return view('posts.index',['posts' => $posts]);
    //     return $request->input('search');
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        //Handle File Upload

        if($request->hasFile('cover_image')){
            //Get File Name with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //Get just filename
            $fileName = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $fileNameToStore= $fileName.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
        } else{
            $fileNameToStore = 'noimage.jpg';
        }
        // Create Post
        $post = new Post;
        $post->title =$request->input('title');
        $post->body =$request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        //Check For correct user
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error','Unauthorized Access');
        }
        return view('posts.edit')->with('post', $post);
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
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);
        
        //Handle File Upload

        if($request->hasFile('cover_image')){
            //Get File Name with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //Get just filename
            $fileName = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $fileNameToStore= $fileName.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
        }

        // Create Post
        $post = Post::find($id);
        $post->title =$request->input('title');
        $post->body =$request->input('body');
        if($request->hasFile('cover_image')){
            $post->cover_image = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success', 'Post updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        //Check For correct user
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error','Unauthorized Access');
        }
        if($post->cover_image!= 'noimage.jpg'){
            //Delete Image
            Storage::delete('public/cover_images/'.$post->cover_image);
        }
        $post->delete();

        return redirect('/posts')->with('success', 'Post removed');

    }
}
