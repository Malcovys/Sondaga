<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSondageRequest;
use App\Models\Sondage;
use App\Models\Vote;
use Illuminate\Http\Request;

class SondageController extends Controller
{
    //tableau de sondages uniquement
    public function unserializeSondagesOptions($sondages){
        foreach($sondages as $sondage) {
            $sondage['options'] = unserialize($sondage['options']);
        }

        return $sondages;
    }

    public function createSondage(StoreSondageRequest $request) {
            $sondage = $request->validated();
            //il faut serialiser l'options
            $sondage['options'] = serialize($sondage['options']);

            $sondage = Sondage::create($sondage);
            $sondage = Sondage::with('votes')->find($sondage->id);

            $sondage->votes_number = $sondage->votes->count();
            $sondage->options = unserialize($sondage->options);

            event(new \App\Events\NewSondageEvent([$sondage]));
    }

    public function getSondagesWithVotes(Request $request)
    {
        $sondages = Sondage::with('votes')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($sondages as $sondage) {
            $sondage->votes_number = $sondage->votes->count();
            $sondage->is_have_voted = false; // Initialisez à false par défaut

            foreach ($sondage->votes as $vote) {
                if ($vote->user_id == $request->input('user_id')) {
                    $sondage->is_have_voted = true; // Si l'utilisateur a voté, définissez-le sur true
                    break; // Sortez de la boucle interne dès que vous trouvez un vote de l'utilisateur
                }
            }
        }
        return $this->unserializeSondagesOptions($sondages);
    }


    public function createVote(Request $request) {
        $vote = $request->validate([
            'user_id' => 'required',
            'option' => 'required',
            'sondage_id' => 'required',
        ]);

        Vote::create($vote);

        $sondage = Sondage::with('votes')->find($vote['sondage_id']);

        $sondage->votes_number = $sondage->votes->count();
        $sondage->options = unserialize($sondage->options);

        event(new \App\Events\VoteEvent([$sondage]));

    }

    public function removeSondage($id, $uid) {

       $userSondages =  Sondage::where('user_id', $uid)->get();
       $sondage = Sondage::find($id);

       foreach($userSondages as $sondageiItem) {
            if($sondageiItem->user_id == $sondage->user_id) {
                $sondage->delete();

                event(new \App\Events\RemoveSondageEvent($id));

                break;
            }
       }
    }
}
