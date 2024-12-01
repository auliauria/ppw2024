<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'id' => "posts",
            'menu' => "Gallery",
            'galleries' => Post::where('picture', '!=',
            '')->whereNotNull('picture')->orderBy('created_at', 'desc')->paginate(30)
        );
        return view('gallery.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);
        if ($request->hasFile('picture')) {
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid().time();
            $smallFilename = "small_{$basename}.{$extension}";
            $mediumFilename = "medium_{$basename}.{$extension}";
            $largeFilename = "large_{$basename}.{$extension}";
            $filenameSimpan ="{$basename}.{$extension}";
            $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);
        } else{
            $filenameSimpan = 'noimage.png';
        }
        //dd($request->input());
        $post = new Post;
        $post->picture = $filenameSimpan;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->save();
        return redirect('gallery')->with('success', 'Berhasil menambahkan data baru');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $gallery = Post::findOrFail($id);
        return view('gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);

        $post = Post::findOrFail($id);
        $post->title = $request->input('title');
        $post->description = $request->input('description');

        if ($request->hasFile('picture')) {
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid().time();
            $filenameSimpan = "{$basename}.{$extension}";
            $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);

            // Delete old image if exists
            if ($post->picture && $post->picture != 'noimage.png') {
                Storage::delete('public/posts_image/'.$post->picture);
            }

            $post->picture = $filenameSimpan;
        }

        $post->save();

        return redirect('gallery')->with('success', 'Image updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Delete the image from storage
        if ($post->picture && $post->picture != 'noimage.png') {
            Storage::delete('public/posts_image/'.$post->picture);
        }

        $post->delete();

        return redirect('gallery')->with('success', 'Image deleted successfully.');
    }

    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *     path="/api/gallery",
     *     tags={"gallery"},
     *     summary="Returns a Sample API gallery response",
     *     description="A sample gallery to test out the API",
     *     operationId="gallery",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent
     *           (example={
     *               "success": true,
     *               "message": "Berhasil memproses galleries",
     *               "galleries": {
     *                  {
     *                      "id": 1,
     *                      "title": "gallery bell",
     *                      "description": "deskripsi gallery bell",
     *                      "picture": "bell.jpeg",
     *                      "created_at": "2024-11-06T02:20:42.000000Z",
     *                      "updated_at": "2024-11-06T02:20:42.000000Z"
     *                  }
     *              }
     *          }),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data tidak ditemukan",
     *         @OA\JsonContent
     *           (example={
     *               "detail": "strings"
     *          }),
     *     )
     * )
     */
    public function gallery()
    {
        $data = array(
            'message' => 'Berhasil memproses galleries',
            'success' => true,
            'galleries' => Post::where('picture', '!=', '')->whereNotNull('picture')->orderBy('created_at', 'desc')->get()
        );
        return response()->json($data);
    }
}
