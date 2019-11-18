<?php

namespace App\Models;

/**
 * App\Models\Article
 *
 * @property int $id
 * @property int $cid 分类ID
 * @property string $title 文章标题
 * @property string $desn 文章摘要
 * @property string $pic 文章封面
 * @property string $body 文章内容
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Cate $cate
 * @property-read mixed $action_btn
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereCid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereDesn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article wherePic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Article extends Base {


    // 添加删除和修改按钮
    protected $appends = ['actionBtn'];

    // 分类
    public function cate() {
        return $this->belongsTo(Cate::class, 'cid');
    }

    // 和访问器合作
    // 修改按钮和删除按钮
    public function getActionBtnAttribute() {
        return $this->editBtn('admin.article.edit') .' '. $this->delBtn('admin.article.destroy');
    }
}
