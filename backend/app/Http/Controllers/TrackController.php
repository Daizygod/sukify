<?php

namespace App\Http\Controllers;

use App\Models\Track;
use App\Models\User;
use App\Models\UsersLikedTrack;
use Carbon\Carbon;
use Cassandra\Uuid;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

/**
 * @OA\Info(title="Tracks", version="0.1")
 */
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
        if ($request->input('ui_background_color')) {
            if (preg_match('/^#[a-f0-9]{6}$/i', $request->input('ui_background_color')))
            {
                $new_track->ui_background_color = $request->input('ui_background_color');
            } elseif(preg_match('/^[a-f0-9]{6}$/i', $request->input('ui_background_color')))
            {
                $new_track->ui_background_color = '#' . $request->input('ui_background_color');
            }
        }
        $new_track->counter = 0;
        //TODO very very fucking piece of shit, on production need to correct
        $new_track->cover_file = env('APP_URL') . ':8000/' . $cover_path; //FIXME
        $new_track->file = env('APP_URL') . ':8000/' . $track_path; //FIXME
        $new_track->video_file = env('APP_URL') . ':8000/' . $video_path; //FIXME
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

    public function listenAudio(Request $request, $folder, $filename, $ext)
    {
        $response_code = 200;
        $headers = ['Content-Type' => 'audio/mpeg'];
        $fileNameWithFolder = "$folder/$filename.$ext";
        $filePath = "public/" . $fileNameWithFolder;
//
//        $filePath = "public/" . $fileNameWithFolder;
//        if (Storage::disk('local')->exists($filePath)) {
//            $file = Storage::disk('local')->get($filePath);
////            return response()->file($file, ['Content-Type' => 'audio/mpeg']);
//            return response()->file($file);
//        } else {
//            return 0;
//        }
        $file = Storage::disk('local')->get($filePath);
        $response = \Illuminate\Support\Facades\Response::make($file, 200);
        $size = Storage::disk('local')->size($filePath);
        $stream = fopen(storage_path('app/' . $filePath), "r");
        $fullsize = $size;
        // Check for request for part of the stream
        $range = \Illuminate\Support\Facades\Request::header('Range');
        if($range != null) {
            $eqPos = strpos($range, "=");
            $toPos = strpos($range, "-");
            $unit = substr($range, 0, $eqPos);
            $start = intval(substr($range, $eqPos+1, $toPos));
            $success = fseek($stream, $start);
            if($success == 0) {
                $size = $fullsize - $start;
                $response_code = 206;
                $headers["Accept-Ranges"] = $unit;
                $headers["Content-Range"] = $unit . " " . $start . "-" . ($fullsize-1) . "/" . $fullsize;
            }
        }

        $headers["Content-Length"] = $size;

        return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
            fpassthru($stream);
        }, $response_code, $headers);

//        $response->header('Content-Type', 'audio/mpeg');
//        return $response;
//
//
//        $file=Storage::disk('local')->get($filePath);
////        return response()->file($file, ['Content-Type' => 'audio/mpeg']);
////        return response()->file($file, $headers);
//
////        dd($file);
////        return 1;
//        $fileName=$filePath;
//        $filesize = Storage::disk('local')->size($filePath);
//
//
//        // return response($file, 200)->header('Content-Type', $mime_type);
//
//        $size   = $filesize; // File size
//        $length = $size;           // Content length
//        $start  = 0;               // Start byte
//        $end    = $size - 1;       // End byte
//
//        $headersArray=[
//            'Accept-Ranges' => "bytes",
//            'Accept-Encoding' => "gzip, deflate",
//            'Pragma' => 'public',
//            'Expires' => '0',
//            'Cache-Control' => 'must-revalidate',
//            'Content-Transfer-Encoding' => 'binary',
//            'Content-Disposition' => ' inline; filename='."$filename.$ext",
//            'Content-Length' => $filesize,
//            'Content-Type' => "audio/mpeg",
//            'Connection' => "Keep-Alive",
//            'Content-Range' => 'bytes 0-'.$end .'/'.$size,
//            'X-Pad' => 'avoid browser bug',
//            'Etag' => "$filename.$ext",
//        ];
//
//        return response()->file($fileName, $headersArray);

    }

    public function setTrackUnfavorite(Request $request)
    {
        $return = new \stdClass();
        $return->error = true;
        //TODO get user_id from jwt
        $user_id = 202;
        $track_id = $request->input('track_id');
        $track = Track::where(['id' => $track_id])->first();
        $user = User::where(['id' => $user_id])->first();
        if ($track && $user) {
            UsersLikedTrack::where(['user_id' => $user_id, 'track_id' => $track_id])->delete();
            $return->error = false;
        }
        return $return;
    }

    public function setTrackFavorite(Request $request)
    {
        $return = new \stdClass();
        $return->error = true;
        //TODO get user_id from jwt
        $user_id = 202;
        $track_id = $request->input('track_id');
        $track = Track::where(['id' => $track_id])->first();
        $user = User::where(['id' => $user_id])->first();
        if ($track && $user) {
            $isset = UsersLikedTrack::where(['user_id' => $user_id, 'track_id' => $track_id])->first();
            if (!$isset) {
                $link = new UsersLikedTrack([
                    'user_id' => $user_id,
                    'track_id' => $track_id
                ]);
            }
            $return->error = false;
            if (!$isset && !$link->save()) {
                $return->error = true;
            }
        }
        return $return;
    }

    /**
     * @OA\Get (
     *     path="/api/tracks/search",
     *     tags={"tracks"},
     *     description="Search tracks",
     *     summary="Search tracks",
     *      @OA\Parameter(
     *          name="search",
     *          description="String to search",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id",type="number",example="1"),
     *                     @OA\Property(property="name",type="string",example="Проснулся В Темноте"),
     *                     @OA\Property(property="release_date",type="string",example="2002-02-02"),
     *                     @OA\Property(property="counter",type="number",example="1"),
     *                     @OA\Property(property="cover_file",type="string",example="http://localhost:80/storage/images202308/Rh5M9Q1ip4s9JphcHHBL8SYIAF39QMq0p4rpIiHa.jpg"),
     *                     @OA\Property(property="file",type="string",example="http://localhost:80/api/getaudio/music202308/aFjuB7PHa8OtF63SrDACxwLRuo5vMwIq7eTNNdcH/mp3"),
     *                     @OA\Property(property="video_file",type="string",example="http://localhost:80/storage/images202308/Rh5M9Q1ip4s9JphcHHBL8SYIAF39QMq0p4rpIiHa.mp4"),
     *                     @OA\Property(property="color",type="string",example="#236180"),
     *                     @OA\Property(property="single",type="number",example="true"),
     *                     @OA\Property(property="duration",type="number",example="125"),
     *                     @OA\Property(property="album_id",type="number",example="1"),
     *                     @OA\Property(property="cover512px",type="string",example="http://localhost:80/storage/images202308/Rh5M9Q1ip4s9JphcHHBL8SYIAF39QMq0p4rpIiHa_512px.jpg"),
     *                     @OA\Property(property="cover384px",type="string",example="http://localhost:80/storage/images202308/Rh5M9Q1ip4s9JphcHHBL8SYIAF39QMq0p4rpIiHa_384px.jpg"),
     *                     @OA\Property(property="cover256px",type="string",example="http://localhost:80/storage/images202308/Rh5M9Q1ip4s9JphcHHBL8SYIAF39QMq0p4rpIiHa_256px.jpg"),
     *                     @OA\Property(property="cover192px",type="string",example="http://localhost:80/storage/images202308/Rh5M9Q1ip4s9JphcHHBL8SYIAF39QMq0p4rpIiHa_192px.jpg"),
     *                     @OA\Property(property="cover128px",type="string",example="http://localhost:80/storage/images202308/Rh5M9Q1ip4s9JphcHHBL8SYIAF39QMq0p4rpIiHa_128px.jpg"),
     *                     @OA\Property(property="cover96px",type="string",example="http://localhost:80/storage/images202308/Rh5M9Q1ip4s9JphcHHBL8SYIAF39QMq0p4rpIiHa_96px.jpg"),
     *                     @OA\Property(property="in_album",type="boolean",example="true"),
     *
     *                      @OA\Property(
     *                          property="album",
     *                          type="object",
     *                          @OA\Property(property="id",type="number", example="1"),
     *                          @OA\Property(property="name",type="string", example="Проснулся В Темноте"),
     *                      ),
     *
     *                     @OA\Property(property="added_at",type="string",example="3 недели назад"),
     *                     @OA\Property(property="liked",type="boolean",example="false"),
     *
     *                      @OA\Property(
     *                          property="artists",
     *                          type="array",
     *                          example={{"id":113,"name":"GONE.Fludd","avatar":"http://localhost:80/storage/images202308/s3LOwH4H1xZbfkFSxrdhTRGhTABS7wUHEHe8Nr0J.png","background":"http://localhost:80/storage/images202308/s3LOwH4H1xZbfkFSxrdhTRGhTABS7wUHEHe8Nr0J.png"}},
     *                          @OA\Items(
     *                              type="object",
     *                              @OA\Property(property="id",type="number"),
     *                              @OA\Property(property="name",type="string"),
     *                              @OA\Property(property="avatar",type="string"),
     *                              @OA\Property(property="background",type="string")
     *                          )
     *                      )
     *                 )
     *             ),
     *              @OA\Property(property="path", type="string", example="http://localhost/api/tracks/search"),
     *              @OA\Property(property="per_page", type="number", example="20"),
     *              @OA\Property(property="next_cursor", type="string", example="eyJjb3VudGVyIjowLCJpZCI6MzksIl9wb2ludHNUb05leHRJdGVtcyI6dHJ1ZX0"),
     *              @OA\Property(property="next_page_url", type="string", example="http://localhost/api/tracks/search?cursor=eyJjb3VudGVyIjowLCJpZCI6MzksIl9wb2ludHNUb05leHRJdGVtcyI6dHJ1ZX0"),
     *              @OA\Property(property="prev_cursor", type="string", example="eyJjb3VudGVyIjowLCJpZCI6MzgsIl9wb2ludHNUb05leHRJdGVtcyI6ZmFsc2V9"),
     *              @OA\Property(property="prev_page_url", type="string", example="http://localhost/api/tracks/search?cursor=eyJjb3VudGVyIjowLCJpZCI6MzgsIl9wb2ludHNUb05leHRJdGVtcyI6ZmFsc2V9"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="Пошел нахуй"),
     *          )
     *      )
     * )
     */
    public function search(Request $request)
    {
        //TODO get user_id from jwt
        $user_id = 202;
        $tracks = Track::where('name', 'LIKE', "%{$request->query('search')}%")
            ->with('artists')
//            ->with('albums')
            ->orderBy('counter', 'desc')
            ->orderBy('id', 'desc')
            ->cursorPaginate(20);

        collect($tracks->items())
            ->map(function ($track) use ($user_id) {
            $track->file2 = env('APP_URL') . "/storage/" . $track->file;
            $track->file = env('APP_URL') . "/api/getaudio/" . str_replace('.', '/', $track->file);
            $track->cover_file = env('APP_URL') . "/storage/" . $track->cover_file;
            $track->cover512px = $track->cover512px;
            $track->cover384px = $track->cover384px;
            $track->cover256px = $track->cover256px;
            $track->cover192px = $track->cover192px;
            $track->cover128px = $track->cover128px;
            $track->cover96px = $track->cover96px;
//            foreach (Track::coverResizeSquareSizes as $size) {
//                $track->covers[$size] = $track->generateCoverPathForSize($size);
//            }
            //FIXME
            $track->duration = $track->duration ?? random_int(30, 300);
            $track->album = ["id" => 12, "name" => $track->name];
                setlocale(LC_TIME, 'ro_RO.UTF-8');
            $track->added_at = Carbon::now('UTC')->subMinutes(random_int(1, 87600));
//                $track->added_at = Carbon::createFromTimestamp(1687705261, 'UTC');


            if (Carbon::now('UTC')->diffInMonths($track->added_at) > 1) {
                $track->added_at = $track->added_at->locale('ru')->translatedFormat('d M. o');
            } else {
                $track->added_at = $track->added_at->locale('ru')->diffForHumans();
            }
//            $track->added_at = Carbon::createFromTimestamp(Carbon::now('UTC')->subSeconds(rand(10, 172800))->timestamp, 'UTC')->locale('ru')->diffForHumans();
            $track->liked = $track->hasLikeFromUser($user_id);
            return $track;
        });

        return response()->json($tracks, 200);
    }

    public function favorites(Request $request)
    {
        //TODO get user_id from jwt
        $user_id = 202;
        $allUserTrackIds = UsersLikedTrack::where(['user_id' => $user_id])->pluck('track_id')->toArray();
        $tracks = Track::whereIn('id', $allUserTrackIds)
            ->with('artists')
            ->orderBy('counter', 'desc')
            ->orderBy('id', 'desc')
            ->cursorPaginate(5);

        collect($tracks->items())
            ->map(function ($track) use ($user_id) {
                $track->file = env('APP_URL') . "/storage/" . $track->file;
                $track->cover_file = env('APP_URL') . "/storage/" . $track->cover_file;
                $track->cover = [];
                foreach (Track::coverResizeSquareSizes as $size) {
                    $track->cover[$size] = $track->generateCoverPathForSize($size);
                }
                $track->liked = true;
                return $track;
            });

        return $tracks;
    }
}
