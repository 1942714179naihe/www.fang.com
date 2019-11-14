@extends('admin.public.main')

@section('cnt')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 角色管理
        <span class="c-gray en">&gt;</span> 角色列表
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
                <a href="{{ route('admin.role.create') }}" class="btn btn-primary radius">
                    <i class="Hui-iconfont">&#xe600;</i> 添加角色
                </a>
            </span>
        </div>

        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th width="100">角色名称</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                {{-- 列表数据 --}}
                @foreach($data as $item)
                    <tr class="text-c">
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td class="td-manage">
                            <a href="{{ route('admin.role.edit',$item) }}" class="label label-secondary radius">修改</a>
                            <a data-href="###" class="label label-danger radius deluser">删除</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{-- 分页 --}}
        {{ $data->appends(request()->except('page'))->links() }}
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ staticAdminWeb() }}lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <script type="text/javascript" src="{{ staticAdminWeb() }}lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{ staticAdminWeb() }}lib/laypage/1.2/laypage.js"></script>
    <script>
        /* $('.deluser').click(async function () {
           // 发起请求的地址
           var url = $(this).attr('data-href');
           let data = await $.ajax({
             url,
             type: 'delete',
             data: {_token: "{{ csrf_token() }}"}
        });
        alert(data);
        // jquery中取消默认行为
        //return false;
      });*/

        const _token = "{{ csrf_token() }}";

        $('.deluser').click(function () {
            // 发起请求的地址
            var url = $(this).attr('data-href');
            // 询问
            layer.confirm('您真的要删除此用户吗？', {
                btn: ['确认删除', '再想一下']
            }, () => { // 确认删除
                $.ajax({
                    url,
                    type: 'delete',
                    data: {_token}
                }).then(ret => {
                    // 把当前点击的行给删除了 dom操作
                    $(this).parents('tr').remove();
                    // 让所有的layer插件弹框都关闭
                    //layer.closeAll();
                    // 提示  自动关闭一个弹框
                    layer.msg(ret.msg, {icon: 1, time: 1000});
                });
            });
            // jquery中取消默认行为
            return false;
        });

        // 全选删除
        function deleteAll() {
            // 选择选中的复选框
            var inputs = $('input[name="ids[]"]:checked');
            // 用户id
            var ids = [];
            inputs.map((key, item) => {
                ids.push($(item).val());
            });
            $.ajax({
                url: '{{ route('admin.user.delall') }}',
                type: 'delete',
                data: {
                    _token,
                    ids
                }
            }).then(ret => {
                inputs.map((key, item) => {
                    $(item).parents('tr').remove();
                });
            });
        }

        // 恢复用户
        // 0 由激活到禁用
        // 1 由禁用到激活
        function changeUser(status, id, obj) {
            if (status == 0) {
                // 就是软删除
                $.ajax({
                    url: '{{ route('admin.user.delall') }}',
                    type: 'delete',
                    data: {
                        _token,
                        ids: [id]
                    }
                }).then(ret => {
                    $(obj).removeClass('label-success').addClass('label-warning').html('禁用');
                })
            } else {
                // 由禁用到激活
                // 就是软删除
                $.ajax({
                    url: '{{ route('admin.user.restore') }}',
                    data: {id}
                }).then(ret => {
                    $(obj).removeClass('label-warning').addClass('label-success').html('激活');
                })
            }
        }
    </script>

@endsection

