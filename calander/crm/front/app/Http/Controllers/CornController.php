<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 12/29/16
 * Time: 2:48 PM
 */

namespace App\Http\Controllers;


use App\Modules\Emails\Email;
use App\Modules\FactoryOrders\FactoryOrder;
use App\Modules\Invoices\Invoice;
use App\Modules\Orders\Order;
use Optimait\Laravel\Services\Email\EmailService;

class CornController extends Controller
{
    public function getAutoEmail()
    {
        $intervals = [1, 6, 9];
        $invoices = Invoice::selectRaw(\DB::raw("i.*, o.due_date, DATEDIFF(CURDATE(), o.due_date) as diff"))
            ->from(\DB::raw('invoices i left join orders o on i.order_id = o.id'))
            ->whereRaw(\DB::raw("DATE(o.due_date) < CURDATE()"))
            ->whereRaw(\DB::raw("DATEDIFF(CURDATE(), o.due_date) IN (" . implode(",", $intervals) . ")"))
            ->unPaid("i.status")
            ->with('order.creator')
            ->get();

        if ($invoices->count() > 0) {
            foreach ($invoices as $invoice) {
                $email = Email::GetByInterval($invoice->diff);
                if ($email) {
                    $emailService = new EmailService();
                    $emailService
                        ->setSubject($email->subject.' - '.$invoice->IID)
                        ->setTo($invoice->order->creator->email)
                        ->setBcc(['morten@morettimilano.com'])
                        ->sendEmail('emails.invoices.due', compact('invoice', 'email'));
                }

            }
        }

        return response("OK");
    }

    public function getAutoEmailInvoices()
    {
        $invoices = Invoice::unpaid()->with('order')->whereRaw(\DB::raw("DATE(created_at) <= DATE_SUB(NOW(), INTERVAL 10 day)"))->get();
        foreach ($invoices as $invoice) {
            if (!$invoice->order) {
                continue;
            }
            $user = $invoice->order->creator;
            $dateDiff = DateDiff(date("Y-m-d"), $invoice->order->createdDate());
            if ($dateDiff->days < 10) {
                continue;
            }

            if ($dateDiff->days > 10 && ($dateDiff - 10) % 7 > 0) {
                continue;
            }

            $subject = 'This is for 10 days';
            if ($dateDiff->days > 10) {
                $subject = 'This is subject for another';
            }
            $email = Email::GetByInterval($invoice->diff);
            if ($email) {
                $emailService = new EmailService();
                $emailService
                    ->setSubject($subject.' - '.$invoice->IID)
                    ->setTo($invoice->order->creator->email)
                    ->sendEmail('emails.invoices.due', compact('invoice', 'dateDiff'));
            }
        }

        return response("OK");
    }

    public function getProcessOrders()
    {
        $orders = Order::shipped()
            ->whereRaw("DATE(due_date) < CURDATE()")
            ->get();

        foreach ($orders as $order) {
            $order->becameDue();
        }

        return response("OKI");
    }

    public function getProcessFactoryOrders()
    {
        $orders = FactoryOrder::ordered()
            ->whereRaw("DATE(delivery_date) < CURDATE()")
            ->get();

        foreach ($orders as $order) {
            $order->becameDue();
        }

        return response("OKI");
    }


    public function getBackup(){
        $filename = EXPORT_TABLES(env("DB_HOST"), env("DB_USERNAME"), env("DB_PASSWORD"), env("DB_DATABASE"));
        $api_url = 'https://content.dropboxapi.com/2/files/upload'; //dropbox api url
        //$filename = "users.sql";

        $token = 'T_H7_xHcKRwAAAAAAAAA8GXOfOf9qaJFg_jkCsqSSBDBVe_rJ8Mc9_OyXY-9Tm9z'; // oauth token

        $headers = array('Authorization: Bearer '. $token,
            'Content-Type: application/octet-stream',
            'Dropbox-API-Arg: '.
            json_encode(
                array(
                    "path"=> '/'. basename($filename),
                    "mode" => "add",
                    "autorename" => true,
                    "mute" => false
                )
            )

        );

        $ch = curl_init($api_url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);

        $path = $filename;
        $fp = fopen($path, 'rb');
        $filesize = filesize($path);

        curl_setopt($ch, CURLOPT_POSTFIELDS, fread($fp, $filesize));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_VERBOSE, 1); // debug

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        echo($response.'<br/>');
        echo($http_code.'<br/>');

        curl_close($ch);
    }
}