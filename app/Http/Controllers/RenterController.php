<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class RenterController extends Controller
{
    public function dashboard()
    {
        $this->authorizeRenter();

        $reports = Report::with('property')
            ->where('reporter_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('renter.dashboard', compact('reports'));
    }

    public function storeComplaint(Request $request)
    {
        $this->authorizeRenter();

        $data = $request->validate([
            'subject_type' => 'required|in:owner,tenant',
            'subject_name' => 'required|string|max:150',
            'subject_contact' => 'nullable|string|max:120',
            'type' => 'required|in:behavior,fraud,harassment,other',
            'details' => 'required|string|max:3000',
        ]);

        Report::create($data + [
            'reporter_id' => auth()->id(),
            'status' => 'open',
        ]);

        return redirect()->to(route('renter.dashboard') . '#complaints')
            ->with('success', __('تم إرسال الشكوى إلى فريق الإدارة للمراجعة.'));
    }

    private function authorizeRenter(): void
    {
        abort_unless(auth()->check() && in_array(auth()->user()->role, ['tenant', 'renter'], true), 403);
    }
}
