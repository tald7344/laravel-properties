<?php
namespace App\Http\Controllers;
use App\Models\Report;
class AdminComplaintsController extends Controller { private function admin(){abort_unless(auth()->check()&&auth()->user()->role==='admin',403);} public function index(){$this->admin();$reports=Report::with(['property','reporter'])->latest()->paginate(20);return view('admin.complaints',compact('reports'));} public function show(Report $report){$this->admin();$report->load(['property','reporter']);return view('admin.complaint-show',compact('report'));} public function resolve(Report $report){$this->admin();$report->update(['status'=>'resolved']);return back()->with('success','تم تحديث البلاغ.');} }
