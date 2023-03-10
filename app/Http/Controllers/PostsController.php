<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::paginate();
        return $this->sendResponse($posts, "Success");
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
    public function store(CreatePostRequest $request)
    {
        $base64_file = base64_decode(preg_replace("/data:image\/jpeg;base64,/", "", $request->banner), true);
        $custom_validation = ($base64_file || preg_match("/^(((https|http)?:\/\/)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(\/.*)?$/", $request->banner) >= 1);
        if (!$custom_validation) {
            return $this->sendError("The Banner field must be a Base64 Encoded Image or external URL.");
        }

        $blog = new Post();
        $blog->fill($request->all());
        $blog->save();

        if ($base64_file) {
            $name = 'jruedadev_andesscd/post_' . $blog->id;
            Storage::disk('s3')->put($name, $base64_file);
            $blog->banner = Storage::disk('s3')->url($name);
        }

        return $this->sendResponse($blog, "Success");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($blog)
    {
        $blog = Post::with('author')->findOrFail($blog);
        return $this->sendResponse($blog, "Success");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $blog)
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
    public function update($blog, Request $request)
    {
        $base64_file = false;
        $blog = Post::with('author')->findOrFail($blog);
        if (isset($request->banner)) {
            $base64_file = base64_decode(preg_replace("/data:image\/jpeg;base64,/", "", $request->banner), true);
            $custom_validation = ($base64_file || preg_match("/^(((https|http)?:\/\/)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(\/.*)?$/", $request->banner) >= 1);
            if (!$custom_validation) {
                return $this->sendError("The Banner field must be a Base64 Encoded Image or external URL.", ['banner' => "The Banner field must be a Base64 Encoded Image or external URL."], 200);
            }
        }

        $blog->fill($request->all());

        if ($base64_file) {
            $name = 'jruedadev_andesscd/post_' . $blog->id . '.jpg';
            Storage::disk('s3')->put($name, $base64_file);
            $blog->fill(['banner' => Storage::disk('s3')->url($name)]);
        }
        $blog->save();
        $blog->load('author');

        return $this->sendResponse($blog, "Success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $blog)
    {
        $blog->delete();
        $this->sendResponse(['deleted' => true], "Post deleted Successfully");
    }
}
