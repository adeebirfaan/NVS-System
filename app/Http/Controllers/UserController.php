<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isMcmc()) {
                return redirect('/')->with('error', 'Access denied.');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $query = User::query()->with('agency');

        if ($request->has('role') && $request->role !== '') {
            $query->where('role', $request->role);
        }

        if ($request->has('search') && $request->search !== '') {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('mcmc.users.index', compact('users'));
    }

    public function create()
    {
        $agencies = Agency::active()->get();
        return view('mcmc.users.create', compact('agencies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'role' => 'required|in:public,mcmc,agency',
            'agency_id' => 'required_if:role,agency|nullable|exists:agencies,id',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'role' => $validated['role'],
            'agency_id' => $validated['agency_id'] ?? null,
            'is_active' => true,
            'must_change_password' => true,
        ]);

        return redirect()->route('mcmc.users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('mcmc.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $agencies = Agency::active()->get();
        return view('mcmc.users.edit', compact('user', 'agencies'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'role' => 'required|in:public,mcmc,agency',
            'agency_id' => 'required_if:role,agency|nullable|exists:agencies,id',
            'is_active' => 'required|boolean',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'role' => $validated['role'],
            'agency_id' => $validated['agency_id'] ?? null,
            'is_active' => $validated['is_active'],
        ]);

        return redirect()->route('mcmc.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('mcmc.users.index')->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('mcmc.users.index')->with('success', 'User deleted successfully.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'new_password' => 'required|string|min:8',
        ]);

        $user->update([
            'password' => Hash::make($validated['new_password']),
            'must_change_password' => true,
        ]);

        return redirect()->route('mcmc.users.show', $user)->with('success', 'Password reset successfully.');
    }

    public function statistics()
    {
        $stats = [
            'total_users' => User::count(),
            'public_users' => User::public()->count(),
            'mcmc_staff' => User::mcmc()->count(),
            'agency_staff' => User::agency()->count(),
            'active_users' => User::active()->count(),
            'inactive_users' => User::where('is_active', false)->count(),
        ];

        return view('mcmc.users.statistics', compact('stats'));
    }

    public function report(Request $request)
    {
        $startDate = $request->get('start_date', now()->subMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        $role = $request->get('role', '');

        $query = User::whereBetween('created_at', [$startDate, $endDate]);

        if ($role) {
            $query->where('role', $role);
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        $stats = [
            'total' => $users->count(),
            'by_role' => $users->groupBy('role')->map->count(),
            'by_status' => $users->groupBy('is_active')->map->count(),
            'daily' => $users->groupBy(function ($user) {
                return $user->created_at->format('Y-m-d');
            })->map->count(),
        ];

        return view('mcmc.users.report', compact('users', 'stats', 'startDate', 'endDate', 'role'));
    }
}
