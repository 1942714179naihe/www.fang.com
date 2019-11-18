<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// 引入软删除
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Btn;

/**
 * App\Models\Base
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Base onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Base withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Base withoutTrashed()
 * @mixin \Eloquent
 */
class Base extends Model
{
    use SoftDeletes,Btn;
    // 指定软删除字段 deleted_at 数据表中的字段
    protected $dates = ['deleted_at'];

    // create添加时所用    黑名单
    protected $guarded = [];

}
