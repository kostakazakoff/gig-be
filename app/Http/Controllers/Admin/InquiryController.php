<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Client;
use App\Http\Requests\Inquiry\UpdateInquiryRequest;
use App\Models\Category;

class InquiryController extends Controller
{
    /**
     * Display a listing of inquiries.
     */
    public function index()
    {
        $inquiries = Inquiry::query()
            ->with(['client', 'category'])
            ->latest()
            ->get();

        return view('admin.inquiries.index', compact('inquiries'));
    }

    /**
     * Show the form for editing the specified inquiry.
     */
    public function edit(Inquiry $inquiry)
    {
        $clients = Client::orderBy('first_name')->orderBy('last_name')->get();
        $categories = Category::orderBy('translation_key')->get();
        return view('admin.inquiries.edit', compact('inquiry', 'clients', 'categories'));
    }

    /**
     * Update the specified inquiry in storage.
     */
    public function update(UpdateInquiryRequest $request, Inquiry $inquiry)
    {
        $inquiry->update($request->validated());

        return redirect()->route('admin.inquiries.index')
            ->with('success', 'Заявката е обновена успешно');
    }

    /**
     * Remove the specified inquiry from storage.
     */
    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')
            ->with('success', 'Заявката е изтрита успешно');
    }
}
