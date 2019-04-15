<?php

namespace App\Http\Controllers\Admin;

use App\Award;
use App\Company;
use App\Partner;
use App\Score;
use App\Services\AwardService;
use App\Services\CompanyService;
use App\Services\ScoreService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{


    /**
     * @var Partner
     */
    private $partner;
    /**
     * @var Company
     */
    private $company;
    /**
     * @var Score
     */
    private $score;
    /**
     * @var ScoreService
     */
    private $scoreService;
    /**
     * @var Award
     */
    private $award;

    /**
     * @var CompanyService
     */
    private $companyService;

    /**
     * @var AwardService
     */
    private $awardService;


    /**
     * ReportsController constructor.
     * @param Company $company
     * @param Partner $partner
     * @param Score $score
     * @param ScoreService $scoreService
     * @param Award $award
     * @param CompanyService $companyService
     * @param AwardService $awardService
     */
    public function __construct(
        Company $company,
        Partner $partner,
        Score $score,
        ScoreService $scoreService,
        Award $award,
        CompanyService $companyService,
        AwardService $awardService
    )
    {
        $this->partner = $partner;
        $this->company = $company;
        $this->score = $score;
        $this->scoreService = $scoreService;
        $this->award = $award;
        $this->companyService = $companyService;
        $this->awardService = $awardService;
    }

    /**
     * Display report scores.
     *
     * @return \Illuminate\Http\Response
     */
    public function report()
    {
        if (!Gate::allows('score_access')) {
            return abort(401);
        }

        $companies = $this->company->all();
        $partners = $this->partner::with('user')->get();

        return view('admin.scores.report.index', compact('companies', 'partners'));

    }

    public function reportByCompanyName(Request $request)
    {

        $companyId = $request->get('company');

        if (!$companyId) {
            return abort(400, 'Necessário informar o id da empresa');
        }

        $companies = $this->company->get();
        $company = $this->company->find($companyId);
        $awards = $company->awards()->get();

        $awards->map(function ($award, $key) {
            $partners = $this->partner::with('user')->where('partner_type_id', $award->partner_type_id)->get();

            $partners->map(function ($partner) use ($award) {
                $scores = $this->scoreService->getAllScoresFromPartner($partner);

                $scoresFiltereds = $this->scoreService->filterPartnerScoresOfAward($scores, $award);

                $partner->totalScore = $this->scoreService->sumOfScores($scoresFiltereds);
                $partner->scores = $scoresFiltereds;
            });

            $award->partners = $partners;
        });

        return view('admin.scores.report.company',
            ['companies' => $companies, 'company' => $company, 'awards' => $awards]);

    }

    public function reportDetail($id, $company_id)
    {
        if (!Gate::allows('score_view')) {
            return abort(401);
        }

        $company = $this->company::findOrFail($company_id);

        $partner = $this->partner::with('user')->findOrFail($id);

        $scores = $this->scoreService->getAllScoresFromPartner($partner);

        return view('admin.scores.report.detail', compact('partner', 'scores', 'company'));
    }

    public function reportPartnerDetail($id)
    {

        if (!Gate::allows('score_view')) {
            return abort(401);
        }

        $partner = $this->partner::with('user', 'company', 'partner_type')->findOrFail($id);

        $scores = $this->scoreService->getAllScoresFromPartnerWithOrder($partner);

        $allAwards = $this->award::with('partner_types')->get();

        $awards = $allAwards->filter(function ($award) use ($partner) {
            $partner_types = collect($award->partner_types);
            return $partner_types->contains(function ($partner_type) use ($partner) {
                return $partner_type->id == $partner->partner_type->id;
            });
        });

        return view('admin.scores.report.partnerDetail',
            compact('partner', 'scores', 'awards')
        );
    }

    public function reportPartnerAwardDetail($id, $id_award)
    {

        if (!Gate::allows('score_view')) {
            return abort(401);
        }

        $partner = $this->partner::with('user', 'company', 'partner_type')->findOrFail($id);

        $award = $this->award::findOrFail($id_award);

        $allScores = $this->scoreService->getAllScoresFromPartner($partner);

        $scores = $this->scoreService->filterPartnerScoresOfAward($allScores, $award);

        return view('admin.scores.report.partnerAwardDetail',
            compact('partner', 'scores', 'award')
        );
    }

    public function reportCompanyTop10()
    {
        $companies = $this->company::all();

        return view('admin.scores.report.companyTop10.index',
            compact('companies')
        );
    }

    public function reportCompanyTop10Detail($empresa_id)
    {
        $company = $this->company::findOrFail($empresa_id);
        $partners = $this->partner::with('scores')->where('company_id', $company->id)->get();
        $awards = $this->companyService->getAwards($company);


        return view('admin.scores.report.companyTop10.detail')
            ->with(['company' => $company,
                'awards' => $awards,
                'partners' => $partners,
                'awardService' => $this->awardService,
                'scoreService' => $this->scoreService
            ]);
    }

    public function reportAwardIndex()
    {

    }
}
