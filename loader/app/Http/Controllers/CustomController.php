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
    private $deleteId;
    private $pageNumber;
    private $customFields;

    public function __construct(
        CustomInterface $custom
    ) {
        $this->request    = Request::all();

        $this->custom     = $custom;

        $this->deleteId   = GeneralFunctions::getRouteParameter('deleteId');
        $this->pageNumber = GeneralFunctions::getRouteParameter('pageNumber');

        $this->customFields = array('title', 'description', 'status', 'description');
    }

    public function manage()
    {
        if (!empty($this->deleteId)) {
            $this->custom->deleteData($this->deleteId);
            $message = 'Deleted Successfully';

            return redirect('/manage/custom/add')->with('message', $message)->with('closePopup', true);
        }

        $numberOfRecordsDisplayed = 20;

        if (!empty($this->pageNumber)) {
            $indexPage = $this->pageNumber;
        } else {
            $indexPage = 0;
        }

        $order = 'title';
        $skipValues = $indexPage * $numberOfRecordsDisplayed;

        $customs = $this->custom->getCustomTypeHolder(array('docid' => Session::get('docId')), $order, $numberOfRecordsDisplayed, $skipValues);
        $customsNum = $this->custom->getCustomTypeHolder(array('docid' => Session::get('docId')), $order, null, null);

        $totalRecords = count($customsNum);

        $noPages = $totalRecords / $numberOfRecordsDisplayed;

        foreach ($this->request as $name => $value) {
            $data[$name] = $value;
        }

        $data = array_merge($data, array(
            'noPages'                  => $noPages,
            'customs'                  => $customs,
            'message'                  => Session::get('message'),
            'totalRecords'             => $totalRecords,
            'numberOfRecordsDisplayed' => $numberOfRecordsDisplayed,
            'customsNum'               => $customsNum,
            'indexPage'                => $indexPage
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
                $path = '/manage/custom/' . Route::input('ed') . '/edit';
            } else {
                $path = '/manage/custom/add';
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
