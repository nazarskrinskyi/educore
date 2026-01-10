<?php

namespace App\Http\Controllers;

use App\Models\PageConfiguration;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PageConfigurationController extends Controller
{
    /**
     * Display the page configuration management interface
     */
    public function index(): Response
    {
        $configurations = PageConfiguration::orderBy('page_name')
            ->orderBy('order')
            ->get()
            ->groupBy('page_name');

        return Inertia::render('Admin/PageConfigurations/Index', [
            'configurations' => $configurations,
        ]);
    }

    /**
     * Show the form for editing a specific page configuration
     */
    public function edit(string $pageName): Response
    {
        $configurations = PageConfiguration::where('page_name', $pageName)
            ->orderBy('order')
            ->get();

        return Inertia::render('Admin/PageConfigurations/Edit', [
            'pageName' => $pageName,
            'configurations' => $configurations,
        ]);
    }

    /**
     * Update the specified page configuration
     */
    public function update(Request $request, PageConfiguration $pageConfiguration)
    {
        $validated = $request->validate([
            'content' => 'required|array',
            'order' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        $pageConfiguration->update($validated);

        return redirect()->back()->with('success', 'Configuration updated successfully');
    }

    /**
     * Update multiple configurations at once
     */
    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'configurations' => 'required|array',
            'configurations.*.id' => 'required|exists:page_configurations,id',
            'configurations.*.content' => 'required|array',
            'configurations.*.order' => 'required|integer',
            'configurations.*.is_active' => 'required|boolean',
        ]);

        foreach ($validated['configurations'] as $config) {
            PageConfiguration::where('id', $config['id'])->update([
                'content' => $config['content'],
                'order' => $config['order'],
                'is_active' => $config['is_active'],
            ]);
        }

        return redirect()->back()->with('success', 'Configurations updated successfully');
    }

    /**
     * Store a new page configuration
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'page_name' => 'required|string',
            'section_key' => 'required|string',
            'content' => 'required|array',
            'order' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        PageConfiguration::create($validated);

        return redirect()->back()->with('success', 'Configuration created successfully');
    }

    /**
     * Remove the specified page configuration
     */
    public function destroy(PageConfiguration $pageConfiguration)
    {
        $pageConfiguration->delete();

        return redirect()->back()->with('success', 'Configuration deleted successfully');
    }
}
