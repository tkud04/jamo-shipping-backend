<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Helpers\Contracts\HelperContract; 
use Illuminate\Support\Facades\Auth;
use Session; 
use Validator; 
use Carbon\Carbon; 

class MainController extends Controller {

	protected $helpers; //Helpers implementation
    
    public function __construct(HelperContract $h)
    {
    	$this->helpers = $h;                     
    }

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getIndex()
    {
       $user = null;

		if(Auth::check())
		{
			$user = Auth::user();
		}

		
		$signals = $this->helpers->signals;
        $plugins = [];
        $courses = [];
        return view('index',compact(['user','plugins','signals','plugins']));
    }
	

	

    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function postApply(Request $request)
    {
		$ret = ['status' => "ok",'message' => 'Nothing happened'];
		$req = $request->all();
		
       
		function validate($arr){
          return array_key_exists('firstName',$arr) || array_key_exists('firstName',$arr) ||
		 array_key_exists('email',$arr) ||array_key_exists('phone',$arr) ||
		  array_key_exists('address',$arr) ||
		  array_key_exists('city',$arr) || array_key_exists('zipCode',$arr) ||
		  array_key_exists('pic',$arr) || array_key_exists('firstName',$arr);
		}

	  $validator = Validator::make($req, [
		  'dt' => "required"
	   ]);

	   
	   if($validator->fails())
	   {
		   $ret = ['status' => 'error','message' => 'All fields are required'];
	   }
	   
	   else
	   {
		 $dt = json_decode($req['dt'],true);
		
		 if(validate($dt)){
			$this->helpers->addResume($dt);
			$ret = ['status' => "ok",'message' => 'Resume added'];
		 }
		 else{
			$ret = ['status' => 'error','message' => 'validation'];
		 }
		 
	   } 
	   return json_encode($ret);
    }

	 /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getResumes()
    {
       $user = null;
		
		$resumes = $this->helpers->getResumes();
        $ret = ['status' => 'ok','data' => $resumes];
		return json_encode($ret);
    }

	 /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getRemoveResume(Request $request)
    {
		$ret = ['status' => "ok",'message' => 'Nothing happened'];
		$req = $request->all();


	  $validator = Validator::make($req, [
		  'xf' => "required"
	   ]);

	   
	   if($validator->fails())
	   {
		   $ret = ['status' => 'error','message' => 'All fields are required'];
	   }
	   
	   else
	   {
		 $this->helpers->removeResume($req['xf']);
		 $ret['message'] = 'Resume removed';
	   } 
	   return json_encode($ret);
    }
	
	
    
    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getZoho()
    {
        $ret = "1535561942737";
    	return $ret;
    }
    
    
    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getPractice()
    {
		$url = "http://www.kloudtransact.com/cobra-deals";
	    $msg = "<h2 style='color: green;'>A new deal has been uploaded!</h2><p>Name: <b>My deal</b></p><br><p>Uploaded by: <b>A Store owner</b></p><br><p>Visit $url for more details.</><br><br><small>KloudTransact Admin</small>";
		$dt = [
		   'sn' => "Tee",
		   'em' => "kudayisitobi@gmail.com",
		   'sa' => "KloudTransact",
		   'subject' => "A new deal was just uploaded. (read this)",
		   'message' => $msg,
		];
    	return $this->helpers->bomb($dt);
    }   


}