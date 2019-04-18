<?php
/**
 * Created by PhpStorm.
 * User: oscaralencar
 * Date: 2019-03-22
 * Time: 22:23
 */

namespace App\Models\DTO;


use App\Award;
use App\Models\Company;
use App\Report;
use App\Score;

/**
 * Class ReportCompanyTop10DTO
 * @package App\Models\DTO
 */
class ReportCompanyTop10DTO
{

    /**
     * @var
     */
    private $partner;
    /**
     * @var
     */
    private $company;
    /**
     * @var
     */
    private $totalScore;
    /**
     * @var
     */
    private $awardScore;

    /**
     * ReportCompanyTop10DTO constructor.
     */
    public function __construct(Company $company, Partner $partner, Award $award, Score $score)
    {

    }
}
