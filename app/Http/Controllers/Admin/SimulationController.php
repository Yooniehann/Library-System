<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SimulationSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SimulationController extends Controller
{
    public function index()
    {
        // Get the first setting or create a default one if none exists
        $setting = SimulationSetting::firstOrCreate([], [
            'is_active' => false,
            'simulation_date' => now(),
            'description' => 'Default simulation settings'
        ]);

        return view('dashboard.admin.simulation.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'is_active' => 'sometimes|boolean',
            'simulation_date' => 'required_if:is_active,1|date',
            'description' => 'nullable|string|max:255',
        ]);

        $setting = SimulationSetting::firstOrNew();

        // Handle the case where is_active checkbox is not checked
        $isActive = $request->has('is_active') ? (bool)$request->is_active : false;

        $setting->fill([
            'is_active' => $isActive,
            'simulation_date' => $isActive ? $request->simulation_date : now(),
            'description' => $request->description,
        ]);

        $setting->save();

        // Run the commands to update statuses immediately after changing simulation settings
        if ($isActive) {
            Artisan::call('books:update-overdue');
            Artisan::call('fines:check-overdue');
            Artisan::call('borrows:sync-status');
        } else {
            // When disabling simulation, also revert overdue statuses
            Artisan::call('books:revert-overdue');
            Artisan::call('books:update-overdue'); // Regular check with real date
            Artisan::call('fines:check-overdue');
            Artisan::call('borrows:sync-status');
        }

        return redirect()->route('admin.simulation.index')
            ->with('success', 'Simulation settings updated successfully!');
    }

    public function disable()
    {
        $setting = SimulationSetting::first();

        if ($setting) {
            $setting->update(['is_active' => false]);

            // Run commands to revert to real-time statuses
            Artisan::call('books:update-overdue');
            Artisan::call('fines:check-overdue');
            Artisan::call('borrows:sync-status');

            // NEW: Also revert overdue statuses that are no longer overdue in real time
            Artisan::call('books:revert-overdue');
        }

        return redirect()->route('admin.simulation.index')
            ->with('success', 'Simulation disabled. Using real-time dates now.');
    }

    public function updateStatus()
    {
        Artisan::call('books:update-overdue');
        Artisan::call('fines:check-overdue');
        Artisan::call('borrows:sync-status');

        return redirect()->route('admin.simulation.index')
            ->with('success', 'Book statuses updated successfully!');
    }
}
