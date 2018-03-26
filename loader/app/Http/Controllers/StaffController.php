<?php
namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Ds3\Contracts\UserInterface;
use Ds3\Contracts\LoginInterface;
use Ds3\Libraries\GeneralFunctions;
use Ds3\Libraries\Password;
use Request;
use Session;
use Route;

class StaffController extends Controller
{
    private $request;
    private $user;
    private $login;
    private $deleteId;
    private $pageNumber;
    private $staffFields;
    private $staffFieldInts;

    public function __construct(
        UserInterface $user,
        LoginInterface $login
    ) {
        $this->request = Request::all();

        $this->deleteId    = GeneralFunctions::getRouteParameter('deleteId');
        $this->pageNumber  = GeneralFunctions::getRouteParameter('pageNumber');

        $this->user  = $user;
        $this->login = $login;

        $this->staffFields    = array('username', 'first_name', 'last_name', 'address', 'status', 'npi', 'medicare_npi', 'medicare_ptan', 'tax_id_or_ssn', 'practice', 'city', 'state', 'zip', 'email');
        $this->staffFieldInts = array('producer', 'producer_files', 'ein', 'ssn', 'post_ledger_adjustments', 'edit_ledger_entries', 'use_course', 'sign_notes', 'manage_staff');
    }

    public function manage()
    {
        if (!empty($this->deleteId)) {
            $getTypeLogins = $this->login->getLogins(array(
                'userid' => $this->deleteId));

            if (count($getTypeLogins) == 0) {
                $this->user->deleteUsers($this->deleteId);
            } else {
                $this->user->updateData($this->deleteId, array(
                    'status' => 2));
            }

            $message = 'Deleted Successfully';

            return redirect('/manage/staff/add')->with('message', $message)->with('closePopup', true);
        }

        $numberOfRecordsDisplayed = 20;

        if (!empty($this->pageNumber)) {
            $indexPage = $this->pageNumber;
        } else {
            $indexPage = 0;
        }

        $skipValues = $indexPage * $numberOfRecordsDisplayed;

        $order = 'username';

        $getTypeUsers = $this->user->getTypeUsers(null, array(
            'user_access' => 1,
            'docid'       => Session::get('docId')), $order, $numberOfRecordsDisplayed, $skipValues);

        $getTypeUsersNumber = $this->user->getTypeUsers(null, array(
            'user_access' => 1,
            'docid'       => Session::get('docId')), $order, null, null);

        $getTypeUsersId = $this->user->getTypeUsers(array(
            'userid' => Session::get('docId')), null, null, null, null);

        if (!empty($getTypeUsersId[0])) {
            $getTypeUsersId = $getTypeUsersId[0];
        }

        $totalRecords = count($getTypeUsersNumber);
        $noPages = $totalRecords / $numberOfRecordsDisplayed;

        foreach ($this->request as $name => $value) {
            $data[$name] = $value;
        }

        $data = array_merge($data, array(
            'getTypeUsers'             => $getTypeUsers,
            'getTypeUsersNumber'       => $getTypeUsersNumber,
            'totalRecords'             => $totalRecords,
            'noPages'                  => $noPages,
            'indexPage'                => $indexPage,
            'numberOfRecordsDisplayed' => $numberOfRecordsDisplayed,
            'message'                  => Session::get('message'),
            'userId'                   => Session::get('userId'),
            'docId'                    => Session::get('docId'),
            'getTypeUsersId'           => $getTypeUsersId
        ));

        return view('manage.staff', $data);
    }

    public function index()
    {
        $getTypeUsers = $this->user->getTypeUsers(array(
            'userid' => (!empty(Route::input('ed')) ? Route::input('ed') : null)));

        $getTypeUsersId = $this->user->getTypeUsers(array(
            'userid' => Session::get('userId')));

        if (count($getTypeUsersId)) {
            $getTypeUsersId = $getTypeUsersId[0];
        }

        if (count($getTypeUsers)) {
            $getTypeUsers = $getTypeUsers[0];
            
        }

        if (count($getTypeUsers)) {

            $buttonText = 'Edit';

            $getTypeLogins = $this->login->getLogins(array(
            'userid' => $getTypeUsers['userid']));

        } else {
            $buttonText    = 'Add';
            $getTypeLogins = null;
        }

        $data = array(
            'getTypeUsers'        => count($getTypeUsers) ? $getTypeUsers : null,
            'getTypeUsersId'      => !empty($getTypeUsersId) ? $getTypeUsersId : '',
            'getTypeLoginsNumber' => !empty(count($getTypeLogins)),
            'buttonText'          => $buttonText,
            'userId'              => Session::get('userId'),
            'docId'               => Session::get('docId'),
            'message'             => !empty(Session::get('message')) ? Session::get('message') : '',
            'closePopup'          => !empty(Session::get('closePopup')) ? Session::get('closePopup') : null
        );

        return view('manage.add_staff', $data);
    }

    public function add()
    {
        if ($this->request['staffsub'] && $this->request['staffsub'] == 1) {

            if (!empty(Route::input('ed'))) {
                foreach ($this->staffFields as $staffField) {
                    $data[$staffField] = $this->request[$staffField];
                }

                foreach ($this->staffFieldInts as $staffFieldInt) {
                    $data[$staffFieldInt] = !empty($this->request[$staffFieldInt]) ? $this->request[$staffFieldInt] : 0;
                }

                $data['user_access'] = 1;
                $data['phone']       = GeneralFunctions::formatPhone($this->request['phone']);

                $this->user->updateData(Route::input('ed'), $data);

                $message = 'Edited Successfully';
            } else {
                foreach ($this->staffFieldInts as $staffFieldInt) {
                    $data[$staffFieldInt] = !empty($this->request[$staffFieldInt]) ? $this->request[$staffFieldInt] : 0;
                }

                foreach ($this->staffFields as $staffField) {
                    $data[$staffField] = $this->request[$staffField];
                }

                $salt = Password::createSalt();

                $data['user_access'] = 1;
                $data['docid']       = Session::get('docId');
                $data['salt']        = $salt;
                $data['password']    = Password::genPassword($this->request['password'], $salt);
                $data['phone']       = GeneralFunctions::formatPhone($this->request['phone']);

                $this->user->insertData($data);

                $message = 'Added Successfully';
            }

            if (!empty(Route::input('ed'))) {
                $path = '/manage/staff/' . Route::input('ed') . '/edit';
            } else {
                $path = '/manage/staff/add';
            }

            return redirect($path)->with('closePopup', true)->with('message', $message);
        }
    }
}
