<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Helpers\Contracts\HelperContract; 
use Illuminate\Support\Facades\Auth;
use Session; 
use Validator; 
use Carbon\Carbon; 

class AdminController extends Controller {

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
	public function getDashboard()
    {
       $user = null;

		if(Auth::check())
		{
			$user = Auth::user();
            if($user->role !== "admin")
            {
                return redirect()->intended('/');
            }
		}
        else
        {
            return redirect()->intended('/');
        }

		
		$signals = $this->helpers->signals;
        $stats = $this->helpers->getDashboardStats();
		 $courses = [];
       return view('dashboard',compact(['user','signals','stats']));
    }
	

	

    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getTrackingHistory(Request $request)
    {
		$ret = ['status' => 'ok','mesage' => 'nothing happened'];


		$req = $request->all();
        $t = []; $valid = false;

        if(isset($req['tnum'])){
           $history = $this->helpers->getTrackingHistory($req['tnum']);
		   $ret = ['status' => 'ok','data' => $history];
        }
		else
		{
			$ret = ['status' => 'error','mesage' => 'validation'];
		}

       return json_encode($ret);
    }

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postAddTrackingHistory(Request $request)
    {
    	$ret = ['status' => 'ok','mesage' => 'nothing happened'];
        
        $req = $request->all();
		#dd($req);
        $validator = Validator::make($req, [
                             'tnum' => 'required',
                             'location' => 'required',
                             'remarks' => 'required',
							 'status' => 'required|not_in:none',
         ]);
         
         if($validator->fails())
         {
            $ret = ['status' => 'error','mesage' => 'validation'];
         }
         
         else
         {
             $ret2 = $this->helpers->addTrackingHistory($req);
			 $ret = ['status' => 'ok','mesage' => 'tracking history added'];
         } 	  

		 return json_encode($ret);
    }


    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getTrackings()
    {
       $user = null;
		$signals = $this->helpers->signals;
        $trackings = $this->helpers->getTrackings(['mode' => "all"]);
		$ret = ['status' => 'ok','data' => $trackings];
		return json_encode($ret);
    }

	/**
	 * Show the application about view to the user.
	 *
	 * @return Response
	 */
	public function getAddTracking(Request $request)
    {
       $user = null;
	   $signals = $this->helpers->signals;

	   if(Auth::check())
	   {
		   $user = Auth::user();
		   if($user->role !== "admin")
		   {
			   return redirect()->intended('/');
		   }
	   }
	   else
	   {
		   return redirect()->intended('/');
	   }

    	return view('add-tracking',compact(['user','signals']));
    }

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postAddTracking(Request $request)
    {
		$ret = ['status' => 'ok','mesage' => 'nothing happened'];
        
        $req = $request->all();
		#dd($req);
        $validator = Validator::make($req, [
                             'sname' => 'required',
                             'sphone' => 'required',
                             'sadd' => 'required',
							 'rname' => 'required',
                             'rphone' => 'required',
                             'radd' => 'required',
                             'stype' => 'required',
                             'weight' => 'required',
                             'origin' => 'required',
                             'bmode' => 'required | not_in:none',
                             'freight' => 'required',
                             'mode' => 'required',
                             'description' => 'required',
                             'dest' => 'required',
                             'pickup_at' => 'required',
                             'status' => 'required|not_in:none',
         ]);
         
         if($validator->fails())
         {
             $ret = ['status' => 'error','mesage' => 'validation','req' => $req];
             //dd($messages);
         }
         
         else
         {
             $ret = $this->helpers->addTracking($req);
			 
			 $s = ['tnum' => $ret->tnum, 'name' => $req['sname'], 'phone' => $req['sphone'],'address' => $req['sadd'] ];
			 $r = ['tnum' => $ret->tnum, 'name' => $req['rname'], 'phone' => $req['rphone'],'address' => $req['radd'] ];
			 
			 $this->helpers->addShipper($s);
			 $this->helpers->addReceiver($r);
			 
	         $ret = ['status' => 'ok','mesage' => 'tracking added'];
         }
		 return json_encode($ret); 	  
    }

	/**
	 * Show the application about view to the user.
	 *
	 * @return Response
	 */
	public function getTracking(Request $request)
    {
       $user = null;
	   $signals = $this->helpers->signals;
	   $req = $request->all();
	   $ret = ['status' => 'ok','mesage' => 'nothing happened','req' => $req];

	   

		if(isset($req['xf']))
		{
			$t = $this->helpers->getTracking($req['xf'],['mode' => "all",'rawDate' => true]);
            
			$ret = ['status' => 'ok','data' => $t];
			
		}
		else
		{
			$ret = ['status' => 'error','mesage' => 'validation'];
		}

    	return json_encode($ret);
    }


	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postTracking(Request $request)
    {
		$ret = ['status' => 'ok','mesage' => 'nothing happened'];
        
        $req = $request->all();
		#dd($req);
        $validator = Validator::make($req, [
			                 'tnum' => 'required',
                             'sname' => 'required',
                             'sphone' => 'required',
                             'sadd' => 'required',
							 'rname' => 'required',
                             'rphone' => 'required',
                             'radd' => 'required',
                             'stype' => 'required',
                             'weight' => 'required',
                             'origin' => 'required',
                             'bmode' => 'required | not_in:none',
                             'freight' => 'required',
                             'mode' => 'required',
                             'description' => 'required',
                             'dest' => 'required',
                             'pickup_at' => 'required',
                             'status' => 'required|not_in:none',
         ]);
         
         if($validator->fails())
         {
			$ret = ['status' => 'error','mesage' => 'validation'];
         }
         
         else
         {
             $ret = $this->helpers->addTracking($req);
             $ret = ['status' => 'ok','mesage' => 'tracking added'];
         } 	
		 
		 return json_encode($ret);
    }

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function getRemoveTracking(Request $request)
    {
		$ret = ['status' => 'ok','mesage' => 'nothing happened'];
        
        $req = $request->all();
		#dd($req);
        $validator = Validator::make($req, [
                             'tnum' => 'required'
         ]);
         
         if($validator->fails())
         {
			$ret = ['status' => 'error','mesage' => 'validation'];
         }
         
         else
         {
             $ret = $this->helpers->removeTracking($req);
			 
	         $ret = ['status' => 'ok','mesage' => 'tracking removed'];
         } 	 
		 return json_encode($ret); 
    }

	 /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getPlugins()
    {
       $user = null;

		if(Auth::check())
		{
			$user = Auth::user();
            if($user->role !== "admin")
            {
                return redirect()->intended('/');
            }
		}
        else
        {
            return redirect()->intended('/');
        }

		
		$signals = $this->helpers->signals;
        $plugins = $this->helpers->getPlugins(['mode' => "all"]);
		#dd($trackings);
       return view('plugins',compact(['user','signals','plugins']));
    }

	/**
	 * Show the application about view to the user.
	 *
	 * @return Response
	 */
	public function getAddPlugin(Request $request)
    {
       $user = null;
	   $signals = $this->helpers->signals;

	   if(Auth::check())
	   {
		   $user = Auth::user();
		   if($user->role !== "admin")
		   {
			   return redirect()->intended('/');
		   }
	   }
	   else
	   {
		   return redirect()->intended('/');
	   }

    	return view('add-plugin',compact(['user','signals']));
    }

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postAddPlugin(Request $request)
    {
    	if(Auth::check())
		{
			$user = Auth::user();
            if($user->role !== "admin")
            {
                return redirect()->intended('/');
            }
		}
        else
        {
            return redirect()->intended('/');
        }
        
        $req = $request->all();
		#dd($req);
        $validator = Validator::make($req, [
                             'name' => 'required',
                             'value' => 'required',
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
			 $req['status'] = "active";
             $ret = $this->helpers->createPlugin($req);
			 
	        session()->flash("new-plugin-status","ok");
			return redirect()->intended('plugins');
         } 	  
    }

	/**
	 * Show the application about view to the user.
	 *
	 * @return Response
	 */
	public function getPlugin(Request $request)
    {
       $user = null;
	   $signals = $this->helpers->signals;
	   $req = $request->all();

	   if(Auth::check())
	   {
		   $user = Auth::user();
		   if($user->role !== "admin")
		   {
			   return redirect()->intended('/');
		   }
	   }
	   else
	   {
		   return redirect()->intended('/');
	   }

		if(isset($req['xf']))
		{
			$p = $this->helpers->getPlugin($req['xf']);

			if(count($p) < 1)
			{
				session()->flash("plugin-status","error");
			    return redirect()->intended('plugins');
			}
		}
		else
		{
			session()->flash("plugin-status","error");
			return redirect()->intended('plugins');
		}

    	return view('edit-plugin',compact(['user','signals','p']));
    }

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postPlugin(Request $request)
    {
    	if(Auth::check())
		{
			$user = Auth::user();
            if($user->role !== "admin")
            {
                return redirect()->intended('/');
            }
		}
        else
        {
            return redirect()->intended('/');
        }
        
        $req = $request->all();
		#dd($req);
        $validator = Validator::make($req, [
			                 'id' => 'required',
                             'name' => 'required',
                             'value' => 'required',
                             'status' => 'required'
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
             $ret = $this->helpers->updatePlugin($req);
			 
	        session()->flash("update-plugin-status","ok");
			return redirect()->intended('plugins');
         } 	  
    }

	/**
	 * Show the application about view to the user.
	 *
	 * @return Response
	 */
	public function removePlugin(Request $request)
    {
       $user = null;
	   $signals = $this->helpers->signals;
	   $req = $request->all();

	   if(Auth::check())
	   {
		   $user = Auth::user();
		   if($user->role !== "admin")
		   {
			   return redirect()->intended('/');
		   }
	   }
	   else
	   {
		   return redirect()->intended('/');
	   }

		if(isset($req['xf']))
		{
			$p = $this->helpers->getPlugin($req['xf']);

			if(count($p) < 1)
			{
				$this->helpers->removePlugin($p['id']);
				session()->flash("remove-plugin-status","ok");
			    return redirect()->intended('plugins');
			}
		}
		else
		{
			session()->flash("plugin-status","error");
			return redirect()->intended('plugins');
		}
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