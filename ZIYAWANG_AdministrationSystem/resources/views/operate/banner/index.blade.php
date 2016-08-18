@extends('layouts.master')

@section('content')
<style>
    .radio input[type="radio"] {
        float: left;
        margin-left: 0px;
    }
</style>
    <div id="breadcrumb">
        <a href="{{url('operate/index')}}" title="轮播图" class="tip-bottom"><i class="icon-home"></i> 轮播图</a>
        <a href="#" class="current">上传轮播图</a>
    </div>
    @if(session("msg"))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>{{session("msg")}}</strong>
        </div>
    @endif
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
								<span class="icon">
									<i class="icon-align-justify"></i>
								</span>
                    <h5>上传轮播图</h5>
                </div>
                <div class="widget-content nopadding">
                    <form method="post" action="{{asset('operate/save')}}" class="form-horizontal" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="control-group">
                        <label class="control-label">类型</label>
                        <div class="controls">
                            <input type="radio" name="type" id="type" value="1" />信息
                            <input type="radio" name="type"  id="type" value="2" />视频
                            <input type="radio" name="type" id="type" value="4" />服务
                        </div>
                    </div>
                    <div class="control-group" id="typeId" style="display:none" >
                        <label class="control-label">信息类型</label>
                            <div class="controls" >
                                <select  name="typeName" id="typeName"/>
                                    <option value="0">---全部---</option>
                                    <option value="01">资产包转账</option>
                                    <option value="02" >委外催收</option>
                                    <option value="03" >法律服务</option>
                                    <option value="04" >商业保理</option>
                                    <option value="05" >典当担保</option>
                                    <option value="06" >融资借贷</option>
                                    <option value="07" >资金过桥</option>
                                    <option value="08" >资产拍卖</option>
                                    <option value="09" >悬赏信息</option>
                                    <option value="10" >尽职调查</option>
                                    <option value="11" >评估审计</option>
                                    <option value="12" >固产转让</option>
                                    <option value="13" >资产求购</option>
                                    <option value="14" >债权转让</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group ">
                        <label class="control-label">详情ID</label>
                        <div class="controls">
                            <input type="text" name="detailId" value="" style="width: 100px;"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">图片</label>
                        <div class="controls">
                            <input type="hidden" id="filepath" name="bannerLink">
                            <input id="file_upload" name="file_upload"  multiple="true">
                        </div>
                        <div class="controls  span4">
                            <img src="" id="thumb" alt=""/>
                        </div>
                    </div>
                        <div class="form-actions">
                        <button type="submit" class="btn btn-primary">保存</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $("input[type='radio']").on("click",function(){
            var type=$("input[type='radio']:checked").val();
            if(type==1){
                $("#typeId").css("display","block");
            }else{
                $("#typeId").css("display","none");
            }
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
                'fileSizeLimit':1024,
                'uploadScript'     :"{{url('/operate/upload')}}",
                'onUploadComplete' : function(file, data) {
                    $('#filepath').val(data);
                    $('#thumb').attr('src',"Http://images.ziyawang.com"+data);
                }
            });
        });
    </script>
@endsection