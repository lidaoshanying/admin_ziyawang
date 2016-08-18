<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class OperateController extends Controller
{
    //上传轮播图
    public function index(){
        $results=DB::table("T_P_PROJECTTYPE")->get();
        return view("operate/banner/index",compact("results"));
    }

    //保存上传的轮播图信息
    public function save(){
        if($_POST['type']==1){
            $type=$_POST['typeName'];
        }else{
            $type=0;
        }
        $db=DB::table("T_P_BANNER")->insert([
            "TypeID"=>$_POST['type'],
            "type"=>$type,
            "BannerLink"=>$_POST['bannerLink'],
            "detailID"=>$_POST['detailId'],
            "created_at" => date("Y-m-d H:i:s", time()),
        ]);
        if($db){
            return back()->with("msg","上传成功");
        }else{
            return back()->with("msg","上传失败,请您重新上传");
        }
    }

    //轮播图上传图片
    public function upload(){
        $file = Input::file('Filedata');
        $clientName = $file->getClientOriginalName();//获取文件名
        $tmpName = $file->getFileName();//获取临时文件名
        $realPath = $file->getRealPath();//缓存文件的绝对路径
        $extension = $file->getClientOriginalExtension();//获取文件的后缀
        $mimeType = $file->getMimeType();//文件类型
        $newName =time() . mt_rand(1000, 9999) . '.' . $extension;//新文件名
//       $path = $file->move(base_path().'/public/upload/images/',$newName);//移动绝对路径
//       $filePath = '/upload/images/'.$newName;//存入数据库的相对路径
        $path = $file->move(dirname(base_path()) . '/ziyaupload/images/operates/', $newName);//移动绝对路径
        $filePath = '/operates/' . $newName;//存入数据库的相对路径
        return $filePath;
    }
}
