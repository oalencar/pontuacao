<?php

namespace App\Http\Controllers\Admin;

use App\Award;
use App\Models\Company;
use App\Models\Partner;
use App\Score;
use App\Services\AwardService;
use App\Services\CompanyService;
use App\Services\ScoreService;
use function foo\func;
use function GuzzleHttp\Promise\all;
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
     * @var CompanyService
     */
    private $companyService;

    /**
     * @var AwardService
     */
    private $awardService;

    /**
     * ScoresController constructor.
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
    ) {
        $this->partner = $partner;
        $this->company = $company;
        $this->score = $score;
        $this->scoreService = $scoreService;
        $this->award = $award;
        $this->companyService = $companyService;
        $this->awardService = $awardService;
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

        $orders = \App\Models\Order::get()->pluck('codigo', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
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


}
