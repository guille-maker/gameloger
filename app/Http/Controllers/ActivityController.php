<?php

namespace App\Http\Controllers;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function destroy($id)
    {
        $activity = Activity::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $activity->delete();

        return redirect()->back()->with('success', 'Actividad eliminada correctamente.');
    }
}
