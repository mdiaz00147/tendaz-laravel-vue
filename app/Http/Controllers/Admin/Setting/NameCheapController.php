<?php

namespace Tendaz\Http\Controllers\Admin\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Tendaz\Api\NameCheapApi;
use Tendaz\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Http\Request;
use Tendaz\Models\Domain\Domain;
use Tendaz\Models\Domain\Tld;
use Tendaz\Models\User;
use anlutro\cURL;
use Tendaz\Api\Twocheckout;


class NameCheapController extends Controller
{

    /**
     *Get data
     */
    public function __construct(){
        $this->ip = env('IP');
        $this->adapter = new NameCheapApi();
        $this->adapter->setClientIp(env('IP_CLIENT'));
    }


    public function getIndex($subdomain , Request $request)
    {
        $domains = Domain::where('shop_id',$request->shop->id)->get();
        $tlds = Cache::get('tlds');
        if(!$tlds)
            $tlds = Tld::all();
        Cache::put('tlds' , $tlds , 1440);
        return view('admin.setting.domain' , compact('domains', 'tlds'));
    }

    public function store($subdomain, Request $request)
    {
         $dom = ['edit',$request->get('domain')];
         Domain::create([
            'domain' => $dom,
            'name' => $dom,
            'ssl' => $dom,
            'state' => 401,
            'shop_id' => $request->shop->id
         ]);

        return redirect()->back()->with('message', array('type' => 'success', 'message' => 'El dominio ' . $request->get('domain') . '  fue agregado correctamente!'));
    }

    public function main($subdomain , Request $request , $uuid)
    {
        $domains = Domain::where('main',1)->where('shop_id',$request->shop->id)->first();
        $domains->fill(['main'=> 0]);
        $domains->save();

        $domain = Domain::where('uuid',$uuid)->where('shop_id',$request->shop->id)->first();
        $domain->fill(['main'=> 1]);
        $domain->save();

        return redirect()->back()->with('message', array('type' => 'success', 'message' => 'El dominio ' . $domain->name . '  es el principal!'));
    }

    public function getVerify($subdomain , Request $request , $uuid)
    {
        $domain = Domain::where('uuid',$uuid)->first();
        if($domain) {
            return view('admin.setting.verify_domain',compact('domain'));
        }
    }
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postVerify($subdomain,  Request $request , $uuid){
        $domain = Domain::where('uuid',$uuid)->first();
        if($domain){
            $url = $domain->name;
            if($url == NULL) return false;
            $exist = $this->curlDNS($url);
            $exist ?  $ip = gethostbyname($url) : $ip = false;
            $ip == $this->ip ? $domain->state = 200 : $domain->state = 401 ;
            if($ip == null) {$domain->state = 300;}
            $domain->save();

        }
        return response()->json($domain->state);
    }

    public function check(Request $request){
        if($request->ajax()){
            $this->adapter->checkDomain($request->get('domain'));
            $this->adapter->getResponse();
            $json = $this->adapter->toResponse();
            $tlds = $request->get('tld');
            $response = $this->adapter->suggestions($json , $tlds , $request->get('domain') );
            return response()->json($response);
        }
    }

    public function getDomainPayment(Request $request)
    {
        $privateKey = env('PRIVATE_KEY_TWO');
        $resellerId = env('SELLER_ID_TWO');
        Twocheckout::privateKey($privateKey);
        Twocheckout::sellerId($resellerId);
        Twocheckout::verifySSL(false);

        Twocheckout::sandbox(env('SANBOX_TWO',false));
        Twocheckout::username('davidfigueroar9');
        Twocheckout::password('D19979872f');

        if(Auth('admins')->user()->phone == null){$phone = '+68 523 523 63';}else{$phone= Auth('admins')->user()->phone;}

        $shop = Auth('admins')->user()->shop;
        $tld = Tld::where('uuid' , $request->get('domainTld'))->first();
        $position = null;


        $data2 = [
            "sellerId" => env('SELLER_ID_TWO'),
            "merchantOrderId" => "123",
            "token" => $request->get('token'),
            "currency" => "USD",
            "lineItems" => [
                [
                    "type" => 'product',
                    "price" => $tld->price,
                    "productId" => 1,
                    "name" => $request->get('domain'),
                    "quantity" => "1",
                    "tangible" => "N",
                    "recurrence" => "Anual",
                    "duration" => 'Forever',
                    "description" => $request->get('domain'),
                ]
            ],
            "billingAddr" => [
                "name" => !$shop->user->full_name == ' ' ?  $shop->user->full_name : $shop->name,
                "addrLine1" => 'Bogota',
                "city" => empty($position->cityName) ? 'Bogota': $position->cityName,
                "state" =>  empty($position->regionCode) ? 'BOG': $position->regionCode,
                "zipCode" => empty($position->zipCode) ? '111461': $position->zipCode,
                "country" =>  empty($position->countryCode) ? 'CO': $position->countryCode,
                "email" => $shop->user->email,
                "phoneNumber" =>  $shop->user->phone
            ]
        ];
        //return $data2;


        //return $data;
        if(Auth('admins')->user()->phone == null){$phone = 'Sin Numero';}else{$phone= Auth('admins')->user()->phone;}
        try {
            $charge = Twocheckout\Twocheckout_Charge::auth($data2);
            //return $charge;

        } catch (Twocheckout_Error $e) {

            $this->assertEquals('Unauthorized', $e->getMessage());
        }

            if($data2){
                $url = $this->adapter->createUrl($request->except(['_token' , 'token']));
                $response = $this->adapter->create($url);
                if(isset($response['error'])){
                    return redirect()->back()->with('message',array('type' => 'warning' , 'message' => $response['error']));
                }else{
                    $dom = ['edit',$request->get('domain')];
                     $this->adapter->toResponse();
                    if(isset($response['has-error'])){
                        Domain::create([
                            'domain' => 'http://'.$dom,
                            'name' => $dom,
                            'ssl' => 'https://'.$dom,
                            'state' => 401,
                            'shop_id' => $shop->id
                        ]);
                        return redirect()->back()->with('message',array('type' => 'info' , 'message' => 'Se creo el dominio pero no el host error:'.$response['error-host']));
                    }
                    Domain::create([
                        'domain' => $dom,
                        'name' => $dom,
                        'ssl' => $dom,
                        'state' => 401,
                        'shop_id' => $shop->id
                    ]);
                    return redirect()->to('admin/setting/domain')->with('message',array('type' => 'success' , 'message' => 'Dominio '. $request->get('domain') .' comprado correctamente. Activalo en tu tabla de Dominios'));
                }
            }else{
                return redirect()->back()->with('message',array('type' => 'warning' , 'message' => 'No se pudo cargar la compra a tu tarjeta de credito'));
            }

        //no olvidar crear el dominio en nginx
    }
































    /**
     * @param Route $route
     */
    public function findDomain(Route $route){
        $uuid = $route->getParameter('account');
        $this->domain = Domain::where('uuid','=',$uuid)->first();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDelete(){
        if($this->domain) {
            if($this->domain->principal){
                Session::flash('message', array('type' => 'warning', 'message' => ' el dominio ' . $this->domain->name . ' principal no se puede eliminar'));
                return redirect()->back();
            }
            $delete = $this->domain->delete();
            $delete ?
                Session::flash('message', array('type' => 'success', 'message' => 'Dominio ' . $this->domain->name . ' eliminado. Si deseas recuperarlo comunicate con nosotros.'))
                : Session::flash('message', array('type' => 'warning', 'message' => ' el dominio ' . $this->domain->name . ' no pudo ser eliminado'));
        }
        return redirect()->back();
    }

    /**
     *
     */
    public function notPrincipal(){
        foreach($this->domains as $domain){
            $domain->principal = 0;
            $domain->save();
        }
    }

    /**
     * @param $url
     * @return bool
     */
    public function curlDNS($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($httpcode >= 200 && $httpcode < 300){
            $exist = true;
        } else {
            $exist = false;
        }
        return $httpcode;
    }

    /**
     * @return $this
     */


    /**
     * Create domain exist not buy
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDomain(DomainCreateRequest $request){
        if($request->ajax()){
                $data = array('name' => $request->get('subDomain') , 'shop_id' => $this->shop->id );
            if($request->get('www') == 0){
                $domain = Domain::create(['name' =>$request->get('domain') , 'shop_id' => $this->shop->id , 'status_id' =>  2]);
                Domain::create(['name' => 'www.'.$request->get('domain') , 'shop_id' => $this->shop->id , 'domain_id' => $domain->id , 'status_id' =>  2]);
            }else{
                Domain::create($data);
            }
            $domains = Domain::where('principal','<>',1)->get();
            return response()->json(['true' ,$domains]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkDomain(Request $request){
        if($request->ajax()){
            $this->adapter->checkDomain($request->get('domain'));
            $this->adapter->getResponse();
            $json = $this->adapter->toResponse();
            $tlds = $request->get('tld');
            $response = $this->adapter->suggestions($json , $tlds , $request->get('domain') );
            Cache::put($this->user->uuid.'_expire_domain' , 1 ,30);
            return response()->json($response);
        }
    }

    public function singleCharge($tld , $request){
        if(!$this->user->subscribed()){
            $this->user->subscription('domain')->create($request['token'] , [
                'email' => $this->user->email,
            ]);
            $this->user->card = $request['cardNumber'];
            $this->user->exp = $request['cardExpiry'];
            $this->user->cvc = $request['cardCVC'];
            $this->user->finish_free = $this->user->finish_free;
            $this->user->save();
        }
        $charge = $this->user->charge(intval($tld->price * 100), [
                'receipt_email' => $this->user->email,
            ]);
        return $charge;
    }
    public function getDomain(Request $request){
        $expired = Cookie::get('_expire_domain');
        if($expired){
            $tld = Tld::where('uuid' , $request->get('_uuid_name'))->first();
            $charge = $this->singleCharge($tld , $request->all());
            if($charge){
                $url = $this->adapter->createUrl($request->except(['_token' , 'token']));
                $response = $this->adapter->create($url);
                if(isset($response['error'])){
                    return redirect()->back()->with('message',array('type' => 'warning' , 'message' => $response['error']));
                }else{
                    $response = $this->adapter->toResponse();
                    if(isset($response['has-error'])){
                        $domain = Domain::create(['name' => $request->get('_domain_name') , 'shop_id' => $this->shop->id , 'status_id' => 5 ]);
                        Domain::create(['name' => 'www.'.$request->get('_domain_name') , 'shop_id' => $this->shop->id ,'status_id' => 5  ,  'domain_id' => $domain->id]);
                        return redirect()->back()->with('meesage',array('type' => 'info' , 'message' => 'Se creo el dominio pero no el host error:'.$response['error-host']));
                    }
                    $domain = Domain::create(['name' => $request->get('_domain_name') , 'shop_id' => $this->shop->id , 'status_id' => 3]);
                    Domain::create(['name' => 'www.'.$request->get('_domain_name') , 'shop_id' => $this->shop->id , 'domain_id' => $domain->id ,   'status_id' => 3]);
                    return redirect()->to('admin/configuration/domain')->with('message',array('type' => 'info' , 'message' => 'Dominio creado y apuntado correctamente. Disfruta de tu tienda personalizada'));
                }
            }else{
                return redirect()->back()->with('message',array('type' => 'warning' , 'message' => 'No se pudo cargar la compra a tu tarjeta de credito'));
            }
        }else{
            return redirect()->to('https://'.$this->user->shop->principalDomain->name.'/admin/configuration/domain')
                ->with('message',array('type' => 'warning' , 'message' => 'El tiempo de session de compra de tu dominio ha expirado'));
        }
        //no olvidar crear el dominio en nginx
    }

    public function  postHost(){

    }
}
