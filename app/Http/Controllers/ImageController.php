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
use Ds3\Contracts\SummSleeplabInterface;
use Ds3\Contracts\PatientInterface;
use Ds3\Contracts\InsDiagnosisInterface;
use Ds3\Contracts\DeviceInterface;
use Ds3\Libraries\Constants;
use Ds3\Libraries\GeneralFunctions;

class ImageController extends Controller
{
	private $qImage;
	private $imageType;
	private $flowPg1;
	private $sleeplab;
	private $summSleeplab;
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
								DeviceInterface $device,
								SummSleeplabInterface $summSleeplab)
	{
		$this->qImage 		= $qImage;
		$this->imageType 	= $imageType;
		$this->flowPg1 		= $flowPg1;
		$this->sleeplab 	= $sleeplab;
		$this->summSleeplab = $summSleeplab;
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

				$uploaded = GeneralFunctions::uploadImage(Input::file('ss_file'), "/shared/q_file/" . $banner1);

				if (!empty($uploaded)) {
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
			
			$data = array(
				'date'				=> $summSleeplabData['date'],
				'sleeptesttype'		=> $summSleeplabData['sleeptesttype'],
				'place'				=> $summSleeplabData['place'],
				'diagnosising_doc'	=> $summSleeplabData['diagnosising_doc'],
				'diagnosising_npi'	=> $summSleeplabData['diagnosising_npi'],
				'ahi'				=> $summSleeplabData['ahi'],
				'ahisupine'			=> $summSleeplabData['ahisupine'],
				'rdi'				=> $summSleeplabData['rdi'],
				'rdisupine'			=> $summSleeplabData['rdisupine'],
				'o2nadir'			=> $summSleeplabData['o2nadir'],
				't9002'				=> $summSleeplabData['t9002'],
				'dentaldevice'		=> $summSleeplabData['dentaldevice'],
				'devicesetting'		=> $summSleeplabData['devicesetting'],
				'diagnosis'			=> $summSleeplabData['diagnosis'],
				'filename'			=> $banner1,
				'notes'				=> $summSleeplabData['notes'],
				'testnumber'		=> $summSleeplabData['testnumber'],
				'sleeplab'			=> $summSleeplabData['sleeplab'],
				'patiendid'			=> $patientId,
				'image_id'			=> $imageId
			);
			
			$summSleeplabId = $this->summSleeplab->insertData($data);

			if (empty($summSleeplabId)) {
				echo 'Could not add sleep lab... Please try again.';
			} else {
				if (!empty($uploaded)) {
					// code...
				}
				$message = 'Successfully added sleep lab' . $uploaded;

				return redirect("/manage/q_image" . (!empty($patientId) ? '/' . $patientId : ''));
			}
		}

		if (!empty($this->request['imagesub']) && $this->request['imagesub'] == 1) {
			$title = $this->request['title'];
			$imageTypeId = $this->request['imagetypeid'];
			if (!empty(Input::file('image_file')) || empty($this->request['ed'])) {
				// check
				if (Input::file('image_file')->error == 4 && Input::file('image_file1')->error == 4) {
					$uploaded = false;
				} else {
					if ($this->request['imagetypeid'] == 0 || (array_search(Input::file('image_file'), Constants::$dss_file_types) !== false)) {
						if ($imageTypeId == '0') {
							$fileName = Input::file('image_file_1')->name;
							$lastdot = strrpos($fileName, ".");
							$name = substr($fileName, 0, $lastdot);
							$extension = substr($fileName, $lastdot + 1);
							$banner1 = $name . '_' . date('dmy_Hi');
							$banner1 = str_replace(" ", "_", $banner1);
							$banner1 = str_replace(".", "_", $banner1);
							$banner1 = str_replace("'", "_", $banner1);
							$banner1 = str_replace("&", "amp", $banner1);
							$banner1 .= "." . $extension;

							// Get new sizes
							$newWidth = 1500;
							$newHeight = 1500;

							// Load
							$thumb = imagecreatetruecolor($newwidth, $newheight);
							for ($i = 1; $i <= 9; $i++) {
								$fileName = Input::file('image_file_' . $i)->name;
								$lastdot = strrpos($fileName, ".");
								$name = substr($fileName, 0, $lastdot);
								$extension2 = substr($fileName, $lastdot + 1);
								switch(strtolower($extension2)){
									case 'jpg':
									case 'jpeg':
										$source = imagecreatefromjpeg(Input::file('image_file_' . $i)->tmp_name);
										break;
									case 'gif':
										$source = imagecreatefromgif(Input::file('image_file_' . $i)->tmp_name);
										break;
									case 'png':
										$source = imagecreatefrompng(Input::file('image_file_' . $i)->tmp_name);
										break;
								}

								list($width, $height) = getimagesize(Input::file('image_file_' . $i)->tmp_name);
								$x = (($i - 1) % 3) * 500;
								$y = floor(($i - 1) / 3) * 500;	

								// Resize
								imagecopyresized($thumb, $source, $x, $y, 0, 0, 500, 500, $width, $height);
							}

							$fileName = Input::file('image_file_1')->name;
							$lastdot = strrpos($fileName, ".");
							$name = substr($fileName, 0, $lastdot);
							$extension = substr($fileName, $lastdot + 1);
							$banner1 = $name . '_' . date('dmy_Hi');
							$banner1 = str_replace(" ",  "_", $banner1);
							$banner1 = str_replace(".","_", $banner1);
							$banner1 = str_replace("'", "_", $banner1);
							$banner1 = str_replace("&", "amp", $banner1);
							$banner1 .= "." . $extension;

							// Output
							switch(strtolower($extension)){
								case 'jpg':
								case 'jpeg':
									imagejpeg($thumb, "/shared/q_file/" . $banner1);
									break;
								case 'gif':
									imagegif($thumb, "/shared/q_file/" . $banner1);                               
									break;
								case 'png':
									imagepng($thumb, "/shared/q_file/" . $banner1);
									break;
							}

							@chmod('/shared/q_file/' . $banner1, 0777);

							$uploaded = true;
						} else {
							//ALL OTHER IMAGES

							$fileSize = Input::file('image_file')->size;
							if ($fileSize <= Constants::DSS_IMAGE_MAX_SIZE) {
								if (!empty(Input::file('image_file')->name)) {
									$fileName = Input::file('image_file')->name;
									$lastdot = strrpos($fileName, ".");
									$name = substr($fileName, 0, $lastdot);
									$extension = substr($fileName, $lastdot + 1);
									$banner1 = $name . '_' . date('dmy_Hi');
									$banner1 = str_replace(" ", "_", $banner1);
									$banner1 = str_replace(".", "_", $banner1);
									$banner1 = str_replace("'", "_", $banner1);
									$banner1 = str_replace("&", "amp", $banner1);
									$banner1 .= ".". $extension;
									$profile = ($this->request['imagetypeid'] == 4) ? 'profile' : 'general';

									$uploaded = GeneralFunctions::uploadImage(Input::file('image_file'), '/shared/q_file/' . $banner1, $profile);

									if (!empty($this->request['image_file_old'])) {
										@unlink('/shared/q_file/' . $this->request['image_file_old']);
									}
								} else {
									$banner1 = $this->request['image_file_old'];
								}
							} else {
								// alert code...

								$uploaded = false;
							}
						}
					} else {
						// alert code...
					}
				}
			} else {
				$data = array(
					'title'			=> $title,
					'imagetypeid'	=> $imageTypeId
				);

				$this->qImage->updateData(array(
					'imageid' => !empty($this->request['ed']) ? $this->request['ed'] : null
				), $data);

				$message = 'Edited Successfully';

				return redirect("/manage/q_image" . (!empty($patientId) ? '/' . $patientId : ''))->with('sh', $this->request['sh']);
			}

			if (!empty($uploaded)) {
				if (!empty($this->request['ed'])) {
					$data = array(
						'title'			=> $title,
						'imagetypeid'	=> $imageTypeId,
						'image_file'	=> $banner1
					);

					$this->qImage->updateData(array(
						'imageid' => !empty($this->request['ed']) ? $this->request['ed'] : null
					), $data);

					$message = 'Edited Successfully';

					return redirect("/manage/q_image" . (!empty($patientId) ? '/' . $patientId : ''))->with('sh', $this->request['sh']);
				} else {
					$data = array(
						'patientid' 	=> $patientId,
						'title' 		=> $title,
						'imagetypeid'	=> $imageTypeId,
						'image_file' 	=> $banner1,
						'userid' 		=> Session::get('userId'),
						'docid' 		=> Session::get('docId'),
						'ip_address' 	=> Request::ip()
					);

					$imageId = $this->qImage->insertData($data);

					$flowPg1 = $this->flowPg1->get($patientId);

					if ($this->request['imagetypeid'] == 6) {
						if (empty($flowPg1->rx_imgid) || $this->request['rx_update'] == 1) {
							$data = array(
								'rx_imgid' 	=> $imageId,
								'rxrec' 	=> date('m/d/Y')
							);

							$this->flowPg1->updateData(array(
								'pid' => $patientId
							), $data);
						}
					}

					if ($this->request['imagetypeid'] == 7) {
						if (empty($flowPg1->lomn_imgid) || $this->request['lomn_update'] == 1) {
							$data = array(
								'lomn_imgid' 	=> $imageId,
								'lomnrec'		=> date('m/d/Y')
							);

							$this->flowPg1->updateData(array(
								'pid' => $patientId
							), $data);
						}
					}

					if ($this->request['imagetypeid'] == 14) {
						if (empty($flowPg1->rxlomn_imgid) || $this->request['rxlomn_update'] == 1) {
							$data = array(
								'rxlomn_imgid' 	=> $imageId,
								'rxlomnrec'		=> date('m/d/Y')
							);

							$this->flowPg1->updateData(array(
								'pid' => $patientId
							), $data);
						}
					}

					$message = 'Uploaded Successfully';

					if ($this->request['flow'] == '1') {
						return redirect('/manage/flowsheet3' . !empty($patientId) ? '/' . $patientId : '');
					} elseif ($this->request['return'] == 'patinfo') {
						if ($this->request['return_field'] == 'profile') {
							$showBlock['updateProfileImage'] = $banner1;
						} elseif ($this->request['imagetypeid'] == 10) {
							$showBlock['updateInsCard'] = array($banner1, 'p_m_ins_card');
						} elseif ($this->request['imagetypeid'] == 12) {
							$showBlock['updateInsCard'] = array($banner1, 's_m_ins_card');
						}
					} else {
						return redirect('/manage/q_image' . !empty($patientId) ? '/' . $patientId : '');
					}
				}
			}
		}

		$redirect = redirect('/manage/add_image');

		$data = array(
			'message' 			=> $message,
			'showJsFunctions' 	=> $showJsFunctions,
			'showBlock'			=> $showBlock
		);

		foreach ($data as $attribute => $value) {
			$redirect = $redirect->with($attribute, $value);
		}

		return $redirect;
	}
}