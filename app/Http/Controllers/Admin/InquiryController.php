<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Filters\InquiryFilter;
use App\Models\Inquiry;
use App\Models\Client;
use App\Models\Category;

class InquiryController extends Controller
{
    /**
     * Display a listing of inquiries.
     */
    public function index(InquiryFilter $filter)
    {
        // dd(Inquiry::with(['client', 'category'])->latest()->get());
        $inquiries = Inquiry::filter($filter)
            ->with(['client', 'category'])
            ->latest()
            ->get();

        $clients = Client::get();

        return view('admin.inquiries.index', compact('inquiries', 'clients'));
    }

    /**
     * Display the specified inquiry (read-only preview).
     */
    public function show(Inquiry $inquiry)
    {
        $inquiry->load(['client', 'category']);

        return view('admin.inquiries.preview', compact('inquiry'));
    }

    /**
     * Remove the specified inquiry from storage.
     */
    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')
            ->with('success', __('messages.inquiry_deleted_successfully'));
    }
}
