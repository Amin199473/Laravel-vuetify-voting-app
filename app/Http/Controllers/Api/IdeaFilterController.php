<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IdeaResource;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use Illuminate\Http\Request;

class IdeaFilterController extends Controller
{
    public function ideasCountBasedOntheirStatus()
    {
        $ideasCount = Idea::get()->count();
        $consideringIdeas = Idea::where('status_id', '2')->count();
        $inProgressIdeas = Idea::where('status_id', '3')->count();
        $implementedIdeas = Idea::where('status_id', '4')->count();
        $closedIdeas = Idea::where('status_id', '5')->count();
        return response()->json([
            'AllIdeas' => $ideasCount,
            'consideringIdeas' => $consideringIdeas,
            'inProgressIdeas' => $inProgressIdeas,
            'implementedIdeas' => $implementedIdeas,
            'closedIdeas' => $closedIdeas,
        ], 200);
    }
    public function filteringIdeasBasedOnTheirStatuses(Request $request)
    {
        $statuses = Status::all()->pluck('id', 'name');
        $status = $request->status;
        $ideas = IdeaResource::collection(
            Idea::Where('status_id', $statuses[$status])->latest()->paginate(5)
        );
        return $ideas;
    }

    public function filteringIdeasBasedOnTheirCategories(Request $request)
    {
        $categories = Category::all()->pluck('id', 'name');
        $category = $request->category;
        $ideas = IdeaResource::collection(
            Idea::Where('category_id', $categories[$category])->latest()->paginate(5)
        );
        return $ideas;
    }

    public function filteringIdeasBasedOnOtherFilters(Request $request)
    {

        $user_id = auth()->user()->id;

        if ($request->otherFilters == "No Filter") {
            $ideas = IdeaResource::collection(
                Idea::paginate(5)
            );
            return $ideas;
        }

        if ($request->otherFilters == "Top Voted") {
            $ideas = IdeaResource::collection(
                Idea::withCount('votes')->orderByDesc('votes_count')->paginate(5)
            );
            return $ideas;
        }

        if ($request->otherFilters == "My Ideas") {
            $ideas = IdeaResource::collection(
                Idea::where('user_id', $user_id)->orderByDesc('created_at')->paginate(5)
            );
            return $ideas;
        }

    }

    public function filteringIdeasBasedOnIdeaTitle(Request $request)
    {
        $ideas = IdeaResource::collection(
            Idea::where('title', 'like', '%' . $request->search . '%')->paginate(5)
        );
        return $ideas;
    }

}
