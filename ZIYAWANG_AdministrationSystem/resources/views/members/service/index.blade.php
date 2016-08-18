@extends('layouts.master')
@section('content')
    <link rel="stylesheet" href="{{asset('css/member.css ')}}"/>
    <div id="breadcrumb" style="position:relative">
        <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>服务方</a>
        <a href="#" class="current">服务方列表</a>
        <a href="#" class="pull-right" id="export"> <div class="btn btn-primary">导出</div></a>
    </div>
    <div class="widget-content nopadding">
        <form class="form-horizontal" method="post" action="{{asset('service/index')}}" name="basic_validate"  novalidate="novalidate" />
        <table  class="table table-bordered table-striped servicerTable">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <td>
                <div class="control-group">
                    <label class="control-label checkState">审核状态</label>
                    <div class="controls selectBox" >
                        <select  name="state" id="state"/>
                        <option value="3">--全部--<option>
                        <option value="1" @if(isset($state) && $state==1) selected="selected" @endif>已审核</option>
                        <option value="0" @if(isset($state) && $state==0) selected="selected" @endif>待审核</option>
                        <option value="2" @if(isset($state) && $state==2) selected="selected" @endif>拒审核</option>
                        </select>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group">
                    <label class="control-label checkState">类型</label>
                    <div class="controls selectBox" >
                        <select  name="typeName" id="typeName"/>
                        <option value="0" class="select1">---全部---</option>
                        <option value="01" @if(!empty($typeName) && $typeName=="01") selected="selected" @endif>资产包收购</option>
                        <option value="02" @if(!empty($typeName) && $typeName=="02") selected="selected" @endif>催收机构</option>
                        <option value="03" @if(!empty($typeName) && $typeName=="03") selected="selected" @endif>律师事务所</option>
                        <option value="04" @if(!empty($typeName) && $typeName=="04") selected="selected" @endif>保理公司</option>
                        <option value="05" @if(!empty($typeName) && $typeName=="05") selected="selected" @endif>典当担保</option>
                        <option value="06" @if(!empty($typeName) && $typeName=="06") selected="selected" @endif>投资贷款</option>
                        <option value="10" @if(!empty($typeName) && $typeName=="10") selected="selected" @endif>尽职调查</option>
                        <option value="12" @if(!empty($typeName) && $typeName=="12") selected="selected" @endif>资产收购</option>
                        <option value="13" @if(!empty($typeName) && $typeName=="13") selected="selected" @endif>资金过桥</option>
                        <option value="14" @if(!empty($typeName) && $typeName=="14") selected="selected" @endif>债权收购</option>
                        </select>
                    </div>
                </div>
            </td>
           <td>
                <div class="control-group">
                    <label class="control-label checkState">手机号</label>
                    <div class="controls selectBox" >
                        @if(!empty($connectPhone))
                            <input type="text" name="connectPhone"  id="connectPhone" value="{{$connectPhone}}"  style="width:100px"/>
                        @else
                            <input type="text" name="connectPhone" id="connectPhone" value="" style="width:100px"/>
                        @endif
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group">
                    <label class="control-label checkState">公司名称</label>
                    <div class="controls selectBox" >
                        @if(!empty($serviceName))
                            <input type="text" name="serviceName"  id="serviceName" value="{{$serviceName}}"  style="width:100px"/>
                        @else
                            <input type="text" name="serviceName" id="serviceName" value="" style="width:100px"/>
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
        $(function(){
            var type = $('#typeName').val();
            var state=$("#state").val();
            var connectPhone=$("#connectPhone").val();
            var serviceName=$("#serviceName").val();
            var url = 'http://admin.ziyawang.com/service/export?type='+type+"&state="+state+"&connectPhone="+connectPhone+"&serviceName="+serviceName;
            $('#export').attr('href',url);
        });
    </script>
    <div  class="container-fluid">
        <div class="widget-content nopadding">
            <table class="table table-bordered table-striped servicerInfoTable">
                <thead>
                <tr>
                    <th class="w1">ID</th>
                    <th class="w2">公司名称</th>
                    <th class="w3">联系方式</th>
                    <th class="w4">地区</th>
                    <th class="w5">服务类型</th>
                    <th class="w6">服务地区</th>
                    <th class="w7">公司介绍</th>
                    <th class="w8">完善时间</th>
                    <th class="w9">审核状态</th>
                    <th class="w10">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($datas as $data)
                    <tr>
                        <td>{{$data->ServiceID}}</td>
                        <td>{{$data->ServiceName}}</td>
                        <td>{{$data->ConnectPhone}}</td>
                        <td>{{$data->ServiceLocation}}</td>
                        <td>{{$data->ServiceType}}</td>
                        <td>{{$data->ServiceArea}}</td>
                        <td class="tdCompanyIntro"><div>{{$data->ServiceIntroduction}}</div></td>
                        <td>{{$data->created_at}}</td>
                        @if($data->State==2)
                            <td><p style="color: #149bdf">拒审核</p></td>
                            @elseif($data->State==0)
                            <td><p style="color: #149bdf">待审核</p></td>
                            @else
                            <td><p style="color: #149bdf">已审核</p></td>
                            @endif

                        <td><a href="{{url('service/detail/'.$data->ServiceID)}}" id="look">查看</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination alternate" >
            {!! $datas->appends(['State'=>$state,"typeName"=>$typeName,"connectPhone"=>$connectPhone,"serviceName"=>$serviceName])->render() !!}
        </div>
    </div>

    @endsection
            <!-- TODO: Current Tasks -->
