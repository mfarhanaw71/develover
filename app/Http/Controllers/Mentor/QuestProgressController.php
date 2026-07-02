<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Quest;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestProgressController extends Controller
{
    public function index()
    {
        // 🔵 Ambil kelompok mentor (pakai group_mentors)
        $groupIds = DB::table('group_mentors')
                      ->where('user_id', auth()->id())
                      ->pluck('group_id');
        
        $groups = Group::whereIn('id', $groupIds)->get();
        
        // Ambil quest harian
        $quests = Quest::where('is_daily', true)->get();
        
        // Ambil mahasiswa di kelompok mentor
        $roleMahasiswa = Role::where('name', 'mahasiswa')->first();
        $students = User::where('role_id', $roleMahasiswa->id ?? 0)
                        ->whereIn('group_id', $groupIds)
                        ->with(['userQuests' => function($q) {
                            $q->whereDate('quest_date', today());
                        }])
                        ->get();
        
        // Hitung statistik
        $totalStudents = $students->count();
        $completedToday = 0;
        $totalFoodGiven = 0;
        
        foreach ($students as $student) {
            $completedToday += $student->userQuests->where('is_completed', true)->count();
            $totalFoodGiven += $student->food_points ?? 0;
        }
        
        // Cegah DivisionByZeroError
        $totalQuests = $quests->count();
        if ($totalStudents > 0 && $totalQuests > 0) {
            $completionRate = round(($completedToday / ($totalStudents * $totalQuests)) * 100, 1);
        } else {
            $completionRate = 0;
        }
        
        return view('mentor.quests-progress', compact(
            'groups',
            'students',
            'quests',
            'totalStudents',
            'completedToday',
            'completionRate',
            'totalFoodGiven'
        ));
    }
}