@extends('admin.public.main')

@section('cnt')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 文章管理
        <span class="c-gray en">&gt;</span> 文章列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="page-container">
        <form>
            <div class="text-c"> 日期范围：
                <input value="{{ request()->get('st') }}" type="text" onfocus="WdatePicker({})" name="st" class="input-text Wdate" style="width:120px;">
                -
                <input value="{{ request()->get('et') }}" type="text" onfocus="WdatePicker({})" name="et" class="input-text Wdate" style="width:120px;">
                <input value="{{ request()->get('kw') }}" type="text" class="input-text" style="width:250px" placeholder="输入搜索的账号" id="kw" name="kw">
                <button type="submit" class="btn btn-success radius" onclick="searchBtn()">
                    <i class="Hui-iconfont">&#xe665;</i> 搜索一下
                </button>
            </div>
        </form>

        @include('admin.public.msg')

        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a class="btn btn-danger radius">
                    <i class="Hui-iconfont">&#xe6e2;</i> 批量删除
                </a>
                <a href="{{ route('admin.article.create') }}" class="btn btn-primary radius">
                    <i class="Hui-iconfont">&#xe600;</i> 添加文章
                </a>
            </span>
        </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th>标题</th>
                    <th width="80">分类</th>
                    <th width="120">更新时间</th>
                    <th width="120">操作</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>

@endsection



@section('js')
{{--//引入datatables类库文件--}}
<script src="{{ staticAdminWeb() }}lib/datatables/1.10.0/jquery.dataTables.min.js"></script>

    <script>
        //选择对应的类选择器
       const datatable = $('.table-sort').dataTable({
            //页码修改
            LengthMenu:[10,20,30,50],
            //指定不排序
            aoColumnDefs: [
                {targets: [4],orderable: false}
            ],

            //初始化排序
            order:[[{{request()->get('field') ?? 0}},'{{request()->get("order") ?? "desc"}}']],
            //冲第几条开启显示
            displayStart:{{request()->get('start') ?? 0}},
           //取消默认搜索，客户端可以保留
           searching:false,
            //开启服务器端分页
            bServerSide:true,

            //进行ajax配置
            ajax:{
                url:'{{route('admin.article.index')}}',
                type:'GET',
                data:function (ret) {
                    //获取表单数据
                    ret.kw = $.trim($('#kw').val())
                }
            },

            //根据服务器端返回的数据显示
            //定义表格中每列中数据的显示
            columns:[
                {data: 'id',className:'text-c'},
                {data: 'title'},
                {data: 'cate.cname'},
                {data:'updated_at'},
                //操作数据源中更没有对应的数据
                {data:'actionBtn',className: 'text-c'}
            ],
            //生成对应行时数据对应事件
            createdRow:function (row,data) {
                // var td =$(row).find('td:last-child');
                //
                // var html = '<a href="###" class="label label-secondary radius">修改</a>';
                // td.html(html)
            }

        });

        //搜索
        function searchBtn() {
            datatable.api().ajax.reload();
        }
        //删除文章
        //事件委托

        $('.table-sort').on('click','.deluser',function () {
            //请求地址
            let url = $(this).attr('href');

            //使用fetch实现异步ajax
            layer.confirm('你真的要删除此用户吗?',{
                btn:['确认删除','再想一下']
            },()=> {
                fetch(url, {
                    method: 'delete',
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                        //json字符串传数据
                        'content-type': 'application/json'
                    },
                    //数据
                    body: JSON.stringify({name: 1})
                }).then(res => {
                    return res.json();
                }).then(ret => {
                    layer.msg('删除成功', {icon: 1, time: 1000}, ()=> {
                        $(this).parents('tr').remove();
                    })
                });

            });
            return false;
        })
    </script>

@endsection