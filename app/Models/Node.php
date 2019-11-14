<?php

namespace App\Models;


/**
 * App\Models\Node
 *
 * @property int $id
 * @property string $name 节点名称
 * @property string|null $route_name 路由别名，权限认证标识
 * @property int $pid 上级ID
 * @property string $is_menu 是否为菜单0否，1是
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node whereIsMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node whereRouteName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Node extends Base
{
    //
}
