<?php

namespace App\Http\Controllers;

use App\Repository\PostRepositoryInterface;
use App\Transcode\Transcode;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{

    public $dropzone;

    public function __construct()
    {
        $this->dropzone = app('App\Http\Controllers\DropzoneController');
    }

    /**
     * Display a listing of the resource.
     *
     * @param PostRepositoryInterface $postRepository
     * @return void
     */
    public function index(PostRepositoryInterface $postRepository)
    {
        $posts = $postRepository->all(request()
            ->only(['word'])
        );
        return view('admin.blog.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param PostRepositoryInterface $postRepository
     * @return void
     */
    public function store(Request $request, PostRepositoryInterface $postRepository)
    {

        $this->validate($request, [
            'title'     => 'required',
            'content'   => 'required',
        ]);

        $img_path = null;
        if($request->has('coverImageName')){
            $extension = pathinfo($request->coverImageName, PATHINFO_EXTENSION);
            $img_path = 'public/blog/cover/'.md5($request->coverImageName).rand(10000, 99999).'.'.$extension;
            $this->dropzone->upload($request->coverImageName, storage_path('app/'.$img_path));
        }

        $post_id = $postRepository->save(
            array_merge($request->only(['title', 'prepared_by', 'published_by', 'content', 'vimeo_id', 'linkedin']), ['cover' => $img_path])
        );

        $postRepository->setPostSections($post_id, $request->input(['sections']));

        Transcode::add(\App\Post::find($post_id), [
            'title' => $request->title_ar,
            'prepared_by'   => $request->prepared_by_ar,
            'published_by'  => $request->published_by_ar,
            'content'   => $request->content_ar,
        ]);

        return response()->json([
            'post_id'   => $post_id
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param PostRepositoryInterface $postRepository
     * @return void
     */
    public function show($id, PostRepositoryInterface $postRepository)
    {
        $post = $postRepository->find($id)->first();
        $postTranscodes = Transcode::evaluate(\App\Post::find($id), 1);
        $post->title_ar = $postTranscodes['title'];
        $post->content_ar = $postTranscodes['content'];
        $post->prepared_by_ar = $postTranscodes['prepared_by'];
        $post->published_by_ar = $postTranscodes['published_by'];


        return response()->json($post, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        return view('admin.blog.edit')->with('post_id', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @param PostRepositoryInterface $postRepository
     * @return void
     */
    public function update(Request $request, $id, PostRepositoryInterface $postRepository)
    {
        $this->validate($request, [
            'title'     => 'required',
            'content'   => 'required',
        ]);

        if($request->has('coverImageName')){
            $extension = pathinfo($request->coverImageName, PATHINFO_EXTENSION);
            $img_path = 'public/blog/cover/'.md5($request->coverImageName).rand(10000, 99999).'.'.$extension;
            $this->dropzone->upload($request->coverImageName, storage_path('app/'.$img_path));
            $data = array_merge($request->only(['title', 'prepared_by', 'published_by', 'content', 'vimeo_id', 'linkedin']), ['cover' => $img_path]);
        }else{
            $data = $request->only(['title', 'prepared_by', 'published_by', 'content', 'vimeo_id', 'linkedin']);
        }

        $postRepository->update($id, $data);
        $postRepository->setPostSections($id, $request->input(['sections']) ?? []);

        Transcode::update(\App\Post::find($id), [
            'title' => $request->title_ar,
            'content'   => $request->content_ar,
            'prepared_by'   => $request->prepared_by_ar,
            'published_by'  => $request->published_by_ar,
        ]);

        return response()->json(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param PostRepositoryInterface $postRepository
     * @return void
     */
    public function destroy($id, PostRepositoryInterface $postRepository)
    {
        $postRepository->delete($id);
        return back()->with('success', 'Post Has been Deleted');
    }

}
