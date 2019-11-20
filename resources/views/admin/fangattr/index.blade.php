@extends('admin.public.main')

@section('cnt')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 权限管理
        <span class="c-gray en">&gt;</span> 权限列表
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
                <a href="{{ route('admin.fangattr.create') }}" class="btn btn-primary radius">
                    <i class="Hui-iconfont">&#xe600;</i> 添加房源属性
                </a>
            </span>
        </div>

        <div class="mt-20" id="app">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th width="100">属性名称</th>
                    <th width="100">图标</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in items">
                    <td v-text="item.id"></td>
                    <td :style="'padding-left:'+(item.level*10)+'px'">@{{ item.name }}@{{ item.level }}</td>
                    <td>
                        <img :src="item.icon" style="width: 100px;">
                    </td>
                    <td v-html="item.actionBtn"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ staticAdminWeb() }}lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <script type="text/javascript" src="{{ staticAdminWeb() }}lib/laypage/1.2/laypage.js"></script>
    <script src="/js/vue.js"></script>

    <script>
        const _token = "{{csrf_token()}}";
        const  app =new Vue({
            el:'#app',
            data:{
                //房源属性
                items:[]
            },
            mounted(){
                $.get("{{route('admin.fangattr.index')}}").then(ret => {
                    this.items =ret;
                })
            }
        })

    </script>
@endsection

