<?php
namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Request;
use Session;

use Ds3\Contracts\SleepLabInterface;
use Ds3\Contracts\PatientInterface;

use Ds3\Libraries\GeneralFunctions;

class SleeplabController extends Controller
{
    private $request;
    private $delid;
    private $sleepLab;
    private $sleepLabs;
    private $page;
    private $contacttype;
    private $sort;
    private $sortdir;

    public function __construct(
        SleepLabInterface $sleepLab,
        PatientInterface $patient
    ) {
        $this->sleepLab     = $sleepLab;
        $this->patient      = $patient;

        $this->request      = Request::all();
        $this->delid        = GeneralFunctions::getRouteParameter('delid');
        $this->page         = GeneralFunctions::getRouteParameter('page');
        $this->contacttype  = GeneralFunctions::getRouteParameter('contacttype');
        $this->letter       = GeneralFunctions::getRouteParameter('letter');
        $this->sort         = GeneralFunctions::getRouteParameter('sort');
        $this->sortdir      = GeneralFunctions::getRouteParameter('sortdir');
    }

    public function index()
    {
        $letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

        foreach ($this->request as $name => $value) {
            $data[$name] = $value;
        }

        if (!empty($this->delid)) {
            $this->sleepLab->deleteData($this->delid);

            $message = 'Deleted Successfully';
            return redirect('/manage/sleeplab')->with('message', $message);
        }

        $sleepLabs = $this->sleepLab->getSleeplabs(array('docid' => Session::get('docId')));

        foreach ($sleepLabs as $sleepLab) {
            $patients = $this->patient->getSleepLab($sleepLab->sleeplabid);
            $amountOfPatients = count($patients);
        }

        /*$recDisp = 20;

        if (!empty($this->page)) {
            $indexVal = $this->page;
        } else {
            $indexVal = 0;
        }

        $iVal = $indexVal * $recDisp;
        $contactTypeHolder = !empty($this->contacttype) ? $this->contacttype : '';

        if (isset($this->letter)) {
            $letter = $this->letter;
        } else {
            $letter = null;
        }

        if (!empty($this->sort)) {
            switch ($this->sort) {
                case 'company':
                    $order = array('company' => $this->sortdir);
                    break;
                case 'type':
                    $order = array('dct.contacttype' => $this->sortdir);
                    break;
                default:
                    $order = array(
                        'lastname'  => $this->sortdir,
                        'firstname' => $this->sortdir
                    );
                    break;
            }
        } else {
            $order = null;
        }*/
        $data = array_merge($data, array(
            'message'       => !empty($message) ? $message : '',
            'letters'       => $letters,
            'sleepLab'      => $sleepLab
        ));

        return view('manage.sleep_lab', $data);
    }
}
