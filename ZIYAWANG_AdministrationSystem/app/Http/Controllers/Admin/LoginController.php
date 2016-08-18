<?php

namespace App\Http\Controllers\Admin;

use App\AsUser;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Admin\IndexController;

class LoginController extends Controller
{
    //登录页面
    public function index()
    {
       session(["user"=>null]);
        return view("login/login");
    }
    //判断登录
    public function login(){
        if(!empty($_POST['email']) && !empty($_POST['password'])){
            $password=md5($_POST['password']);
            $data=DB::table("T_AS_USER")->where(["Email"=>$_POST['email'],"PassWord"=>$password,"Status"=>1])
                ->get();
            if($data){
               foreach($data as $value){
                   $userId=$value->id;
                   $name=$value->Name;
                   $roleId=$value->RoleID;
                   $pAuths=DB::table("T_AS_ROLEAUTH")
                       ->leftJoin("T_AS_AUTH","T_AS_AUTH.Auth_ID","=","T_AS_ROLEAUTH.AuthID")
                       ->where(["Level"=>1,"RoleID"=>$roleId])
                       ->get();
                   $Auths=DB::table("T_AS_ROLEAUTH")
                       ->leftJoin("T_AS_AUTH","T_AS_AUTH.Auth_ID","=","T_AS_ROLEAUTH.AuthID")
                       ->where(["Level"=>2,"RoleID"=>$roleId])
                       ->get();
               }
                foreach($pAuths as $pAuth){
                    $id=$pAuth->Auth_ID;
                    $count=DB::table("T_AS_ROLEAUTH")
                        ->leftJoin("T_AS_AUTH","T_AS_AUTH.Auth_ID","=","T_AS_ROLEAUTH.AuthID")
                        ->where(["Level"=>2,"RoleID"=>$roleId,"PID"=>$id])
                        ->count();
                    $pAuth->count=$count;
                }
                $pAuths = serialize($pAuths);
                $Auths = serialize($Auths);
                session(['user'=>"admin",'pAuths'=>$pAuths,'Auths'=>$Auths,"userId"=>$userId,"userName"=>$name]);
                return redirect('index/index');
            }else{
                return back()->with('msg',"您输入的账号或者密码有误，请重新输入");
                return view("login/login");
            }

            //return redirect()->action("Admin\IndexController@index");
            }else{
            return back()->with('msg',"请您输入邮箱和密码!");
            return view("login/login");
        }
    }
    //修改密码首页
    public function wordEdit(){
        $id=Session::get("userId");
        $datas=DB::table("T_AS_USER")->where("id",$id)->get();
        return view("login/wordEdit",compact("datas"));
    }
    //修改密码保存
    public function wordUpdate(){
        $pwd=$_POST['pwd'];
        $pwd2=$_POST['pwd2'];
        if(empty($pwd)){
            return back()->with("msg","*请您输入新的密码!");
            return view("login/wordEdit");
        }
        if(empty($pwd2)){
            return back()->with("msg1","*请您输入确认密码!");
            return view("login/wordEdit");
        }elseif($pwd!=$pwd2){
            return back()->with("msg2","*确认密码与新密码不一致!");
            return view("login/wordEdit");
        }

        $db=DB::table("T_AS_USER")->where("id",$_POST['userId'])
                                  ->update([
                                      "PassWord"=>md5($pwd),
                                      'updated_at'=>date("Y-m-d H:i:s", time())

                                  ]);
        if($db){
            return Redirect::to("/");
        }else{
            return view("login/edit");

        }
    }
}
