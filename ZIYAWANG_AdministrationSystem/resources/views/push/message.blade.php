@extends('layouts.master')

@section('content')
    <link rel="stylesheet" href="{{asset('css/push.css ')}}"/>
    <div id="breadcrumb" style="position:relative">
        <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>信息</a>
        <a href="#" class="current">信息列表</a>
    </div>
    <div class="widget-content nopadding">
        <form class="form-horizontal" method="post" action="{{asset('push/message')}}" name="basic_validate"  novalidate="novalidate" />
        <table  class="table table-bordered table-striped pushMessage">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <td>
                <div class="control-group">
                    <label class="control-label">类型</label>
                    <div class="controls" >
                        <select  name="typeName" id="typeName"/>
                        <option value="0" class="select1">---全部---</option>
                        @foreach($types as $type)
                            <option value="{{$type->TypeID}}" @if(!empty($typeName) && $typeName==$type->TypeID) selected="selected" @endif>{{$type->TypeName}}</option>
                            @endforeach
                            </select>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group">
                    <label class="control-label">服务地区</label>
                    <div class="controls" >
                        <select  name="province" id="province"/>
                        <option   value="全国" @if(!empty($province) && $province=="全国") selected="selected" @endif>--全国--</option>
                        <option value="北京" @if(!empty($province) && $province=="北京") selected="selected" @endif>北京</option>
                        <option value="上海" @if(!empty($province) && $province=="上海") selected="selected" @endif>上海</option>
                        <option value="广东" @if(!empty($province) && $province=="广东") selected="selected" @endif>广东</option>
                        <option value="江苏" @if(!empty($province) && $province=="江苏") selected="selected" @endif>江苏</option>
                        <option value="山东" @if(!empty($province) && $province=="山东") selected="selected" @endif>山东</option>
                        <option value="浙江" @if(!empty($province) && $province=="浙江") selected="selected" @endif>浙江</option>
                        <option value="河南" @if(!empty($province) && $province=="河南") selected="selected" @endif>河南</option>
                        <option value="河北" @if(!empty($province) && $province=="河北") selected="selected" @endif>河北</option>
                        <option value="辽宁" @if(!empty($province) && $province=="辽宁") selected="selected" @endif>辽宁</option>
                        <option value="四川" @if(!empty($province) && $province=="四川") selected="selected" @endif>四川</option>
                        <option value="湖北" @if(!empty($province) && $province=="湖南") selected="selected" @endif>湖北</option>
                        <option value="湖南" @if(!empty($province) && $province=="湖南") selected="selected" @endif>湖南</option>
                        <option value="福建" @if(!empty($province) && $province=="福建") selected="selected" @endif>福建</option>
                        <option value="安徽" @if(!empty($province) && $province=="安徽") selected="selected" @endif>安徽</option>
                        <option value="陕西" @if(!empty($province) && $province=="陕西") selected="selected" @endif>陕西</option>
                        <option value="天津" @if(!empty($province) && $province=="天津") selected="selected" @endif >天津</option>
                        <option value="江西" @if(!empty($province) && $province=="江西") selected="selected" @endif>江西</option>
                        <option value="广西" @if(!empty($province) && $province=="广西") selected="selected" @endif>广西</option>
                        <option value="重庆" @if(!empty($province) && $province=="重庆") selected="selected" @endif>重庆</option>
                        <option value="吉林" @if(!empty($province) && $province=="吉林") selected="selected" @endif>吉林</option>
                        <option value="云南" @if(!empty($province) && $province=="云南") selected="selected" @endif>云南</option>
                        <option value="山西" @if(!empty($province) && $province=="山西") selected="selected" @endif>山西</option>
                        <option value="新疆" @if(!empty($province) && $province=="新疆") selected="selected" @endif>新疆</option>
                        <option value="贵州" @if(!empty($province) && $province=="贵州") selected="selected" @endif>贵州</option>
                        <option value="甘肃" @if(!empty($province) && $province=="甘肃") selected="selected" @endif>甘肃</option>
                        <option value="海南" @if(!empty($province) && $province=="海南") selected="selected" @endif>海南</option>
                        <option value="宁夏" @if(!empty($province) && $province=="宁夏") selected="selected" @endif>宁夏</option>
                        <option value="青海" @if(!empty($province) && $province=="青海") selected="selected" @endif>青海</option>
                        <option value="西藏" @if(!empty($province) && $province=="西藏") selected="selected" @endif>西藏</option>
                        <option value="黑龙江" @if(!empty($province) && $province=="黑龙江") selected="selected" @endif>黑龙江</option>
                        <option value="内蒙古" @if(!empty($province) && $province=="内蒙古") selected="selected" @endif>内蒙古</option>
                        </select>
                    </div>
                </div>
            </td>
            <td>
                <div class="form-actions searchBox">
                    <input type="submit" value="搜索" class="btn btn-success" />
                </div>
            </td>
        </table>
        </form>
    </div>
    <div  class="container-fluid">
        <div class="widget-content nopadding">
            <table class="table table-bordered table-striped infoList">
                <thead>
                <tr>
                    <th class="w1"></th>
                    <th class="w2">类型</th>
                    <th class="w3">文字描述</th>
                    <th class="w4">服务地区</th>
                </tr>
                </thead>
                <tbody>
                @foreach($datas as $data)
                    <tr>
                        <td> <input type="radio" class="message" name="serviceID" value="{{$data->ProjectID}}"></td>
                        <td class="tdMiddle">{{$data->TypeName}}</td>
                        <td>{{$data->WordDes}}</td>
                        <td class="tdMiddle">{{$data->ProArea}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination alternate">
            {!! $datas->render() !!}
        </div>
        <script type="text/javascript">
            $(".message").on("click",function(){
                var value= $(this).val();

               $.ajax({
                   url:"{{asset('push/save')}}",
                   data:{projectId:value,_token:"{{ csrf_token() }}"},
                   dataType:"json",
                   type:"post",
                   success:function(msg){
                       window.location.href="{{asset("push/index")}}"
                   }
               })

            });
        </script>
    </div>
    @endsection
            <!-- TODO: Current Tasks -->