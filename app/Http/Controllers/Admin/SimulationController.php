<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SimulationSetting;
use Illuminate\Http\Request;

class SimulationController extends Controller
{
    public function index()
    {
        $setting = SimulationSetting::first();
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

        $setting->fill([
            'is_active' => $request->has('is_active'),
            'simulation_date' => $request->simulation_date,
            'description' => $request->description,
        ]);

        $setting->save();

        return redirect()->route('admin.simulation.index')
            ->with('success', 'Simulation settings updated successfully!');
    }

    public function disable()
    {
        $setting = SimulationSetting::first();

        if ($setting) {
            $setting->update(['is_active' => false]);
        }

        return redirect()->route('admin.simulation.index')
            ->with('success', 'Simulation disabled. Using real-time dates now.');
    }
}
