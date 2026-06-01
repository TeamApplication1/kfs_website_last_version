<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComplaintRequest;
use App\Models\Complaint;
use App\Models\User;
use App\Notifications\NewComplaintNotification;
use Illuminate\Support\Facades\Notification;

class ComplaintController extends Controller
{
    public function create()
    {
        return view('complaints.create');
    }

    public function store(ComplaintRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('complaints', 'public');
        }

        $complaint = Complaint::create($data);

        $admins = User::role(['super_admin', 'مسئول المركز التكنولوجي'])->get();
        Notification::send($admins, new NewComplaintNotification($complaint));

        return back()->with(
            'success',
            'تم استلام شكواك بنجاح. رقم المتابعة الخاص بك هو: ' . $complaint->id
        );
    }
}
