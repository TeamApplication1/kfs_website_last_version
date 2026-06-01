<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmergencyReportRequest;
use App\Models\Center;
use App\Models\CityVillage;
use App\Models\EmergencyReport;

class EmergencyReportController extends Controller
{
    public function create()
    {
        $centers = Center::where('is_active', true)->orderBy('sort_order')->get();
        $reportTypes = ['حريق', 'حادث مروري', 'تلوث بيئي', 'انهيار مبنى', 'تسريب غاز', 'انقطاع مرافق', 'أخرى'];

        return view('emergency.create', compact('centers', 'reportTypes'));
    }

    public function getVillages($centerId)
    {
        $villages = CityVillage::where('center_id', $centerId)
            ->where('is_active', true)
            ->orderBy('type')
            ->orderBy('sort_order')
            ->get(['id', 'name', 'type']);

        return response()->json($villages);
    }

    public function store(EmergencyReportRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('attachments')) {
            $paths = [];
            foreach ($request->file('attachments') as $file) {
                $paths[] = $file->store('emergency_reports', 'public');
            }
            $data['attachments'] = $paths;
        }

        $report = EmergencyReport::create($data);

        return back()->with('success', 'تم استلام بلاغك بنجاح! رقم المتابعة: ' . $report->id);
    }
}
