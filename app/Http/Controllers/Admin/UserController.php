<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    /**
     * Display a listing of users with search, filtering, and pagination.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search by name or email
        $search = $request->input('search', $request->input('q'));
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role (admin, organizer, member)
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by active status
        if ($request->filled('is_active')) {
            $isActive = filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($isActive !== null) {
                $query->where('status', $isActive ? 'active' : 'inactive');
            } else {
                $query->where('status', $request->is_active);
            }
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $isActive = $request->boolean('is_active');

        // Admin cannot deactivate own account
        if ($user->id === auth()->id() && !$isActive) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun admin Anda sendiri.')->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $isActive ? 'active' : 'inactive',
        ]);

        AuditLog::log('user_role_changed', $user, ['role' => $user->getOriginal('role'), 'status' => $user->getOriginal('status')], ['role' => $request->role, 'status' => $isActive ? 'active' : 'inactive'], request());

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui');
    }

    public function export()
    {
        $users = \App\Models\User::select('id', 'name', 'email', 'role', 'phone', 'is_active', 'no_show_count', 'is_restricted', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Nama', 'Email', 'Role', 'Telepon', 'Aktif', 'No-Show', 'Restricted', 'Terdaftar']);
            foreach ($users as $user) {
                fputcsv($file, [$user->id, $user->name, $user->email, $user->role, $user->phone ?? '', $user->is_active ? 'Ya' : 'Tidak', $user->no_show_count, $user->is_restricted ? 'Ya' : 'Tidak', $user->created_at->format('d M Y')]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="users-export.csv"']);
    }
}