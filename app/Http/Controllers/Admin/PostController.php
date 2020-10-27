<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Post;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = Post::where('user_id',Auth::id())->first();
        //dd(Auth::user()->role_id);
        if (Auth::user()->role_id==2) { //se l'utente è super mostro tutto
            $posts = Post::all();
        } elseif (Auth::user()->role_id==1) { //Altrimenti gli mostro solo i suoi
            $posts = Post::where('user_id',Auth::id())->orderBy('created_at','desc')->paginate(5);
        }
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();

        return view('admin.posts.create',compact('tags'));
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
        $request->validate([
            'title'=>'required|min:5|max:100',
            'body'=>'required|min:5|max:500',
            'img'=>'image'
        ]);
        $data['user_id'] = Auth::id();
        $data['slug']=Str::slug($data['title'],'-');

        $newPost = new Post();

        if(!empty($data['img'])) {
            $data['img'] = Storage::disk('public')->put('images',$data['img']);
        }

        $newPost->fill($data);

        $saved = $newPost->save();

        if(!empty($data['tags'])) {
        $newPost->tags()->attach($data['tags']);
        }

        // dd($saved);
        if($saved){
            return redirect()->route('posts.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = Tag::all();
        //dd($post);
        return view('admin.posts.edit',compact('post','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //dd($request->all());
        //dd($post->user_id);
        $data = $request->all(); //array di dati
        $data['slug'] = Str::slug($data['title'],'-');
        $data['update_at'] = Carbon::now('Europe/Rome');

        if(!empty($data['tags'])) {
            $post->tags()->sync($data['tags']);
        } else {
            $post->tags()->detach();
        }

        if(!empty($data['img'])) {
            //Cancella immaggine precedente
            if(!empty($post->img)) {
                Storage::disk('public')->delete($post->img);
            }
            $data['img'] = Storage::disk('public')->put('images',$data['img']);
        }

        $updated = $post->update($data); //istruzione update sql
        if($updated) {
            return redirect()->route('posts.index')->with('status','Hai modificato correttamente il post');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('status','Hai cancellato correttamente il post');
    }
}
