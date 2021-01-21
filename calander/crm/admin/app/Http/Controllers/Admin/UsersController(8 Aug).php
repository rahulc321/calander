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
        foreach($userInfos as $userInfo){
            $userId= $userInfo['id'];
            //$userId= 95;
            //$userId= 316;
            
            $allData['data'][]=$userInfo;
            // paid data
            $oData = Order::join('invoices','invoices.order_id','=','orders.id')
                ->select(\DB::raw('sum(price) as total,sum(shipping_price) as shipping_price,tax_percent'))
                ->where('invoices.user_id',$userId)->where('invoices.status',1)->get();
            //unpaid data
            $oData1 = Order::join('invoices','invoices.order_id','=','orders.id')
                ->select(\DB::raw('sum(price) as total1,sum(shipping_price) as shipping_price,tax_percent'))
                ->where('invoices.user_id',$userId)->where('invoices.status',2)->get();
               // echo '<pre>';print_r($oData1 );die;
            // cancel 
            
            $cancel = Order::join('invoices','invoices.order_id','=','orders.id')
                ->select(\DB::raw('sum(price) as ctotal,sum(shipping_price) as shipping_price,tax_percent'))
                ->where('invoices.user_id',$userId)->where('invoices.status',3)->get();

            
           
            //echo '<pre>';print_r($oData);die;
            // get tax
            $paidTax= ($oData[0]['total']+$oData[0]['shipping_price'])*$oData[0]['tax_percent']/100;

            $unPaidTax= ($oData1[0]['total1']+$oData1[0]['shipping_price'])*$oData1[0]['tax_percent']/100;

            $canTax= ($cancel[0]['ctotal']+$cancel[0]['shipping_price'])*$cancel[0]['tax_percent']/100;
            
             
            $allData['paid'][$userId]=$oData[0]['total']+$oData[0]['shipping_price']+$paidTax;

            $allData['unpaid'][]=$oData1[0]['total1']+$oData1[0]['shipping_price']+$unPaidTax;

            $allData['cancel'][]=$cancel[0]['ctotal']+$cancel[0]['shipping_price']+$canTax;

           // echo 'un'.$oData1['total1'];echo '<br>';
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


        $paidPrice1 = Laser::select(\DB::raw('sum(paid_price) as paid'))->get();
        //echo '<pre>';print_r($paidPrice1[0]['paid']);
        $paidPrice= $paidPrice1[0]['paid'];

        $oData1 = Order::join('invoices','invoices.order_id','=','orders.id')
                // ->where('invoices.IID',3487)
                ->where('invoices.status',2)->get();
        
        $sum=0;
        foreach($oData1 as $unPaidPrice){
            //echo '<pre>';print_r($unPaidPrice);
            $price=$unPaidPrice['price'];
            $shipPrice=$unPaidPrice['shipping_price'];
            $tax =$unPaidPrice['tax_percent'];
            $k=100;
             
            if($tax==NULL){
                $act=$price+$shipPrice;
                $totalAmt=$act+$price;
                $totalAmt=$price+$shipPrice;
                // echo  $price.'+'.$shipPrice.'='.$totalAmt; echo '<br>';
            }else{
                $act=$price+$shipPrice;
                $totalTax=$act*$tax/100;
                $totalAmt=$totalTax+$price;
                // echo  $price.'-'.$tax.'/'.$k.'='.$totalAmt; echo '<br>';
            }
            $sum+=$totalAmt;
        }
        

        // echo '<pre>';print_r($allData['gtotal']);
        //  die;
        //echo '>>'.$i;die;
        //echo '<pre>';print_r($allData['status']);die;
        return view('webpanel.userinfo.index')->with('userInfo',$allData)->with('unPaid',$sum)->with('paidPrice',$paidPrice);
        //Total= 1145786.50
        //Unpaid= 259208.00
        //paid= 852556.50
        // cancel= 34022.00
    }

    function user_data($id){
          //$id=95;

        $uData = Order::join('invoices','invoices.order_id','=','orders.id')
        // ->leftjoin('tbl_laser', 'invoices.IID', '=', 'tbl_laser.invoice_id')
        ->where('invoices.user_id',$id)->where('invoices.status',2)->orderBy('invoices.id', 'DESC')->get();
        // echo '<pre>';print_r($uData);die;
        // unpaid amount

        $currency = \DB::table('users')
            ->leftjoin('currencies','currencies.id','=','users.currency_id')
            ->where('users.id',$id)
            ->first();

       $symbol= $currency->symbol; 
       $conversion= $currency->conversion;


        $unPaidQuery = Order::join('invoices','invoices.order_id','=','orders.id')
                ->select(\DB::raw('sum(price) as total1,sum(shipping_price) as shipping_price,tax_percent'))
                ->where('invoices.user_id',$id)->where('invoices.status',2)->get();
        $unPaidTx= ($unPaidQuery[0]['total1']+$unPaidQuery[0]['shipping_price'])*$unPaidQuery[0]['tax_percent']/100;      
        $unpaid= $unPaidQuery[0]['total1']+$unPaidQuery[0]['shipping_price']+$unPaidTx;
         
         
        $k=0;
        $dArr=array();
        $sum=0;
        foreach($uData as $data){
               // echo '<pre>';print_r($data['IID']);die;
                $InvoiceID= $data['IID'];   
               
               //get invoice id
                $invoice = Invoice::where('IID',$InvoiceID)->where('status',2)->get();
                // // get laser data
                $dArr['laserPrice'][] = Laser::select(\DB::raw('sum(paid_price) as lPrice'))->where('userId',$id)->where('invoice_id',$InvoiceID)->first();

            $k++;
        }
        
       
        // echo '<pre>';print_r($dArr['laserPrice']);die;
        $total_ramainging = Unpaid::where('user_id',$id)->first();
        return view('webpanel.userinfo.alldata')->with('allProductDetail',$uData)->with('unpaid',$unpaid)->with('total_ramainging',$total_ramainging)->with('lprice',$dArr)->with('symbol',$symbol)->with('conversion',$conversion);
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
                            <td><?=number_format($laser['paid_price'],2)?></td>
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
                             
                            <td><?=number_format($laser['amount'],2)?></td>
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
       //echo '<pre>';print_r($request->all());
        $invoice = Invoice::where('id',$request->invoiceId)->first();
        $userInfo = $userInfos = $this->users->getUserDetails($request->userId);
        if (is_null($invoice)) {
            throw new ResourceNotFoundException('Invoice Not Found');
        }
       // echo $request->userId;die;
        $currency = \DB::table('users')
            ->leftjoin('currencies','currencies.id','=','users.currency_id')
            ->where('users.id',$request->userId)
            ->first();

            $symbol= $currency->symbol; 
            $conversion= $currency->conversion;

            
            $pdf = \PDF::loadHtml(view('pdf.orders.auto-invoice', compact('order', 'invoice','conversion','symbol'))->render());
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
                //$message->bcc('rahulwebgurux97@gmail.com');
                //$message->from('sender@domain.net');
               /* $message->attach(public_path("uploads/attachments/pdf/$fileName"), ['as' => 'Invoice.pdf','mime' => 'application/pdf']);*/
                $message->attachData($pdf->output(), 'Invoice.pdf',['mime' => 'application/pdf']);
            });

             \Session::flash('sendemail', 'You have successfully sent Email!');

            return redirect('webpanel/user-data/'.$allData['userId']);
           
    }

/****************************************/
/* Send automatic email
/*****************************************/
    // public function automaticEmail(){
    //    // echo 'Hey';die;
    //         $dueData = Order::join('invoices','invoices.order_id','=','orders.id')
    //         ->where('invoices.status',2)
    //         // ->where('invoices.IID',3414)
    //         ->where('orders.due_date','<',date('Y-m-d'))
    //         ->get();

    //         // from email table data
    //         $emails = \DB::table('emails')->get();
    //         // day diffrence
    //         $i=0;
    //         foreach($dueData as $dDate){

    //         $sendMail=0;
    //             //echo '<pre>';print_r($dDate->updated_at);die;
    //             $getDueDate= Carbon::parse($dDate->due_date)->format('Y-m-d');
                
    //             $dueDate = new \DateTime($getDueDate);
    //             $cDate= date("Y-m-d");
    //             $currentDate = new \DateTime($cDate);
    //             $difference = $dueDate->diff($currentDate);
                
    //             $dayDiff= $difference->days;
    //             //$dayDiff= 28;
    //             $invoice1 = Invoice::where('IID',$dDate->IID)->first();

    //             /********************************/
    //             // After 10 Days
    //             /********************************/
    //             $updateDate= Carbon::parse($dDate->updated_at)->format('Y-m-d');
    //             $dueDate1 = new \DateTime($updateDate);
    //             //$cDate1= date("2019-07-05");
    //             $cDate1= date("Y-m-d");
    //             $currentDate1 = new \DateTime($cDate1);
    //             $difference1 = $dueDate1->diff($currentDate1);
                
    //            $dayDiff1= $difference1->days;
    //             /*******************************/

    //             if($dayDiff >=7 && $dayDiff <=17){
    //                 if($dDate->emailStatus==0){
                       
    //                     $subject= $emails[0]->subject;
    //                     $message= $emails[0]->message;
    //                     $invoice1->emailStatus=1;
    //                     $invoice1->update();
    //                     $sendMail=1;
    //                 }
    //             }elseif($dayDiff >=17 && $dayDiff <=26){
    //                 if($dDate->emailStatus==1){
    //                     //echo 17;
    //                     $subject= $emails[1]->subject;
    //                     $message= $emails[1]->message;
    //                     $invoice1->emailStatus=2;
    //                     $invoice1->update();
    //                     $sendMail=1;

    //                 }
    //             }elseif($dayDiff == 27){
                    
    //                 if($dDate->emailStatus==2){
    //                     //echo 27;
    //                     $subject= $emails[2]->subject;
    //                     $message= $emails[2]->message;
    //                     $invoice1->emailStatus=3;
    //                     $invoice1->update();
    //                     $sendMail=1;

    //                 }
    //             }elseif($dayDiff > 27){
    //                  if($dayDiff1==10){
    //                     //echo 10;
    //                     $subject= $emails[3]->subject;
    //                     $message= $emails[3]->message;
    //                     $invoice1->emailStatus=4;
    //                     $invoice1->update();
    //                     $sendMail=1;
    //                  }else{
    //                     if($dDate->emailStatus==0){
    //                         $subject= $emails[3]->subject;
    //                         $message= $emails[3]->message;
    //                         $invoice1->emailStatus=4;
    //                         $invoice1->update();
    //                         $sendMail=1;

    //                     }
    //                  }


    //             }

    //             if($sendMail==1){

    //             // echo $subject;echo '<br>';
    //             // echo $message;echo '<br>';

    //             $invoice = Invoice::where('IID',$dDate->IID)->first();

    //             // 3414
    //             //
    //             //echo '<pre>';print_r($invoice);echo '<br>';
    //             $userInfo = $this->users->getUserDetails($dDate->user_id);
    //             if (is_null($invoice)) {
    //                 throw new ResourceNotFoundException('Invoice Not Found');
    //             }   
                    
    //                $pdf = \PDF::loadHtml(view('pdf.orders.invoice', compact('order', 'invoice'))->render());
    //                 $userEmail = $userInfo['email'];
    //                 //$userEmail = 'rahul@yopmail.com';;
                    
    //                 $data1=
    //                     [
    //                         "InvoiceId" => $dDate->IID,
    //                         "subject" => $subject,
    //                         "message" => $message,
    //                         "userName" => $userInfo['full_name']
                            
                            
    //                     ];
                    
    //                 \Mail::send('emails.contact.autoemail',compact('data1', $data1), function($message) use ($userEmail, $pdf)
    //                 {
    //                     $message->to($userEmail);
    //                     $message->subject('Message from Invoice');
    //                     $message->bcc('rahulwebguruz97@gmail.com');
    //                     $message->bcc('morettimilano@gmail.com');
    //                     $message->attachData($pdf->output(), 'Invoice.pdf',['mime' => 'application/pdf']);
    //                 });

                      
    //             $i++;
    //             }
            
    //         }
    //          echo $i."You have successfylly sent email.";
    //     }



    /*******************************************/

    /**************New Function ***************/

    /******************************************/

    public function automaticEmail(){
       // echo 'Hey';die;
            $dueData = Order::join('invoices','invoices.order_id','=','orders.id')
            ->where('invoices.status',2)
            //->where('invoices.IID',3523)
            ->where('orders.due_date','<',date('Y-m-d'))
            ->get();

            // from email table data
            $emails = \DB::table('emails')->get();
            // day diffrence
            $i=0;
            foreach($dueData as $dDate){
                //echo '<>';print_r($dDate);die;
            $uId=$dDate->user_id;
            $currency = \DB::table('users')
            ->leftjoin('currencies','currencies.id','=','users.currency_id')
            ->where('users.id',$uId)
            ->first();

            $symbol= $currency->symbol; 
            $conversion= $currency->conversion;

            $sendMail=0;
                //echo '<pre>';print_r($dDate->updated_at);die;
                $getDueDate= Carbon::parse($dDate->due_date)->format('Y-m-d');
                
                $dueDate = new \DateTime($getDueDate);
                //$cDate= date("2019-08-21");
                $cDate= date("Y-m-d");
                $currentDate = new \DateTime($cDate);
                $difference = $dueDate->diff($currentDate);
                
                $dayDiff= $difference->days;
                //$dayDiff= 28;
                $invoice1 = Invoice::where('IID',$dDate->IID)->first();
                //echo  $getDueDate;
                /********************************/
                // After 10 Days
                /********************************/
                $updateDate= Carbon::parse($dDate->updated_at)->format('Y-m-d');
                //$updateDate= date("2019-08-21");
                $dueDate1 = new \DateTime($updateDate);
                //$cDate1= date("2019-08-31");
                $cDate1= date("Y-m-d");
                $currentDate1 = new \DateTime($cDate1);
                $difference1 = $dueDate1->diff($currentDate1);
                
                $dayDiff1= $difference1->days;
                /*******************************/
               //echo '>>'.$dayDiff;echo '<br>';
                if($dayDiff ==7 && $dayDiff <=8){
                    //echo 7;die;
                    if($dDate->emailStatus==0){
                       
                        $subject= $emails[0]->subject;
                        $message= $emails[0]->message;
                        $invoice1->emailStatus=1;
                        $invoice1->update();
                        $sendMail=1;
                    }
                }elseif($dayDiff == 17 && $dayDiff <=18){
                     // echo 17;die;
                    if($dDate->emailStatus==1){
                        //echo 17;
                        $subject= $emails[1]->subject;
                        $message= $emails[1]->message;
                        $invoice1->emailStatus=2;
                        $invoice1->update();
                        $sendMail=1;

                    }
                }elseif($dayDiff == 27){
                    // echo 27;die;
                    if($dDate->emailStatus==2){
                        //echo 27;
                        $subject= $emails[2]->subject;
                        $message= $emails[2]->message;
                        $invoice1->emailStatus=3;
                        $invoice1->update();
                        $sendMail=1;

                    }
                }elseif($dayDiff > 27){

                     if($dayDiff1==10){
                        //echo 10;
                        $subject= $emails[3]->subject;
                        $message= $emails[3]->message;
                        $invoice1->emailStatus=4;
                        $invoice1->update();
                        $sendMail=1;
                     }else{
                         if($dDate->emailStatus==0){
                           // echo 27;
                            $subject= $emails[3]->subject;
                            $message= $emails[3]->message;
                            $invoice1->emailStatus=4;
                            $invoice1->update();
                            $sendMail=1;

                         }
                     }


                }
               // die;
                if($sendMail==1){

                // echo $subject;echo '<br>';
                // echo $message;echo '<br>';

                $invoice = Invoice::where('IID',$dDate->IID)->first();

                // 3414
                //
                //echo '<pre>';print_r($invoice);echo '<br>';
                $userInfo = $this->users->getUserDetails($dDate->user_id);
                if (is_null($invoice)) {
                    throw new ResourceNotFoundException('Invoice Not Found');
                }   
                    
                   $pdf = \PDF::loadHtml(view('pdf.orders.auto-invoice', compact('order', 'invoice','conversion','symbol'))->render());
                    $userEmail = $userInfo['email'];
                    //$userEmail = 'mkbhardwaj961@gmail.com';;
                    
                    $data1=
                        [
                            "InvoiceId" => $dDate->IID,
                            "subject" => $subject,
                            "message" => $message,
                            "userName" => $userInfo['full_name']
                            
                            
                        ];
                     
                    \Mail::send('emails.contact.autoemail',compact('data1', $data1), function($message) use ($userEmail, $pdf)
                    {
                        $message->to($userEmail);
                        $message->subject('Message from Invoice');
                        $message->bcc('sonu@yopmail.com');
                        $message->bcc('morettimilano@gmail.com');
                        $message->attachData($pdf->output(), 'Invoice.pdf',['mime' => 'application/pdf']);
                    });

                      
                $i++;
                 echo $dayDiff."You have successfylly sent email.";
                }
            
            }
            
        }

}