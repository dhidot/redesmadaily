<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Presence;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PresenceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::all()->sortByDesc('data.is_end')->sortByDesc('data.is_start');
        // query all data from table attendances_position migration

        return view('presences.index', [
            "title" => "Daftar Form Presensi",
            "attendances" => $attendances
        ]);
    }

    public function show(Attendance $attendance)
    {
        $attendance->load(['positions', 'presences']);
        return view('presences.show', [
            "title" => "Data Detail Kehadiran",
            "attendance" => $attendance,
        ]);
    }

    public function showQrcode()
    {
        $code = request('code');
        $qrcode = $this->getQrCode($code);

        return view('presences.qrcode', [
            "title" => "Generate Absensi QRCode",
            "qrcode" => $qrcode,
            "code" => $code
        ]);
    }

    public function downloadQrCodePDF()
    {
        $code = request('code');
        $qrcode = $this->getQrCode($code);

        $html = '<img src="' . $qrcode . '" />';
        return Pdf::loadHTML($html)->setWarnings(false)->download('qrcode.pdf');
    }

    public function getQrCode(?string $code): string
    {
        if (!Attendance::query()->where('code', $code)->first())
            throw new NotFoundHttpException(message: "Tidak ditemukan absensi dengan code '$code'.");

        return parent::getQrCode($code);
    }

    // regenerate qr code


    public function notPresentIn(Attendance $attendance)
    {
        //only show employee with position same as attendance position
        $attendance->load(['positions', 'presences']);
        $byDate = now()->toDateString();
        if (request('display-by-date'))
            $byDate = request('display-by-date');

        $presences = Presence::query()
            ->where('attendance_id', $attendance->id)
            ->where('presence_date', $byDate)
            ->get(['presence_date', 'user_id']);

        // jika semua karyawan tidak hadir
        if ($presences->isEmpty()) {
            $notPresentData[] =
                [
                    "not_presence_date" => $byDate,
                    // get user with position same as attendance position
                    "users" => User::query()
                        ->with('position')
                        ->onlyEmployees()
                        ->where('position_id', $attendance->positions->pluck('id'))
                        ->get()
                        ->toArray()
                ];
        } else {
            $notPresentData = $this->getNotPresentInEmployees($presences, $attendance);
        }


        return view('presences.not-present-in', [
            "title" => "Data Karyawan Tidak Hadir",
            "attendance" => $attendance,
            "notPresentData" => $notPresentData,
        ]);
    }


    public function presentUserIn(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'user_id' => 'required|string|numeric',
            "presence_date" => "required|date"
        ]);

        $user = User::findOrFail($validated['user_id']);

        $presence = Presence::query()
            ->where('attendance_id', $attendance->id)
            ->where('user_id', $user->id)
            ->where('presence_date', $validated['presence_date'])
            ->first();

        // jika data user yang didapatkan dari request user_id, presence_date, sudah absen atau sudah ada ditable presences
        if ($presence || !$user)
            return back()->with('failed', 'Request tidak diterima.');

        Presence::create([
            "attendance_id" => $attendance->id,
            "user_id" => $user->id,
            "presence_date" => $validated['presence_date'],
            "presence_enter_time" => now()->toTimeString(),
            "presence_out_time" =>  /*now + 8 hours*/ now()->addHours(8)->toTimeString(),
            "presence_status" => "Hadir"
        ]);

        return back()
            ->with('success', "Berhasil menyimpan data hadir atas nama \"$user->name\".");
    }


    private function getNotPresentInEmployees($presences, $attendance)
    {

        $uniquePresenceDates = $presences->unique("presence_date")->pluck('presence_date');
        $uniquePresenceDatesAndCompactTheUserIds = $uniquePresenceDates->map(function ($date) use ($presences) {
            return [
                "presence_date" => $date,
                "user_ids" => $presences->where('presence_date', $date)->pluck('user_id')->toArray()
            ];
        });

        // get user with position same as attendance position
        $notPresentData = [];
        foreach ($uniquePresenceDatesAndCompactTheUserIds as $presence) {
            $notPresentData[] =
                [
                    "not_presence_date" => $presence['presence_date'],
                    "users" => User::query()
                        ->with('position')
                        ->onlyEmployees()
                        ->where('position_id', $attendance->positions->pluck('id'))
                        ->whereNotIn('id', $presence['user_ids'])
                        ->get()
                        ->toArray()
                ];
        }
        return $notPresentData;
    }
}
