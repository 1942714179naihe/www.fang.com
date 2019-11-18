<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Cate;
use Illuminate\Http\Request;

use App\Http\Requests\ArticleAddRequest;

class ArticleController extends BaseController
{
    //文章列表
    public function index(Request $request)
    {

        //判断是否是ajax请求
        if ($request->ajax()){
            //获取记录总数
            $count = Article::count();

            //分页
            $offset = $request->get('start',0);
            //获取的记录条数
            $limit = $request->get('length',$this->pagesize);

            //排序
            $order = $request->get('order')[0];
            //排字字段数组
            $columns = $request->get('columns')[$order['column']];
            //排序规则
            $orderType = $order['dir'];
            //排序字段
            $field = $columns['data'];

            //搜索
            $kw = $request->get('kw');
            $builer = Article::when($kw,function ($query) use($kw){
                $query->where('title','like',"%{$kw}%");
            });
            //获取记录总数
            $count = $builer->count();


            //服务器端分页
            $data = $builer->with('cate')->orderBy($field,$orderType)->offset($offset)->limit($limit)->get();

            //返回指定的格式json数据
            return [
                //客户端调用服务器端次数标识
                'draw' => $request->get('draw'),
                //获取数据记录总条数
                'recordsTotal' =>$count,
                //数据过滤后的总数量
                'recordsFiltered' => $count,
                'data' => $data
            ];
        }
        return view('admin.article.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //添加文章显示
    public function create()
    {
        //地区分类信息
        $cateData = Cate::all()->toArray();
        $cateData = treeLevel($cateData);

        return view('admin.article.create',compact('cateData'));
//        dump($cateData);
    }

    //文件上传
    public function upfile(Request $request)
    {
        $file = $request->file('file');

        $uri = $file->store('','article');
        return['status' => 0,'url' => '/uploads/articles/' . $uri];
    }

    //删除文件
    public function delfile(Request $request)
    {
        $id = $request->get('id');
        //删除图片的相对地址
        $src = $request->get('src');
        //绝对地址
        $filepath = public_path($src);
        if (is_file($filepath)){
            unlink($filepath);
        }
        return['status'=>0,'msg'=>'删除成功'];

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //添加处理
    public function store(ArticleAddRequest $request)
    {
        $data = $request->except(['_token','file']);

        Article::create($data);
        return redirect(route('admin.article.index'));
    }


    //修改显示
    public function edit(Request $request,Article $article)
    {
        //获取url参数
        $url_query = $request->all();
        //读取分类信息
        $cateData = Cate::all()->toArray();
        $cateData = treeLevel($cateData);
        return view('admin.article.edit',compact('cateData','article','url_query'));

    }

    //修改处理
    public function update(Request $request, Article $article)
    {
        $url = $request->get('url');


        $article->update($request->except(['file','_method','_token','url']));
        $url = route('admin.article.index'). '?' . http_build_query($url);
        return redirect($url);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    //删除操作
    public function destroy(Article $article)
    {
        $article->delete();
        return['status'=>0,'msg'=>'删除成功'];
    }
}
