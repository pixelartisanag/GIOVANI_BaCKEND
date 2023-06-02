<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use App\Models\Gallery;
use App\Models\Story;
use App\Models\Video;
use App\Http\Resources\StoryResource;
use App\Http\Resources\VideoResource;
use App\Http\Resources\GalleryResource;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function featuredPosts()
    {
        $stories = Story::where('featured', 1)
            ->where('published', 1)
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        $videos = Video::where('featured', 1)
            ->where('published', 1)
            ->orderBy('created_at', 'desc')
            ->take(1)
            ->get();

        $galleries = Gallery::where('featured', 1)
            ->where('published', 1)
            ->orderBy('created_at', 'desc')
            ->take(1)
            ->get();

        $data = $stories->map(function ($story) {
            $story['type'] = 'Story';
            return $story;
        })->concat(
            $videos->map(function ($video) {
                $video['type'] = 'Video';
                return $video;
            })
        )->concat(
            $galleries->map(function ($gallery) {
                $gallery['type'] = 'Gallery';
                return $gallery;
            })
        )->shuffle();


        return response()->json($data);
    }

    public function homePosts()
    {
        $stories = Story::where('published', 1)
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        $videos = Video::where('published', 1)
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        $galleries = Gallery::where('published', 1)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $data = $stories->map(function ($story) {
            $story['type'] = 'Story';
            return $story;
        })->concat(
            $videos->map(function ($video) {
                $video['type'] = 'Video';
                return $video;
            })
        )->concat(
            $galleries->map(function ($gallery) {
                $gallery['type'] = 'Gallery';
                return $gallery;
            })
        )->shuffle();


        return response()->json($data);
    }

    public function sendContactEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ];

        Mail::to(env('MAIL_ADMIN_ADDRESS'))->send(new ContactFormMail($data));

        return response()->json(['message' => 'Email sent successfully.'], 200);
    }

}
