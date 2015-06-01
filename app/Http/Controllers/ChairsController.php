<?php
namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Ds3\Libraries\GeneralFunctions;
use Ds3\Contracts\ChairsInterface;
use Ds3\Contracts\UserInterface;
use Ds3\Contracts\LoginInterface;
use Request;
use Session;
use Route;

class ChairsController extends Controller
{
    private $request;
    private $deleteId;
    private $pageNumber;
    private $chairs;
    private $users;
    private $logins;

    public function __construct(
        ChairsInterface $chairs,
        UserInterface $users,
        LoginInterface $logins
    ) {
        $this->request = Request::all();

        $this->deleteId   = GeneralFunctions::getRouteParameter('deleteId');
        $this->pageNumber = GeneralFunctions::getRouteParameter('pageNumber');

        $this->chairs = $chairs;
        $this->users  = $users;
        $this->logins = $logins;
    }

    public function manage()
    {
        if (!empty($this->deleteId)) {
            $this->chairs->deleteData(Session::get('docId'), $this->deleteId);

            $message = 'Deleted Successfully';

            return redirect('/manage/chairs/add')->with('message', $message)->with('closePopup', true);
        }

        $numberOfRecordsDisplayed = 20;

        if (!empty($this->pageNumber)) {
            $indexPage = $this->pageNumber;
        } else {
            $indexPage = 0;
        }

        $skipValues = $indexPage * $numberOfRecordsDisplayed;

        $order     = 'rank';
        $orderName = 'name';

        $resources = $this->chairs->getResource(array('docid' => Session::get('docId')), $whereId = null, $order, $orderName, $numberOfRecordsDisplayed, $skipValues);

        $resourcesNumber = $this->chairs->getResource(array(
            'docid' => Session::get('docId')));

        $users = $this->users->getTypeUsers(array(
            'userid' => Session::get('userId')));

        $totalRecords = count($resourcesNumber);

        $noPages = $totalRecords / $numberOfRecordsDisplayed;

        if (!empty($users[0])) {
            $users = $users[0];
        }

        foreach ($this->request as $name => $value) {
            $data[$name] = $value;
        }

        $data = array_merge($data, array(
            'resources'                => $resources,
            'totalRecords'             => $totalRecords,
            'noPages'                  => $noPages,
            'indexPage'                => $indexPage,
            'users'                    => $users,
            'message'                  => Session::get('message'),
            'docId'                    => Session::get('docId'),
            'userId'                   => Session::get('userId'),
            'numberOfRecordsDisplayed' => $numberOfRecordsDisplayed
        ));

        return view('manage.chairs', $data);
    }

    public function index()
    {
        $resources = $this->chairs->getResource(
        array(
            'docid' => Session::get('docId')),
        array(
            'id'    => (!empty(Route::input('ed')) ? Route::input('ed') : null)));

            if (count($resources)) {
            $resource = $resources[0];

            $data['docid'] = $resource->docid;
            $data['name']  = $resource->name;
            $data['rank']  = $resource->rank;

            $logins = $this->logins->getLogins(array('userid' => $resource['id']));

            if (count($logins)) {
                $data['countLogins'] = count($logins);
            }
        }

        if (!empty(Route::input('ed'))) {
            $buttonText = 'Edit';
        } else {
            $buttonText = 'Add';
        }

        $data = array(
            'buttonText' => $buttonText,
            'ed'         => Route::input('ed'),
            'message'    => !empty(Session::get('message')) ? Session::get('message') : '',
            'closePopup' => !empty(Session::get('closePopup')) ? Session::get('closePopup') : null
        );

        if (count($resources)) {
            $resource = $resources[0];

            $data['docid'] = $resource->docid;
            $data['name']  = $resource->name;
            $data['rank']  = $resource->rank;
        }

        return view('manage.add_chairs', $data);
    }

    public function add()
    {
        if ($this->request['staffsub'] && $this->request['staffsub'] == 1) {

            if (!empty(Route::input('ed'))) {
                $data['name'] = $this->request['name'];
                $data['rank'] = $this->request['rank'];

                $this->chairs->updateData(array('id' => Route::input('ed')), $data);

                $message = 'Edited Successfully' . $this->request['name'];
            } else {
                $data['name']  = $this->request['name'];
                $data['rank']  = $this->request['rank'];
                $data['docid'] = Session::get('docId');

                $this->chairs->insertData($data);

                $message = 'Added Successfully';
            }

            if (!empty(Route::input('ed'))) {
                $path = '/manage/chairs/' . Route::input('ed') . '/edit';
            } else {
                $path = '/manage/chairs/add';
            }

            return redirect($path)->with('closePopup', true)->with('message', $message);
        }
    }
}
