<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Emails\Email;
use App\Modules\Emails\EmailRepository;
use App\Modules\Products\ProductRepository;
use Exception;
use Input;
use Optimait\Laravel\Exceptions\ApplicationException;
use Optimait\Laravel\Services\PdfExport\PdfExportService;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use View;

class EmailsController extends Controller
{


    /**
     * Display a listing of the resource.
     * GET /EmailEmails
     *
     * @return Response
     */
    public function getIndex()
    {
        $emails = Email::all();
        return sysView('emails.index', compact('emails'));
    }

    public function putIndex()
    {
        $data = Input::all();
        foreach ($data['subject'] as $k => $subject) {
            $email = Email::find($k);
            if ($email) {
                $email->fill([
                    'subject' => $subject,
                    'message' => $data['message'][$k]
                ]);
                $email->save();
            }
        }

        return redirect()->back()->with(['success' => 'Updated']);
    }

    public function getEdit($id)
    {
        $email = Email::find(decryptIt($id));

        return sysView('emails.edit', compact('email'));
    }

    public function putUpdate($id)
    {
        $email = Email::find(decryptIt($id));
        $data = Input::all();
        if ($email) {
            $email->fill([
                'subject' => $data['subject'],
                'message' => $data['message']
            ]);
            $email->save();
        }

        return response()->json(array(
            'notification' => ReturnNotification(array('success' => 'Updated Successfully')),
            'redirect' => sysUrl('emails')
        ));
    }

}
