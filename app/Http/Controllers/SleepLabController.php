<?php
namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Request;
use Session;
use Route;

use Ds3\Contracts\SleepLabInterface;
use Ds3\Contracts\PatientInterface;
use Ds3\Libraries\GeneralFunctions;

class SleeplabController extends Controller
{
    private $request;
    private $sleeplabFields;
    private $delid;
    private $sleepLab;
    private $page;
    private $contacttype;
    private $sort;
    private $sortdir;
    private $activePat;

    public function __construct(
        SleepLabInterface $sleepLab,
        PatientInterface $patient
    ) {
        $this->sleepLab     = $sleepLab;
        $this->patient      = $patient;

        $this->request      = Request::all();

        $this->activePat    = GeneralFunctions::getRouteParameter('activePat');
        $this->delid        = GeneralFunctions::getRouteParameter('delid');
        $this->page         = GeneralFunctions::getRouteParameter('page');
        $this->letter       = GeneralFunctions::getRouteParameter('letter');
        $this->sort         = GeneralFunctions::getRouteParameter('sort');
        $this->sortdir      = GeneralFunctions::getRouteParameter('sortdir');

        $this->sleeplabFields = array('company', 'salutation', 'firstname', 'lastname', 'middlename', 'add1', 'add2', 'city', 'state', 'zip', 'phone1', 'phone2', 'fax', 'email', 'notes', 'status');
    }

    public function manage()
    {
        $letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

        $patientsInfo = array();

        if (!empty($this->delid)) {
            $this->sleepLab->deleteData($this->delid);
            $message = 'Deleted Successfully';

            return redirect('/manage/sleeplab/add')->with('message', $message)->with('closePopup', true);
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

        $sleepLabs = $this->sleepLab->getSleepLabTypeHolder(array('docid' => Session::get('docId')), $letter, $order, $dir, $recDisp, $iVal);

        $sleepLabsNum = $this->sleepLab->getSleepLabTypeHolder(array('docid' => Session::get('docId')), $letter, $order, $dir);

        foreach ($sleepLabs as $sleepLab) {
            $patients = $this->patient->getSleepLab($sleepLab->sleeplabid);
            $patientsInfo[$sleepLab->sleeplabid]['pat'] = $patients;
        }

        $totalRec = count($sleepLabsNum);

        $noPages = $totalRec / $recDisp;

        foreach ($this->request as $name => $value) {
            $data[$name] = $value;
        }

        $data = array_merge($data, array(
            'letters'        => $letters,
            'sleepLabs'      => $sleepLabs,
            'patientsInfo'   => $patientsInfo,
            'sort'           => $this->sort,
            'sortdir'        => $this->sortdir,
            'letter'         => $this->letter,
            'totalRec'       => $totalRec,
            'noPages'        => $noPages,
            'recDisp'        => $recDisp,
            'indexVal'       => $indexVal,
            'message'        => Session::get('message'),
            'closePopup'  => !empty(Session::get('closePopup')) ? Session::get('closePopup') : null
        ));

        return view('manage.sleep_lab', $data);
    }

    public function view()
    {
        $sleepLabs = $this->sleepLab->getSleepLabTypeHolder(array('sleeplabid' => (!empty(Route::input('ed')) ? Route::input('ed') : null)));

        if (count($sleepLabs)) {
            $sleepLab = $sleepLabs[0];
            $sleeplabData['name'] = (($sleepLab['salutation'])
                                 . ($sleepLab['firstname'])
                                 . ($sleepLab['middlename'])
                                 . ($sleepLab['lastname']));

            $sleeplabData['phone1'] = GeneralFunctions::formatPhone($sleepLab['phone1']);
            $sleeplabData['phone2'] = GeneralFunctions::formatPhone($sleepLab['phone2']);
            $sleeplabData['fax'] = GeneralFunctions::formatPhone($sleepLab['fax']);
        }

        $data = array(
            'sleeplabData' => $sleeplabData,
            'sleepLabs'    => $sleepLabs,
            'ed'           => !empty(Route::input('ed')) ? Route::input('ed') : null
        );

        return view('manage.view_sleeplab', $data);
    }

    public function index()
    {
        $sleepLabs = $this->sleepLab->getSleepLabTypeHolder(array('sleeplabid' => Route::input('ed')));

        if (!empty(Route::input('ed'))) {
            $buttonText = 'Edit';
        } else {
            $buttonText = 'Add';
        }

        $data = array(
            'buttonText'     => $buttonText,
            'ed'          => Route::input('ed'),
            'message'     => !empty(Session::get('message')) ? Session::get('message') : 'som',
            'closePopup'  => !empty(Session::get('closePopup')) ? Session::get('closePopup') : null
        );

        if (count($sleepLabs)) {
            $sleepLab = $sleepLabs[0];

            foreach ($this->sleeplabFields as $sleeplabField) {
                if (!empty($sleepLab->$sleeplabField)) {
                    $data[$sleeplabField] = $sleepLab->$sleeplabField;
                } else {
                    $data[$sleeplabField] = '';
                }
            }
        }

        return view('manage.add_sleeplab', $data);
    }

    public function add()
    {
        if (!empty($this->request['sleeplabsub']) && $this->request['sleeplabsub'] == 1) {
            if (!empty(Route::input('ed'))) {
                foreach ($this->sleeplabFields as $sleeplabField) {
                    $data[$sleeplabField] = $this->request[$sleeplabField];
                }

                $this->sleepLab->updateData(Route::input('ed'), $data);
                $message = 'Edited Successfully';
            } else {
                foreach ($this->sleeplabFields as $sleeplabField) {
                    $data[$sleeplabField] = $this->request[$sleeplabField];
                }

                $data['phone1']     = GeneralFunctions::num($data['phone1']);
                $data['phone2']     = GeneralFunctions::num($data['phone2']);
                $data['fax']        = GeneralFunctions::num($data['fax']);
                $data['docid']      = Session::get('docId');
                $data['ip_address'] = Request::ip();

                $this->sleepLab->insertData($data);
                $message = 'Added Successfully';
            }

            if (!empty(Route::input('ed'))) {
                $path = '/manage/sleeplab/add' . Route::input('ed');
            } else {
                $path = '/manage/sleeplab/add';
            }

            return redirect($path)->with('closePopup', true)->with('message', $message);
        }
    }
}
