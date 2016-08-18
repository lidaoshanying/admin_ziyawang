<?php

namespace App\Http\Controllers\Admin;

use App\AsUser;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class SystemController extends Controller
{
  //系统管理
  //人员管理列表
  public function index()
  {

    $datas = AsUser::where('T_AS_USER.Status', 1)
        ->leftJoin("T_AS_USERROLE", "T_AS_USERROLE.UserID", "=", "T_AS_USER.id")
        ->leftJoin("T_AS_ROLE", "T_AS_ROLE.id", "=", "T_AS_USERROLE.RoleID")
        ->select("T_AS_USER.*", "T_AS_ROLE.RoleName")
        ->orderBy("T_AS_USER.id", "desc")->paginate(20);
    return view("systems/system/index", compact('datas'));
  }

  //添加人员
  public function add()
  {
    if (!empty($_POST)) {
      if (!empty($_POST['email'])) {
        $res = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
        $email = $_POST['email'];
        if (!preg_match($res, $email)) {
          return back()->with("msg0", "*请输入正确的邮箱格式!");
          return view("system/add");
        }
        if (!empty($_POST['number'])) {
          $res1 ="/^1[34578]\d{9}$/";
          $number = $_POST['number'];
          if (!preg_match($res1, $number)) {
            return back()->with("msg4", "*请输入正确的手机号!");
            return view("system/add");
          }
          $count=DB::table("T_AS_USER")->where("Email",$_POST['email'])->count();
          if($count!=0){
            return back()->with("msg5", "*您添加的邮箱号已经存在!");
            return view("system/add");
          }
          $_POST['status'] = 1;
          $pwd=!empty($_POST['password']) ? $_POST['password'] : 123456;
          $password = md5($pwd);
          $db = DB::table("T_AS_USER")->insertGetId([
              'Name' => $_POST['name'],
              'Email' => $_POST['email'],
              'Password' => $password,
              'PhoneNumber' => $_POST['number'],
              'Department' => $_POST['department'],
              'Status' => $_POST['status'],
              "RoleID" => $_POST['roleName'],
               'created_at'=>date("Y-m-d H:i:s", time()),
             'updated_at'=>date("Y-m-d H:i:s", time())
          ]);

          if ($db) {
            $roleId = $_POST['roleName'];
            DB::table('T_AS_USERROLE')->insert([
                "UserID" => $db,
                "RoleID" => $roleId
            ]);
            return Redirect::to('system/index');
          } else {
            return Redirect::to('system/add');
          }
        } else {
          return back()->with("msg3", "*请输入手机号!");
          return view("system/add");
        }

      } else {
        return back()->with("msg2", "*请输入您的邮箱!");
        return view("system/add");
      }
    }
    $datas=DB::table("T_AS_ROLE")->where("Status",1)->get();
        return view('systems/system/add',compact("datas"));
    }
    //编辑人员信息
    public function update($id=null){
      if(isset($_POST['_token']) && !empty($_POST['_token'])){
        if (!empty($_POST['email'])) {
              $res = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
              $email = $_POST['email'];
          if (!preg_match($res, $email)) {
                return back()->with("msg0", "*请输入正确的邮箱格式!");
                return view("system/add");
          }
          if (!empty($_POST['number'])) {
                  $res1 ="/^1[34578]\d{9}$/";
                  $number = $_POST['number'];
            if (!preg_match($res1, $number)) {
                  return back()->with("msg4", "*请输入正确的手机号!");
                  return view("system/add");
            }
              $count=DB::table("T_AS_USER")->where("Email",$_POST['email'])->count();
            if($count!=0 && $count!=1){
                  return back()->with("msg5", "*您添加的邮箱号已经存在!");
                  return view("system/add");
            }
            $Id=$_POST['id'];
            $db=DB::table("T_AS_USER")->where('id',$Id)->update([
                'Name'=>$_POST['name'],
                'Email'=>$_POST['email'],
                'PhoneNumber'=>$_POST['number'],
                'Department'=>$_POST['department'],
                "RoleID"=>$_POST['roleName'],
                'updated_at'=>date("Y-m-d H:i:s", time())
            ]);

            if($db){

              $roleId=$_POST['roleName'];
              DB::table('T_AS_USERROLE')->where("UserID",$Id)->update([
                  "RoleID"=>$roleId
              ]);

              return Redirect::to('system/index');
            }else{
              return Redirect::to('system/index');
            }
          } else {
            return back()->with("msg3", "*请输入手机号!");
            return view("system/add");
          }

        } else {
          return back()->with("msg2", "*请输入您的邮箱!");
          return view("system/add");
        }
      }
      $datas=AsUser::find($id)->toArray();
      $results=DB::table("T_AS_ROLE")->where("Status",1)->get();
      return view('systems/system/update',compact('datas','results'));
    }

  //密码恢复原始值
    public function edit($id){
      $pwd=md5(123456);
         $db=DB::table("T_AS_USER")->where("id",$id)->update([
                "PassWord"=>$pwd,
                'updated_at'=>date("Y-m-d H:i:s", time())
             ]);
      if($db){
           return  back()->with("msg","密码初始化成功!");
           //return redirect("system/index");
      }
    }

    //删除人员信息
    public function delete($id){
      DB::table('T_AS_USER')->where('id',$id)
            ->update(['Status'=>0]);
      return Redirect::to('system/index');
    }
    
}
