@extends('admin.public.main')

@section('cnt')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 房东管理
        <span class="c-gray en">&gt;</span> 房东列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="page-container">
        <form>
            <div class="text-c"> 日期范围：
                <input value="{{ request()->get('kw') }}" type="text" class="input-text" style="width:250px" placeholder="输入搜索的账号" name="kw">
                <button type="submit" class="btn btn-success radius" id="" name="">
                    <i class="Hui-iconfont">&#xe665;</i> 搜索一下
                </button>
            </div>
        </form>

        @include('admin.public.msg')

        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="{{ route('admin.fangowner.create') }}" class="btn btn-primary radius">
                    <i class="Hui-iconfont">&#xe600;</i> 添加房东
                </a>
                 <a href="{{ route('admin.fangowner.export') }}" class="btn btn-success radius">
                    <i class="Hui-iconfont">&#xe600;</i> 导出房东Excel
                </a>
                   <a style="display: @if($isshow) inline-block; @else none; @endif" href="/uploads/fangownerexcel/fangowner.xlsx" class="btn btn-success radius">
                    <i class="Hui-iconfont">&#xe600;</i> 下载excel
                </a>
            </span>
        </div>

        <div class="mt-20" id="app">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th width="100">房东姓名</th>
                    <th width="100">身份证号</th>
                    <th width="100">房东性别</th>
                    <th width="100">房东年龄</th>
                    <th width="100">联系号码</th>
                    <th width="100">家庭住址</th>
                    <th width="100">邮箱</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->card}}</td>
                        <td>{{$item->sex}}</td>
                        <td>{{$item->age}}</td>
                        <td>{{$item->phone}}</td>
                        <td>{{$item->address}}</td>
                        <td>{{$item->email}}</td>
                        <td>

                            {!! $item->showBtn('admin.fangowner.show') !!}
                            {!! $item->editBtn('admin.fangowner.edit') !!}
                            {!! $item->delBtn('admin.fangowner.destroy') !!}
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>

        {{--分页--}}

        {{$data->appends(request()->except('page'))->links()}}
    </div>

@endsection

@section('js')
    <script type="text/javascript" src="{{ staticAdminWeb() }}lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <script type="text/javascript" src="{{ staticAdminWeb() }}lib/laypage/1.2/laypage.js"></script>
    <script src="/js/vue.js"></script>

    <script>
        const _token = "{{csrf_token()}}";
      //给查看按钮点击绑定事件并取消摩尔年时间
        $('.showBtn').click(function () {
            let url =$(this).attr('href');
            //弹窗查看身份证信息
            $.get(url).then(({status,msg,data}) => {
                if (status ==0){
                    let content = '';
                    data.forEach(item => {
                        content += `<img src="${item}" style="width:150px" />&nbsp; `
                    });
                    //弹窗
                    layer.open({
                        type : 1,
                        skin : 'layui-layer-rim',
                        area:['600px','300px'],
                            content
                    });
                }
            });
            return false;
        });

    </script>
@endsection

