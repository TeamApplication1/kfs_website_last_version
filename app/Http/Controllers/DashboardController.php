<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ContactMessage;
use App\Models\EmergencyReport;
use App\Models\Enrollment;
use App\Models\GisSubmission;
use App\Models\ServiceSubmission;
use App\Models\Suggestion;
use App\Models\TrainingApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $data = $this->getAllData();
        $data['chartData'] = $this->getChartData($data['userId'], $data['nationalId']);
        $data['activeNav'] = 'overview';

        return view('citizen.dashboard.index', $data);
    }

    public function services()
    {
        $data = $this->getAllData();
        $data['activeNav'] = 'services';

        return view('citizen.dashboard.services', $data);
    }

    public function gis()
    {
        $data = $this->getAllData();
        $data['activeNav'] = 'gis';

        return view('citizen.dashboard.gis', $data);
    }

    public function estidama()
    {
        $data = $this->getAllData();
        $data['activeNav'] = 'estidama';

        return view('citizen.dashboard.estidama', $data);
    }

    public function monitoring()
    {
        $data = $this->getAllData();
        $data['activeNav'] = 'monitoring';

        return view('citizen.dashboard.monitoring', $data);
    }

    public function fulfillment()
    {
        $data = $this->getAllData();
        $data['activeNav'] = 'fulfillment';

        return view('citizen.dashboard.fulfillment', $data);
    }

    public function show($id)
    {
        $submission = ServiceSubmission::with('service')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('citizen.submissions.show', compact('submission'));
    }

    private function getAllData(): array
    {
        $user = Auth::user();
        $nationalId = $user->national_id;
        $userEmail = $user->email;
        $userId = $user->id;

        $complaints = Complaint::where('national_id', $nationalId)->latest()->get();
        $suggestions = Suggestion::where('national_id', $nationalId)->latest()->get();
        $serviceSubmissions = ServiceSubmission::where('user_id', $userId)->with('service')->latest()->get();
        $gisSubmissions = GisSubmission::where('user_id', $userId)->with('subService')->latest()->get();
        $enrollments = Enrollment::where('user_id', $userId)->with('trainingProgram')->latest()->get();
        $trainingApplications = TrainingApplication::where('national_id', $nationalId)->with('trainingProgram')->latest()->get();
        $contactMessages = ContactMessage::where('email', $userEmail)->latest()->get();
        $emergencyReports = EmergencyReport::where('reporter_national_id', $nationalId)->latest()->get();
        $fulfillmentItems = $this->getUserFulfillments($userId);
        $stats = $this->getStats($serviceSubmissions, $gisSubmissions, $enrollments, $trainingApplications, $complaints, $suggestions, $contactMessages, $emergencyReports);

        return [
            'user' => $user,
            'nationalId' => $nationalId,
            'userId' => $userId,
            'complaints' => $complaints,
            'suggestions' => $suggestions,
            'serviceSubmissions' => $serviceSubmissions,
            'gisSubmissions' => $gisSubmissions,
            'enrollments' => $enrollments,
            'trainingApplications' => $trainingApplications,
            'contactMessages' => $contactMessages,
            'emergencyReports' => $emergencyReports,
            'fulfillmentItems' => $fulfillmentItems,
            'fulfillmentCount' => $fulfillmentItems->count(),
            'stats' => $stats,
        ];
    }

    private function getStats($serviceSubmissions, $gisSubmissions, $enrollments, $trainingApplications, $complaints, $suggestions, $contactMessages, $emergencyReports): array
    {
        return [
            'services' => $serviceSubmissions->count(),
            'gis' => $gisSubmissions->count(),
            'estidama' => $enrollments->count() + $trainingApplications->count(),
            'complaints' => $complaints->count(),
            'suggestions' => $suggestions->count(),
            'contactMessages' => $contactMessages->count(),
            'emergencyReports' => $emergencyReports->count(),
        ];
    }

    private function getUserFulfillments($userId): Collection
    {
        $items = collect();

        ServiceSubmission::where('user_id', $userId)
            ->with('service')
            ->latest()
            ->get()
            ->each(function ($item) use ($items) {
                $action = match ($item->status) {
                    'pending' => 'مراجعة بيانات',
                    'awaiting_payment' => 'دفع رسوم',
                    'paid' => 'مكتمل',
                    'completed' => 'مكتمل',
                    'rejected' => 'إعادة تقديم',
                    default => '—',
                };
                if ($action !== 'مكتمل' && $action !== '—') {
                    $items->push((object) [
                        'id' => $item->id,
                        'source' => 'خدمة عامة',
                        'type' => 'service',
                        'reference' => $item->service?->name ?? '#' . $item->id,
                        'status' => $item->status,
                        'fulfillment_action' => $action,
                        'fulfillment_status' => $item->fulfillment_status,
                        'fulfillment_action_type' => $item->fulfillment_action,
                        'fulfillment_reason' => $item->fulfillment_reason,
                        'fulfillment_data_fields' => $item->fulfillment_data_fields,
                        'created_at' => $item->created_at,
                    ]);
                }
            });

        GisSubmission::where('user_id', $userId)
            ->with('subService')
            ->latest()
            ->get()
            ->each(function ($item) use ($items) {
                $action = match ($item->status) {
                    'received' => 'مراجعة بيانات',
                    'processing' => $item->payment_status === 'paid' ? 'مستندات ناقصة' : 'دفع رسوم',
                    'completed' => 'مكتمل',
                    'rejected' => 'إعادة تقديم',
                    default => '—',
                };
                if ($action !== 'مكتمل' && $action !== '—') {
                    $items->push((object) [
                        'id' => $item->id,
                        'source' => 'خدمات مكانية',
                        'type' => 'gis',
                        'reference' => $item->subService?->name ?? '#' . $item->id,
                        'status' => $item->status,
                        'fulfillment_action' => $action,
                        'fulfillment_status' => $item->fulfillment_status,
                        'fulfillment_action_type' => $item->fulfillment_action,
                        'fulfillment_reason' => $item->fulfillment_reason,
                        'fulfillment_data_fields' => $item->fulfillment_data_fields,
                        'created_at' => $item->created_at,
                    ]);
                }
            });

        return $items->sortByDesc('created_at');
    }

    private function getChartData($userId, $nationalId): array
    {
        $days = collect(range(6, 0))->map(fn($i) => now()->subDays($i)->format('Y-m-d'));

        $serviceData = $days->map(fn($day) =>
            ServiceSubmission::where('user_id', $userId)->whereDate('created_at', $day)->count()
        );

        $gisData = $days->map(fn($day) =>
            GisSubmission::where('user_id', $userId)->whereDate('created_at', $day)->count()
        );

        $complaintsData = $days->map(fn($day) =>
            Complaint::where('national_id', $nationalId)->whereDate('created_at', $day)->count()
        );

        return [
            'labels' => $days->map(fn($day) => now()->parse($day)->format('d/m'))->values()->toArray(),
            'services' => $serviceData->values()->toArray(),
            'gis' => $gisData->values()->toArray(),
            'complaints' => $complaintsData->values()->toArray(),
        ];
    }
}
