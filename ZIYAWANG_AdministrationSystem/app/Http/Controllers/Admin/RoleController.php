<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    //角色展示
    public function index(){
        $datas=DB::table("T_AS_ROLE")->orderBy("id","desc")
               ->where("status",1)
               ->paginate(20);
        return view("systems/role/index",compact("datas"));
    }

    //添加角色
    public function add(){
        $_POST['status']=1;
        if(isset($_POST['_token'])){
            if(empty($_POST['roleName'])){
                return back()->with("msg","角色名称不能为空!");
                return view("role/add");
            }
            $count=DB::table("T_AS_ROLE")->where("RoleName",$_POST['roleName'])
                ->count();
            if($count!=0){
                return back()->with("msg","您添加的角色已经存在!");
                return view("role/add");
            }
            $db=DB::table("T_AS_ROLE")->insert([
                "RoleName"=>$_POST['roleName'],
                "Status"=>$_POST['status'],
                 'created_at'=>date("Y-m-d H:i:s", time()),
                 'updated_at'=>date("Y-m-d H:i:s", time())
            ]);
            if($db){
                return Redirect::to("role/index");
            }
        }else{
            return view("systems/role/add");
        }

    }

    //角色的编辑
    public function update($id=""){
        if(isset($_POST['_token'])){
            $id=$_POST['id'];
            if(empty($_POST['roleName'])){
                return back()->with("msg","角色名称不能为空!");
                return view("role/add");
            }
            $count=DB::table("T_AS_ROLE")->where("RoleName",$_POST['roleName'])
                ->count();
            if($count!=0){
                return back()->with("msg","您添加的角色已经存在!");
                return view("role/add");
            }
            DB::table('T_AS_ROLE')->where('id',$id)->update([
                "RoleName"=>$_POST['roleName'],
                'updated_at'=>date("Y-m-d H:i:s", time())
            ]);
           
            return Redirect::to("role/index");
        }
        $db=DB::table('T_AS_ROLE')->where('id',$id)->get();
        return view('systems/role/update',compact('db'));
    }

    //删除角色
    public function delete($id){
        $count=DB::table("T_AS_USERROLE")->where("RoleID",$id)
                                         ->count();
        if($count!=0){
            return back()->with("msg","该角色存在用户，暂不能删除!");
            return view("role/index");
        }
        $db= DB::table("T_AS_ROLE")->where("id",$id)->update([
                "status"=>0
        ]);
        if($db){
            return Redirect::to("role/index");
        }
        
    }
 //获取角色名称
    public function getRoleName(){
       $name=$_POST['data'];
       // $name="技术部经理";
        $db=DB::table('T_AS_ROLE')->where(["RoleName"=>$name,"Status"=>1])->get();
        if($db){
            $arr["status"]=1;
           
        }else{
            $arr['status']=0;
          
        }

        return json_encode($arr);
    }
}
