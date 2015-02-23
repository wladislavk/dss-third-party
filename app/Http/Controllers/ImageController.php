<?php namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Request;
use Session;
use Route;
use Input;

use Ds3\Contracts\QImageInterface;
use Ds3\Contracts\ImageTypeInterface;
use Ds3\Contracts\FlowPg1Interface;
use Ds3\Contracts\SleeplabInterface;
use Ds3\Contracts\PatientInterface;
use Ds3\Contracts\InsDiagnosisInterface;
use Ds3\Contracts\DeviceInterface;
use Ds3\Libraries\Constants;

class ImageController extends Controller
{
	private $qImage;
	private $imageType;
	private $flowPg1;
	private $sleeplab;
	private $patient;
	private $insDiagnosis;
	private $device;

	private $request;

	public function __construct(QImageInterface $qImage,
								ImageTypeInterface $imageType,
								FlowPg1Interface $flowPg1,
								SleeplabInterface $sleeplab,
								PatientInterface $patient,
								InsDiagnosisInterface $insDiagnosis,
								DeviceInterface $device)
	{
		$this->qImage 		= $qImage;
		$this->imageType 	= $imageType;
		$this->flowPg1 		= $flowPg1;
		$this->sleeplab 	= $sleeplab;
		$this->patient 		= $patient;
		$this->insDiagnosis = $insDiagnosis;
		$this->device 		= $device;
		$this->request 		= Request::all();
	}

	public function index()
	{
		$patientId = !empty(Route::input('pid')) ? Route::input('pid') : null;
		$ed = !empty($this->request['ed']) ? $this->request['ed'] : null;

		$image = $this->qImage->get($ed);

		if (!empty($message)) {
			$title = $this->request['title'];
			$imageTypeId = $this->request['imagetypeid'];
		} elseif (!empty($image)) {
			$title 			= $image->title;
			$imageFile 		= $image->image_file;
			$imageTypeId 	= $image->imagetypeid;
			$butText 		= 'Add';
		} else {
			$title = null;
		}

		if (empty($imageTypeId)) {
			$imageTypeId = !empty($this->request['sh']) ? $this->request['sh'] : null;
		}

		if (!empty($image->contactid)) {
			$butText = 'Edit ';
		} else {
			$butText = 'Add ';
		}

		$imageTypes = $this->imageType->get();

		$showBlock = array();

		if (!empty($this->request['itro']) && $this->request['itro'] == 1) {
			$showBlock['imageTypes'] = true;
		}

		$flowPg1 = $this->flowPg1->get($patientId);

		if (!empty($imageFile)) {
			$showBlock['imageFile'] = true;
		}

		$labels = array('', 'Facial Right', 'Facial Front', 'Facial Left', 'Retracted Right', 'Retracted Frontal', 'Retracted Left', 'Occlusal Upper', 'Mallampati', 'Occlusal Lower');

		$patients = $this->patient->get(array('patientid' => $patientId));

		$patient = count($patients) ? $patients[0] : null;

		$sleepSlabs = $this->sleeplab->get(array(
			'status' 	=> 1,
			'docid'		=> Session::get('docId')
		), 'company');

		$insDiagnoses = $this->insDiagnosis->get();

		$devices = $this->device->get();

		$data = array(
			'path'			=> '/' . Request::segment(1) . '/' . Request::segment(2),
			'message'		=> !empty(Session::get('message')) ? Session::get('message') : null,
			'sh'			=> !empty($this->request['sh']) ? $this->request['sh'] : null,
			'it'			=> !empty($this->request['it']) ? $this->request['it'] : null,
			'return'		=> !empty($this->request['return']) ? $this->request['return'] : '',
			'returnField'	=> !empty($this->request['return_field']) ? $this->request['return_field'] : '',
			'patientId' 	=> $patientId,
			// 'flow'			=> $flow,
			'butText'		=> $butText,
			'title'			=> $title,
			'imageTypes'	=> $imageTypes,
			'imageTypeId'	=> $imageTypeId,
			'flowPg1'		=> $flowPg1,
			'labels'		=> $labels,
			'image'			=> $image,
			'sleepSlabs'	=> $sleepSlabs,
			'insDiagnoses'	=> $insDiagnoses,
			'patient'		=> $patient,
			'devices'		=> $devices,
			'showBlock'		=> $showBlock
		);

		// dd($data);

		return view('manage.add_image', $data);
	}

	public function add()
	{
		$patientId = !empty(Route::input('pid')) ? Route::input('pid') : null;

		if (!empty($this->request['submitnewsleeplabsumm'])) {
			$sleeplabData = array('date', 'sleeptesttype', 'place', 'diagnosising_doc', 'diagnosising_npi',
				'apnea', 'hypopnea', 'ahi', 'ahisupine', 'rdi', 'rdisupine', 'o2nadir', 't9002', 'sleepefficiency',
				'cpaplevel', 'dentaldevice', 'devicesetting', 'diagnosis', 'notes', 'testnumber', 'needed', 'scheddate',
				'completed', 'interpolation', 'copyreqdate', 'sleeplab'
			);

			foreach ($sleeplabData as $attribute) {
				$summSleeplabData[$attribute] = $this->request[$attribute];
			}
			
			if (!empty(Input::file('ss_file'))) {
				$fileName = Input::file('ss_file')->getClientOriginalExtension();
				$lastdot = strrpos($fileName, ".");
				$name = substr($fileName, 0, $lastdot);
				$extension = substr($fileName, $lastdot + 1);
				$banner1 = $name . '_' . date('dmy_Hi');
				$banner1 = str_replace(" ", "_", $banner1);
				$banner1 = str_replace(".", "_", $banner1);
				$banner1 = str_replace("'", "_", $banner1);
				$banner1 = str_replace("&", "amp", $banner1);
				$banner1 = preg_replace("/[^a-zA-Z0-9_]/", "", $banner1);
				$banner1 .= ".". $extension;

				/**

				*/

				$uploaded = uploadImage(Input::file('ss_file'), "/shared/q_file/" . $banner1);

				/**

				*/

				if ($uploaded) {
					$data = array(
						'patientid' => $patientId,
						'title' => $summSleeplabData['sleeptesttype'] . ' ' . $summSleeplabData['date'],
						'imagetypeid' => 1,
						'image_file' => $banner1,
						'userid' => Session::get('userId'),
						'docid' => Session::get('docId'),
						'ip_address' => Request::ip()
					);

					$imageId = $this->qImage->insertData($data);
				}
			} else {
				$banner1 = null;
				$imageId = null;
			}
			
		}

		$redirect = redirect('/manage/add_image');

		$data = array(
			'message' => 'test'
		);

		foreach ($data as $attribute => $value) {
			$redirect = $redirect->with($attribute, $value);
		}

		return redirect('/manage/add_image')->with('message', 'test');
	}
}