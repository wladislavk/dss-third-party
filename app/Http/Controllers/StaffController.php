<?php
namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Ds3\Contracts\UserInterface;
use Ds3\Contracts\LoginInterface;
use Ds3\Libraries\GeneralFunctions;
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

    public function __construct(
        UserInterface $user,
        LoginInterface $login
    ) {
        $this->request = Request::all();

        $this->deleteId    = GeneralFunctions::getRouteParameter('deleteId');
        $this->pageNumber  = GeneralFunctions::getRouteParameter('pageNumber');

        $this->user  = $user;
        $this->login = $login;
    }

    public function manage()
    {
        if (!empty($this->request['deleteId'])) {
            $getTypeLogins = $this->login->getLogins(array('userid' => $this->request['deleteId']));

            if (count($getTypeLogins) == 0) {
                $this->user->deleteUsers($this->request['deleteId']);
            } else {
                $this->user->updateData($this->request['deleteId'], array('status' => 2));
            }

            $message = 'Deleted Successfully';
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
            $buttonText   = 'Edit';

            $getTypeLogins = $this->login->getLogins(array(
            'userid' => $getTypeUsers['userid']));

        } else {
            $buttonText = 'Add';
        }

        $data = array(
            'getTypeUsers'   => !empty($getTypeUsers) ? $getTypeUsers : '',
            'getTypeUsersId' => !empty($getTypeUsersId) ? $getTypeUsersId : '',
            'getTypeLoginsNumber'  => count($getTypeLogins),
            'buttonText'     => $buttonText,
            'userId'         => Session::get('userId'),
            'docId'          => Session::get('docId'),
            'message'        => !empty(Session::get('message')) ? Session::get('message') : '',
            'closePopup'     => !empty(Session::get('closePopup')) ? Session::get('closePopup') : null
        );

        return view('manage.add_staff', $data);
    }
}
