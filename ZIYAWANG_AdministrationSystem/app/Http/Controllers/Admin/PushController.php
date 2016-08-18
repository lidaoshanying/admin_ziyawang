<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class PushController extends Controller{
    //消息推送首页
    public  function index($id=""){
            if(!empty($_GET)){
                $serviceId=$_GET['id'];
               
                $datas=DB::table("T_U_SERVICEINFO")
                         ->select("ServiceName")
                         ->where("ServiceID",$serviceId)
                         ->get();
                foreach($datas as $data){
                   $serviceName=$data->ServiceName;
                }
                session(['receiveId'=>$_GET['id'],"receiveName"=>$serviceName]);
                return view('push/index',compact('datas'));
            }
            return view("push/index");
        }
    //获取收信人的信息
    public function receive(){
      if(isset($_POST['_token'])){
          if(!empty($_POST['serviceName'])){
              if(!empty($_POST['connectPhone'])){
                  $datas=DB::table("T_U_SERVICEINFO")
                      ->leftJoin("T_P_SERVICECERTIFY","T_U_SERVICEINFO.ServiceID","=","T_P_SERVICECERTIFY.ServiceID")
                      ->select("T_U_SERVICEINFO.ServiceName","T_U_SERVICEINFO.ConnectPhone","T_U_SERVICEINFO.ServiceID","T_P_SERVICECERTIFY.State")
                      //->where("T_P_SERVICECERTIFY.State",1)
                      ->where("T_U_SERVICEINFO.ServiceName","like","%".$_POST['serviceName']."%")
                      ->where("T_U_SERVICEINFO.ConnectPhone","like","%".$_POST['serviceName']."%")
                      ->orderBy("T_U_SERVICEINFO.created_at","desc")
                      ->paginate(20);
                     return view("push/receive",compact("datas"));
              }else{
                  $datas=DB::table("T_U_SERVICEINFO")
                      ->leftJoin("T_P_SERVICECERTIFY","T_U_SERVICEINFO.ServiceID","=","T_P_SERVICECERTIFY.ServiceID")
                      ->select("T_U_SERVICEINFO.ServiceName","T_U_SERVICEINFO.ConnectPhone","T_U_SERVICEINFO.ServiceID","T_P_SERVICECERTIFY.State")
                     // ->where("T_P_SERVICECERTIFY.State",1)
                      ->where("T_U_SERVICEINFO.ServiceName","like","%".$_POST['serviceName']."%")
                      ->orderBy("T_U_SERVICEINFO.created_at","desc")
                      ->paginate(20);
                     return view("push/receive",compact("datas"));
              }
          }else{
              if(!empty($_POST['connectPhone'])){
                  $datas=DB::table("T_U_SERVICEINFO")
                      ->leftJoin("T_P_SERVICECERTIFY","T_U_SERVICEINFO.ServiceID","=","T_P_SERVICECERTIFY.ServiceID")
                      ->select("T_U_SERVICEINFO.ServiceName","T_U_SERVICEINFO.ConnectPhone","T_U_SERVICEINFO.ServiceID","T_P_SERVICECERTIFY.State")
                     // ->where("T_P_SERVICECERTIFY.State",1)
                      ->where("T_U_SERVICEINFO.ConnectPhone","like","%".$_POST['serviceName']."%")
                      ->orderBy("T_U_SERVICEINFO.created_at","desc")
                      ->paginate(20);
                    return view("push/receive",compact("datas"));
              }else{
                  $datas=DB::table("T_U_SERVICEINFO")
                      ->leftJoin("T_P_SERVICECERTIFY","T_U_SERVICEINFO.ServiceID","=","T_P_SERVICECERTIFY.ServiceID")
                      ->select("T_U_SERVICEINFO.ServiceName","T_U_SERVICEINFO.ConnectPhone","T_U_SERVICEINFO.ServiceID","T_P_SERVICECERTIFY.State")
                     // ->where("T_P_SERVICECERTIFY.State",1)
                      ->orderBy("T_U_SERVICEINFO.created_at","desc")
                      ->paginate(20);
                     return view("push/receive",compact("datas"));
              }
          }
      }
            $datas=DB::table("T_U_SERVICEINFO")
                ->leftJoin("T_P_SERVICECERTIFY","T_U_SERVICEINFO.ServiceID","=","T_P_SERVICECERTIFY.ServiceID","T_U_SERVICEINFO.ServiceID")
                ->select("T_U_SERVICEINFO.ServiceName","T_U_SERVICEINFO.ConnectPhone","T_U_SERVICEINFO.ServiceID","T_P_SERVICECERTIFY.State")
                //->where("T_P_SERVICECERTIFY.State",1)
                ->orderBy("T_U_SERVICEINFO.created_at","desc")
                ->paginate(20);
            return view("push/receive",compact("datas"));

}

    //获取要推送的信息的内容
     public function message(){
     $nowTime=date("Y-m-d H:m:s",time());
    $endTime=date("Y-m-d H:m:s",time()-86400*1);
    if(isset($_POST['_token'])){
        $typeName=$_POST['typeName'];
        $typeId=$_POST['typeName'];
        $province=$_POST['province'];
        if(!empty($_POST['typeName'])){
             if($_POST['province']!="全国"){
                 $datas=DB::table("T_P_PROJECTINFO")
                     ->leftJoin("T_P_PROJECTTYPE","T_P_PROJECTINFO.TypeID","=","T_P_PROJECTTYPE.TypeID")
                     ->select("T_P_PROJECTINFO.ProArea","T_P_PROJECTINFO.WordDes","T_P_PROJECTTYPE.TypeName","T_P_PROJECTINFO.ProjectID")
                     ->where("T_P_PROJECTINFO.TypeID",$typeId)
                     ->where("ProArea","like","%".$_POST['province']."%")
                     ->whereBetween("T_P_PROJECTINFO.created_at",[$endTime,$nowTime])
                     ->paginate(20);
                 $types=DB::table("T_P_PROJECTTYPE")->get();
                 return view("push/message",compact('datas',"types","typeName","province"));
             }else{
                 $datas=DB::table("T_P_PROJECTINFO")
                     ->leftJoin("T_P_PROJECTTYPE","T_P_PROJECTINFO.TypeID","=","T_P_PROJECTTYPE.TypeID")
                     ->select("T_P_PROJECTINFO.ProArea","T_P_PROJECTINFO.WordDes","T_P_PROJECTTYPE.TypeName","T_P_PROJECTINFO.ProjectID")
                     ->where("T_P_PROJECTINFO.TypeID",$typeId)
                    ->whereBetween("T_P_PROJECTINFO.created_at",[$endTime,$nowTime])
                     ->paginate(20);
                 $types=DB::table("T_P_PROJECTTYPE")->get();
                 return view("push/message",compact('datas',"types","typeName","province"));
             }

        }else{
            if($_POST['province']!="全国"){
                $datas=DB::table("T_P_PROJECTINFO")
                    ->leftJoin("T_P_PROJECTTYPE","T_P_PROJECTINFO.TypeID","=","T_P_PROJECTTYPE.TypeID")
                    ->select("T_P_PROJECTINFO.ProArea","T_P_PROJECTINFO.WordDes","T_P_PROJECTTYPE.TypeName","T_P_PROJECTINFO.ProjectID")
                    ->where("ProArea","like","%".$_POST['province']."%")
                    ->whereBetween("T_P_PROJECTINFO.created_at",[$endTime,$nowTime])
                    ->paginate(20);
                $types=DB::table("T_P_PROJECTTYPE")->get();
                return view("push/message",compact('datas',"types","typeName","province"));
        }else{
                $datas=DB::table("T_P_PROJECTINFO")
                    ->leftJoin("T_P_PROJECTTYPE","T_P_PROJECTINFO.TypeID","=","T_P_PROJECTTYPE.TypeID")
                    ->select("T_P_PROJECTINFO.ProArea","T_P_PROJECTINFO.WordDes","T_P_PROJECTTYPE.TypeName","T_P_PROJECTINFO.ProjectID")
                    ->whereBetween("T_P_PROJECTINFO.created_at",[$endTime,$nowTime])
                    ->paginate(20);
                $types=DB::table("T_P_PROJECTTYPE")->get();
                return view("push/message",compact('datas',"types","typeName","province"));
            }
        }

    }
        $datas=DB::table("T_P_PROJECTINFO")
            ->leftJoin("T_P_PROJECTTYPE","T_P_PROJECTINFO.TypeID","=","T_P_PROJECTTYPE.TypeID")
            ->select("T_P_PROJECTINFO.ProArea","T_P_PROJECTINFO.WordDes","T_P_PROJECTTYPE.TypeName","T_P_PROJECTINFO.ProjectID")
            ->whereBetween("T_P_PROJECTINFO.created_at",[$endTime,$nowTime])
            ->paginate(20);
        $types=DB::table("T_P_PROJECTTYPE")->get();

        return view("push/message",compact('datas',"types"));

}
    //保存推送的消息
    public  function sent(Request $request){

            if(empty($_POST['receiveId'])){
                if(empty($_POST['receives'])){
                    $usersId=0;
                   // dd(123);
                }else{
                    $phoneNumber=$_POST['receives'];
                    $dbs=DB::table("users")->select("userid")->where("phonenumber",$phoneNumber)->get();
                       if($dbs){
                           foreach($dbs as $db){
                               $usersId=$db->userid;
                           }

                       }else{
                           return back()->with("msgReceive","您填写的手机号不正确,请您重新填写!");
                       }
                }
            }else{
                $receiveId=$_POST['receiveId'];
                $usersId=DB::table("T_U_SERVICEINFO")->select("UserID")->where("ServiceID",$receiveId)->get();
                foreach($usersId as $value){
                    $usersId=$value->UserID;
                }
            }
            $contant=$_POST['con'];
            if(!empty(session('projectId'))){
                $contants=$contant."请点击<a href='http://ziyawang.com/project/".session('projectId')."'>"."http://ziyawang.com/project/".session('projectId')."</a>";
            }else{
                $contants=$contant;
            }
            $textId=DB::table("T_M_MESSAGETEXT")->insertGetId([
                "Title"=>$_POST['title'],
                "Text"=>$contants,
                "Time"=>date("Y-m-d H:i:s", time())
            ]);
            $mesId=DB::table("T_M_MESSAGE")->insertGetId([
                "SendID"=>0,
                "RecID"=>$usersId,
                "TextID"=>$textId,
            ]);
           /* $sysMsg=DB::table("T_M_SYSMESSAGE")->insert([
                "CustomerId"=>$mesId,
                "MessageId"=>$mesId
            ]);*/
            if($mesId){
                $request->session()->forget('receiveName');
                $request->session()->forget("receiveId");
                $request->session()->forget("title");
                $request->session()->forget("con");
                $request->session()->forget('projectId');
                $request->session()->forget('receives');
                //dd(session('receiveName'));
                 return  redirect("push/index");
               // return back()->with("msg","您已经推送成功");
            }else{
                return  back()->with('msg',"您推送失败，请您重新推送");
            }
    }
    //ajax 向session中存推送的信息
    public function save(){
        $projectId=$_POST['projectId'];
        if($projectId){
            $data=array("state"=>$projectId);
            echo json_encode($data);
        }
        session(['projectId'=>$projectId]);


    }
    //ajax向session中存入给固定人发送消息的手机号
    public function  receives(){
        $receives=$_POST['receives'];
        session(['receives'=>$receives]);
    }
    // ajax向session中存入推送内容
    public function title(){
        $title=$_POST['title'];
        session(["title"=>$title]);
    }
    public function contant(){
                $con=$_POST['con'];
            session(["con"=>$con]);
        }


    //已推送信息的列表
    public function detail(){
        $datas=DB::table("T_M_MESSAGETEXT")
            ->leftJoin("T_M_MESSAGE","T_M_MESSAGETEXT.TextID","=","T_M_MESSAGE.TextID")
            ->leftJoin("users","users.userid","=","T_M_MESSAGE.RecID")
            ->orderBy("Time","desc")
            ->paginate(20);
        return view("push/detail",compact("datas"));

    }
    //信息详情页
    public function listDetail($id){
        $datas=DB::table("T_M_MESSAGETEXT")
            ->leftJoin("T_M_MESSAGE","T_M_MESSAGETEXT.TextID","=","T_M_MESSAGE.TextID")
            ->leftJoin("users","users.userid","=","T_M_MESSAGE.RecID")
            ->leftJoin("T_U_SERVICEINFO","T_U_SERVICEINFO.UserID","=","users.userid")
            ->orderBy("Time","desc")
            ->where("MessageId",$id)
            ->paginate(20);
        return view("push/list",compact("datas"));
    }
    //清除所有与推送有关的session中的数据
    public function clear(Request $request){
        $request->session()->forget('receiveName');
        $request->session()->forget("receiveId");
        $request->session()->forget("title");
        $request->session()->forget("con");
        $request->session()->forget('projectId');
        $request->session()->forget('receives');
        return view("push/index");
    }

}