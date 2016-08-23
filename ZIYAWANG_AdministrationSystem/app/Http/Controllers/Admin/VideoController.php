<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class VideoController extends Controller
{
    //视频管理
    public function index(){
        if(isset($_POST["_token"])){
            $datas=DB::table("T_V_VIDEOINFO")->where("Flag","<>",2)->where("VideoTitle","like","%".$_POST['videoTitle']."%")->orderBy("PublishTime","desc")->paginate(20);
            return view("news/video/index",compact('datas'));
        }
        $datas=DB::table("T_V_VIDEOINFO")->where('Flag',"<>",2)->orderBy("PublishTime","desc")->paginate(20);
        return view("news/video/index",compact('datas'));
    }
    //添加视频
    public function add(){
        $datas=DB::table("T_CONFIG_TYPE")->where("module",2)->get();
        return view("news/video/add",compact("datas"));
    }

    //保存添加视频
    public function save($type){
        if(!empty($_POST['type'])){
            $typeIds=$_POST['type'];
            foreach ($typeIds  as $typeId ){
                $typeNames= DB::table("T_CONFIG_TYPE")->select("TypeName")->where("id",$typeId)->get();
                foreach ($typeNames as $typeName){
                    $name=$typeName->TypeName;
                    switch($name){
                        case "推荐":
                            $typeName->TypeName="tj";
                            break;
                        case "资芽哈哈哈":
                            $typeName->TypeName="zyhhh";
                            break;
                        case "行业说":
                            $typeName->TypeName="hys";
                            break;
                        case "大咖秀":
                            $typeName->TypeName="dkx";
                            break;
                        case "资芽一分钟":
                            $typeName->TypeName="zyyfz";
                            break;
                    }
                }
                foreach ($typeNames as $typeName){
                    $arr[]=$typeName->TypeName;
                }
            }
            $videoLab=implode(",",$arr);
            $db=DB::table("T_V_VIDEOINFO")->insertGetId([
                'VideoTitle'=>$_POST['title'],
                'VideoDes'=>$_POST['description'],
                'VideoLink'=>$_POST['videolink'],
                "VideoLink2"=>$_POST['videolink2'],
                'VideoLogo'=>$_POST['videologo'],
                "VideoThumb"=>$_POST['videoThumb'],
                'Flag'=>$type,
                "VideoLabel"=>$videoLab,
                "Order"=>!empty($_POST['order']) ? $_POST['order'] : "",
                'PublishTime'=>date("Y-m-d H:i:s", time()),
                'created_at'=>date("Y-m-d H:i:s", time())
            ]);
            $types=$_POST['type'];
            foreach($types as $value){
                DB::table("T_CONFIG_ITEMTYPE")->insert([
                    "ModuleID"=>$db,
                    "TypeID"=>$value,
                    "Module"=>2
                ]);
            }
            return redirect("video/index");
        }else {
            return back()->with('msg', "请选择新闻类型");
        }

    }

    //保存编辑视频
    public function saveupdate($type){
        if(!empty($_POST['type'])){
            $typeIds=$_POST['type'];
            foreach ($typeIds  as $typeId ){
                $typeNames= DB::table("T_CONFIG_TYPE")->select("TypeName")->where("id",$typeId)->get();
                foreach ($typeNames as $typeName){
                    $name=$typeName->TypeName;
                    switch($name){
                        case "推荐":
                            $typeName->TypeName="tj";
                        break;
                        case "资芽哈哈哈":
                            $typeName->TypeName="zyhhh";
                            break;
                        case "行业说":
                            $typeName->TypeName="hys";
                            break;
                        case "资芽一分钟":
                            $typeName->TypeName="zyyfz";
                            break;
                    }
                }
                foreach ($typeNames as $typeName){
                    $arr[]= $typeName->TypeName;
                }

            }
            $videoLab=implode(",",$arr);
            $db=DB::table("T_V_VIDEOINFO")->where('VideoID',$_POST['videoid'])->update([
                'VideoTitle'=>$_POST['title'],
                'VideoDes'=>$_POST['description'],
                'VideoLink'=>$_POST['videolink'],
                'VideoLink2'=>$_POST['videolink2'],
                'VideoLogo'=>$_POST['videologo'],
                "VideoThumb"=>$_POST['videoThumb'],
                'Flag'=>$type,
                "VideoLabel"=>$videoLab,
                "Order"=>!empty($_POST['order']) ? $_POST['order'] : "",
                'PublishTime'=>date("Y-m-d H:i:s", time()),
                'updated_at'=>date("Y-m-d H:i:s", time())
            ]);
            $types=$_POST['type'];
            $count=DB::table("T_CONFIG_ITEMTYPE")->where("ModuleID",$_POST['videoid'])->count();
            if($count!=0){
                DB::table("T_CONFIG_ITEMTYPE")->where("ModuleID",$_POST['videoid'])->delete();
            }
            foreach($types as $value){
                DB::table("T_CONFIG_ITEMTYPE")->insert([
                    "ModuleID"=>$_POST['videoid'],
                    "TypeID"=>$value,
                    "Module"=>2
                ]);
            }

            return redirect("video/index");
        }else{
            return back()->with('msg',"请选择视频类型");
         
        }

    }
    
    //编辑视频信息
    public function update($id){
        $datas=DB::table("T_V_VIDEOINFO")->where('VideoID',$id)->first();
        $results=DB::table("T_CONFIG_ITEMTYPE")->select("TypeID")->where("ModuleID",$id)->get();
        foreach ($results as $result){
            $count[]=$result->TypeID;
        }
        $types=DB::table("T_CONFIG_TYPE")->where("module",2)->get();
        return view("news/video/update",compact('datas',"count","types"));
    }
    //删除视频信息
    public function delete($id){
        DB::table('T_V_VIDEOINFO')->where('VideoID',$id)->update([
            'Flag'=>2,
            'updated_at'=>date("Y-m-d H:i:s", time())]);
        DB::table("T_CONFIG_ITEMTYPE")->where("ModuleID",$id)->delete();
        return redirect("video/index");
    }
    //上传视频logo图片
    public function upload(){
        $file = Input::file('Filedata');
        $clientName = $file->getClientOriginalName();//获取文件名
        $tmpName = $file->getFileName();//获取临时文件名
        $realPath = $file->getRealPath();//缓存文件的绝对路径
        $extension = $file->getClientOriginalExtension();//获取文件的后缀
        $mimeType = $file->getMimeType();//文件类型
        $newName = time(). mt_rand(1000,9999). '.'. $extension;//新文件名
//       $path = $file->move(base_path().'/public/upload/images/',$newName);//移动绝对路径
//       $filePath = '/upload/images/'.$newName;//存入数据库的相对路径
        $path = $file->move(dirname(base_path()).'/ziyaupload/images/videos/',$newName);//移动绝对路径
        $filePath = '/videos/'.$newName;//存入数据库的相对路径
        return $filePath;
    }
     //上传pc端的视频
    public function bigupload(){
        $file = Input::file('Filedata');
        $clientName = $file->getClientOriginalName();//获取文件名
        $tmpName = $file->getFileName();//获取临时文件名
        $realPath = $file->getRealPath();//缓存文件的绝对路径
        $extension = $file->getClientOriginalExtension();//获取文件的后缀
        $mimeType = $file->getMimeType();//文件类型
        $newName = time(). mt_rand(1000,9999). '.'. $extension;//新文件名
//       $path = $file->move(base_path().'/public/upload/images/',$newName);//移动绝对路径
//       $filePath = '/upload/images/'.$newName;//存入数据库的相对路径
        $path = $file->move(dirname(base_path()).'/ziyaupload/videos/bigvideo/',$newName);//移动绝对路径
        $filePath = '/bigvideo/'.$newName;//存入数据库的相对路径
        return $filePath;
    }
      //上传手机端的视频
    public function smallupload(){
        $file = Input::file('Filedata');
        $clientName = $file->getClientOriginalName();//获取文件名
        $tmpName = $file->getFileName();//获取临时文件名
        $realPath = $file->getRealPath();//缓存文件的绝对路径
        $extension = $file->getClientOriginalExtension();//获取文件的后缀
        $mimeType = $file->getMimeType();//文件类型
        $newName = time(). mt_rand(1000,9999). '.'. $extension;//新文件名
//       $path = $file->move(base_path().'/public/upload/images/',$newName);//移动绝对路径
//       $filePath = '/upload/images/'.$newName;//存入数据库的相对路径
        $path = $file->move(dirname(base_path()).'/ziyaupload/videos/smallvideo/',$newName);//移动绝对路径
        $filePath = '/smallvideo/'.$newName;//存入数据库的相对路径
        return $filePath;
    }
 
}
