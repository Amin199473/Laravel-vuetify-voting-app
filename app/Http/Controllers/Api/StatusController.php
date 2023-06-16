<?php

namespace App\Http\Controllers\Api;

use App\Models\Idea;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\StatusResource;
use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Mail\IdeaStatusUpdatedMailable;

class StatusController extends Controller
{
    public $idea;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = StatusResource::collection(Status::get());
        return $statuses;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function updateStatus(Request $request)
    {
        $status_id = Status::where('name', $request->status)->first()->id;
        $idea = Idea::where('slug', $request->slug)->first();
        $idea->update([
            'status_id' => $status_id,
        ]);
        if ($request->notifyAllVoters) {
            $idea->votes()
            ->select('name', 'email')
            ->chunk(100, function ($voters) use ($idea) {
                foreach ($voters as $user) {
                    Mail::to($user)->queue(new IdeaStatusUpdatedMailable($idea));
                }
            });
        }
        return response()->json(['message' => 'status changed successfully'], 200);
    }

    private function notifyAllVoters(Idea $idea)
    {

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatusRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatusRequest $request, Status $status)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status)
    {
        //
    }
}
