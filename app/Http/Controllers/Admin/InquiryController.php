<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $q = Inquiry::query()->latest();
        if ($status = $request->query('status')) {
            $q->where('status', $status);
        }
        return view('admin.inquiries.index', ['inquiries' => $q->paginate(20)->withQueryString()]);
    }

    public function show(Inquiry $inquiry)
    {
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function update(Request $request, Inquiry $inquiry)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(Inquiry::STATUSES))],
            'admin_notes' => 'nullable|string|max:5000',
        ]);
        $inquiry->update($data);
        return back()->with('success', 'Inquiry updated.');
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted.');
    }
}
