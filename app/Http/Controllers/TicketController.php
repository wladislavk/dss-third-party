<?php
namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Request;
use Session;
use Input;
use Mail;

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
}
