<?php
namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Request;
use Route;
use Session;
use Input;
use Mail;
use Carbon\Carbon;

use Ds3\Contracts\SupportTicketInterface;
use Ds3\Contracts\SupportResponseInterface;
use Ds3\Contracts\SupportCategoryInterface;
use Ds3\Contracts\SupportAttachmentInterface;
use Ds3\Contracts\CompanyInterface;
use Ds3\Admin\Contracts\AdminInterface;
use Ds3\Contracts\UserInterface;
use Ds3\Libraries\GeneralFunctions;
use Ds3\Libraries\Constants;

class TicketController extends Controller
{
    private $supportTicket;
    private $supportResponse;
    private $supportCategory;
    private $supportAttachment;
    private $company;
    private $admin;
    private $user;

    private $rid;
    private $urid;

    public function __construct(
        SupportTicketInterface $supportTicket,
        SupportResponseInterface $supportResponse,
        SupportCategoryInterface $supportCategory,
        SupportAttachmentInterface $supportAttachment,
        CompanyInterface $company,
        AdminInterface $admin,
        UserInterface $user
    ) {
        $this->supportTicket     = $supportTicket;
        $this->supportResponse   = $supportResponse;
        $this->supportCategory   = $supportCategory;
        $this->supportAttachment = $supportAttachment;
        $this->company           = $company;
        $this->admin             = $admin;
        $this->user              = $user;

        $this->request = Request::all();

        $this->rid  = GeneralFunctions::getRouteParameter('rid');
        $this->urid = GeneralFunctions::getRouteParameter('urid');
    }

    public function support()
    {
        if (isset($this->rid)) {
            $this->supportTicket->updateData($this->rid, array('viewed' => 0));
            $this->supportResponse->updateData($this->rid, array('viewed' => 0));
        }

        if (isset($this->urid)) {
            $this->supportTicket->updateData($this->urid, array('viewed' => 1));
            $this->supportResponse->updateData($this->urid, array('viewed' => 1));
        }

        $openTickets = $this->supportTicket->getOpenTickets(
            Session::get('docId'),
            array(
                'DSS_TICKET_STATUS_OPEN'     => Constants::DSS_TICKET_STATUS_OPEN,
                'DSS_TICKET_STATUS_REOPENED' => Constants::DSS_TICKET_STATUS_REOPENED,
                'DSS_TICKET_STATUS_CLOSED'   => Constants::DSS_TICKET_STATUS_CLOSED
            )
        );

        if (count($openTickets)) {
            foreach ($openTickets as $openTicket) {
                if ($openTicket->create_type == '0' && $openTicket->viewed == '1') {
                    $openTicket->ticket_read = true;
                } else {
                    $openTicket->ticket_read = false;
                }

                if (!empty($openTicket->last_response)) {
                    $openTicket->latest = $openTicket->last_response;
                } else {
                    $openTicket->latest = $openTicket->adddate;
                }
            }
        }

        $closedTickets = $this->supportTicket->getClosedTickets(Session::get('docId'), Constants::DSS_TICKET_STATUS_CLOSED);

        if (count($closedTickets)) {
            foreach ($closedTickets as $closedTicket) {
                if (!empty($closedTicket->last_response)) {
                    $closedTicket->latest = $closedTicket->last_response;
                } else {
                    $closedTicket->latest = $closedTicket->adddate;
                }
            }
        }

        foreach ($this->request as $name => $value) {
            $data[$name] = $value;
        }

        $data = array_merge($data, array(
            'openTickets'           => $openTickets,
            'closedTickets'         => $closedTickets,
            'dssTicketStatusLabels' => Constants::$dss_ticket_status_labels
        ));

        // dd($data);

        return view('manage.support', $data);
    }

    public function show()
    {
        $nonActiveCategories = $this->supportCategory->getNonActive();

        $billingCompanies = $this->company->getBilling(
            array(
                'c.use_support' => 1,
                'u.userid'      => Session::get('docId')
            ),
            'c.name'
        );

        $data = array(
            'nonActiveCategories' => $nonActiveCategories,
            'billingCompanies'    => $billingCompanies,
            'categoryId'          => !empty($this->request['category_id']) ? $this->request['category_id'] : null,
            'companyId'           => !empty($this->request['company_id']) ? $this->request['company_id'] : null,
            'title'               => !empty($this->request['title']) ? $this->request['title'] : null,
            'body'                => !empty($this->request['body']) ? $this->request['body'] : null,
            'buttonText'          => 'Add ',
            'alert'               => Session::get('alert'),
            'redirect'            => Session::get('redirect')
        );

        // dd($data);

        return view('manage.add_ticket', $data);
    }

    public function add()
    {
        if (!empty($this->request['ticketsub']) && $this->request['ticketsub'] == 1) {
            $data = array(
                'title'       => $this->request['title'],
                'category_id' => $this->request['category_id'],
                'company_id'  => $this->request['company_id'],
                'body'        => $this->request['body'],
                'userid'      => Session::get('userId'),
                'docid'       => Session::get('docId'),
                'create_type' => '1',
                'creator_id'  => Session::get('userId'),
                'ip_address'  => Request::ip()
            );

            $insertedTicketId = $this->supportTicket->insertData($data);

            foreach (Input::file('attachment') as $file) {
                if (!empty($file->getPathName()) && $file->getSize() <= Constants::DSS_IMAGE_MAX_SIZE) {
                    $attachment = 'support_attachment_' . $insertedTicketId . '_' . Session::get('docId') . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . '/shared/q_file/', $attachment);

                    $data = array(
                        'filename'  => $attachment,
                        'ticket_id' => $insertedTicketId
                    );

                    $this->supportAttachment->insertData($data);
                }
            }

            $supportAdmins = $this->admin->getSupportAdmins($this->request['category_id']);
            $admins = array();
            if (count($supportAdmins)) {
                foreach ($supportAdmins as $supportAdmin) {
                    array_push($admins, $supportAdmin->email);
                }
            }

            $user = $this->user->findUser(Session::get('userId'));

            $message = 'Support ticket has been opened by ' . $user->name . '.';
            $subject = 'Support Ticket Opened';
            Mail::raw($message, function($message) use ($admins, $subject)
            {
                $message->from('support@dentalsleepsolutions.com', 'Dental Sleep Solutions');
                $message->to($admins)->subject($subject);
            });

            $alert = 'Thank you for your submission! We will respond promptly to you inquiry.';
            return redirect('/manage/add_ticket')->with('alert', $alert)->with('redirect', true);
        }
    }

    public function view()
    {
        $this->supportTicket->updateData(Route::input('id'), array('viewed' => 1));
        $this->supportResponse->updateData(Route::input('id'), array('viewed' => 1));

        $ticket = $this->supportTicket->getTicketById(Route::input('id'));

        if (!empty($ticket->company_name)) {
            $companyName = $ticket->company_name;
        } else {
            $companyName = 'Dental Sleep Solutions';
        }

        $attachments = $this->supportAttachment->getAttachmentsById(array('ticket_id' => Route::input('id')));

        if (empty($ticket->create_type)) {
            $admin = $this->admin->findAdmin($ticket->creator_id);
            $name = 'Support - ' . $admin->username;
        } elseif ($ticket->create_type == '1') {
            $user = $this->user->findUser($ticket->creator_id);
            $name = $user->name;
        } else {
            $name = '';
        }

        $responses = $this->supportResponse->getResponsesById(array('ticket_id' => Route::input('id')));

        if (count($responses)) {
            foreach ($responses as $response) {
                $response->attachments = $this->supportAttachment->getAttachmentsById(array('response_id' => $response->id), true);

                if ($response->response_type == '0') {
                    $admin = $this->admin->findAdmin($response->responder_id);
                    $responseName = 'Support - ' . $admin->username;
                } elseif ($response->response_type == '1') {
                    $user = $this->user->findUser($response->responder_id);
                    $responseName = $user->name;
                } else {
                    $responseName = '';
                }

                $response->name = $responseName;
                $response->add_date = Carbon::parse($response->adddate)->format('m/d/Y h:i:s a');
            }
        }

        if (!empty($ticket->status) && ($ticket->status === Constants::DSS_TICKET_STATUS_OPEN || $ticket->status === Constants::DSS_TICKET_STATUS_REOPENED)) {
            $ticketStatus = true;
        } else {
            $ticketStatus = false;
        }

        foreach ($this->request as $title => $value) {
            $data[$title] = $value;
        }

        $data = array_merge($data, array(
            'companyName'  => $companyName,
            'ticket'       => $ticket,
            'attachments'  => $attachments,
            'responses'    => $responses,
            'name'         => $name,
            'id'           => Route::input('id'),
            'ticketStatus' => $ticketStatus,
            'showAlert'    => !empty(Session::get('showAlert')) ? Session::get('showAlert') : false
        ));

        // dd($data);

        return view('manage.view_support_ticket', $data);
    }

    public function submitResponse()
    {
        if (isset($this->request['respond'])) {
            $insertedResponseId = 0;
            if (!empty($this->request['body']) || !empty(Input::file('attachment')[0])) {
                $data = array(
                    'ticket_id'     => Route::input('id'),
                    'responder_id'  => Session::get('userId'),
                    'response_type' => 1,
                    'body'          => $this->request['body'],
                    'ip_address'    => Request::ip()
                );

                $insertedResponseId = $this->supportResponse->insertData($data);
            }

            if (!empty($this->request['close']) && $this->request['close'] == 2) {
                $this->supportTicket->updateData(Route::input('id'), array('status' => '2'), true);
            }

            $reopen = false;
            if (!empty($this->request['reopen']) && $this->request['reopen'] == 1) {
                $this->supportTicket->updateData(Route::input('id'), array('status' => '1'), true);
                $reopen = true;
            }

            if (count(Input::file('attachment'))) {
                foreach (Input::file('attachment') as $file) {
                    if (!empty($file)) {
                        $attachment = 'support_attachment_' . $insertedResponseId . '_' . Session::get('docId') . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path() . '/shared/q_file/', $attachment);

                        $data = array(
                            'filename'    => $attachment,
                            'ticket_id'   => Route::input('id'),
                            'response_id' => $insertedResponseId
                        );

                        $this->supportAttachment->insertData($data);
                    }
                }
            }

            if ($reopen) {
                return redirect('/manage/view_support_ticket/' . Route::input('id'))->with('showAlert', true);
            } else {
                return redirect('/manage/view_support_ticket/' . Route::input('id'));
            }
        }
    }
}
