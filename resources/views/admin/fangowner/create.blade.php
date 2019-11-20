@extends('admin.public.main')

@section('css')
    <!-- webuploader上传样式 -->
    <link rel="stylesheet" href="{{ staticAdminWeb() }}lib/webuploader/0.1.5/webuploader.css">
    <style>
        #imgbox img {
            margin: 10px;
            width: 100px;
            height: 100px;
        }
    </style>
@endsection

@section('cnt')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 房东管理
        <span class="c-gray en">&gt;</span> 添加房东
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <article class="page-container">

        {{-- 错误信息 --}}
        @include('admin.public.msg')

        <form action="{{ route('admin.fangowner.store') }}" method="post" class="form form-horizontal" id="form-node-add">
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>房东姓名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" value="{{ old('name') }}" class="input-text" name="name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>性别：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <label>
                            <input name="sex" type="radio" value="男" checked>男
                        </label>
                    </div>
                    <div class="radio-box">
                        <label>
                            <input name="sex" type="radio" value="女">女
                        </label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>房东年龄：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" value="{{ old('age') }}" class="input-text" name="age">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>手机号码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" value="{{ old('phone') }}" class="input-text" name="phone">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>身份证号码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" value="{{ old('card') }}" class="input-text" name="card">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>联系地址：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" value="{{ old('address') }}" class="input-text" name="address">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>联系邮箱：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" value="{{ old('email') }}" class="input-text" name="email">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>图标：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <div class="uploader-thum-container">
                        <div id="filePicker">选择图片</div>
                        <!-- 表单提交数据所用表单项 -->
                        <input type="hidden" name="pic" id="pic">
                        <!-- 上传图片显示区域 -->
                        <div id="imgbox"></div>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="添加房东信息">
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
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

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
                // 允许多张图片上传
                multiple: true
            },
            // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: false,
            // 表单传额外值
            formData: {
                _token: "{{ csrf_token() }}",
                // 上传的节点名称
                node: 'fangowner'
            },
            // 上传表单名称
            fileVal: 'file'
        });
        // 回调方法监听
        uploader.on('uploadSuccess', function (file, {url}) {
            // 上传图片地址，因为是多图片上传，进行字符串拼接
            // 获取表单中的数据
            let val = $('#pic').val();
            $('#pic').val(val + '#' + url);
            // 显示图片所用
            // 创建一个img的jquery对象
            var imgObj = $('<img />');
            imgObj.attr('src', url);
            $('#imgbox').append(imgObj);
        });

        // 表单验证
        $("#form-node-add").validate({
            // 规则
            rules: {
                // 表单名
                name: {
                    required: true
                },
                age: {
                    required: true,
                    digits: true,
                    min: 1,
                    max: 110
                },
                phone: {
                    required: true,
                    checkPhone: true
                },
                card: {
                    required: true,
                    checkCard: true
                },
                address: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                }
            },
            // 回车取消
            onkeyup: false,
            success: "valid",
            // 验证通过后，处理回调函数
            submitHandler: function (form) {
                form.submit();
            }
        });

        自定义验证器jq,手机号码验证
        jQuery.validator.addMethod("checkPhone",function (value,element) {
            var reg = /^1[3-9]\d{9}$/;
            return this.optional(element) || (reg.test(value));
        },"你输入的不是个合法号码！！");
        //身份征验证
        jQuery.validator.addMethod("checkCard",function (value,element) {
          var  card = value.replace(' ','');
            var len =card.length;
            var bool = len == 18 ? true : false;
            return this.optional(element) || bool;
        },"你输入的不是个合法身份证！！");


    </script>
@endsection
