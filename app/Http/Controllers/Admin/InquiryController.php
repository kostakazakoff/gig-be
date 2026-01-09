<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Client;
use App\Models\Service;
use App\Http\Requests\StoreInquiryRequest;
use App\Http\Requests\UpdateInquiryRequest;

class InquiryController extends Controller
{
    /**
     * Display a listing of inquiries.
     */
    public function index()
    {
        $inquiries = Inquiry::query()
            ->with(['client', 'service'])
            ->latest()
            ->get();

        return view('admin.inquiries.index', compact('inquiries'));
    }

    /**
     * Show the form for creating a new inquiry.
     */
    public function create()
    {
        $clients = Client::orderBy('first_name')->orderBy('last_name')->get();
        $services = Service::orderBy('translation_key')->get();
        return view('admin.inquiries.create', compact('clients', 'services'));
    }

    /**
     * Store a newly created inquiry in storage.
     */
    public function store(StoreInquiryRequest $request)
    {
        Inquiry::create($request->validated());

        return redirect()->route('admin.inquiries.index')
            ->with('success', 'Inquiry created successfully');
    }

    /**
     * Show the form for editing the specified inquiry.
     */
    public function edit(Inquiry $inquiry)
    {
        $clients = Client::orderBy('first_name')->orderBy('last_name')->get();
        $services = Service::orderBy('translation_key')->get();
        return view('admin.inquiries.edit', compact('inquiry', 'clients', 'services'));
    }

    /**
     * Update the specified inquiry in storage.
     */
    public function update(UpdateInquiryRequest $request, Inquiry $inquiry)
    {
        $inquiry->update($request->validated());

        return redirect()->route('admin.inquiries.index')
            ->with('success', 'Inquiry updated successfully');
    }

    /**
     * Remove the specified inquiry from storage.
     */
    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')
            ->with('success', 'Inquiry deleted successfully');
    }
}
