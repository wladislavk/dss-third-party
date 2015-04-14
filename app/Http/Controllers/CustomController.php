<?php
namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Request;
use Session;
use Route;

use Ds3\Contracts\CustomInterface;
use Ds3\Libraries\GeneralFunctions;

class CustomController extends Controller
{
    private $request;
    private $custom;
    private $delid;
    private $page;
    private $customFields;

    public function __construct(
        CustomInterface $custom
    ) {
        $this->request = Request::all();

        $this->custom  = $custom;

        $this->delid   = GeneralFunctions::getRouteParameter('delid');
        $this->page    = GeneralFunctions::getRouteParameter('page');

        $this->customFields = array('title', 'description', 'status', 'description');
    }

    public function manage()
    {
        if (!empty($this->delid)) {
            $this->custom->deleteData($this->delid);
            $message = 'Deleted Successfully';

            return redirect('/manage/add_custom')->with('message', $message)->with('closePopup', true);
        }

        $recDisp = 20;

        if (!empty($this->page)) {
            $indexVal = $this->page;
        } else {
            $indexVal = 0;
        }

        $order = 'title';
        $iVal = $indexVal * $recDisp;

        $customs = $this->custom->getCustomTypeHolder(array('docid' => Session::get('docId')), $order, $recDisp, $iVal);
        $customsNum = $this->custom->getCustomTypeHolder(array('docid' => Session::get('docId')), $order, null, null);

        $totalRec = count($customsNum);

        $noPages = $totalRec / $recDisp;

        foreach ($this->request as $name => $value) {
            $data[$name] = $value;
        }

        $data = array_merge($data, array(
            'noPages'      => $noPages,
            'customs'      => $customs,
            'message'      => Session::get('message'),
            'totalRec'     => $totalRec,
            'recDisp'      => $recDisp,
            'customsNum'   => $customsNum,
            'indexVal'     => $indexVal
        ));

        return view('manage.custom', $data);
    }

    public function add()
    {
        if (!empty($this->request['customsub']) && $this->request['customsub'] == 1) {
            if (Route::input('ed') != '') {
                foreach ($this->customFields as $customField) {
                    $data[$customField] = $this->request[$customField];
                }

                $data['docid'] = Session::get('docId');
                $data['ip_address'] = Request::ip();

                $this->custom->updateData(Route::input('ed'), $data);
                $message = 'Edited Successfully';
            } else {
                foreach ($this->customFields as $customField) {
                    $data[$customField] = $this->request[$customField];
                }

                $data['docid'] = Session::get('docId');
                $data['ip_address'] = Request::ip();

                $this->custom->insertData($data);
                $message = 'Added Successfully';

            }

            if (!empty(Route::input('ed'))) {
                $path = '/manage/add_custom/' . Route::input('ed');
            } else {
                $path = '/manage/add_custom';
            }

            return redirect($path)->with('closePopup', true)->with('message', $message);
        }
    }

    public function index()
    {
        $customs = $this->custom->getCustomTypeHolder(array('customid' => (!empty(Route::input('ed')) ? Route::input('ed') : null)));

        if (!empty(Route::input('ed'))) {
            $butText = 'Edit';
        } else {
            $butText = 'Add';
        }

        $data = array(
            'butText'     => $butText,
            'ed'          => Route::input('ed'),
            'message'     => !empty(Session::get('message')) ? Session::get('message') : '',
            'closePopup'  => !empty(Session::get('closePopup')) ? Session::get('closePopup') : null
        );

        if (count($customs)) {
            $custom = $customs[0];

            foreach ($this->customFields as $customField) {
                if (!empty($custom->$customField)) {
                    $data[$customField] = $custom->$customField;
                } else {
                    $data[$customField] = '';
                }
            }

            $data['customid'] = $custom->customid;
        }

        return view('manage.add_custom', $data);
    }
}
