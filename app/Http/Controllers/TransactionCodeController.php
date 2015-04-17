<?php
namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Request;
use Session;
use Route;

use Ds3\Contracts\TransactionCodeInterface;
use Ds3\Contracts\UserInterface;
use Ds3\Libraries\GeneralFunctions;

class TransactionCodeController extends Controller
{
    private $transactionCode;
    private $request;
    private $user;
    private $delid;
    private $page;
    private $transactionCodeFields;

    const LIMIT = 20;
    const ORDER = 'sortby';
    const DSS_AMOUNT_ADJUST_USER = 'User Entered';
    const DSS_AMOUNT_ADJUST_NEGATIVE = 'Always Negative';
    const DSS_AMOUNT_ADJUST_POSITIVE = 'Always Positive';

    public function __construct(
        TransactionCodeInterface $transactionCode,
        UserInterface            $user
    ) {
        $this->request         = Request::all();

        $this->user            = $user;
        $this->transactionCode = $transactionCode;

        $this->delid           = GeneralFunctions::getRouteParameter('delid');
        $this->page            = GeneralFunctions::getRouteParameter('page');

        $this->transactionCodeFields = array('transaction_code', 'description', 'type', 'place', 'modifier_code_1', 'modifier_code_1', 'modifier_code_2', 'days_units', 'amount_adjust', 'status', 'amount');
    }

    public function manage()
    {
        $usersType = $this->user->getTypeUsers(array('userid' => Session::get('userId')));

        if (count($usersType)) {
            $usersType = $usersType[0];
        }

        if (Session::get('docId') != Session::get('userId') && $usersType->manage_staff != 1) {
            $message = 'You are not authorized to access this page.';

            return view('manage.transaction_code', $message);
        }

        if (!empty($this->delid)) {
            $this->transactionCode->deleteData(array('transaction_codeid' => $this->delid,
                                                     'docid'              => Session::get('docId')));

            $message = 'Deleted Successfully';

            return redirect('/manage/transaction_code/edit')->with('message', $message)->with('closePopup', true);
        }

        if (!empty($this->page)) {
            $indexVal = $this->page;
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

            if (!empty($this->page)) {
                $indexVal = $this->page;
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

             return redirect('/manage/transaction_code/edit')->with('message', $message)->with('closePopup', true);
        }
    }

    public function index()
    {
        $transactionsNum = $this->transactionCode->getTransactionCode(array('transaction_codeid' => Route::input('ed'),
                                                                            'docid'              => Session::get('docId')),
                                                                            null, null, null);

        $placeServices = $this->transactionCode->getPlaceService(null, 'sortby');
        $modifierCodes = $this->transactionCode->getModifierCode(null, 'sortby');

        if (count($transactionsNum)) {
            $butText         = 'Edit';
            $transactionsNum = $transactionsNum[0];
        } else {
            $butText = 'Add';
        }

        $data = array(
            'butText'                 => $butText,
            'transactionsNum'         => $transactionsNum,
            'placeServices'           => $placeServices,
            'modifierCodes'           => $modifierCodes,
            'dssAmountAdjustUser'     => self::DSS_AMOUNT_ADJUST_USER,
            'dssAmountAdjustNegative' => self::DSS_AMOUNT_ADJUST_NEGATIVE,
            'dssAmountAdjustPositive' => self::DSS_AMOUNT_ADJUST_POSITIVE,
            'message'     => !empty(Session::get('message')) ? Session::get('message') : '',
            'closePopup'  => !empty(Session::get('closePopup')) ? Session::get('closePopup') : null
        );

        return view('manage.add_transaction_code', $data);
    }
}
