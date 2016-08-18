<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PublishController extends Controller
{
    //发布方列表
    public  function index(){
        $stateWhere=array();
        if(isset($_POST["_token"])){
            $state=$_POST['state'];
            $longTime=$_POST['longTime'];
            $shortTime=$_POST['shortTime'];
            $usersId=!empty($_POST['usersId']) ? $_POST['usersId'] : "";
            $phoneNumber=$_POST['connectPhone'];
            $stateWhere=$_POST['state']!=2 ? array("Status"=>$state) :array();
            $userIdWhere=!empty($_POST['usersId']) ? array("userid"=>$usersId) : array();
            if(!empty($_POST['connectPhone'])){
                  if(!empty($longTime) && !empty($shortTime)){
                      $datas=DB::table("users")->select("users.*")
                          ->where($stateWhere)
                          ->where($userIdWhere)
                          ->where("phonenumber","like","%".$phoneNumber."%")
                          ->whereBetween("created_at",[$shortTime,$longTime])
                          ->orderBy("created_at","desc")
                          ->paginate(20);
                  }else{
                      $datas=DB::table("users")->select("users.*")
                          ->where($stateWhere)
                          ->where($userIdWhere)
                          ->where("phonenumber","like","%".$phoneNumber."%")
                          ->orderBy("created_at","desc")
                          ->paginate(20);
                  }
            }else{
                if(!empty($longTime) && !empty($shortTime)){
                    $datas=DB::table("users")->select("users.*")
                        ->where($stateWhere)
                        ->where($userIdWhere)
                        ->whereBetween("created_at",[$shortTime,$longTime])
                        ->orderBy("created_at","desc")
                        ->paginate(20);
                }else{
                    $datas=DB::table("users")->select("users.*")
                        ->where($stateWhere)
                        ->where($userIdWhere)
                        ->orderBy("created_at","desc")
                        ->paginate(20);
                }
            }
            foreach($datas as $data){
                $userId=$data->userid;
                $results=DB::table("T_U_SERVICEINFO")->where('userid',$userId)->count();
                $pubs=DB::table("T_P_PROJECTINFO")->where("userid",$userId)->count();
                if($results>0){
                    $data->role=1;
                }else if($pubs>0 && $results==0 ){
                    $data->role=2;
                }else{
                    $data->role=0;
                }
            }
            return view("members/publish/index",compact("datas","state","phoneNumber","usersId","shortTime","longTime"));
        }
        if(!empty($_GET)){
            $state=$_GET['state'];
            $phoneNumber=$_GET['phoneNumber'];
            $usersId=$_GET['usersId'];
            $shortTime=!empty($_GET['shortTime']) ? $_GET['shortTime'] : "";
            $longTime=!empty($_GET['longTime']) ? $_GET['longTime'] : "";
            $userIdWhere=!empty($_GET['usersId']) ? array("userid"=>$usersId) : array();
            $stateWhere=$_GET['state']!=2 ? array("Status"=>$state) :array();
            $datas=array();
            if(!empty($_GET['phoneNumber'])){
                  if(!empty($longTime) && !empty($shortTime)){
                      $datas=DB::table("users")
                          ->where($stateWhere)
                          ->where($userIdWhere)
                          ->where("phonenumber","like","%".$phoneNumber."%")
                          ->whereBetween("created_at",[$shortTime,$longTime])
                          ->orderBy("created_at","desc")
                          ->paginate(20);
                  }else{
                      $datas=DB::table("users")
                          ->where($stateWhere)
                          ->where($userIdWhere)
                          ->where("phonenumber","like","%".$phoneNumber."%")
                          ->orderBy("created_at","desc")
                          ->paginate(20);
                  }
            }else{
                    if(!empty($longTime) && !empty($shortTime)){
                        $datas=DB::table("users")
                            ->where($stateWhere)
                            ->where($userIdWhere)
                            ->whereBetween("created_at",[$shortTime,$longTime])
                            ->orderBy("created_at","desc")
                            ->paginate(20);
                    }else{
                        $datas=DB::table("users")
                            ->where($stateWhere)
                            ->where($userIdWhere)
                            ->orderBy("created_at","desc")
                            ->paginate(20);
                    }
            }

            foreach($datas as $data){
                $userId=$data->userid;
                $results=DB::table("T_U_SERVICEINFO")->where('userid',$userId)->count();
                $pubs=DB::table("T_P_PROJECTINFO")->where("userid",$userId)->count();
                if($results>0){
                    $data->role=1;
                }else if($pubs>0 && $results==0 ){
                    $data->role=2;
                }else{
                    $data->role=0;
                }
            }
            return view("members/publish/index",compact("datas","state","phoneNumber","usersId","shortTime","longTime"));
        }
        
        $state=2;
        $phoneNumber="";
        $usersId="";
        $shortTime="";
        $longTime="";
        $datas=DB::table("users")->orderBy("created_at","desc")->paginate(20);
        foreach($datas as $data){
            $userId=$data->userid;
            $results=DB::table("T_U_SERVICEINFO")->where('userid',$userId)->count();
            $pubs=DB::table("T_P_PROJECTINFO")->where("userid",$userId)->count();
            if($results>0){
                $data->role=1;
            }else if($pubs>0 && $results==0 ){
                $data->role=2;
            }else{
                $data->role=0;
            }

        }
        return view("members/publish/index",compact("datas","state","phoneNumber","usersId","shortTime","longTime"));
    }
    //详情
    public function  detail($id){
        $db=DB::table("users")->where("userid",$id)->get();

        return view("members/publish/detail",compact('db'));

    }

    //导出
    public function export(){
            set_time_limit(0);
            ini_set('memory_limit', '512M');
            $stateWhere=$userIdWhere=array();
            $state=$_GET['state'];
            $shortTime=!empty($_GET['shortTime']) ? $_GET['shortTime'] : "";
            $longTime=!empty($_GET['longTime']) ? $_GET['longTime'] : "";
            $phoneNumber=$_GET['connectPhone'];
            $stateWhere=$_GET['state']!=2 ? array("Status"=>$state) : array();
            $usersId=$_GET['usersId'];
            $userIdWhere=!empty($_GET['usersId']) ? array("userid"=>$usersId) : array();
        if(!empty($_GET['connectPhone'])){
                  if(!empty($longTime) && !empty($shortTime)){
                      $datas=DB::table("users")
                          ->where("phonenumber","like","%".$phoneNumber."%")
                          ->where($stateWhere)
                          ->where($userIdWhere)
                          ->whereBetween("created_at",[$shortTime,$longTime])
                          ->get();
                  }else{
                      $datas=DB::table("users")
                          ->where("phonenumber","like","%".$phoneNumber."%")
                          ->where($stateWhere)
                          ->where($userIdWhere)
                          ->get();
                  }
        }else{
            if(!empty($shortTime) && !empty($longTime)){
                $datas=DB::table("users")
                    ->where($userIdWhere)
                    ->where($stateWhere)
                    ->whereBetween("created_at",[$shortTime,$longTime])
                    ->get();
            }else{
                $datas=DB::table("users")
                    ->where($userIdWhere)
                    ->where($stateWhere)
                    ->get();
            }
        }
        foreach($datas as $data){
                $userId=$data->userid;
                $results=DB::table("T_U_SERVICEINFO")->where('userid',$userId)->get();
                if($results){
                    $data->role=1;
                }else{
                    $data->role=0;
                }

            }
            require_once '../vendor/PHPExcel.class.php';
            require_once '../vendor/PHPExcel/IOFactory.php';
            require_once '../vendor/PHPExcel/Reader/Excel5.php';

            $phpExcel = new \PHPExcel();
            //var_dump($phpExcel);die;
            $excel_name = '资芽网发布方信息' . date("Y-m-d", time());
            $phpExcel->setActiveSheetIndex(0);
            $phpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $phpExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

            $phpExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', '姓名')
                ->setCellValue('B1', '注册手机')
                ->setCellValue('C1', '注册时间')
                ->setCellValue('D1', '角色');
        foreach ($datas as $key => $data) {
                if($data->role==1){
                    $role="服务方";
                }else{
                    $role='发布方';
                }
                $i = $key + 2;
                $phpExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $data->username)
                    ->setCellValue('B' . $i, $data->phonenumber)
                    ->setCellValue('C' . $i, $data->created_at)
                    ->setCellValue('D' . $i, $role);

            }
            $objWriter = \PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
            header("Content-Type:application/force-download");
            header("Content-Type:application/vnd.ms-execl");
            header("Content-Type:application/octet-stream");
            header("Content-Type:application/download");
            header('Content-Disposition:attachment;filename=' . $excel_name . ".xls");
            header("Content-Transfer-Encoding:binary");
            $objWriter->save('php://output');
        }
    //发布方编辑信息保存
    public function update(){

        $db= DB::table("users")->where("userid",$_POST['id'])->update([
            "Status"=>$_POST['status'],
            "Remark"=>$_POST["remark"],
             'updated_at'=>date("Y-m-d H:i:s", time()),
        ]);
        if($db){
             return Redirect::to("publish/index");
        }else{
           return Redirect::to("publish/detail/".$_POST['id']);
        }
    }
 

}
