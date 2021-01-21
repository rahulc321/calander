<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Helpers\Authority;
use App\Http\Controllers\Controller;
use App\Modules\Users\Budget;
use App\Modules\Users\Message;
use App\Modules\Users\UserRepository;

use Exception;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Input;
use Optimait\Laravel\Exceptions\ApplicationException;
use Optimait\Laravel\Services\Email\EmailService;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use View;
// new add
use App\Modules\Orders\Order;
use App\Modules\Invoices\Invoice;
use App\Modules\Orders\Item;
use App\Modules\Products\Product;
use App\Modules\Products\Variant;
use App\Modules\Products\Color;
use App\Modules\Userinfo;
use App\Modules\Laser;
use App\Modules\Unpaid;
use Carbon\Carbon;

// jun
use Optimait\Laravel\Services\PdfExport\PdfExportService;

class UsersController extends Controller
{
    use ResetsPasswords;
    private $users;


    public function __construct(UserRepository $userRepository)
    {
        $this->users = $userRepository;
    }

    /**
     * Display a listing of the resource.
     * GET /userusers
     *
     * @return Response
     */
    public function index()
    {
        Authority::authorize('list', 'users');
        /*for ajax request*/
        if (\Request::ajax()) {
            return $this->getList();
        }
        return auth()->user()->isAdmin() ? view('webpanel.users.index') : sysView('users.index-for-dealers');
    }

    public function getList($id = 0)
    {
        $users = $this->users->getPaginated(Input::all(), 10, Input::get('orderBy', 'id'), Input::get('orderType', 'ASC'));
        /*echo 'hello world';*/

        return response()->json(array(
            'data' => view('webpanel.users.partials.list', compact('users'))->render(),
            'pagination' => sysView('includes.pagination', ['data' => $users])->render()
        ));
    }

    /**
     * Show the form for creating a new resource.
     * GET /users/create
     *
     * @return Response
     */
    public function create()
    {
        Authority::authorize('add', 'users');
        return sysView('users.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST /users
     *
     * @return Response
     */
    public function store()
    {
        Authority::authorize('add', 'users');
        //provide the validation data
        $this->users->validator->with(Input::all())->isValid();

        /*$this->users->checkDuplicateUsers(Input::get('email'));*/

        $user = $this->users->createUser(Input::all());
        //finally add the user
        /*var_dump($u);
        die();*/

        return response()->json(array(
            'notification' => ReturnNotification(array('success' => 'Created Successfully')),
            'redirect' => sysRoute('users.index')
        ));


    }

    /**
     * Display the specified resource.
     * GET /users/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * GET /users/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        Authority::authorize('edit', 'users');
        $id = decrypt($id);
        $user = $this->users->getById($id);
        if (is_null($user)) {
            throw new ResourceNotFoundException('User not Found');
        }
        return sysView('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     * PUT /users/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        Authority::authorize('edit', 'users');
        //set up validation data
        $id = decryptIt($id);
        $this->users->validator->with(Input::all())->setDefault('edit-with-pass');
        if (Input::get('password') == '' || !Input::get('password')) {
            $this->users->validator->setDefault('edit');
        }
        //check if the validation is OK
        $this->users->validator->isValid();
        if ($this->users->updateUser($id, Input::all())) {
            return response()->json(array(
                'notification' => ReturnNotification(array('success' => 'User Info Saved Successfully')),
                'redirect' => route('webpanel.users.index')
            ));

        }

    }

    /**
     * Remove the specified resource from storage.
     * DELETE /users/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Get the profile View
     *
     * @return \Illuminate\View\View
     */
    public function getProfile()
    {
        $user = $this->users->getById(\Auth::user()->id);
        return sysView('users.profile', compact('user'));
    }

    public function postProfile()
    {
        //set up validation data
        $this->users->validator->with(Input::all());
        $this->users->validator->setDefault('profile');

        //check if the validation is OK
        $this->users->validator->isValid();

        $userData = Input::all();
        if (Input::hasFile('photo')) {
            /*$this->users->validator->setDefault('photo');
            if (!$this->users->validator->isValid()) {
                return redirect()->back()->with(array('errors' => $this->users->validator->getErrors()));
            }*/
            $userData['photo_id'] = $this->users->uploadMedia(Input::file('photo'), true)->id;
            $this->users->deleteOldMedia(Input::get('old_photo'), true);;
        }


        if ($this->users->updateUser(\Auth::user()->id, $userData)) {
            return back()->with(array('success' => 'User Info Saved Successfully'));
            //return Redirect::route('admin.users.edit',array('id'=>$id))->with('success','User Saved Successfully');
        } else {
            redirect()->back()->with(array('error', 'Sorry! cannot perform the requested action at the moement'));
        }
    }

    /**
     * Get the change password view
     * @return \Illuminate\View\View
     */
    public function getChangePassword()
    {
        return sysView('users.changepassword');
    }

    /**
     * Post from change password view
     * @return \Illuminate\View\View
     */

    public function postChangePassword()
    {
        $this->users->validator->with(Input::all())->setDefault('change_password')->isValid();

        if ($this->users->changePassword(Input::get('password'))) {
            return back()->with(array('success' => 'User Info Saved Successfully'));
        } else {
            back()->with(array('error', 'Sorry! cannot perform the requested action at the moement'));
        }
    }


    public function getResetPassword(Guard $auth, PasswordBroker $passwords, $id)
    {
        $user = $this->users->getById(decrypt($id));
        if (!$user) {
            throw new ApplicationException("Invalid User Data");
        }
        $password = str_random(6);
        if ($this->users->changePassword($password, $user)) {
            $emailService = new EmailService();
            $emailService->sendEmail('emails.users.password-reset', compact('user', 'password'), function ($email) use ($user) {
                $email
                    ->setSubject(\Config::get('strings.user.passwordReset'))
                    ->setTo($user->email);
            });
            return redirect()->route('webpanel.users.index')->with('success', 'Password Reset Successful');
        }
        throw new ApplicationException("Opps! Something went wrong. Please try again later");
    }


    public function getDefaultPermissions($type)
    {
        $userType = \App\Modules\Users\Types\UserType::find($type);
        return view('webpanel.users.partials.default-permissions', compact('userType'));
    }


    /*
     * Delete the users along with their related data like permissions.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function getDelete($id)
    {
        Authority::authorize('delete', 'users');
        if ($this->users->deleteUser(decryptIt($id))) {
            echo 1;
        } else {
            throw new Exception('Cannot delete User at the moment');
        }
    }


    public function getClientMap()
    {
        $jsData['users'] = $this->users->getClientsForMap();
        return sysView('users.map', compact('jsData'));
    }


    public function getMessageInactive($id)
    {
        $user = $this->users->requireById(decryptIt($id));
        return sysView('users.partials.message-modal', compact('user'));
    }

    public function postMessageInactive(EmailService $emailService, $id)
    {
        if (!Input::get('message')) {
            throw new ApplicationException("Invalid");
        }

        $user = $this->users->requireById(decryptIt($id));
        $user->messages()->save(new Message([
            'message' => Input::get('message')
        ]));

        if (Input::get('sendEmail')) {
            $emailService->setSubject('Message from Moretti')->setTo($user->email)
                ->sendEmail('emails.users.inactive-message', [
                    'msg' => Input::get('message'),
                    'user' => $user
                ]);
        }

        return redirect()->back()->with(['success' => 'Message Sent']);

    }

    public function getBudgetPlanning($id)
    {
        $user = $this->users->requireById(decryptIt($id));
        return sysView('users.budget-planning', compact('user'));
    }

    public function postBudgetPlanning($id)
    {
        $user = $this->users->requireById(decryptIt($id));

        $data = Input::all();
        foreach ($data['budget'] as $month => $budget) {
            $user->budgets()->save(new Budget([
                'month' => $month,
                'budget' => $budget
            ]));
        }

        return redirect()->back()->with(['success' => 'Budget Updated']);
    }


     // new chnanges 15 april 
    public function contact(Request $request){ 

       

        $data= $request->all();
        if(!empty($data)){
            $current_user_email = \Auth::user()->email;
            $admin_email = 'rahulwebguruz97@gmail.com';;
            $name = \Auth::user()->full_name;
            $data1=
                [
                    "user_email" => $current_user_email ,
                    "name" => $name ,
                    "message" => $data['message']
                    
                ];
            $emailService = new EmailService();
            $emailService->sendEmail('emails.contact.contact', compact('data1', $data1), function ($email) use ($admin_email) {
            $email
            ->setSubject('Message from Contact Us')
            ->setTo($admin_email);
            });
            return view('webpanel.contact.create')->with('success_message','Your message has been sussessfully sent.');
            }
        //echo '<pre>';print_r($data['message']);die;
        //echo 'email'.Auth::user()->email;
        return view('webpanel.contact.create');
        //return view('emails.contact.contact');
    }

    // may new changes
    function user_info(){

        Authority::authorize('list', 'users');
        $userInfos = $this->users->getall();
        $i=0;
        $price ="";
        $allData= array();
        $status = array();
        $totalUnpaid = 0;
        foreach($userInfos as $userInfo){
            $userId= $userInfo['id'];
            //$userId= 193;
            
            $allData['data'][]=$userInfo;
            // paid data
            $oData = Item::join('invoices','invoices.order_id','=','order_items.order_id')
                ->select(\DB::raw('sum(price) as total'))
                ->where('invoices.user_id',$userId)->where('invoices.status',1)->first();
            //unpaid data
            $oData1 = Item::join('invoices','invoices.order_id','=','order_items.order_id')
                ->select(\DB::raw('sum(price) as total1'))
                ->where('invoices.user_id',$userId)->where('invoices.status',2)->first();
            // cancel 
            $cancel = Item::join('invoices','invoices.order_id','=','order_items.order_id')
                ->select(\DB::raw('sum(price) as ctotal'))
                ->where('invoices.user_id',$userId)->where('invoices.status',3)->first();
            // grand total
            $gtotal = Item::join('invoices','invoices.order_id','=','order_items.order_id')
                ->select(\DB::raw('sum(price) as gtotal'))
                ->where('invoices.user_id',$userId)->first();

            $allData['paid'][]=$oData;
            $allData['unpaid'][]=$oData1['total1'];
            $allData['cancel'][]=$cancel['ctotal'];
            $allData['gtotal'][]=$gtotal['gtotal'];
            $totalUnpaid = $totalUnpaid + $oData1['total1'];

/*************************************************************/
           	$laser = Laser::select(\DB::raw('sum(paid_price) as laser_price1'))->where('userId',$userId)->where('invoice_status',0)->get(); 
			$allData['laser_price1'][$userId]=$laser[0]['laser_price1'];

			$laser1 = Laser::where('userId',$userId)->get(); 
           	
			$t=0;
			
           	foreach($laser1 as $inv){
           		//echo '<pre>';print_r($laser1[$t]['invoice_id']);

				$invoiceId= $laser1[$t]['invoice_id'];
				$invoivce= Invoice::where('IID',$invoiceId)->first();
				$allData['status'][$userId] = $invoivce['status'];
				//echo '<pre>';print_r($invoivce['status']);
           		$t++;
           	}

           
          
/*************************************************************/

            $i++;
       
        }

        $totalUnpaid1 = 0;
        $oData2 = Item::join('invoices','invoices.order_id','=','order_items.order_id')
                ->select(\DB::raw('sum(price) as total1'))->where('invoices.status',2)->get();
        if(count($oData2)>0) {
            foreach($oData2 as $totalU){
                //echo '<pre>';print_r($oData1['total1']);die;
                 $totalUnpaid1 = $totalU['total1'];
            }
        }


       $allData['totalUnpaid'] = $totalUnpaid1;
        //echo '>>'.$i;die;
        //echo '<pre>';print_r($allData['status']);die;
        return view('webpanel.userinfo.index')->with('userInfo',$allData);
        //Total= 1145786.50
        //Unpaid= 259208.00
        //paid= 852556.50
        // cancel= 34022.00
    }

    function user_data($id){
         //$id=193;

        $uData = Item::join('invoices','invoices.order_id','=','order_items.order_id')->where('invoices.user_id',$id)->where('invoices.status',2)->groupBy('order_items.order_id')->orderBy('invoices.id', 'DESC')->get();
        //echo '<pre>';print_r($uData);die;
        // unpaid amount
        $unpaid = Item::join('invoices','invoices.order_id','=','order_items.order_id')
                ->select(\DB::raw('sum(price) as total1'))
                ->where('invoices.user_id',$id)->where('invoices.status',2)->first();


        $k=0;
        $dArr=array();
        $sum=0;
        foreach($uData as $data){
               
                $orderId= $data['order_id'];   
                $sum+= $data['price'];

               // get due date from order table
               $order = Order::where('id',$orderId)->first();
               $dArr['due_date'][]= Carbon::parse($order['due_date'])->format('Y-m-d');
               
               //echo  Carbon::parse($order['due_date'])->format('d/m/Y');
               //get invoice id
                $invoice = Invoice::where('order_id',$orderId)->where('status',2)->get();
                $dArr['invoice'][] = $invoice;
                 
                $oId= $invoice[0]['order_id'];
                
                //total 
                $total = Item::join('invoices','invoices.order_id','=','order_items.order_id')
                ->select(\DB::raw('sum(price) as total1'))
                ->where('order_items.order_id',$oId)->first();

                $dArr['total1'][]=$total['total1'];

                // // get laser data
                $dArr['pprice'][] = Laser::select(\DB::raw('sum(paid_price) as pprice'))->where('userId',$id)->where('invoice_id',$invoice[0]['IID'])->first();

            $k++;
        }
        
       
        // / echo '<pre>';print_r($dArr['due_date']);die;
        $total_ramainging = Unpaid::where('user_id',$id)->first();
        return view('webpanel.userinfo.alldata')->with('allProductDetail',$dArr)->with('unpaid',$unpaid)->with('total_ramainging',$total_ramainging);
    }

    function add_amount($id){
        //echo 'sada';die;
        $all=Input::get();
        $userinfo= new Userinfo;
        $userinfo->userId = $id;
        $userinfo->amount= $all['add_amt'];
        $userinfo->save();

        $unpaid= Unpaid::where('user_id',$id)->first();
        
        if(count($unpaid) > 0){
            $unpaid1= Unpaid::where('user_id',$id)->first();
            $unpaid1->user_id=$id;
            $unpaid1->total_amt=$unpaid1->total_amt+$all['add_amt'];
            $unpaid1->update();
        }else{
            $unpaid1= new Unpaid;
            $unpaid1->user_id=$id;
            $unpaid1->total_amt=$all['add_amt'];
            $unpaid1->save();
        }

        \Session::flash('addamount', 'You have successfully Add remaining balance!'); 
        return redirect('webpanel/user-data/'.$id);
    }

    public function single_amount($sid){
        $all=Input::get();
       //echo '<pre>';print_r($all);die;

        $remainingBalance = Userinfo::select(\DB::raw('sum(amount) as total'))->where('userId',$sid)->first();
        //echo $remainingBalance['total'];die;
        $laser= new Laser;
        $laser->userId=$all['uid'];
        $laser->invoice_id=$all['invoiceId'];
         
        $laser->paid_price=$all['paid_amt1'];
        $laser->save();

        // update remaining balance
        $unpaid= Unpaid::where('user_id',$sid)->first();
        $unpaid->total_amt= $unpaid->total_amt-$all['paid_amt1'];
        $unpaid->update();
        \Session::flash('paidamount', 'You have successfully paid balance!'); 
        return redirect('webpanel/user-data/'.$all['uid']);
    }

    public function changeStatus(){
        //echo '<pre>';print_r($_POST);

        $invoice = Invoice::where('IID',$_POST['invoiceID'])->first();
        $invoice->status=1;
        $invoice->update();

        $laser= Laser::where('invoice_id',$_POST['invoiceID'])->get();
        $j=0;
        foreach($laser as $dta1){
      	//echo '<pre>';print_r($dta1['laserId']);
      	$laser= Laser::where('laserId',$dta1['laserId'])->first();
      	$laser->invoice_status	=1;
        $laser->update();
        $j++;	
        }

        //echo '<pre>';print_r($laser);
    }
    public function view_history(){
        //echo '<pre>';print_r($_POST);

       $lasers= Laser::where('userId',$_POST['id'])->get();

       ?>
       <div class="r_history1">
        <a href="javascript:void(0)" style="float:right" class="hide_histroy1 btn btn-warning">Hide History</a>
       <center><h3>View Paid Amount History</h3></center>
       <table class="table table-bordered  table-binvoiceed deleteArena table-striped view_h"
                       data-request-url="<?php echo route('webpanel.invoices.index'); ?>">
                    <thead>
                    <tr >
                        <th class="table-success">SN</th>
                        <th class="sortableHeading table-success" data-invoiceBy="OID">Invoice Id</th>
                        <th class="table-success">Paid Price</th>
                        <th class="table-success">Date </th>
                       
                            
                    </tr>
                    </thead>
                    
                    <tbody>

       <?php 
       $i=1;
       foreach($lasers as $laser){ ?>
       
                        
                        <tr>
                            <td><?=$i?></td>
                            <td><?=$laser['invoice_id']?></td>
                            <td><?=$laser['paid_price']?></td>
                            <td><?=date('d-F-Y', strtotime($laser['created_at']))?></td>
                        </tr>
                         
                   
      <?php $i++;  } ?>

       </tbody>

        </table>
    </div>
    <?php 
    }


     public function rebal_history(){
        //echo '<pre>';print_r($_POST);

       $lasers= Userinfo::where('userId',$_POST['id'])->get();

       ?>

        <div class="r_history">
        <a href="javascript:void(0)" style="float:right" class="hide_histroy btn btn-warning">Hide History</a>
       <center><h3>View Remaining Balance History</h3></center>
       <table class="table table-bordered  table-binvoiceed deleteArena table-striped view_h"
                       data-request-url="<?php echo route('webpanel.invoices.index'); ?>">
                    <thead>
                    <tr >
                        <th class="table-success">SN</th>
                        
                        <th class="table-success">Amount</th>
                        <th class="table-success">Date </th>
                       
                            
                    </tr>
                    </thead>
                    
                    <tbody>

       <?php 
       $i=1;
       foreach($lasers as $laser){ ?>
       
                        
                        <tr>
                            <td><?=$i?></td>
                             
                            <td><?=$laser['amount']?></td>
                            <td><?=date('d-F-Y', strtotime($laser['created_at']))?></td>
                        </tr>
                         
                   
      <?php $i++;  } ?>

       </tbody>

        </table>
    </div>
    <?php 
    }

    public function sendmail(PdfExportService $exportService,Request $request){
        error_reporting(0);
        $allData= $request->all();
       // echo '<pre>';print_r($request->all());
        $invoice = Invoice::where('id',$request->invoiceId)->first();
        $userInfo = $userInfos = $this->users->getUserDetails($request->userId);
        if (is_null($invoice)) {
            throw new ResourceNotFoundException('Invoice Not Found');
        }
			$pdf = \PDF::loadHtml(view('pdf.orders.invoice', compact('order', 'invoice'))->render());
            $admin_email = $userInfo->email;
            //$admin_email = 'rahulwebguruz97@gmail.com';;
            $name = $userInfo->full_name;
            $data1=
                [
                    "InvoiceId" => $allData['IID'],
                    "paidAmt" => $allData['paidPrice1'] ,
                    "message" => $allData['sendtext'] ,
                    "fileName" => 'IID-'.$invoice->IID .'-'.time(). '.pdf',
                    "unpaidAmt" => $allData['uPaidPrice1']
                    
                ];
            //echo '<pre>';print_r($data1);die;

            /*$emailService = new EmailService();
            $emailService->sendEmail('emails.contact.pdf', compact('data1', $data1), function ($email) use ($admin_email) {
            $email
            ->setSubject('Message from User Info')
            ->setTo($admin_email)
            ->setAttachments(public_path("uploads/attachments/pdf/$fileName"));
            });*/
           
            //return view('emails.contact.pdf')->with('data1',$data1);


            \Mail::send('emails.contact.pdf',compact('data1', $data1), function($message) use ($admin_email, $pdf)
			{
			    $message->to($admin_email);
			    $message->subject('Message from User Info');
			    $message->bcc('morettimilano@gmail.com');
			    //$message->from('sender@domain.net');
			   /* $message->attach(public_path("uploads/attachments/pdf/$fileName"), ['as' => 'Invoice.pdf','mime' => 'application/pdf']);*/
			    $message->attachData($pdf->output(), 'Invoice.pdf',['mime' => 'application/pdf']);
			});

             \Session::flash('sendemail', 'You have successfully sent Email!');

            return redirect('webpanel/user-data/'.$allData['userId']);
           
    }



}