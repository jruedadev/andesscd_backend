<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

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
        $custom_validation = (base64_decode($request->banner, true) || preg_match("/^(((https|http)?:\/\/)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(\/.*)?$/", $request->banner) >= 1);
        if (!$custom_validation) {
            return $this->sendError("The Banner field must be a Base64 Encoded Image or external URL.");
        }
        if (base64_decode($request->banner, true)) {
        }

        $blog = new Post();
        $blog->fill($request->all());
        $blog->save();

        return $this->sendResponse($blog, "Success");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $blog)
    {
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
    public function update(Post $blog, Request $request)
    {
        dd($request->all());
        if (isset($request->banner)) {
            $custom_validation = (base64_decode($request->banner, true) || preg_match("/^(((https|http)?:\/\/)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(\/.*)?$/", $request->banner) >= 1);
            if (!$custom_validation) {
                return $this->sendError("The Banner field must be a Base64 Encoded Image or external URL.");
            }
            if (base64_decode($request->banner, true)) {
                dd($request->banner);
            }
        }


        $blog->fill($request->all());
        $blog->save();

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
