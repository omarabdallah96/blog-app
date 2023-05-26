<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetPostRequest;
use App\Http\Resources\BlogPostResource;
use App\Models\BlogPost;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $postWithAuthors = BlogPost::with('author')->paginate(10);





        // $postWithAuthors =  $postWithAuthors->getCollection()->transform(function ($user) {
        //     unset($user->author_id);
        //     $user->author_name = $user->author->name;
        //     $user->featured_image = asset('storage/' . $user->featured_image);
        //     unset($user->author);
        //     return $user;
        // });

        return BlogPostResource::collection($this->format($postWithAuthors));
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

        //find or return json


        $post = BlogPost::with('author')->find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post not found',
                'success' => false,
                'data' => null

            ], 404);
        }
        return response()->json([
            'message' => ' Post found',
            'success' => true,
            'data' => new BlogPostResource($this->format($post))

        ], 200);
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

    public function format($data)
    {
        if ($data instanceof Paginator) {
            $format = $data->getCollection()->transform(function ($item) {
                return $this->transformItem($item);
            });

            $data->setCollection($format);

            return $data;
        } else {
            return $this->transformItem($data);
        }
    }

    private function transformItem($item)
    {
        unset($item->author_id);
        $item->author_name = $item->author->name;
        $item->featured_image = asset('storage/' . $item->featured_image);
        unset($item->author);
        return $item;
    }
}
