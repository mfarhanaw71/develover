<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        // Ambil kelompok mentor
        $groupIds = DB::table('group_mentors')
                      ->where('user_id', auth()->id())
                      ->pluck('group_id');
        
        $groups = Group::whereIn('id', $groupIds)->get();
        
        // Ambil mahasiswa di kelompok mentor
        $roleMahasiswa = Role::where('name', 'mahasiswa')->first();
        $students = User::where('role_id', $roleMahasiswa->id ?? 0)
                        ->whereIn('group_id', $groupIds)
                        ->with('group')
                        ->get();
        
        return view('mentor.students.index', compact('students', 'groups'));
    }

    public function create()
    {
        // Ambil kelompok mentor
        $groupIds = DB::table('group_mentors')
                      ->where('user_id', auth()->id())
                      ->pluck('group_id');
        $groups = Group::whereIn('id', $groupIds)->get();
        
        return view('mentor.students.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|unique:users,nim|max:20',
            'group_id' => 'required|exists:groups,id',
            'password' => 'required|min:6',
        ]);

        $roleMahasiswa = Role::where('name', 'mahasiswa')->first();

        User::create([
            'name' => $request->name,
            'nim' => $request->nim,
            'group_id' => $request->group_id,
            'password' => Hash::make($request->password),
            'role_id' => $roleMahasiswa->id,
            'is_active' => true,
        ]);

        return redirect()->route('mentor.students.index')
                         ->with('success', 'Mahasiswa berhasil ditambahkan!');
    }

    // 🔵 FIX: Method edit()
    public function edit($id)
    {
        // Ambil data student
        $roleMahasiswa = Role::where('name', 'mahasiswa')->first();
        $student = User::where('role_id', $roleMahasiswa->id ?? 0)
                       ->where('id', $id)
                       ->firstOrFail();
        
        // Ambil kelompok mentor
        $groupIds = DB::table('group_mentors')
                      ->where('user_id', auth()->id())
                      ->pluck('group_id');
        $groups = Group::whereIn('id', $groupIds)->get();
        
        return view('mentor.students.edit', compact('student', 'groups'));
    }

    public function update(Request $request, $id)
    {
        $roleMahasiswa = Role::where('name', 'mahasiswa')->first();
        $student = User::where('role_id', $roleMahasiswa->id ?? 0)
                       ->where('id', $id)
                       ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:users,nim,' . $id,
            'group_id' => 'required|exists:groups,id',
            'password' => 'nullable|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'nim' => $request->nim,
            'group_id' => $request->group_id,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $student->update($data);

        return redirect()->route('mentor.students.index')
                         ->with('success', 'Mahasiswa berhasil diupdate!');
    }

    public function destroy($id)
    {
        $roleMahasiswa = Role::where('name', 'mahasiswa')->first();
        $student = User::where('role_id', $roleMahasiswa->id ?? 0)
                       ->where('id', $id)
                       ->firstOrFail();
        
        $student->delete();

        return redirect()->route('mentor.students.index')
                         ->with('success', 'Mahasiswa berhasil dihapus!');
    }

    public function importForm()
    {
        $groupIds = DB::table('group_mentors')
                      ->where('user_id', auth()->id())
                      ->pluck('group_id');
        $groups = Group::whereIn('id', $groupIds)->get();
        
        return view('mentor.students.import', compact('groups'));
    }

    public function import(Request $request)
    {
        // Implementasi import Excel
        // ...
    }
}