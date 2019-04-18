<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\Partner;
use App\Models\PartnerType;
use App\Score;
use App\Services\PartnerService;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePartnersRequest;
use App\Http\Requests\Admin\UpdatePartnersRequest;

define("PARTNER_ROLE_ID", 3);

/**
 * Class PartnersController
 * @package App\Http\Controllers\Admin
 */
class PartnersController extends Controller
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
     * @var User
     */
    private $user;
    /**
     * @var PartnerType
     */
    private $partnerType;

    /**
    * @var Score
    */
    private $score;

    /**
     * @var PartnerService
     */
    private $partnerService;

    /**
     * PartnersController constructor.
     */
    public function __construct(
        Partner $partner,
        Company $company,
        User $user,
        PartnerType $partnerType,
        Score $score,
        PartnerService $partnerService
    )
    {
        $this->partner = $partner;
        $this->company = $company;
        $this->user = $user;
        $this->partnerType = $partnerType;
        $this->score = $score;
        $this->partnerService = $partnerService;
    }

    /**
     * Display a listing of Partner.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('partner_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('partner_delete')) {
                return abort(401);
            }
            $partners = $this->partner::onlyTrashed()->get();
        } else {
            $partners = $this->partner::all();
        }

        return view('admin.partners.index', compact('partners'));
    }

    /**
     * Show the form for creating new Partner.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('partner_create')) {
            return abort(401);
        }

        $users = $this->user::where('role_id', PARTNER_ROLE_ID)->get();

        $partner_types = $this->partnerType::get();

        $partner_role_id = PARTNER_ROLE_ID;

        return view('admin.partners.create', compact('users', 'partner_types', 'partner_role_id'));
    }

    /**
     * Store a newly created Partner in storage.
     *
     * @param  \App\Http\Requests\Admin\StorePartnersRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePartnersRequest $request)
    {
        if (! Gate::allows('partner_create')) {
            return abort(401);
        }
        try {
            $user = $this->user::where('email', $request->get('email'))->get();

            if (count($user) > 0) {
                $newUser = $user[0];
            } else {
                $newUser = $this->user::create($request->all());

            }
        }
        catch (\Exception $e){
             return $e;
        }

        $partner_type = $this->partnerType::find($request->get('partner_type_id'));

        $partnerData = [
            'partner_type_id' => $request->get('partner_type_id'),
            'user_id' => $newUser->id,
            'company_id' => $partner_type->company_id
        ];

        $partner = $this->partner::create($partnerData);

        return redirect()->route('admin.partners.index');
    }


    /**
     * Show the form for editing Partner.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('partner_edit')) {
            return abort(401);
        }

        $partner = $this->partner::findOrFail($id);

        $partner_types = $this->partnerType::get();

        $partner_role_id = PARTNER_ROLE_ID;

        return view('admin.partners.edit', compact('partner', 'partner_types', 'partner_role_id'));
    }

    /**
     * Update Partner in storage.
     *
     * @param UpdatePartnersRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePartnersRequest $request, $id)
    {
        if (! Gate::allows('partner_edit')) {
            return abort(401);
        }

        $partner = $this->partner::findOrFail($id);

        try {
            $partner->user()->update($request->all());
        }
        catch (QueryException $e){
            return 'erro ao criar usuário';
        }


        $partner->update($request->except('company_id'));

        return redirect()->route('admin.partners.index');
    }


    /**
     * Display Partner.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('partner_view')) {
            return abort(401);
        }
        $partner = $this->partner::findOrFail($id);

        return view('admin.partners.show', compact('partner'));
    }


    /**
     * Remove Partner from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        if (! Gate::allows('partner_delete')) {
            return abort(401);
        }

        $partner = $this->partner::findOrFail($id);
        $partner->delete();
        $this->partnerService->deleteAllPartnerScores($partner);
        $partner->user()->delete();

        return redirect()->route('admin.partners.index');
    }

    /**
     * Delete all selected Partner at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('partner_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = $this->partner::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Partner from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('partner_delete')) {
            return abort(401);
        }
        $partner = $this->partner::onlyTrashed()->findOrFail($id);
        $partner->restore();

        return redirect()->route('admin.partners.index');
    }

    /**
     * Permanently delete Partner from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('partner_delete')) {
            return abort(401);
        }
        $partner = $this->partner::onlyTrashed()->findOrFail($id);
        $partner->forceDelete();

        return redirect()->route('admin.partners.index');
    }
}
