@extends('layouts.master')
@section('content')
    <div id="breadcrumb" style="position:relative">
        <a href="{{asset('refuse/index')}}" title="退单列表" class="tip-bottom"><i class="icon-home"></i>退单</a>
        <a href="#" class="current">退单详情</a>
    </div>
    <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                            <span class="icon">
                                <i class="icon-align-justify"></i>
                            </span>
                        <h5>退单详情</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{asset('refuse/update')}}"  />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" value="{{ $id }}">
                        @foreach($datas as $data)
                            <div class="control-group">
                                <label class="control-label">订单号</label>
                                <div class="controls">
                                    <input type="text" name="rushProID" id="required" value="{{$data->RushProID}}" readonly />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">服务类型</label>
                                <div class="controls">
                                    <input type="text" name="TypeName" id="TypeName"  value="{{$data->TypeName}}" readonly/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">发布方</label>
                                <div class="controls">
                                    <input type="text" name="phonenumber" id="phonenumber" value="{{$data->phonenumber}}" readonly/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">处置方名称</label>
                                <div class="controls">
                                    <input type="text" name="ServiceName" id="ServiceName" value="{{$data->ServiceName}}" readonly/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">退单申请时间</label>
                                <div class="controls">
                                    <input type="text" name="RushTime" id="RushTime" value="{{$data->RushTime}}" readonly/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">退单审核</label>
                                <div class="controls">
                                    <select name="CooperateFlag" id="CooperateFlag">
                                        <option value="0" >--请选择--</option>
                                        <option value="1" >同意退单</option>
                                        <option value="2" >拒绝退单</option>
                                    </select>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-actions">
                            <input type="submit" value="修改" class="btn btn-primary"/>
                            <a href="{{url('refuse/index')}}"><input type=button value="返回" class="btn btn-primary"/></a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection