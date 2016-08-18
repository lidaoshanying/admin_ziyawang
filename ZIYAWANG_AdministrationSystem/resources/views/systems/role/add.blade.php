@extends('layouts.master')
@section('content')
    <div id="breadcrumb" >
        <a href="{{asset('role/index')}}" title="角色列表" class="tip-bottom"><i class="icon-home"></i>角色</a>
        <a href="#" class="current">添加角色</a>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                            <span class="icon">
                                <i class="icon-align-justify"></i>
                            </span>
                    <h5>添加角色</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="post" action="{{asset('systems/role/add')}}" name="basic_validate"  novalidate="novalidate" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="control-group">
                        <label class="control-label">角色名称:</label>
                        <div class="controls">
                            <input type="text" name="roleName"  id="roleName"/>
                            <span class="help-inline"  id= "remark" for="pwd" generated="true" style="display: none; color: red">*您添加的角色已经存在</span>
                            @if(session("msg"))
                                <span class="help-inline"  id= "remark" for="pwd" generated="true" style=" color: red">{{session("msg")}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="submit"  id="submit" value="添加" class="btn btn-primary" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
    <script>
        $("#roleName").on("mouseover",function(){
           var datas=$("#roleName").val();
            $.ajax({
                url:"{{url('role/getRoleName')}}",
                data:{"data":datas,'_token':"{{csrf_token()}}"},
                dataType:"json",
                type:"post",
                success:function(msg){
                        if(msg.status==1){
                            $("#remark").show();
                        }
                }
            });
        });
        $("#roleName").on("mouseover",function(){
            $("#remark").hide();
        });
    </script>
</div>
@endsection