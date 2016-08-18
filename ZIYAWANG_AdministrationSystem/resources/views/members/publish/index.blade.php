@extends('layouts.master')
@section('content')
    <link rel="stylesheet" href="{{asset('css/member.css ')}}"/>
    <div id="breadcrumb">
        <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>发布方</a>
        <a href="#" class="current">发布方列表</a>
        <a href="#" class="pull-right" id="export"> <div class=" btn btn-primary ">导出</div></a>
    </div>
    <div class="widget-content nopadding">
        <form class="form-horizontal" method="post" action="{{asset('publish/index')}}" name="basic_validate"  novalidate="novalidate" />
        <table  class="table table-bordered table-striped publishTable">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <td>
                <div class="control-group">
                    <label class="control-label">当前状态</label>
                    <div class="controls" >
                        <select  name="state" id="state"/>
                        <option value="2">全部<option>
                        <option value="1" @if(isset($state) && $state==1) selected="selected" @endif>冻结</option>
                        <option value="0" @if(isset($state) && $state==0) selected="selected" @endif>正常</option>
                        </select>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group">
                    <label class="control-label">手机号</label>
                    <div class="controls" >
                        @if(!empty($phoneNumber))
                            <input type="text" name="connectPhone"  id="connectPhone" value="{{$phoneNumber}}"  style="width:100px"/>
                        @else
                            <input type="text" name="connectPhone" id="connectPhone" value="" style="width:100px"/>
                        @endif
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group">
                    <label class="control-label">编号</label>
                    <div class="controls " >
                        @if(!empty($usersId))
                            <input type="text" name="usersId"  id="usersId" value="{{$usersId}}"  style="width:100px"/>
                        @else
                            <input type="text" name="usersId" id="usersId" value="" style="width:100px"/>
                        @endif
                    </div>
                </div>
            </td>
            <td class="tdTime">
            <div class="control-group ">
                <label class="control-label">时间</label>
                <div class="controls" >
                    @if(!empty($longTime) && !empty($shortTime))
                        <input type="text" name="shortTime"  id="shortTime" value="{{$shortTime}}"  style="width:100px"/>&nbsp&nbsp&nbsp&nbsp~&nbsp&nbsp&nbsp&nbsp <input type="text" name="longTime"  id="longTime" value="{{$longTime}}"  style="width:100px"/>
                    @else
                        <input type="text" name="shortTime" id="shortTime" value="" style="width:100px"/>&nbsp&nbsp&nbsp&nbsp~&nbsp&nbsp&nbsp&nbsp <input type="text" name="longTime"  id="longTime" value=""  style="width:100px"/>
                    @endif
                </div>
            </div>
            </td>
            <td class="tdSearch">
                <div class="form-actions searchBox">
                    <input type="submit" value="搜索" class="btn btn-success" />
                </div>
            </td>
        </table>
        </form>
    </div>
    <script>
        $(function () {
            $('#longTime').datetimepicker({
                minView: "month", //选择日期后，不会再跳转去选择时分秒
                format: "yyyy-mm-dd", //选择日期后，文本框显示的日期格式
                language: 'zh-CN', //汉化
                autoclose:true //选择日期后自动关闭
            });
            $("#shortTime").datetimepicker({
                minView: "month", //选择日期后，不会再跳转去选择时分秒
                format: "yyyy-mm-dd", //选择日期后，文本框显示的日期格式
                language: 'zh-CN', //汉化
                autoclose:true //选择日期后自动关闭
            });
        });
    </script>
    <script>
        $(function(){
            var connectPhone = $('#connectPhone').val();
            var state= $("#state").val();
            var usersId=$("#usersId").val();
            var shortTime=$("#shortTime").val();
            var longTime=$("#longTime").val();
            var url = 'http://admin.ziyawang.com/publish/export?state='+state+"&connectPhone="+connectPhone+"&usersId="+usersId+"&shortTime="+shortTime+"&longTime="+longTime;
            $('#export').attr('href',url);
        });
    </script>
    <div  class="container-fluid">
        <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>姓名</th>
                    <th>注册手机</th>
                    <th>注册时间</th>
                    <th>当前状态</th>
                    <th>角色</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($datas as $data)
                    <tr>
                        <td>{{$data->userid}}</td>
                        <td>{{$data->username}}</td>
                        <td>{{$data->phonenumber}}</td>
                        <td>{{$data->created_at}}</td>
                        @if($data->Status==0)
                            <td><p style="color:dodgerblue;margin:0 auto">正常</p></td>
                        @else
                           <td><p  style="color:dodgerblue">冻结</p></td>
                        @endif
                        @if($data->role==1)
                        <td>服务方</td>
                        @elseif($data->role==2)
                            <td>发布方</td>
                        @else
                            <td>注册</td>
                        @endif
                        <td>
                            <a href="{{url('publish/detail/'.$data->userid)}}">查看</a>
                        </td>
                      
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination alternate">
            {!! $datas->appends(["state"=>$state,"phoneNumber"=>$phoneNumber,"usersId"=>$usersId,"shortTime"=>$shortTime,"longTime"=>$longTime])->render() !!}
        </div>

    </div>

    @endsection
            <!-- TODO: Current Tasks -->


