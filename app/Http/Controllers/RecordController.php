<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecordGetRequest;
use App\Http\Requests\RecordStoreRequest;
use App\Http\Resources\RecordResource;
use App\Models\Record;
use App\Models\Video;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success(
            RecordResource::collection(
                Record::where('user_id', Auth::user()->id)->orderBy('created_at','DESC')->get()    
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RecordStoreRequest $request)
    {
        $request->validated($request->all());

        $record = Record::create([
            'user_id' => Auth::user()->id,
            'video_id' => $request->video_id
        ]);

        return $this->success(new RecordResource($record));
    }

    /**
     * Display the specified resource.
     * 
     * @param int $video_id
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        return RecordResource::collection(
            Record::where('user_id', Auth::user()->id)->where('video_id', $video->id)->get()
        );
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Record $record)
    {
        if(Auth::user()->id != $record->user_id){
            return $this->error('', 'Unauthorised request.', 403);
        }

        $record->update($request->all());

        return $this->success(new RecordResource($record));
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Record $record)
    {
        return $this->isNotAuthorised($record) ?? $record->delete();
    }

    private function isNotAuthorised(Record $record)
    {
        if(Auth::user()->id != $record->user_id){
            return $this->error('', 'Unauthorised request.', 403);
        }
        return null;
    }
}