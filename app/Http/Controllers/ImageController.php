<?php
namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Request;
use Session;
use Route;
use Input;
use Carbon\Carbon;

use Ds3\Contracts\QImageInterface;
use Ds3\Contracts\ImageTypeInterface;
use Ds3\Contracts\FlowPg1Interface;
use Ds3\Contracts\SleeplabInterface;
use Ds3\Contracts\SummSleeplabInterface;
use Ds3\Contracts\PatientInterface;
use Ds3\Contracts\InsDiagnosisInterface;
use Ds3\Contracts\DeviceInterface;
use Ds3\Libraries\Constants;
use Ds3\Libraries\GeneralFunctions;

class ImageController extends Controller
{
    private $uploadedPath;

    private $qImage;
    private $imageType;
    private $flowPg1;
    private $sleeplab;
    private $summSleeplab;
    private $patient;
    private $insDiagnosis;
    private $device;

    private $request;
    private $sh;
    private $it;
    private $return;
    private $returnField;
    private $patientId;

    public function __construct(
        QImageInterface $qImage,
        ImageTypeInterface $imageType,
        FlowPg1Interface $flowPg1,
        SleeplabInterface $sleeplab,
        PatientInterface $patient,
        InsDiagnosisInterface $insDiagnosis,
        DeviceInterface $device,
        SummSleeplabInterface $summSleeplab
    ) {
        $this->uploadedPath = public_path() . "/shared/q_file/";

        $this->qImage       = $qImage;
        $this->imageType    = $imageType;
        $this->flowPg1      = $flowPg1;
        $this->sleeplab     = $sleeplab;
        $this->summSleeplab = $summSleeplab;
        $this->patient      = $patient;
        $this->insDiagnosis = $insDiagnosis;
        $this->device       = $device;

        $this->request      = Request::all();

        $this->sh           = GeneralFunctions::getRouteParameter('sh');
        $this->it           = GeneralFunctions::getRouteParameter('it');
        $this->return       = GeneralFunctions::getRouteParameter('return');
        $this->returnField  = GeneralFunctions::getRouteParameter('field');
        $this->patientId    = GeneralFunctions::getRouteParameter('pid');
    }

    public function index()
    {
        $image = $this->qImage->find(Route::input('ed'));

        if (!empty(Session::get('message'))) {
            $title = Session::get('title');
            $imageTypeId = Session::get('imageTypeId');
        } elseif (!empty($image)) {
            $title        = $image->title;
            $imageFile    = $image->image_file;
            $imageTypeId  = $image->imagetypeid;
            $butText      = 'Add';
        } else {
            $title = null;
        }

        if (empty($imageTypeId)) {
            $imageTypeId = !empty($this->sh) ? $this->sh : null;
        }

        if (!empty($image->contactid)) {
            $buttonText = 'Edit ';
        } else {
            $buttonText = 'Add ';
        }

        $imageTypes = $this->imageType->getActiveImageTypes();

        $showBlock = array();

        if (!empty($this->request['itro']) && $this->request['itro'] == 1) {
            $showBlock['imageTypes'] = true;
        }

        $flowPg1 = $this->flowPg1->find($this->patientId);

        if (!empty($imageFile)) {
            $showBlock['imageFile'] = true;
        }

        $labels = array('', 'Facial Right', 'Facial Front', 'Facial Left', 'Retracted Right', 'Retracted Frontal', 'Retracted Left', 'Occlusal Upper', 'Mallampati', 'Occlusal Lower');

        $patients = $this->patient->getPatients(array('patientid' => $this->patientId));

        $patient = count($patients) ? $patients[0] : null;

        $sleepSlabs = $this->sleeplab->getSleeplabs(array(
            'status'  => 1,
            'docid'   => Session::get('docId')
        ), 'company');

        $insDiagnoses = $this->insDiagnosis->getActiveInsDiagnosis();

        $devices = $this->device->getActiveDevices();

        $data = array(
            'path'          => '/' . Request::segment(1) . '/' . Request::segment(2),
            'message'       => Session::get('message'),
            'sh'            => $this->sh,
            'it'            => $this->it,
            'return'        => $this->return,
            'field'         => $this->returnField,
            'patientId'     => $this->patientId,
            'buttonText'    => $buttonText,
            'title'         => $title,
            'imageTypes'    => $imageTypes,
            'imageTypeId'   => $imageTypeId,
            'flowPg1'       => $flowPg1,
            'labels'        => $labels,
            'image'         => $image,
            'sleepSlabs'    => $sleepSlabs,
            'insDiagnoses'  => $insDiagnoses,
            'patient'       => $patient,
            'devices'       => $devices,
            'showBlock'     => $showBlock,
            'alert'         => Session::get('alert'),
            'closePopup'    => Session::get('closePopup')
        );

        // dd($data);

        return view('manage.add_image', $data);
    }

    public function add()
    {
        if (!empty($this->request['submitnewsleeplabsumm'])) {
            $sleeplabData = array(
                'date', 'sleeptesttype', 'place', 'diagnosising_doc',
                'diagnosising_npi', 'ahi', 'ahisupine', 'rdi',
                'rdisupine', 'o2nadir', 't9002', 'dentaldevice',
                'devicesetting', 'diagnosis', 'notes', 'testnumber',
                'sleeplab'
            );

            foreach ($sleeplabData as $attribute) {
                $summSleeplabData[$attribute] = $this->request[$attribute];
            }

            if (Input::hasFile('ss_file')) {
                $fullName = Input::file('ss_file')->getClientOriginalName();
                $lastPoint = strrpos($fullName, ".");
                $name = substr($fullName, 0, $lastPoint);

                $name = $name . '_' . Carbon::now()->format('dmy_Hi');
                $name = str_replace(" ", "_", $name);
                $name = str_replace(".", "_", $name);
                $name = str_replace("'", "_", $name);
                $name = str_replace("&", "amp", $name);
                $name = preg_replace("/[^a-zA-Z0-9_]/", "", $name);

                $fileName = $name . "." . Input::file('ss_file')->getClientOriginalExtension();

                $uploaded = GeneralFunctions::uploadImage(Input::file('ss_file'), $this->uploadedPath . $fileName);

                if (!empty($uploaded)) {
                    $data = array(
                        'patientid'    => $this->patientId,
                        'title'        => $summSleeplabData['sleeptesttype'] . ' ' . $summSleeplabData['date'],
                        'imagetypeid'  => 1,
                        'image_file'   => $name,
                        'userid'       => Session::get('userId'),
                        'docid'        => Session::get('docId'),
                        'ip_address'   => Request::ip()
                    );

                    $imageId = $this->qImage->insertData($data);
                }
            } else {
                $name = null;
                $imageId = null;
            }

            foreach ($sleeplabData as $attribute) {
                $data[$attribute] = $summSleeplabData[$attribute];
            }

            $data = array_merge($data, array(
                'filename'          => $name,
                'patiendid'         => $this->patientId,
                'image_id'          => $imageId
            ));

            $summSleeplabId = $this->summSleeplab->insertData($data);

            if (empty($summSleeplabId)) {
                $message = 'Could not add sleep lab... Please try again.';
            } else {
                $message = 'Successfully added sleep lab' . $uploaded;
            }

            return redirect("/manage/q_image" . (!empty($this->patientId) ? '/' . $this->patientId : ''));
        }

        if (!empty($this->request['imagesub']) && $this->request['imagesub'] == 1) {
            $title = $this->request['title'];
            $imageTypeId = $this->request['imagetypeid'];

            if (Input::hasFile('image_file') || empty(Route::input('ed'))) {
                if (!Input::file('image_file')->isValid() && !Input::file('image_file1')->isValid()) {
                    $uploaded = false;
                } else {
                    if ($imageTypeId == 0 || (array_search(Input::file('image_file')->getMimeType(), Constants::$dss_file_types) !== false)) {
                        if ($imageTypeId == '0') {
                            $fullName = Input::file('image_file_1')->getClientOriginalName();
                            $lastPoint = strrpos($fullName, ".");
                            $name = substr($fullName, 0, $lastPoint);

                            $name = $name . '_' . Carbon::now()->format('dmy_Hi');
                            $name = str_replace(" ", "_", $name);
                            $name = str_replace(".", "_", $name);
                            $name = str_replace("'", "_", $name);
                            $name = str_replace("&", "amp", $name);

                            $fileName = $name . "." . Input::file('image_file_1')->getClientOriginalExtension();

                            // Get new sizes
                            $newWidth = 1500;
                            $newHeight = 1500;

                            // Load
                            $thumb = imagecreatetruecolor($newWidth, $newHeight);

                            for ($i = 1; $i <= 9; $i++) {
                                $fileName = Input::file('image_file_' . $i)->getClientOriginalName();
                                /*
                                $lastdot = strrpos($fileName, ".");
                                $name = substr($fileName, 0, $lastdot);
                                */
                                $extension2 = Input::file('image_file_' . $i)->getClientOriginalExtension();
                                switch (strtolower($extension2)) {
                                    case 'jpg':
                                    case 'jpeg':
                                        $source = imagecreatefromjpeg(Input::file('image_file_' . $i)->getPathName());
                                        break;
                                    case 'gif':
                                        $source = imagecreatefromgif(Input::file('image_file_' . $i)->getPathName());
                                        break;
                                    case 'png':
                                        $source = imagecreatefrompng(Input::file('image_file_' . $i)->getPathName());
                                        break;
                                }

                                list($width, $height) = getimagesize(Input::file('image_file_' . $i)->getPathName());
                                $x = (($i - 1) % 3) * 500;
                                $y = floor(($i - 1) / 3) * 500;    

                                // Resize
                                imagecopyresized($thumb, $source, $x, $y, 0, 0, 500, 500, $width, $height);
                            }

                            // Output
                            switch (strtolower(Input::file('image_file_1')->getClientOriginalExtension())) {
                                case 'jpg':
                                case 'jpeg':
                                    imagejpeg($thumb, $this->uploadedPath . $fileName);
                                    break;
                                case 'gif':
                                    imagegif($thumb, $this->uploadedPath . $fileName);
                                    break;
                                case 'png':
                                    imagepng($thumb, $this->uploadedPath . $fileName);
                                    break;
                            }

                            @chmod($this->uploadedPath . $fileName, 0777);

                            $uploaded = true;
                        } else {
                            //ALL OTHER IMAGES

                            $fileSize = Input::file('image_file')->getSize();
                            if ($fileSize <= Constants::DSS_IMAGE_MAX_SIZE) {
                                if (!empty(Input::file('image_file')->getClientOriginalName())) {
                                    $fullName = Input::file('image_file')->getClientOriginalName();
                                    $lastPoint = strrpos($fullName, ".");
                                    $name = substr($fullName, 0, $lastPoint);

                                    $name = $name . '_' . Carbon::now()->format('dmy_Hi');
                                    $name = str_replace(" ", "_", $name);
                                    $name = str_replace(".", "_", $name);
                                    $name = str_replace("'", "_", $name);
                                    $name = str_replace("&", "amp", $name);

                                    $fileName = $name . "." . Input::file('image_file')->getClientOriginalExtension();
                                    $profile = ($this->request['imagetypeid'] == 4) ? 'profile' : 'general';

                                    $uploaded = GeneralFunctions::uploadImage(Input::file('image_file'), $this->uploadedPath . $fileName, $profile);

                                    if (!empty($this->request['image_file_old'])) {
                                        @unlink($this->uploadedPath . $this->request['image_file_old']);
                                    }
                                } else {
                                    $fileName = $this->request['image_file_old'];
                                }
                            } else {
                                $alert = 'Max image size exceeded. Uploaded files can be no larger than 10 megabytes.';
                                $uploaded = false;
                            }
                        }
                    } else {
                        $alert = 'Invalid File Type';
                    }
                }
            } else {
                $data = array(
                    'title'        => $title,
                    'imagetypeid'  => $imageTypeId
                );

                $this->qImage->updateData(array(
                    'imageid' => Route::input('ed')
                ), $data);

                $message = 'Edited Successfully';

                return redirect("/manage/q_image" . (!empty($this->patientId) ? '/' . $this->patientId : ''))->with('sh', $this->sh);
            }

            if (!empty($uploaded)) {
                if (!empty(Route::input('ed'))) {
                    $data = array(
                        'title'        => $title,
                        'imagetypeid'  => $imageTypeId,
                        'image_file'   => $banner1
                    );

                    $this->qImage->updateData(array(
                        'imageid' => Route::input('ed')
                    ), $data);

                    $message = 'Edited Successfully';

                    return redirect("/manage/q_image" . (!empty($this->patientId) ? '/' . $this->patientId : ''))->with('sh', $this->sh);
                } else {
                    $data = array(
                        'patientid'    => $this->patientId,
                        'title'        => $title,
                        'imagetypeid'  => $imageTypeId,
                        'image_file'   => $fileName,
                        'userid'       => Session::get('userId'),
                        'docid'        => Session::get('docId'),
                        'ip_address'   => Request::ip()
                    );

                    $imageId = $this->qImage->insertData($data);

                    $flowPg1 = $this->flowPg1->find($this->patientId);

                    if ($this->request['imagetypeid'] == 6) {
                        if (empty($flowPg1->rx_imgid) || $this->request['rx_update'] == 1) {
                            $data = array(
                                'rx_imgid'  => $imageId,
                                'rxrec'     => Carbon::now()->format('m/d/Y')
                            );

                            $this->flowPg1->updateData(array(
                                'pid' => $this->patientId
                            ), $data);
                        }
                    }

                    if ($this->request['imagetypeid'] == 7) {
                        if (empty($flowPg1->lomn_imgid) || $this->request['lomn_update'] == 1) {
                            $data = array(
                                'lomn_imgid'  => $imageId,
                                'lomnrec'     => Carbon::now()->format('m/d/Y')
                            );

                            $this->flowPg1->updateData(array(
                                'pid' => $this->patientId
                            ), $data);
                        }
                    }

                    if ($this->request['imagetypeid'] == 14) {
                        if (empty($flowPg1->rxlomn_imgid) || $this->request['rxlomn_update'] == 1) {
                            $data = array(
                                'rxlomn_imgid'  => $imageId,
                                'rxlomnrec'     => Carbon::now()->format('m/d/Y')
                            );

                            $this->flowPg1->updateData(array(
                                'pid' => $this->patientId
                            ), $data);
                        }
                    }

                    $message = 'Uploaded Successfully';

                    if ($this->request['flow'] == '1') {
                        return redirect('/manage/flowsheet3' . (!empty($this->patientId) ? '/' . $this->patientId : ''));
                    } elseif ($this->return == 'patinfo') {
                        $showBlock = array(0);

                        if ($this->returnField == 'profile') {
                            $showBlock['updateProfileImage'] = $fileName;
                        } elseif ($this->request['imagetypeid'] == 10) {
                            $showBlock['updateInsCard'] = array($fileName, 'p_m_ins_card');
                        } elseif ($this->request['imagetypeid'] == 12) {
                            $showBlock['updateInsCard'] = array($fileName, 's_m_ins_card');
                        }
                    } else {
                        return redirect('/manage/q_image' . (!empty($this->patientId) ? '/' . $this->patientId : ''));
                    }
                }
            }
        }

        $redirect = redirect('/manage/image/add');

        if (!empty($message)) {
            $data['message']     = $message;
            $data['title']       = $this->request['title'];
            $data['imageTypeId'] = $this->request['imagetypeid'];
        }

        if (!empty($showBlock)) {
            $data['showBlock'] = $showBlock;
        }

        if (!empty($alert)) {
            $data['alert'] = $alert;
        }

        $data['closePopup'] = true;

        if (!empty($data)) foreach ($data as $attribute => $value) {
            $redirect = $redirect->with($attribute, $value);
        }

        return $redirect;
    }

    public function imageHolder($image, $folder = null)
    {
        if (empty($folder)) {
            $folder = $this->uploadedPath;
        }

        return view('manage.imageHolder')->with('image', $image)->with('folder', $folder);
    }

    public function setInfoPopup()
    {
        if (Request::ajax()) {
            Session::put('sh', $this->sh);
            Session::put('it', $this->it);
            Session::put('return', $this->return);
            Session::put('field', $this->returnField);
        }
    }
}
