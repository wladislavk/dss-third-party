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
        $this->letter       = GeneralFunctions::getRouteParameter('letter');
        $this->sort         = GeneralFunctions::getRouteParameter('sort');
        $this->sortdir      = GeneralFunctions::getRouteParameter('sortdir');
    }

    public function index()
    {
        $letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

        $patientsInfo = array();

        if (!empty($this->delid)) {
            $this->sleepLab->deleteData($this->delid);

            $message = 'Deleted Successfully';
            return redirect('/manage/sleeplab')->with('message', $message);
        }

        $recDisp = 20;

        if (!empty($this->page)) {
            $indexVal = $this->page;
        } else {
            $indexVal = 0;
        }

        $iVal = $indexVal * $recDisp;

        if (!empty($this->letter)) {
            $letter = $this->letter;
        } else {
            $letter = null;
        }

        if (!empty($this->sort)) {
            if($this->sort == 'lab') {
                $order = 'company';
                $dir = 'DESC';
            } else {
                $order = 'lastname';
                $dir = 'DESC';
            }
        } else {
            $dir = 'ASC';
            $order = 'company';
        }

        $sleepLabs = $this->sleepLab->getSleepLabTypeHolder(array('docid' => Session::get('docId')), $letter, $order, $dir, $recDisp, $indexVal);

        foreach ($sleepLabs as $sleepLab) {
            $patients = $this->patient->getSleepLab($sleepLab->sleeplabid);
            $patientsInfo[$sleepLab->sleeplabid]['pat'] = $patients;
        }

        $totalRec = count($sleepLabs);

        $noPages = $totalRec / $recDisp;

        foreach ($this->request as $name => $value) {
            $data[$name] = $value;
        }

        $data = array_merge($data, array(
            'message'        => !empty($message) ? $message : '',
            'letters'        => $letters,
            'sleepLabs'      => $sleepLabs,
            'patientsInfo'   => $patientsInfo,
            'sort'           => $this->sort,
            'sortdir'        => $this->sortdir,
            'totalRec'       => $totalRec,
            'noPages'        => $noPages,
            'recDisp'        => $recDisp
        ));

        return view('manage.sleep_lab', $data);
    }
}
