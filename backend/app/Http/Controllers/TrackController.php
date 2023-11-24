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
 * @OA\Info(
 *      version="1.0.0",
 *      title="Sukify Documentation",
 *      description="Sukify Swagger OpenApi description",
 *      @OA\Contact(
 *          url="https://github.com/Daizygod/sukify"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Demo API Server"
 * )
 *
 * @OA\Server(
 *      url="https://sukify.ru",
 *      description="Deploy API Server"
 * )
 *
 */
class TrackController extends Controller
{
    /**
     * @OA\Get (
     *     path="/api/getaudio/{folder}/{filename}/{ext}",
     *     tags={"tracks"},
     *     description="Listen track by file path",
     *     summary="Listen track",
     *      @OA\Parameter(
     *          name="folder",
     *          description="Folder of audio file",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="filename",
     *          description="Filename of audio file",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="ext",
     *          description="extension of audio file",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\MediaType(mediaType="audio/mpeg")
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
