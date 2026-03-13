<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;

class AgencyController extends Controller
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
        $query = Agency::query();

        if ($request->has('search') && $request->search !== '') {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status === 'active');
        }

        $agencies = $query->orderBy('name')->paginate(15);

        return view('mcmc.agencies.index', compact('agencies'));
    }

    public function create()
    {
        return view('mcmc.agencies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:agencies,code',
            'description' => 'nullable|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        Agency::create([
            'name' => $validated['name'],
            'code' => strtoupper($validated['code']),
            'description' => $validated['description'] ?? null,
            'contact_email' => $validated['contact_email'],
            'contact_phone' => $validated['contact_phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->route('mcmc.agencies.index')->with('success', 'Agency created successfully.');
    }

    public function show(Agency $agency)
    {
        $agency->load('users');
        return view('mcmc.agencies.show', compact('agency'));
    }

    public function edit(Agency $agency)
    {
        return view('mcmc.agencies.edit', compact('agency'));
    }

    public function update(Request $request, Agency $agency)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:agencies,code,' . $agency->id,
            'description' => 'nullable|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'is_active' => 'required|boolean',
        ]);

        $agency->update($validated);

        return redirect()->route('mcmc.agencies.index')->with('success', 'Agency updated successfully.');
    }

    public function destroy(Agency $agency)
    {
        if ($agency->users()->count() > 0) {
            return redirect()->route('mcmc.agencies.index')->with('error', 'Cannot delete agency with associated users.');
        }

        $agency->delete();

        return redirect()->route('mcmc.agencies.index')->with('success', 'Agency deleted successfully.');
    }
}
