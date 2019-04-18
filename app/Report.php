<?php

namespace App;

use App\Models\Company;
use App\Partner;
use App\Award;
use App\Score;
use App\Services\ScoreService;


/**
 * Class ReportCompanyTop10
 * @package App
 */
class Report
{

    /**
     * @var Company
     */
    private $company;
    /**
     * @var Partner
     */
    private $partners;
    /**
     * @var Award
     */
    private $awards;
    /**
     * @var Score
     */
    private $scores;
    /**
     * @var ScoreService
     */
    private $scoreService;

    /**
     * ReportCompanyTop10 constructor.
     * @param Company $company
     * @param \App\Partner $partners
     * @param \App\Models\Award $awards
     * @param \App\Score $scores
     * @param ScoreService $scoreService
     */
    public function __construct(Company $company, Partner $partners, Award $awards, Score $scores, ScoreService $scoreService)
    {
        $this->company = $company;
        $this->partners = $partners;
        $this->awards = $awards;
        $this->scores = $scores;
        $this->scoreService = $scoreService;
    }

    /**
     * @return \App\Models\Company
     */
    public function getCompany(): \App\Models\Company
    {
        return $this->company;
    }

    /**
     * @param \App\Models\Company $company
     */
    public function setCompany(\App\Models\Company $company): void
    {
        $this->company = $company;
    }

    /**
     * @return \App\Partner
     */
    public function getPartners(): \App\Partner
    {
        return $this->partners;
    }

    /**
     * @param \App\Partner $partners
     */
    public function setPartners(\App\Partner $partners): void
    {
        $this->partners = $partners;
    }

    /**
     * @return \App\Models\Award
     */
    public function getAwards(): \App\Models\Award
    {
        return $this->awards;
    }

    /**
     * @param \App\Models\Award $awards
     */
    public function setAwards(\App\Models\Award $awards): void
    {
        $this->awards = $awards;
    }

    /**
     * @return \App\Score
     */
    public function getScores(): \App\Score
    {
        return $this->scores;
    }

    /**
     * @param \App\Score $scores
     */
    public function setScores(\App\Score $scores): void
    {
        $this->scores = $scores;
    }

    /**
     * @return ScoreService
     */
    public function getScoreService(): ScoreService
    {
        return $this->scoreService;
    }

    /**
     * @param ScoreService $scoreService
     */
    public function setScoreService(ScoreService $scoreService): void
    {
        $this->scoreService = $scoreService;
    }
}
