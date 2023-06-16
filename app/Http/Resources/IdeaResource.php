<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IdeaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'name' => $this->user->name,
            'category' => $this->category->name,
            'status' => $this->status->name,
            'isVotedbyUser'=> $this->isVotedByUser(auth()->user()),
            'votes'=>$this->votes()->count(),
            'commentsCount'=>$this->comments()->count(),
            'color' => $this->status->color,
            'slug' => $this->slug,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->diffForHumans(),
        ];
    }
}
