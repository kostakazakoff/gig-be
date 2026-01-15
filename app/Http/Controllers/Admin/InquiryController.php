<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Filters\InquiryFilter;
use App\Models\Inquiry;
use App\Models\Client;
use App\Models\Category;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    /**
     * Display a listing of inquiries.
     */
    public function index(Request $request, InquiryFilter $filter)
    {
        $inquiries = Inquiry::with(['client', 'category'])
            ->when($request->filled('client'), fn($q) => $q->where('client_id', $request->input('client')))
            ->when($request->filled('category'), fn($q) => $q->where('category_id', $request->input('category')))
            ->when($request->filled('date'), fn($q) => $q->where('created_at', '>=' , $request->input('date')))
            ->paginate(10)
            ->withQueryString();
    
        $clients = Client::get();
        $categories = Category::get();

        return view('admin.inquiries.index', compact('inquiries', 'clients', 'categories'));
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
