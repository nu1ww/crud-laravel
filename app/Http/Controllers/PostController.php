<?php

namespace App\Http\Controllers;

use App\Events\SendEmailEvent;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Post;
use App\User;
use Illuminate\Http\Request;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @return string
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index()
    {
        //
        $users=User::all();

        $data=Post::all();

        return view('post.index')->with('posts',$data);
        //return 'ok';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('post.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('posts/create')
                ->withErrors($validator)
                ->withInput();
        }
        Post::create(['title'=>request('title'),'body'=>request('body')]);
        event(new SendEmailEvent(['title'=>request('title'),'body'=>request('body')]));
        return redirect('posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=Post::find($id);
        return view('post.edit')->with('data',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return 'ok';
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);
//form validation
        if ($validator->fails()) {
            return redirect()
                ->route('posts.show',$id)
                ->withErrors($validator)
                ->withInput();
        }

      $post= Post::find($id);
      $post->title=request('title');
      $post->body=request('body');
      $post->save();
      //Set flash massage
      Session::flash('danger', 'Post was successful!');
      return redirect()->route('posts.show',$post->id);
       // session('')
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
    }
}
