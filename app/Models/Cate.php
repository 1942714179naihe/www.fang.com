<?php

namespace App\Models;

/**
 * App\Models\Cate
 *
 * @property int $id
 * @property string $cname 分类名称
 * @property int $pid 上级ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cate query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cate whereCname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cate wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Cate extends Base
{
    //
}
