<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Http\Resources\GalleryResource;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Gallerys = Gallery::all();
        if ($request->header('X-My-Response-Header') === 'json') {
            return response()->json($Gallerys);
        }

        return GalleryResource::collection($Gallerys);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'plan_id' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'uri' => 'required|string',
            'featured' => 'required|boolean',
            'published' => 'required|boolean',
            'main_image' => 'required|image',
            'media_gallery.*' => 'required|image',
        ]);

        // Handle main_image file upload
        if ($request->hasFile('main_image')) {
            $mainImage = $request->file('main_image');
            $mainImageName = time() . '_' . $mainImage->getClientOriginalName();
            $mainImagePath = $mainImage->storeAs('public/galleries/main_images', $mainImageName);
            $validatedData['main_image'] = $mainImagePath;
        }

        // Handle media_gallery file upload
        if ($request->hasFile('media_gallery')) {
            $mediaGallery = $request->file('media_gallery');
            $mediaGalleryPaths = [];
            foreach ($mediaGallery as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('public/galleries/media_gallery', $imageName);
                $mediaGalleryPaths[] = $imagePath;
            }
            $validatedData['media_gallery'] = json_encode($mediaGalleryPaths);
        }

        $gallery = Gallery::create($validatedData);

        // If you have a separate model for the media gallery, you can create and associate the images with the gallery here

        return new GalleryResource($gallery);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $Gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $Gallery)
    {
        return new GalleryResource($Gallery);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        return json_encode($request);
        // Validate request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'plan_id' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'uri' => 'required|string',
            'featured' => 'required|boolean',
            'published' => 'required|boolean',
            'main_image' => 'sometimes|image',
            'media_gallery.*' => 'sometimes|image',
        ]);

        // Handle main_image file upload
        if ($request->hasFile('main_image')) {
            $mainImage = $request->file('main_image');
            $mainImageName = time() . '_' . $mainImage->getClientOriginalName();
            $mainImagePath = $mainImage->storeAs('public/galleries/main_images', $mainImageName);
            $validatedData['main_image'] = $mainImagePath;
        }

        // Handle media_gallery file upload
        if ($request->hasFile('media_gallery')) {
            $mediaGallery = $request->file('media_gallery');
            $mediaGalleryPaths = [];
            foreach ($mediaGallery as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('public/galleries/media_gallery', $imageName);
                $mediaGalleryPaths[] = $imagePath;
            }
            $validatedData['media_gallery'] = json_encode($mediaGalleryPaths);
        }

        $gallery->update($validatedData);
        return new GalleryResource($gallery);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $Gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $Gallery)
    {
        $Gallery->delete();
        return response()->json(['message' => 'Gallery deleted successfully.']);
    }
}
