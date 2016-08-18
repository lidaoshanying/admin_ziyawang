<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class NewsController extends Controller
{
    //新闻列表
    public function index()
    {
        if (isset($_POST["_token"])) {
            $datas = DB::table("T_N_NEWSINFO")->where("Flag", "<>", 2)->where("NewsTitle", "like", "%" . $_POST['newsTitle'] . "%")->orderBy("PublishTime", "desc")->paginate(20);
            return view("news/news/index", compact('datas'));
        }
        $datas = DB::table("T_N_NEWSINFO")->where('Flag', "<>", 2)->orderBy("PublishTime", "desc")->paginate(20);
        return view("news/news/index", compact('datas'));
    }

    //添加新闻
    public function add()
    {
        $datas = DB::table("T_CONFIG_TYPE")->where("Module", 1)->get();
        return view("news/news/add", compact("datas"));
    }

    //保存添加新闻
    public function save($type){
        if(!empty($_POST['type'])){
            $typeIds=$_POST['type'];
            foreach ($typeIds  as $typeId ){
               $typeNames= DB::table("T_CONFIG_TYPE")->select("TypeName")->where("id",$typeId)->get();
                foreach ($typeNames as $typeName){
                    $name=$typeName->TypeName;
                    switch($name){
                        case "行业动态":
                            $typeName->TypeName="hydt";
                            break;
                        case "财经资讯":
                            $typeName->TypeName="cjzx";
                            break;
                        case "资芽新闻":
                            $typeName->TypeName="zyxw";
                            break;
                    }
                }
                    foreach ($typeNames as $typeName){
                        $arr[]=$typeName->TypeName;
                    }
            }
            $newLab=implode(",",$arr);
                $db = DB::table("T_N_NEWSINFO")->insertGetId([
                    'NewsTitle' => $_POST['title'],
                    'NewsContent' => $_POST['content'],
                    'Brief' => $_POST['description'],
                    'NewsLogo' => $_POST['newslogo'],
                    'NewsThumb'=>$_POST['NewsThumb'],
                    'Flag' => $type,
                    "NewsLabel"=>$newLab,
                    'created_at' => date("Y-m-d H:i:s", time()),
                    "PublishTime"=>date("Y-m-d H:i:s", time()),

                ]);
                 $types = $_POST['type'];
                foreach ($types as $value) {
                    DB::table("T_CONFIG_ITEMTYPE")->insert([
                        "ModuleID" => $db,
                        "TypeID" => $value,
                        "Module" => 1,
                    'created_at' => date("Y-m-d H:i:s", time()),
                    "updated_at"=>date("Y-m-d H:i:s", time()),
                    ]);
                }

                return redirect("news/index");
        }else{
            return back()->with('msg',"请选择新闻类型");

        }

    }

    //保存编辑新闻
    public function saveupdate($type){   
        if(!empty($_POST['type'])){
            $typeIds=$_POST['type'];
            foreach ($typeIds  as $typeId ){
                $typeNames= DB::table("T_CONFIG_TYPE")->select("TypeName")->where("id",$typeId)->get();
                foreach ($typeNames as $typeName){
                    $name=$typeName->TypeName;
                    switch($name){
                        case "行业动态":
                            $typeName->TypeName="hydt";
                            break;
                        case "财经资讯":
                            $typeName->TypeName="cjzx";
                            break;
                        case "资芽新闻":
                            $typeName->TypeName="zyxw";
                            break;
                    }
                }
                foreach ($typeNames as $typeName){
                    $arr[]=$typeName->TypeName;
                }
            }
            $newLab=implode(",",$arr);
                $db = DB::table("T_N_NEWSINFO")->where('newsid', $_POST['newsid'])->update([
                    'NewsTitle' => $_POST['title'],
                    'NewsContent' => $_POST['content'],
                    'Brief' => $_POST['description'],
                    'NewsLogo' => $_POST['newslogo'],
                    'NewsThumb'=>$_POST['newsThumb'],
                    'NewsLabel'=>$newLab,
                    'Flag' => $type,
                    'updated_at' => date("Y-m-d H:i:s", time())
                ]);
                $types = $_POST['type'];
                $count = DB::table("T_CONFIG_ITEMTYPE")->where("ModuleID", $_POST['newsid'])->count();
                if ($count != 0) {
                    DB::table("T_CONFIG_ITEMTYPE")->where("ModuleID", $_POST['newsid'])->delete();
                }
                foreach ($types as $value) {
                    $result = DB::table("T_CONFIG_ITEMTYPE")->insert([
                        "ModuleID" => $_POST['newsid'],
                        "TypeID" => $value,
                        "Module" => 1
                    ]);
                }
            return redirect("news/index");
    }else{
            return back()->with('msg',"请选择新闻类型");
           
        }
        
    }

    //编辑新闻信息
    public function update($id)
    {
        $datas = DB::table("T_N_NEWSINFO")->where('newsid', $id)->first();
        $results = DB::table("T_CONFIG_ITEMTYPE")->select("TypeID")->where("ModuleID", $id)->get();
        foreach ($results as $result) {
            $count[] = $result->TypeID;
        }
        $types = DB::table("T_CONFIG_TYPE")->where("Module", 1)->get();
        return view("news/news/update", compact('datas', "count", "types"));
    }

    //删除新闻信息
    public function delete($id)
    {
        DB::table('T_N_NEWSINFO')->where('NewsID', $id)->update([
            'Flag' => 2,
            'updated_at' => date("Y-m-d H:i:s", time())]);
        DB::table("T_CONFIG_ITEMTYPE")->where("ModuleID", $id)->delete();
        return redirect("news/index");

    }

    public function upload()
    {
        $file = Input::file('Filedata');
        $clientName = $file->getClientOriginalName();//获取文件名
        $tmpName = $file->getFileName();//获取临时文件名
        $realPath = $file->getRealPath();//缓存文件的绝对路径
        $extension = $file->getClientOriginalExtension();//获取文件的后缀
        $mimeType = $file->getMimeType();//文件类型
        $newName =time() . mt_rand(1000, 9999) . '.' . $extension;//新文件名
//       $path = $file->move(base_path().'/public/upload/images/',$newName);//移动绝对路径
//       $filePath = '/upload/images/'.$newName;//存入数据库的相对路径
        $path = $file->move(dirname(base_path()) . '/ziyaupload/images/news/', $newName);//移动绝对路径
        $filePath = '/news/' . $newName;//存入数据库的相对路径
        return $filePath;
    }

    public function editorUpload()
    {
        $extensions = array("jpg", "bmp", "gif", "png");
        $uploadFilename = $_FILES['upload']['name'];
        $extension = pathInfo($uploadFilename, PATHINFO_EXTENSION);
        if (in_array($extension, $extensions)) {
         //   $uploadPath = str_replace("\\", '/', realpath(base_path())) . "/public/upload/";
            $uploadPath = str_replace("\\", '/', realpath(dirname(base_path())))."/ziyaupload/images/news/";
            $uuid = "N_".date('Ymd') . mt_rand(1000, 9999) . "." . $extension;
            $desname = $uploadPath . $uuid;
            $previewname = '/news/' . $uuid;
            $tag = move_uploaded_file($_FILES['upload']['tmp_name'], $desname);
            $callback = $_REQUEST["CKEditorFuncNum"];
            echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($callback,'http://images.ziyawang.com'+'" . $previewname . "','');</script>";
        } else {
            echo "<font color=\"red\"size=\"2\">*文件格式不正确（必须为.jpg/.gif/.bmp/.png文件）</font>";
        }



    }
}