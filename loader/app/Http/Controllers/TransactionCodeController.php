<?php
namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Request;
use Session;
use Route;

use Ds3\Contracts\TransactionCodeInterface;
use Ds3\Contracts\PlaceServiceInterface;
use Ds3\Contracts\ModifierCodeInterface;
use Ds3\Contracts\UserInterface;
use Ds3\Libraries\GeneralFunctions;

use Ds3\Libraries\Constants;

class TransactionCodeController extends Controller
{
    private $transactionCode;
    private $placeService;
    private $modifierCode;
    private $request;
    private $user;
    private $deleteId;
    private $pageNumber;
    private $transactionCodeFields;

    const LIMIT = 20;
    const ORDER = 'sortby';

    public function __construct(
        TransactionCodeInterface $transactionCode,
        PlaceServiceInterface    $placeService,
        ModifierCodeInterface    $modifierCode,
        UserInterface            $user
    ) {
        $this->request         = Request::all();

        $this->user            = $user;
        $this->transactionCode = $transactionCode;
        $this->placeService    = $placeService;
        $this->modifierCode    = $modifierCode;

        $this->deleteId        = GeneralFunctions::getRouteParameter('delid');
        $this->pageNumber      = GeneralFunctions::getRouteParameter('page');

        $this->transactionCodeFields = array('transaction_code', 'description', 'type', 'place', 'modifier_code_1', 'modifier_code_1', 'modifier_code_2', 'days_units', 'amount_adjust', 'status', 'amount');
    }

    public function manage()
    {
        $usersType = $this->user->getTypeUsers(array(
            'userid' => Session::get('userId')));

        if (count($usersType)) {
            $usersType = $usersType[0];
        }

        if (Session::get('docId') != Session::get('userId') && $usersType->manage_staff != 1) {
            $message = 'You are not authorized to access this page.';

            return view('manage.transaction_code', $message);
        }

        if (!empty($this->deleteId)) {
            $this->transactionCode->deleteData(array('transaction_codeid' => $this->deleteId,
                                                     'docid'              => Session::get('docId')));

            $message = 'Deleted Successfully';

            return redirect('/manage/transaction_code/add')->with('message', $message)->with('closePopup', true);
        }

        if (!empty($this->pageNumber)) {
            $indexVal = $this->pageNumber;
        } else {
            $indexVal = 0;
        }

        $iVal = $indexVal * self::LIMIT;

        $transactions    = $this->transactionCode->getTransactionCode(array('docid' => Session::get('docId')), self::ORDER, self::LIMIT, $iVal);
        $transactionsNum = $this->transactionCode->getTransactionCode(array('docid' => Session::get('docId')), self::ORDER, null, null);

        $totalRec = count($transactionsNum);

        $noPages = $totalRec / self::LIMIT;

        foreach ($this->request as $name => $value) {
            $data[$name] = $value;
        }

        $data = array_merge($data, array(
            'totalRec'        => $totalRec,
            'noPages'         => $noPages,
            'transactions'    => $transactions,
            'transactionsNum' => $transactionsNum,
            'indexVal'        => $indexVal,
            'recDisp'         => self::LIMIT,
            'message'         => Session::get('message')
        ));

        return view('manage.transaction_code', $data);
    }

    public function add()
    {
        if (!empty($this->request['sortsub']) && $this->request['sortsub'] == 1) {

            if (!empty($this->pageNumber)) {
                $indexVal = $this->pageNumber;
            } else {
                $indexVal = 0;
            }

            $iVal = $indexVal * self::LIMIT;

            $transactionsNum = $this->transactionCode->getTransactionCode(array('docid' => Session::get('docId')), self::ORDER, self::LIMIT, $iVal);

            $data['codeid'] = $transactionsNum;
            $data['docId']  = Session::get('docId');
            $data['val']    = $this->request['sortby'];

            $this->transactionCode->updateDataSortby($data);

            $message = 'Sort By Changed Successfully';

            return redirect('/manage/transaction_code')->with('message', $message);
        }

        if ($this->request['sortby'] == '' || is_numeric($this->request['sortby']) === false) {
            $sortBy = 999;
        } else {
            $sortBy = $this->request['sortby'];
        }

        if (!empty($this->request['add']) && $this->request['add'] == 1) {
            if (!empty($this->request['ed'])) {
                foreach ($this->transactionCodeFields as $transactionCodeField) {
                    $data[$transactionCodeField] = $this->request[$transactionCodeField];
                }

                $data['sortby'] = $sortBy;

                $this->transactionCode->updateData($this->request['ed'], $data);

                $message = 'Edited Successfully';
            } else {
                foreach ($this->transactionCodeFields as $transactionCodeField) {
                    $data[$transactionCodeField] = $this->request[$transactionCodeField];
                }

                $data['sortby'] = $sortBy;
                $data['docid'] = Session::get('docId');
                $data['ip_address'] = Request::ip();

                $this->transactionCode->insertData($data);

                $message = 'Added Successfully';
            }

             return redirect('/manage/transaction_code/add')->with('message', $message)->with('closePopup', true);
        }
    }

    public function index()
    {
        $transactionsNum = $this->transactionCode->getTransactionCode(array(
            'transaction_codeid' => Route::input('ed'),
            'docid'              => Session::get('docId')),
            null, null, null);

        $placeServices = $this->placeService->getPlaceService('sortby');
        $modifierCodes = $this->modifierCode->getModifierCode('sortby');

        if (count($transactionsNum)) {
            $buttonText      = 'Edit';
            $transactionsNum = $transactionsNum[0];
        } else {
            $buttonText = 'Add';
        }

        $data = array(
            'buttonText'              => $buttonText,
            'transactionsNum'         => $transactionsNum,
            'placeServices'           => $placeServices,
            'modifierCodes'           => $modifierCodes,
            'dssAmountAdjustUser'     => Constants::$dss_amount_adjust_labels[0],
            'dssAmountAdjustNegative' => Constants::$dss_amount_adjust_labels[1],
            'dssAmountAdjustPositive' => Constants::$dss_amount_adjust_labels[2],
            'message'     => !empty(Session::get('message')) ? Session::get('message') : '',
            'closePopup'  => !empty(Session::get('closePopup')) ? Session::get('closePopup') : null
        );

        return view('manage.add_transaction_code', $data);
    }
}
