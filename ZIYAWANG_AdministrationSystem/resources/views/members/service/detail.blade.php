@extends('layouts.master')
@section('content')
    <div id="breadcrumb" style="position:relative">
        <a href="{{asset("service/index")}}" title="服务方列表" class="tip-bottom"><i class="icon-home"></i>服务方</a>
        <a href="#" class="current">服务方详情</a>
    </div>
    <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                            <span class="icon">
                                <i class="icon-align-justify"></i>
                            </span>
                        <h5>服务方详情</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{asset('service/update')}}"
                              />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @foreach($datas as $data)
                            <input type="hidden" name="id" value="{{$id}}">
                            <div class="control-group">
                                <label class="control-label">公司名称</label>
                                <div class="controls">
                                    <input type="text" name="name" id="required" value="{{$data->ServiceName}}"
                                           readonly/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">联系人</label>
                                <div class="controls">
                                    <input type="text" name="connectPerson" id="connectPerson" value="{{$data->ConnectPerson}}"
                                           readonly/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">联系方式</label>
                                <div class="controls">
                                    <input type="text" name="number" id="number" value="{{$data->ConnectPhone}}"
                                           readonly/>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">地区</label>
                                <div class="controls">
                                    <input type="text" name="area" id="area" value="{{$data->ServiceLocation}}"
                                           readonly/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">服务类型</label>
                                <div class="controls">
                                    <input type="text" name="type" id="type" value="{{$data->ServiceType}}"
                                           readonly/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">服务地区</label>
                                <div class="controls">
                                    <input type="text" name="ServiceArea" id="url" value="{{$data->ServiceArea}}"
                                           readonly/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">服务方认证时间</label>
                                <div class="controls">
                                    <input type="text" name="time" id="time" value="{{$data->created_at}}"
                                           readonly/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">公司简介</label>
                                <div class="controls">
                                    <input type="text" name="SerInt" id="url" value="{{$data->ServiceIntroduction}}"
                                           readonly/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">服务方资质认证</label>
                                <div class="controls">
                                    <input type="hidden" id="filepath" name="servicelogo[]">
                                    <input id="file_upload" name="file_upload"  multiple="true">
                                </div>
                                <div class="controls  span3">
                                   <div><img id="confirmationP1" alt=""  @if(!empty($data->ConfirmationP1)) src="{{'Http://images.ziyawang.com'.$data->ConfirmationP1}}"   @endif/>
                                       <span><a href="{{asset('Http://images.ziyawang.com'."$data->ConfirmationP1")}}"><i class="icon-download confirmationP1"  @if(empty($data->ConfirmationP1)) style="display:none" @endif></i></a>&nbsp&nbsp
                                           <i class="icon-trash confirmationP1"  @if(empty($data->ConfirmationP1)) style="display:none" @endif></i>
                                       </span>
                                   </div>
                                    <div><img  id="confirmationP2" alt=""  @if(!empty($data->ConfirmationP2))  src="{{'Http://images.ziyawang.com'.$data->ConfirmationP2}}" @endif/>
                                        <span><a href="{{asset('Http://images.ziyawang.com'."$data->ConfirmationP2")}}"><i class="icon-download confirmationP2"  @if(empty($data->ConfirmationP2)) style="display:none" @endif></i></a>&nbsp&nbsp
                                            <i class="icon-trash confirmationP2"  @if(empty($data->ConfirmationP2)) style="display:none" @endif></i>
                                        </span>
                                    </div>
                                        <div><img  id="confirmationP3" alt=""  @if(!empty($data->ConfirmationP3))  src="{{'Http://images.ziyawang.com'.$data->ConfirmationP3}}"  @endif/>
                                            <span><a href="{{asset('Http://images.ziyawang.com'."$data->ConfirmationP3")}}"><i class="icon-download confirmationP3"  @if(empty($data->ConfirmationP3)) style="display:none" @endif></i></a>&nbsp&nbsp
                                                <i class="icon-trash confirmationP3"  @if(empty($data->ConfirmationP3)) style="display:none" @endif></i>
                                            </span>
                                        </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">审核状态</label>/
                                <div class="controls">
                                    <select name="state" id="state">
                                        <option value="1" @if($data->State==1)selected="selected" @endif>已审核</option>
                                        <option value="2" @if($data->State==2)selected="selected" @endif>拒审核</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group" id="remark" style="display: none">
                                <label class="control-label">备注</label>
                                <div class="controls">
                                    <input type="text" name="remark" value="{{$data->Remark}}"/>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-actions">
                            <input type="submit" value="修改" class="btn btn-primary"/>
                            <a href="javascript:void(0)" id="back"><input type=button value="返回"
                                                                      class="btn btn-primary" onclick="javascript:history.back(-1);"/></a>
                        </div>
                        </form>
                    </div>
                </div>
        </div>
        <script type="text/javascript">
            $("#state").on("change", function () {
                var result2 = $(this).val();
                if ( result2==2) {
                    $("#remark").show();
                } else {
                    $("#remark").hide();
                }
            });
            $(function(){
                $(".confirmationP1").on("click",function(){
                    var id=$("input[name='id']").val();
                    $("#confirmationP1").removeAttrs("src");
                    $(".confirmationP1").hide();
                });
            });
            $(function(){
                $(".confirmationP2").on("click",function(){
                    var id=$("input[name='id']").val();
                    $("#confirmationP2").removeAttrs("src")
                    $(".confirmationP2").hide();
                });
            });
            $(function(){
                $(".confirmationP3").on("click",function(){
                    var id=$("input[name='id']").val();
                        $("#confirmationP3").removeAttrs("src")
                         $(".confirmationP3").hide();
                });
            });
            <?php $timestamp = time();?>
           $(function() {

                $("#file_upload").uploadifive({
                    'buttonText' : '上传图片',
                    'formData'     : {
                        'timestamp' : '<?php echo $timestamp;?>',
                        '_token'     : "{{csrf_token()}}"
                    },
                    'removeCompleted' : true,
                    'fileSizeLimit': 1024,
                    'uploadLimit'     : 3,
                    'uploadScript'     :"{{url('/service/upload')}}",
                    'onUploadComplete' : function(file, data) {
                        $('#filepath').val(data);
                        //$('#confirmationP1').attr('src', data);
                        var p1=$("#confirmationP1").attr('src');
                        var p2=$("#confirmationP2").attr('src');
                        var p3=$("#confirmationP3").attr('src');
                        if(typeof(p1)=="undefined"){
                            $('#confirmationP1').attr('src',"Http://images.ziyawang.com"+data);
                            $(".confirmationP1").show();
                            //var data= $('#confirmationP1').attr('src');
                            var id=$("input[name='id']").val();
                            $.ajax({
                                url:"{{asset('service/editHandle')}}",
                                data:{"id":id,"data":data,"title":"ConfirmationP1","_token":"{{ csrf_token() }}"},
                                dataType:"json",
                                type:"post",
                                success:function(mag){
                                    if(mag.state==0){
                                        alert("您添加失败!");
                                    }
                                }
                            });
                        }else if(typeof(p2)=="undefined"){
                            $('#confirmationP2').attr('src',"Http://images.ziyawang.com"+data);
                            $(".confirmationP2").show();
                            //var data= $('#confirmationP2').attr('src');
                            var id=$("input[name='id']").val();
                            $.ajax({
                                url:"{{asset('service/editHandle')}}",
                                data:{"id":id,"data":data,"title":"ConfirmationP2","_token":"{{ csrf_token() }}"},
                                dataType:"json",
                                type:"post",
                                success:function(mag){
                                    if(mag.state==0){
                                        alert("您添加失败!");
                                    }
                                }
                            });
                        }else{
                            $('#confirmationP3').attr('src',"Http://images.ziyawang.com"+data);
                            $(".confirmationP3").show();
                           // var data= $('#confirmationP3').attr('src');
                            var id=$("input[name='id']").val();
                            $.ajax({
                                url:"{{asset('service/editHandle')}}",
                                data:{"id":id,"data":data,"title":"ConfirmationP3","_token":"{{ csrf_token() }}"},
                                dataType:"json",
                                type:"post",
                                success:function(mag){
                                    if(mag.state==0){
                                        alert("您添加失败!");
                                    }
                                }
                            });
                        }
                    }
                });
            });
    </script>

@endsection