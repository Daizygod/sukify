<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Carbon\Carbon;
use Cassandra\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Itstructure\GridView\DataProviders\EloquentDataProvider;


class TrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $dataProvider = new EloquentDataProvider(Track::query());
        return view('tracks.index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View('tracks.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->hasFile('cover_file')) {
            //TODO very very fucking piece of shit, on production need to correct
            $cover = $request->file('cover_file');
            $cover_path = str_replace('public', 'storage', $cover->store('public/images' . Carbon::now()->format('Ym')));
        }
        if ($request->hasFile('file')) {
            //TODO very very fucking piece of shit, on production need to correct
            $track = $request->file('file');
            $track_path = str_replace('public', 'storage', $track->store('public/music' . Carbon::now()->format('Ym')));
        }
        if ($request->hasFile('video_file')) {
            //TODO very very fucking piece of shit, on production need to correct
            $video = $request->file('video_file');
            $video_path = str_replace('public', 'storage', $video->store('public/videos' . Carbon::now()->format('Ym')));
        }
//
//        if(!$request->file('file_upload')) {
//            return RS::error(400, "Поле file_upload не заполнено");
//        }
//
//        $uuid = Uuid::uuid4()->toString();
//        if(
//            !in_array(
//                $request->file('file_upload')->getClientOriginalExtension(),
//                Setting::$fileExtension[$attribute->attribute_name]
//            )
//        ) {
//            return RS::error(400, "Unknown file format: "
//                . $request->file('file_upload')->getClientOriginalExtension() .
//                ". Allowed: " . implode(",", Setting::$fileExtension[$attribute->attribute_name]));
//        }
//        $file_name = $uuid . '.' . $request->file('file_upload')->getClientOriginalExtension();
//        list($width, $height, $type, $attr) = getimagesize($request->file('file_upload'));
//        if (array_key_exists($attribute->attribute_name, Setting::$imagesResolution)) {
//            $minWidth = Setting::$imagesResolution[$attribute->attribute_name]['width'];
//            $minHeight = Setting::$imagesResolution[$attribute->attribute_name]['height'];
//            if ($width < $minWidth || $height < $minHeight) {
//                return RS::error(400, "Минимальное разрешение - " . $minWidth . 'x' . $minHeight);
//            }
//        }
//
//        if (filesize($request->file('file_upload'))/1024/1024 > 10) {
//            return RS::error(400, "Размер файла больше 10мб (" . round(filesize($request->file('file_upload'))/1024/1024, 2) . 'мб)');
//        }
//
//        if(!$request->file('file_upload')->storeAs(
//            '',
//            $file_name,
//            ['disk' => 'public']
//        )) {
//            return RS::error(400, "Ошибка сохранения файла");
//        }
//        $settingValueText = env('APP_URL') . '/storage/' . $file_name;
//        Setting::setSetting($attribute->id, $settingValueText, session('club_id'));
        //Carbon::createFromFormat('Y-m-d', $request->input('release_date'), 'Europe/Moscow')->format('Y-m-d H:i:s')
        $new_track = new Track();
        $new_track->name = $request->input('name');
        $new_track->artist_id = $request->input('artist_id');
        $new_track->release_date = Carbon::createFromFormat('Y-m-d', $request->input('release_date'), 'Europe/Moscow')->format('Y/m/d H:i:s');
        $new_track->type = $request->input('type');
        $new_track->counter = 0;
        //TODO very very fucking piece of shit, on production need to correct
        $new_track->cover_file = env('APP_URL') . ':8000/' . $cover_path;
        $new_track->file = env('APP_URL') . ':8000/' . $track_path;
        $new_track->video_file = env('APP_URL') . ':8000/' . $video_path;
//        $new_track->created_by = $request->input('name');
//        $new_track->updated_by = $request->input('name');


        $new_track->save();
        return redirect()->route('tracks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Track  $track
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Track $track)
    {
        return view('show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Track  $track
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Track $track)
    {
        return View('tracks.form', compact('track'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Track  $track
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Track $track)
    {
        $track->update($request->only(
            [
                'name',
                'artist_id',
                'release_date',
                'type',
                'counter',
                'photo_cover_id',
                'file_id',
                'video_id'
            ]
        ));
        return redirect()->route('tracks.index')->withSuccess('Updated $track ' . $track->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Track  $track
     * @return \Illuminate\Http\Response
     */
    public function destroy(Track $track)
    {
        //
    }

    public function search(Request $request)
    {
//        return Track::where('name', 'LIKE', "%{$request->input('search')}%")
//            ->get();
        return Track::orderBy('id')->cursorPaginate(5)->map(function($track) {
            $track->file = env('APP_URL') . "/storage/" . $track->file;
            $track->cover_file = env('APP_URL') . "/storage/" . $track->cover_file;
            return $track;
        });
    }
}
