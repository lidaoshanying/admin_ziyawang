@extends('layouts.master')
@section('content')
    <div id="breadcrumb" style="position:relative">
        <a href="{{asset('publish/index')}}" title="发布方列表" class="tip-bottom"><i class="icon-home"></i>发布方</a>
        <a href="#" class="current">发布方详情</a>
    </div>
    <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                            <span class="icon">
                                <i class="icon-align-justify"></i>
                            </span>
                        <h5>发布方详情</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{asset('publish/update')}}" />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        @foreach($db as $data)
                            <input type="hidden" name="id" value="{{$data->userid}}">
                        <div class="control-group">
                            <label class="control-label">姓名</label>
                            <div class="controls">
                                <input type="text" name="name" id="required" value="{{$data->username}}" readonly/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">邮箱</label>
                            <div class="controls">
                                <input type="text" name="email" id="email"  value="{{$data->email}}"  readonly/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">注册手机号</label>
                            <div class="controls">
                                <input type="text" name="number" id="date" value="{{$data->phonenumber}}"  readonly/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">注册时间</label>
                            <div class="controls">
                                <input type="text" name="password" id="url" value="{{$data->created_at}}"  readonly/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">当前状态</label>
                            <div class="controls">
                                <select name="status" id="status">
                                        <option value="1"  @if($data->Status==1) selected="selected"  @endif>冻结</option>
                                        <option value="0" @if($data->Status==0)selected="selected"  @endif>正常</option>
                                    </select>
                            </div>
                        </div>
                        <div class="control-group"  id="remark"style="display:none;">
                            <label class="control-label">备注</label>
                            <div class="controls">
                                <input type="text" name="remark" id="date" value="{{$data->Remark}}"/>
                            </div>
                        </div>
                            <div class="form-actions">
                                <input type="submit" value="修改" class="btn btn-primary"/>
                                <a href="#"><input type="button" value="返回" class="btn btn-primary" onclick="javascript:history.back(-1);"/></a>
                            </div>
                        @endforeach
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var result1 = $("#status").val();
            $("#status").on("change", function () {
                var result2 = $(this).val();
                if (result1 == result2) {
                    $("#remark").hide();
                } else {
                    $("#remark").css("display", "block");
                }
            });
        </script>


@endsection