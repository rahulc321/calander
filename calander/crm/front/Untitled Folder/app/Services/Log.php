<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 10/21/16
 * Time: 11:39 AM
 */

namespace App\Services;


use App\Modules\Leads\Lead;
use App\Modules\Logs;

class Log
{

    private $lead;
    private $disposition = null;
    private $status = null;

    public function __construct(Lead $lead){
        $this->lead = $lead;
    }

    public static function ForLead($lead){
        $log = new Log($lead);
        return $log;
    }

    /**
     * @return mixed
     */
    public function getDisposition()
    {
        return $this->disposition;
    }

    /**
     * @param mixed $disposition
     * @return Log
     */
    public function setDisposition($disposition)
    {
        $this->disposition = $disposition;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return Log
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function finish($message){
        $this->lead->logs()->save(new Logs([
            'log_text' => $message,
            'disposition' => $this->disposition,
            'status_id' => $this->status
        ]));
    }


}