@extends('admin.public.main')

@section('css')
    <!-- webuploader上传样式 -->
    <link rel="stylesheet" href="{{ staticAdminWeb() }}lib/webuploader/0.1.5/webuploader.css">
@endsection

@section('cnt')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 房源属性
        <span class="c-gray en">&gt;</span> 添加房源属性
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <article class="page-container">

        {{-- 错误信息 --}}
        @include('admin.public.msg')

        <form action="{{ route('admin.fangattr.store') }}" method="post" class="form form-horizontal" id="form-node-add">
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">顶级属性：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="pid" id="pid" class="select">
					@foreach($data as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
				</select>
				</span></div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>属性名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" value="{{ old('name') }}" class="input-text" name="name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">字段名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" value="{{ old('field_name') }}" class="input-text" name="field_name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">图标：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <div class="uploader-thum-container">
                        <div id="filePicker">选择图片</div>
                        <input type="hidden" name="icon" id="pic">
                        <img src="" style="width: 100px;" id="showpic">
                    </div>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="添加房源属性">
                </div>
            </div>
        </form>
    </article>
@endsection
@section('js')
    <!-- 引入webuploader插件 类库JS -->
    <script type="text/javascript" src="{{ staticAdminWeb() }}lib/webuploader/0.1.5/webuploader.min.js"></script>
    <!-- 表单验证 -->
    <script type="text/javascript" src="{{ staticAdminWeb() }}lib/jquery.validation/1.14.0/jquery.validate.js"></script>
    <script type="text/javascript" src="{{ staticAdminWeb() }}lib/jquery.validation/1.14.0/validate-methods.js"></script>
    <script type="text/javascript" src="{{ staticAdminWeb() }}lib/jquery.validation/1.14.0/messages_zh.js"></script>
    <script>
        // 异步文件上传
        var uploader = WebUploader.create({
            // 自动上传
            auto: true,
            // swf文件路径
            swf: '{{ staticAdminWeb() }}lib/webuploader/0.1.5/Uploader.swf',
            // 文件接收服务端
            server: '{{ route('admin.base.upfile') }}',
            // 选择文件的按钮
            pick: {
                id: '#filePicker',
                // 只允许单张图片
                multiple: false
            },
            resize: false,
            // 表单传额外值
            formData: {
                _token: "{{ csrf_token() }}",
                // 上传的节点名称
                node: 'fangattr'
            },
            // 上传表单名称
            fileVal: 'file'
        });
        // 回调方法监听
        uploader.on('uploadSuccess', function (file, {url}) {
            // 表单，用户于提交数据所用
            $('#pic').val(url);
            // 显示图片所用
            $('#showpic').attr('src', url);
        });

        //表单验证
        $("#form-node-add").validate({
            //规则
            rules:{
                name:{
                    required:true
                },
                field_name:{
                    fieldName:true
                }
            },
            //回车取消
            onkeyup:false,
            success:"valid",
            submitHandler:function (form) {
                form.submit();
            }
        })

        //自定义验证器
        jQuery.validator.addMethod("fieldName",function (value,emement) {
            //获取房源属性下拉列表重元素的值
            var bool =$('#pid').val() ==0 ? false : true;
            var  reg = /[a-zA-Z]/;
            return bool || (reg.test(value));
        },"选择顶级属性必须要填写对应字段名称");





    </script>
@endsection
