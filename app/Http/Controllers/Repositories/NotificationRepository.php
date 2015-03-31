<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\NotificationInterface;
use Ds3\Eloquent\Notification;

class NotificationRepository implements NotificationInterface
{
    public function getNotifications($where)
    {
        $notification = new Notification();

        foreach ($where as $key => $value) {
            $notification = $notification->where($key, '=', $value);
        }

        return $notification->get();
    }
}
