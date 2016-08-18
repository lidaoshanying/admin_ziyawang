<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //后台首页
    public function index(){

        $data= $this->datas();
        $nowTime=date("Y-m-d",time());
        $lastTime=date("Y-m-d",time()-86400*7);
        $oneTime=date("Y-m-d",time()-86400*1);
        $twoTime=date("Y-m-d",time()-86400*2);
        $threeTime=date("Y-m-d",time()-86400*3);
        $fourTime=date("Y-m-d",time()-86400*4);
        $fiveTime=date("Y-m-d",time()-86400*5);
        $sixTime=date("Y-m-d",time()-86400*6);
        $ToneUser=DB::table("users")->where( 'created_at',"<",$nowTime)->count();
        $TtwoUser=DB::table("users")->where('created_at', "<",$oneTime)->count();
        $TthreeUser=DB::table("users")->where('created_at',"<",$twoTime)->count();
        $TfourUser=DB::table("users")->where('created_at',"<",$threeTime)->count();
        $TfiveUser=DB::table("users")->where('created_at',"<",$fourTime)->count();
        $TsixUser=DB::table("users")->where('created_at',"<",$fiveTime)->count();
        $TsevenUser=DB::table("users")->where('created_at',"<",$sixTime)->count();
        $chart=array(
            "TsevenUser"=>$TsevenUser,
            "TsixUser"=>$TsixUser,
            "TfiveUser"=>$TfiveUser,
            "TfourUser"=>$TfourUser,
            "TthreeUser"=>$TthreeUser,
            "TtwoUser"=>$TtwoUser,
            "ToneUser"=>$ToneUser,
        );
        $times=array(
            0=>$lastTime,
            1=>$sixTime,
            2=>$fiveTime,
            3=>$fourTime,
            4=>$threeTime,
            5=>$twoTime,
            6=>$oneTime,
        );

        $maxs=array_search(max($chart),$chart);
        $max=$chart[$maxs];
        $mins=array_search(min($chart),$chart);
        $min=$chart[$mins];
        
        return view("Index/index",compact("data","chart","max","min","times"));
    }
    //后台首页数据
    public function datas(){
        $nowTime=date("Y-m-d",time());
        $lastTime=date("Y-m-d",time()-86400*7);
        $oneTime=date("Y-m-d",time()-86400*1);
        $twoTime=date("Y-m-d",time()-86400*2);
        $threeTime=date("Y-m-d",time()-86400*3);
        $fourTime=date("Y-m-d",time()-86400*4);
        $fiveTime=date("Y-m-d",time()-86400*5);
        $sixTime=date("Y-m-d",time()-86400*6);
        //最近一周每天总的注册的人数
        
        $ToneUser=DB::table("users")->where( 'created_at',"<",$nowTime)->count();
        $TtwoUser=DB::table("users")->where('created_at', "<",$oneTime)->count();
        $TthreeUser=DB::table("users")->where('created_at',"<",$twoTime)->count();
        $TfourUser=DB::table("users")->where('created_at',"<",$threeTime)->count();
        $TfiveUser=DB::table("users")->where('created_at',"<",$fourTime)->count();
        $TsixUser=DB::table("users")->where('created_at',"<",$fiveTime)->count();
        $TsevenUser=DB::table("users")->where('created_at',"<",$lastTime)->count();
        $total=DB::table("users")->count();
        $changes=($ToneUser-$TsevenUser)/$total;
        $change=round($changes,2)*100;

        //最近一周每天新增的注册的人数
        $oneUser=DB::table("users")->whereBetween( 'created_at',[$oneTime, $nowTime])->count();
        $twoUser=DB::table("users")->whereBetween('created_at',[$twoTime, $oneTime])->count();
        $threeUser=DB::table("users")->whereBetween('created_at',[$threeTime, $twoTime])->count();
        $fourUser=DB::table("users")->whereBetween('created_at',[$fourTime, $threeTime])->count();
        $fiveUser=DB::table("users")->whereBetween('created_at',[$fiveTime, $fourTime])->count();
        $sixUser=DB::table("users")->whereBetween('created_at',[$sixTime, $fiveTime])->count();
        $sevenUser=DB::table("users")->whereBetween('created_at',[$lastTime, $sixTime])->count();
        $changeusers=($oneUser-$sevenUser)/$total;
        $changeUser=round($changeusers,2)*100;
        

        //最近一周的服务商每天的总数
        $ToneSer=DB::table("T_U_SERVICEINFO")->where( 'created_at',"<",$nowTime)->count();
        $TtwoSer=DB::table("T_U_SERVICEINFO")->where('created_at', "<",$oneTime)->count();
        $TthreeSer=DB::table("T_U_SERVICEINFO")->where('created_at',"<",$twoTime)->count();
        $TfourSer=DB::table("T_U_SERVICEINFO")->where('created_at',"<",$threeTime)->count();
        $TfiveSer=DB::table("T_U_SERVICEINFO")->where('created_at',"<",$fourTime)->count();
        $TsixSer=DB::table("T_U_SERVICEINFO")->where('created_at',"<",$fiveTime)->count();
        $TsevenSer=DB::table("T_U_SERVICEINFO")->where('created_at',"<",$lastTime)->count();
         $totalSer=DB::table("T_U_SERVICEINFO")->count();
        $changeSers=($ToneSer-$TsevenSer)/$totalSer;
        $changeSer=round($changeSers,2)*100;
        
        
        //最近一周每天新增的服务商的人数
        $oneSer=DB::table("T_U_SERVICEINFO")->whereBetween( 'created_at',[$oneTime, $nowTime])->count();
        $twoSer=DB::table("T_U_SERVICEINFO")->whereBetween('created_at',[$twoTime, $oneTime])->count();
        $threeSer=DB::table("T_U_SERVICEINFO")->whereBetween('created_at',[$threeTime, $twoTime])->count();
        $fourSer=DB::table("T_U_SERVICEINFO")->whereBetween('created_at',[$fourTime, $threeTime])->count();
        $fiveSer=DB::table("T_U_SERVICEINFO")->whereBetween('created_at',[$fiveTime, $fourTime])->count();
        $sixSer=DB::table("T_U_SERVICEINFO")->whereBetween('created_at',[$sixTime, $fiveTime])->count();
        $sevenSer=DB::table("T_U_SERVICEINFO")->whereBetween('created_at',[$lastTime, $sixTime])->count();
        $lchangeSers=($oneSer-$sevenSer)/$totalSer;
        $lchangeSer=round($lchangeSers,2)*100;


        $lastUser=DB::table("users")->whereBetween('created_at', [$lastTime, $nowTime])->count();
        $services=DB::table("T_U_SERVICEINFO")->count();
        $lastServices=DB::table("T_U_SERVICEINFO")->whereBetween("created_at", [$lastTime, $nowTime])->count();
        $hots=DB::table("T_P_RUSHPROJECT")->where("CooperateFlag",0)->count();
        $togethers=DB::table("T_P_RUSHPROJECT")->where("CooperateFlag",1)->count();
        $projectinfos=DB::table("T_P_PROJECTINFO")->count();
        $users=DB::table("users")->count();
        $orders=DB::table("T_P_RUSHPROJECT")->count();
        $lastOrders=DB::table("T_P_PROJECTINFO")->whereBetween("PublishTime", [$lastTime, $nowTime])->count();

        $data=array(
            "users"=>$users,
            "lastUser"=>$lastUser,
            "services"=>$services,
            "lastServices"=>$lastServices,
            "hots"=>$hots,
            "togethers"=>$togethers,
            "projectinfos"=>$projectinfos,
            "orders"=>$orders,
            "lastOrders"=>$lastOrders,
            "oneUser"=>$oneUser,
            "twoUser"=>$twoUser,
            "threeUser"=>$threeUser,
            "fourUser"=>$fourUser,
            "fiveUser"=>$fiveUser,
            "sixUser"=>$sixUser,
            "sevenUser"=>$sevenUser,
            "ToneUser"=>$ToneUser,
            "TtwoUser"=>$TtwoUser,
            "TthreeUser"=>$TthreeUser,
            "TfourUser"=>$TfourUser,
            "TfiveUser"=>$TfiveUser,
            "TsixUser"=>$TsixUser,
            "TsevenUser"=>$TsevenUser,
            "ToneSer"=> $ToneSer,
            "TtwoSer"=> $TtwoSer,
            "TthreeSer"=> $TthreeSer,
            "TfourSer"=> $TfourSer,
            "TfiveSer"=> $TfiveSer,
            "TsixSer"=> $TsixSer,
            "TsevenSer"=> $TsevenSer,
            "oneSer"=> $oneSer,
            "twoSer"=> $twoSer,
            "threeSer"=>$threeSer,
            "fourSer"=>$fourSer,
            "fiveSer"=>$fiveSer,
            "sixSer"=>$sixSer,
            "sevenSer"=>$sevenSer,
            "change"=>$change,
             "changeSer"=>$changeSer,
             "changeUser"=>$changeUser,
            "lchangeSer"=>$lchangeSer
          

        );
        return $data;
    }
}
