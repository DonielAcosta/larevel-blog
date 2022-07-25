<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

   /**
    * The index function returns a view of all the posts in the database
    * 
    * @return A view called posts.index with a variable called posts.
    */
    public function index()
    {
        $posts = Post::latest()->get();

        return view('posts.index', compact('posts'));
    }

 
  /**
   * The create() function returns the view posts.create
   * 
   * @return The view posts.create
   */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * It creates a new post and stores it in the database.
     * 
     * @param PostRequest request The incoming request.
     */
    public function store(PostRequest $request)
    {
      //salvar
      // dd($request->all());
      $post = Post::create([
        'user_id' => auth()->user()->id
      ] + $request->all());

      //image

      if ($request->file('file')){
        $post->image = $request->file('file')->store('posts','public');
        $post->save();
      }
      //retornar

      return back()->with('status','Creado con Exito');
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
      return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->all());

        if ($request->file('file')){
          //eliminar imagen
          Storage::disk('public')->delete($post->image);
          $post->image = $request->file('file')->store('posts','public');
          $post->save();
        }

        return back()->with('status','Actualizado con Exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        Storage::disk("public")->delete((string) $post->image);
        $post->delete();

        return back()->with('status', 'Eliminado con éxito');
    }
}