<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
 
use App\Models\Products;
use App\Models\Payment;
use App\Models\Review;
use Auth;
use Hash;
use Session;
use App\Http\Requests;
 

use App\Http\Controllers\Controller;
use App\Modules\Orders\Order;
use App\Modules\Orders\OrderRepository;
use App\Modules\Products\ProductRepository;
use App\Modules\Products\Variant;
use App\Modules\Orders\Item;
 

use Exception;
use Input;
use Optimait\Laravel\Exceptions\ApplicationException;
use Optimait\Laravel\Services\PdfExport\PdfExportService;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
 
use Optimait\Laravel\Services\Email\EmailService;


class FrontController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orders = $orderRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(ProductRepository $repository)
    // {
    //   // echo Input::get('keyword');die;
    //     if(!empty(Input::get('keyword'))){
            
    //         $products = $repository->getSearchedPaginated(Input::all(), 12, Input::get('orderBy', 'name'), Input::get('orderType', 'ASC'));

    //     }else{

    //     //$products = $repository->getPaginated(12, Input::get('orderBy', 'name'), Input::get('orderType', 'ASC'));
    //   @$products = $repository->getPaginated(12, Input::get('orderBy', 'name'), Input::get('orderType', 'ASC'));

    //     //$productFooter = $repository->getPaginated(6, Input::get('orderBy', 'name'), Input::get('orderType', 'ASC'));
    //     }
    //     return view('webpanel.front.front')->with('products',@$products);
    //     // return view('webpanel.layouts.front-layout')->with('productFooter',$productFooter);


    // }
    
     public function index(ProductRepository $repository, Request $request)
    {
        //echo __DIR__;die;
       // echo Input::get('keyword');die;
        // if(!empty($request->keyword)){
        //      //echo $request->keyword;
        //     $products = $repository->getSearchedPaginated(Input::all(), 12, Input::get('orderBy', 'name'), Input::get('orderType', 'ASC'));

        // }else{

        //$products = $repository->getPaginated(12, Input::get('orderBy', 'name'), Input::get('orderType', 'ASC'));
       @$products = $repository->getPaginated(12, Input::get('orderBy', 'name'), Input::get('orderType', 'ASC'));

        //$productFooter = $repository->getPaginated(6, Input::get('orderBy', 'name'), Input::get('orderType', 'ASC'));
        // }
        return view('webpanel.front.front')->with('products',@$products)->with('category',$request->keyword);
        // return view('webpanel.layouts.front-layout')->with('productFooter',$productFooter);


    }
    
    
    
    public function userLogin(Request $request)
    {   
        $url= \Session::get('url');
        $uData= $request->all();
        if(!empty($uData)){

            $userdata = array(
            'email' => $uData['email'],
            'password' => $uData['password']

            );
            if (Auth::attempt($userdata, (isset($data['remember']) ? true : false))) {

                if(Auth::user()->user_type_id==2){

                if(!empty($url)){
                    return redirect('https://shop.morettimilano.com'.$url);
                }else{
                   
                 return redirect('/');
                }


                }


            }else{
                Session::flash('error', 'Invalid Username Or Password!');
                return view('webpanel.front.login');
            }



        }else{
            return view('webpanel.front.login');
        }
    }
    public function userRegister(Request $request)
    {
        
        $uData= $request->all();
        if(!empty($uData)){
        //echo '<pre>';print_r($uData);
        $user= new User();
        $user->full_name = $uData['firstname'].' '.$uData['lastname'];
        $user->email = $uData['email'];
        $user->user_type_id = 2;
        $user->phone = $uData['phone'];
        $user->address = $uData['address'];
        $user->city = $uData['city'];
        $user->country = $uData['country'];
        $user->zipcode = $uData['zipcode'];
        $user->photo_id = 0;
        $user->permissions ="";
        $user->created_by =0;
        $user->updated_by =0;
        $user->currency_id =2;
        $user->password = Hash::make($uData['cpassword']);
        $user->password_text= $uData['cpassword'];
        $user->user_register_type= 'web';
        $user->save();
        
        $lastId = $user->id;
        Auth::loginUsingId($lastId);
        return redirect('/')->with('message', 'You have Successfully logged in!!');

        //\session()->set('success','Item created successfully.');
        // Session::flash('success', 'You have Successfully Register');
        // return view('webpanel.front.register'); 
        }else{
            return view('webpanel.front.register');
        }
        
    }

    Public function checkEmail(Request $request){
        $data= $request->all();
        $email= $data['email'];

        $user = user::where('email',$email)->first();

        if(count($user) > 0){
           return 'false';
        }else{
            return 'true';
        }


    }
    public function logout(){
        Session::flush();
        return redirect('/user-login');
    } 
    public function productInfo(ProductRepository $repository){
         
        error_reporting(0);
        if (Input::get('keyword')) {
        $products = $repository->getSearchedPaginated1(Input::all(), 100, Input::get('orderBy', 'name'), Input::get('orderType', 'ASC'));
        // echo 'hi';
        // echo Input::get('keyword');
        // echo Input::get('name');
        // echo '<pre>';
        // print_r(Input::get('name'));
        if(isset($products[0]['photos'][0]['media']['filename'])){
        $fileName= $products[0]['photos'][0]['media']['filename'];
        $folder= $products[0]['photos'][0]['media']['folder'];
        }
        ?>
        <center>
        <img src="<?php echo IMGPATH; ?>/public/<?php echo $folder.$fileName ?>" alt="<?php echo Input::get('keyword'); ?>" class="img-responsive"  style="width:400px !important" onerror='this.onerror=null;this.src="<?php echo NO_IMG; ?>"' /> 
        </center>
        <br>
        <strong>Select Colors:</strong><br><br>
        <?php $variants = $products[0]->variants()->with('color')->get();
            if($variants->count() > 0){
            /*   foreach($variants as $variant){
                      

                     if (!$variant->color): continue; endif;?>
                     <style>

                    .color-box {
                    display: block;
                    float: left;
                    width: 20px;
                    height: 20px;
                    padding: 5px;
                    margin-right: 10px;
                    }
                     </style>
                    <a class="color-box" style="background:<?=$variant->color->hex_code?> "
                       data-stock-label="<?php  if($variant->qty > 0){ echo  'In Stock';}else{ echo 'Out Of Stock';}  ?>"
                       data-id="<?= $variant->id?>" title="<?=$variant->color->name?>" data-qty="<?=$variant->qty?>"></a>
                     
                <?php        
                }*/
                echo '<select class="color-box1">
                                        <option value="" selected="">choose color</option>';
               foreach($variants as $variant){
                      

                     if (!$variant->color): continue; endif;?>
                     
                    <!-- <a class="color-box1" style="background:<?=$variant->color->hex_code?> "
                       data-stock-label="<?php  if($variant->qty > 0){ echo  'In Stock';}else{ echo 'Out Of Stock';}  ?>"
                       data-id="<?= $variant->id?>" title="<?=$variant->color->name?>" data-qty="<?=$variant->qty?>"></a> -->
                       <option data-stock-label="<?php if($variant->qty > 0) {echo 'In Stock'; } else{ echo 'Out Of Stock'; }?>"
                                               data-id="<?=$variant->id ?>" title="<?=@$variant->color->name ?>" data-qty="<?=$variant->qty?>" value="" style="background-color: <?php echo $variant->color->hex_code ?>;color:<?php if($variant->color->name == "Rosa" || $variant->color->name == "Beige" || $variant->color->name =='Silver Metal'){ echo 'black'; }else{ echo 'white'; } ?>;"><?php echo $variant->color->name ?></option>
                     
                <?php        
                }
                echo '</select>';
           } 

           echo '<br>';  
          // echo '>>'.$variant->qty;  
        }
    }


    public function single(){
        return view('webpanel.front.single');
    }

    public function editProfile(Request $request){
        
        $editProfile = user::where('id',\Auth::user()->id)->first();
        //echo '<pre>';print_r($editProfile);
        return view('webpanel.front.edit-profile')->with('editProfile',$editProfile);
    } 

    public function updateProfile(Request $request){
        $uData= $request->all();
         //echo '<pre>';print_r($uData);

        $user = User::where('id',\Auth::user()->id)->first();
        $user->full_name = $uData['fname'];
        $user->email = $uData['email'];
        $user->user_type_id = 2;
        $user->phone = $uData['phone'];
        $user->address = $uData['address'];
        $user->city = $uData['city'];
        $user->country = $uData['country'];
        $user->zipcode = $uData['zipcode'];
        $user->photo_id = 0;
        $user->permissions ="";
        $user->created_by =0;
        $user->updated_by =\Auth::user()->id;
        $user->currency_id =$uData['currency_id'];
        // $user->password = Hash::make($uData['cpassword']);
        // $user->password_text= $uData['cpassword'];
        $user->update();

        \Session::flash('message', 'You have successfully Updated');
        return redirect('/edit-profile'); 
    } 

    public function paypalTransaction(Request $request){
        $uData= $request->all();
        //echo '<pre>';print_r($uData);die;
        $order = Order::Current();

        //echo '<pre>';print_r($_REQUEST);die;
        $oid= $order->OID; 
        $paymentStatus= $_REQUEST['paymentStatus'];
        $transactionId= $_REQUEST['transactionId'];
        $currency= $_REQUEST['currency'];
        $amount= $_REQUEST['amount'];


        $payment = new Payment();
        $payment->userId =\Auth::user()->id;
        $payment->transactionId =$transactionId;
        $payment->paymentStatus =$paymentStatus;
        $payment->currency =$currency;
        $payment->amount =$amount;
        $payment->orderId =$oid;
        $payment->save();
        echo 1;
    }


     public function products(ProductRepository $repository)
    {
       // echo Input::get('keyword');die;
        if(!empty(Input::get('keyword'))){
            
            $products = $repository->getSearchedPaginatedproduct(Input::all(), 50, Input::get('orderBy', 'name'), Input::get('orderType', 'ASC'));

        }else{

        $products = $repository->getPaginatedProduct(50, Input::get('orderBy', 'name'), Input::get('orderType', 'ASC'));
        //$productFooter = $repository->getPaginated(6, Input::get('orderBy', 'name'), Input::get('orderType', 'ASC'));
        }
        return view('webpanel.front.products')->with('products',$products);


    }

    public function userRating(Request $request){
            $uData= $request->all();
            $userId= \Auth::user()->id; 
            $userName= \Auth::user()->full_name; 
            //echo '<pre>';print_r($uData);die;
            if(!empty(\Auth::user()->id)){
                $review = new Review();
                $review->userId = $userId;
                $review->productId = $uData['productId'];
                $review->userName = $userName;
                $review->star = $uData['ratingval'];
                $review->message = $uData['review'];
                $review->save();
                return redirect('/single/'.encryptIt($uData['productId']));
            }else{
                return redirect('/user-login');
            }
    }
    
    public function contact(Request $request){
        $uData= $request->all();
        if(!empty($uData)){
            $current_user_email = $uData['email'];
            $admin_email = 'rahul@yopmail.com';;
            $name = $uData['fname'];
            $data1=
                [
                    "user_email" => $current_user_email ,
                    "name" => $name ,
                    "subject" =>$uData['subject'] ,
                    "message" => $uData['message']
                    
                ];
            $emailService = new EmailService();
            $emailService->sendEmail('emails.contact.front-contact', compact('data1', $data1), function ($email) use ($admin_email) {
            $email
            ->setSubject('Message from Contact Us')
            ->setTo($admin_email);
            });
            return view('webpanel.front.contact')->with('success_message','Your message has been sussessfully sent.');
            
        }else{
             return view('webpanel.front.contact');
        }
    }
    
    //03-01-2020
    public function checkGuest(Request $request){

        $email = $request->guestEmail;
        // echo $email;die;
        $check = \App\User::where('email',$email)->first();
        
            echo '<br><form action="'.url('/register-guest').'" method="post">
                  <input type="hidden" name="_token" value="'.csrf_token().'">
                  <input type="hidden" name="user_email" value="'.$email.'">
                    <div class="form-group">
                        <label for="guest_name" style="float: left;">Name:</label>                       
                            <input type="text" class="form-control" id="guest_name" name="name" value="'.$check['full_name'].'">
                    </div>
                    <div class="form-group">
                        <label for="guest_address" style="float: left;">Address:</label>                       
                            <input type="text" class="form-control" id="guest_address" name="address" value="'.$check['address'].'">
                    </div>

                    <div class="form-group">
                        <label for="guest_city" style="float: left;">City:</label>                       
                            <input type="text" class="form-control" id="guest_city" name="city" value="'.$check['city'].'">
                    </div><div class="form-group">
                        <label for="guest_country" style="float: left;">Country:</label>                       
                            <input type="text" class="form-control" id="guest_country" name="country" value="'.$check['country'].'">
                    </div><div class="form-group" style="float: left;">                     
                            <input type="submit" value="Continue" id="guest_register" class="btn btn-success submit-btn"> 
                  </form>';         
        
    }

    public function registerGuest(Request $request){

        $data = $request->all();
        $check = \App\User::where('email',$data['user_email'])->first();
        if($check){
            $check->full_name = $data['name'];
            $check->address = $data['address'];
            $check->city = $data['city'];
            $check->country = $data['country'];
            $check->update();
             Auth::loginUsingId($check->id);
        }else{
            $myStr= $data['name'];
            $result = substr($myStr, 0, 4);
            $digit=rand ( 1000 , 9999);
            $total= $result.'@'.$digit;

            $check = new \App\User;
            $check->user_type_id = 2;
            $check->full_name = $data['name'];
            $check->email = $data['user_email'];    
            $check->password = Hash::make($total);
            $check->password_text = $total;
            $check->address = $data['address'];
            $check->city = $data['city'];
            $check->country = $data['country'];
            $check->user_register_type = 'web';
            $check->save();
             Auth::loginUsingId($check->id);

             $guest_email = $data['user_email'];
            $name = $data['name'];
            $data1=
                [
                    "user_email" => $data['user_email'] ,
                    "name" => $data['name'] ,
                    "password" => $total
                ];
            $emailService = new EmailService();
            $emailService->sendEmail('emails.contact.guestpassword', compact('data1', $data1), function ($email) use ($guest_email) {
            $email
            ->setSubject('Your password')
            ->setTo($guest_email);
            });

              // return view('emails.contact.guestpassword')->with('data1',$data1);
 
        }
        $order = Order::Current();
        $updateOrderUser = Order::find($order->id);
        $updateOrderUser->created_by = $check->id;
        $updateOrderUser->save();
        
        $itemUpdate = Item::where('order_id', $order->id)->get();
        foreach($itemUpdate as $item) {
            $updateItem = Item::find($item->id);
            $updateItem->created_by = $check->id;
            $updateItem->updated_by = $check->id;
            $updateItem->save();
        }
        //$check->id
             return redirect(url('/orders/cart/xl'));
    }

    public function forgotPass(Request $request){

      $data = $request->all();

      if(!empty($data)){
           $check = \App\User::where('email',$data['email'])->first();
           if($check){
            // echo '<pre>';print_r($check);die;
            $guest_email = $check->email;
             //echo $check->email;die;
            // $name = $data['name'];
            $data1= [
                        "name" => $check->full_name,
                        "id"   => $check->id
                    ];
             
            //  echo '<pre>';print_r($data1);die;
            $emailService = new EmailService();
            $emailService->sendEmail('emails.contact.resetpasswordmail', compact('data1', $data1), function ($email) use ($guest_email) {
            $email
            ->setSubject('Your password')
            ->setTo($guest_email);
            });
           return view('webpanel.front.forgotpassword')->with('recovery','Password Recovery Email Sent!');
           }else{
              return view('webpanel.front.forgotpassword')->with('notfound','Email not found!!');
           }
      }else{
        return view('webpanel.front.forgotpassword');
      }
    }

    public function resetPass(Request $request, $id){

        $data = $request->all();
        if(!empty($data)){
           // echo $data['confirmpassword'];die;
           $user = \App\User::where('id',$id)->first();
           $user->password = Hash::make($data['confirmpassword']);
           $user->password_text = $data['confirmpassword'];
           $user->update();
           return view('webpanel.front.login')->with('reset_success','Password reset successfull!');
        }
        else{          
            return view('webpanel.front.resetpassword')->with('id',$id);
        }

    }

}
