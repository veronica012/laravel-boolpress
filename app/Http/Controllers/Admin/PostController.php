<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;
use Illuminate\Support\Str;
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
        // $posts = Post::all();
        //riduciamo le query
        $posts = Post::with('category', 'tags')->get();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //leggo le categorie dal db e le passo alla view in compact
        $categories = Category::all();

        $tags = Tag::all();
        $data = [
            'categories' => $categories,
            'tags' => $tags

        ];
        return view('admin.posts.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        //validazione
        $request->validate([
           'title' => 'required|max:255|unique:posts,title',
           'content' => 'required',
           'image' => 'image|max:1024'
       ]);
       $dati = $request->all();
       //generazione dello slug dal titolo
       $slug = Str::of($dati['title'])->slug('-');
       $original_slug = $slug;
       //verifico se lo slug esiste già nella tabella ('slug' nome colonna $slug valore)
       $post_exists = Post::where('slug', $slug)->first(); //get = collection di oggetti, first = un oggetto
       // dd($post_exists);
       $contatore = 0;
       while($post_exists) {
           $contatore++;
           $slug = $original_slug . '-' . $contatore;
           $post_exists = Post::where('slug', $slug)->first();
       } //in questo modo lo slug sarà unico
       $dati['slug'] = $slug;

       //caricamento immagine
       //verificare se l'immagine esiste
       if($dati['image']) {
           $img_path =  Storage::put('uploads', $dati['image']);
           // dd($img_path);
           $dati['cover_image'] = $img_path;
       }
       //alternativa image required e non serve la if
       //salvo i dati
       $nuovo_post = new Post();
       $nuovo_post->fill($dati);
       $nuovo_post->save();
//se sono stati selezionati dei tag li associo al post
       if(!empty($dati['tags'])) {

           $nuovo_post->tags()->sync($dati['tags']);
       }

       return redirect()->route('admin.posts.index');
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

       if($post) {
           return view('admin.posts.show', compact('post'));
       } else {
           return abort('404');
       }
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

        if($post) {
            $categories = Category::all();
            $tags = Tag::all();
            //non si può più usare compact quindi:
            $data = [
                'post' => $post,
                'categories' => $categories,
                'tags' => $tags

            ];
            return view('admin.posts.edit', $data);
        } else {
            return abort('404');
        }
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
        $request->validate([
            'title' => 'required|max:255|unique:posts,title,'.$id,
            'content' => 'required',
            'image' => 'image|max:1024'
        ]);
        $dati = $request->all();
        $slug = Str::of($dati['title'])->slug('-');
        $dati['slug'] = $slug;
        $original_slug = $slug;
        //verifico se lo slug esiste già nella tabella 'slug' nome colonna $slug valore
        $post_exists = Post::where('slug', $slug)->first(); //get = collection di oggetti, first = un oggetto
        // dd($post_exists);
        $contatore = 0;
        while($post_exists) {
            $contatore++;
            $slug = $original_slug . '-' . $contatore;
            $post_exists = Post::where('slug', $slug)->first();
        }
        //in questo modo lo slug sarà unico
        $dati['slug'] = $slug;

        // verifico se l'utente ha caricato una foto
        if($dati['image']) {
            // carico l'immagine
            $img_path = Storage::put('uploads', $dati['image']);
            $dati['cover_image'] = $img_path;
        }
        
        $post = Post::find($id);
        $post->update($dati);
        if(!empty($dati['tags'])){

            $post->tags()->sync($dati['tags']);
        } else {

            $post->tags()->sync([]);
        }

        return redirect()->route('admin.posts.index');
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
        if($post) {

            $post->delete();
            return redirect()->route('admin.posts.index');

        } else {
            return abort('404');
        }
    }
}
