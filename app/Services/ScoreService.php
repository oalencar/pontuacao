<?php

namespace App\Services;

use App\Award;
use App\Models\Partner;
use App\Models\Score;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ScoreService
{
    /**
     * ScoreService constructor.
     */
    public function __construct(
        Partner $partner,
        Score $score
    ) {
        $this->partner = $partner;
        $this->score = $score;
    }

    /**
     * Return All Scores From A Partner
     *
     * @param Partner
     * @return array Score
     */
    public function getAllScoresFromPartner($partner)
    {
        if (!$partner) {
            abort(500, 'Necessário passar Parceiro para getAllScoresFromPartner');
        }
        return $this->score::with('order')->where('partner_id', $partner->partner_ids)->get();
    }

    /**
     * Return All Scores From A Partner
     *
     * @param Partner
     * @return array Score
     */
    public function getAllScoresFromPartnerWithOrder($partner)
    {
        if (!$partner) {
            abort(500, 'Necessário passar Parceiro para getAllScoresFromPartner');
        }
        return $this->score::with('order')
            ->where('partner_id', $partner->id)
            ->get()
            ->filter(function ($score){
                return $score->order != null;
            });
    }

    /**
     * @param $scores array Score
     * @param $award Award
     * @return array Score
     */
    public function filterPartnerScoresOfAward($scores, $award)
    {
        if (!$award) {
            abort(500, 'Necessário passar Award para filterScoresOfAward');
        }

        return $scores->filter(function($item) use ($award) {
            $orderStartDate = Carbon::createFromFormat(config('app.date_format'), $item->order->start_date);
            $awardStartDate = Carbon::createFromFormat(config('app.date_format'), $award->start_date);
            $awardFinishDate = Carbon::createFromFormat(config('app.date_format'), $award->finish_date);

            return $orderStartDate->between($awardStartDate, $awardFinishDate);
        });
    }

    /**
     * @param $scores Score[]|Collection
     * @param $awards Award[]|Collection
     * @return array Score
     */
    public function filterPartnerScoresOfAwards($scores, $awards)
    {
        if (!$awards) {
            abort(500, 'Necessário passar Awards para filterScoresOfAward');
        }

        return $awards->map(function($award) use ($scores) {

            return $scores->filter(function($score) use ($award) {

                $orderStartDate = Carbon::createFromFormat(config('app.date_format'), $score->order->start_date);
                $awardStartDate = Carbon::createFromFormat(config('app.date_format'), $award->start_date);
                $awardFinishDate = Carbon::createFromFormat(config('app.date_format'), $award->finish_date);

                return $orderStartDate->between($awardStartDate, $awardFinishDate);
            });
        });

    }

    /**
     * @param $scores array Score
     * @return int
     */
    public function sumOfScores($scores)
    {
        if (!$scores) {
            abort(500, 'Necessário passar score para sumOfScores');
        }
        return $scores->sum('score');
    }


    /**
     * @param $goal
     * @param int $score
     * @return int
     */
    public function getPercentReachedGoal($goal, $score)
    {
        if ($score === null) {
            abort(500, 'Necessário passar $score para sumOfScores');
        }
        $resultado = intval(($score/$goal)*100);
        if ($resultado > 100) return 100;
        return $resultado;
    }


    /**
     * Formata pontuação para XXX.XXXs
     * @param $numero
     * @return string
     */
    public function formataPontuacao($numero) {
        return number_format($numero,0,'','.');
    }
}
