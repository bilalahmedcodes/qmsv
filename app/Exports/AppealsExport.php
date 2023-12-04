<?php

namespace App\Exports;

use App\Models\VoiceAudit;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class AppealsExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $request = $this->request;
        $query = new VoiceAudit;

        $query->with('user', 'associate', 'campaign');

        $query = $query->has('appeal');

        $query = $query->whereHas('appeal', function ($query) use($request) {
            $query = $query->when($request, function ($query, $request) {
                $query->search($request);
            });
        });

        if ((in_array(Auth::user()->hrms_id, ['87223','238430','386433'])) && Auth::user()->campaign_id != 4) {
            $query = $query->where('project_id', 2);

        }
        if (in_array(Auth::user()->hrms_id, ['887913']) && Auth::user()->campaign_id != 4) {
            $query = $query->whereIn('campaign_id', [2, 3]);
        }
        if (in_array(Auth::user()->hrms_id, ['854157']) && Auth::user()->campaign_id != 4) {
            $query = $query->where('campaign_id', 3);
        }
        if (in_array(Auth::user()->hrms_id, ['566343']) && Auth::user()->campaign_id != 4) {
            $query = $query->where('campaign_id', 1);
        }

        /* elseif(in_array(Auth::user()->roles[0]->name, ['Team Lead', 'Manager', 'Associate']) && Auth::user()->campaign_id != 4){
            abort(403);
        } */


        $query = $query->when($request, function ($query, $request) {
            $query->search($request);
        });

        $voice_audits = $query->orderBy('id', 'desc')->get();

        return view('exports.appeals-export', [
            'voice_audits' => $voice_audits
        ]);
    }
}
