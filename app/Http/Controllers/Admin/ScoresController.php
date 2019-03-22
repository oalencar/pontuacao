<?php

namespace App\Http\Controllers\Admin;

use App\Award;
use App\Company;
use App\Partner;
use App\Score;
use App\Services\ScoreService;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreScoresRequest;
use App\Http\Requests\Admin\UpdateScoresRequest;

class ScoresController extends Controller
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
     * ScoresController constructor.
     * @param Company $company
     * @param Partner $partner
     * @param Score $score
     * @param ScoreService $scoreService
     * @param Award $award
     */
    public function __construct(
        Company $company,
        Partner $partner,
        Score $score,
        ScoreService $scoreService,
        Award $award
    ) {
        $this->partner = $partner;
        $this->company = $company;
        $this->score = $score;
        $this->scoreService = $scoreService;
        $this->award = $award;
    }


    /**
     * Display a listing of Score.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('score_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('score_delete')) {
                return abort(401);
            }
            $scores = Score::onlyTrashed()->get();
        } else {
            $scores = Score::all();
        }

        return view('admin.scores.index', compact('scores'));
    }

    /**
     * Show the form for creating new Score.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('score_create')) {
            return abort(401);
        }

        $orders = \App\Order::get()->pluck('codigo', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $users = \App\User::get()->pluck('email', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.scores.create', compact('orders', 'users'));
    }

    /**
     * Store a newly created Score in storage.
     *
     * @param  \App\Http\Requests\StoreScoresRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreScoresRequest $request)
    {
        if (! Gate::allows('score_create')) {
            return abort(401);
        }
        $score = Score::create($request->all());



        return redirect()->route('admin.scores.index');
    }


    /**
     * Display Score.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('score_view')) {
            return abort(401);
        }
        $score = Score::findOrFail($id);

        return view('admin.scores.show', compact('score'));
    }


    /**
     * Remove Score from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('score_delete')) {
            return abort(401);
        }
        $score = Score::findOrFail($id);
        $score->delete();

        return redirect()->route('admin.scores.index');
    }

    /**
     * Delete all selected Score at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('score_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Score::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Score from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('score_delete')) {
            return abort(401);
        }
        $score = Score::onlyTrashed()->findOrFail($id);
        $score->restore();

        return redirect()->route('admin.scores.index');
    }

    /**
     * Permanently delete Score from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('score_delete')) {
            return abort(401);
        }
        $score = Score::onlyTrashed()->findOrFail($id);
        $score->forceDelete();

        return redirect()->route('admin.scores.index');
    }

    /**
     * Display report scores.
     *
     * @return \Illuminate\Http\Response
     */
    public function report()
    {
        if (! Gate::allows('score_access')) {
            return abort(401);
        }

        $companies = $this->company->all();
        $partners = $this->partner::with('user')->get();

        return view('admin.scores.report.index', compact('companies', 'partners'));

    }

    public function reportByCompanyName(Request $request) {

        $companyId = $request->get('company');

        if (!$companyId) {
            return abort(400, 'Necessário informar o id da empresa');
        }

        $companies = $this->company->get();
        $company = $this->company->find($companyId);
        $awards = $company->awards()->get();

        $awards->map(function ($award, $key) {
            $partners = $this->partner::with('user')->where('partner_type_id', $award->partner_type_id)->get();

            $partners->map(function($partner) use ($award) {
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
        if (! Gate::allows('score_view')) {
            return abort(401);
        }

        $company = $this->company::findOrFail($company_id);

        $partner = $this->partner::with('user')->findOrFail($id);

        $scores = $this->scoreService->getAllScoresFromPartner($partner);

        return view('admin.scores.report.detail', compact('partner', 'scores', 'company'));
    }

    public function reportPartnerDetail($id) {

        if (! Gate::allows('score_view')) {
            return abort(401);
        }

        $partner = $this->partner::with('user', 'company', 'partner_type')->findOrFail($id);

        $scores = $this->scoreService->getAllScoresFromPartnerWithOrder($partner);

        $allAwards = $this->award::with('partner_types')->get();

        $awards = $allAwards->filter( function ($award) use ($partner) {
            $partner_types = collect($award->partner_types);
            return $partner_types->contains(function ($partner_type) use ($partner) {
                return $partner_type->id == $partner->partner_type->id;
            } );
        });

        return view('admin.scores.report.partnerDetail',
            compact('partner', 'scores', 'awards')
        );
    }

    public function reportPartnerAwardDetail($id, $id_award) {

        if (! Gate::allows('score_view')) {
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
}
