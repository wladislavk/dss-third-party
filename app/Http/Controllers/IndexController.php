<?php namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;

use Ds3\Contracts\UserInterface;
use Ds3\Contracts\DocumentCategoryInterface;
use Ds3\Contracts\MemoAdminInterface;

use Ds3\Libraries\Constants;

class IndexController extends Controller
{
    private $user;
    private $documentCategory;
    private $memoAdmin;
    private $request;

    public function __construct(UserInterface $user, DocumentCategoryInterface $documentCategory, MemoAdminInterface $memoAdmin)
    {
        $this->user = $user;
        $this->documentCategory = $documentCategory;
        $this->memoAdmin = $memoAdmin;
        $this->request = Request::all();
    }

    public function index()
    {
        $user = $this->user->findUser(Session::get('docId'));

        if ($user->homepage != '1') {
            return redirect('/manage/index2');
        }

        $showBlock = array();

        if (Request::server()['SERVER_NAME'] == 'stage.dss-rh.xforty.com') {
            $showBlock['timerLong'] = true;
        }

        if (Session::get('docId') == Session::get('userId') || $user->manage_staff == 1) {
            $showBlock['invoices'] = true;
            $showBlock['transactionCode'] = true;
        }

        $documentCategories = $this->documentCategory->get();

        if ($user->use_eligible_api == 1) {
            $showBlock['enrollments'] = true;
        }

        if (Session::get('docId') == Session::get('userId')) {
            if ($user->use_course == 1) {
                $showBlock['edxLogin'] = true;
            }
        } else {
            $courseJoin = $this->user->getCourseJoin(Session::get('userId'));

            if ($courseJoin['use_course'] == 1 && $courseJoin['use_course_staff'] == 1) {
                $showBlock['edxLogin'] = true;
            }
        }

        $numPortal = $this->request['numPatientContacts'] + $this->request['numPatientInsurance'] + $this->request['numC'];
        
        if ($this->request['useLetters'] && Session::get('userType') == Constants::DSS_USER_TYPE_SOFTWARE) {
            $showBlock['unmailedLetters'] = true;
        }
        
        switch (Session::get('userType')) {
            case Constants::DSS_USER_TYPE_SOFTWARE:
                $showBlock['pendingNodssClaims'] = true;
                $showBlock['unmailedClaims'] = true;
                break;
            case Constants::DSS_USER_TYPE_FRANCHISEE:
                $showBlock['pendingClaims'] = true;
                $showBlock['operationsManual'] = true;
                break;
            default:
                break;
        }

        $numAlerts = $this->request['numRejectedPreauth'];

        $memoAdmins = $this->memoAdmin->get();

        $data = array();

        foreach ($this->request as $name => $value) {
            $data[$name] = $value;
        }

        $data = array_merge($data, array(
            'path'                  => Request::path(),
            'showBlock'             => $showBlock,
            'documentCategories'    => $documentCategories,
            'numPortal'             => $numPortal,
            'numAlerts'             => $numAlerts,
            'memoAdmins'            => $memoAdmins,
            'username'              => Session::get('username'),
            'hstStatusLabel'        => Constants::$dss_hst_status_labels[Constants::DSS_HST_REJECTED],
            'DSS_HST_REJECTED'      => Constants::DSS_HST_REJECTED,
            'DSS_HST_SCHEDULED'     => Constants::DSS_HST_SCHEDULED,
            'DSS_PREAUTH_COMPLETE'  => Constants::DSS_PREAUTH_COMPLETE,
            'DSS_HST_COMPLETE'      => Constants::DSS_HST_COMPLETE,
            'DSS_HST_REQUESTED'     => Constants::DSS_HST_REQUESTED,
            'DSS_PREAUTH_REJECTED'  => Constants::DSS_PREAUTH_REJECTED
        ));

        // dd($data);

        return view('manage.index', $data);
     }
}
