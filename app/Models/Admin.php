<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

//软删除 导入类
use Illuminate\Database\Eloquent\SoftDeletes;

//引入按钮组trait
use App\Models\Traits\Btn;

/**
 * App\Models\Admin
 *
 * @property int $id
 * @property int $role_id 角色ID
 * @property string $username 账号
 * @property string $truename 真实姓名
 * @property string $password 密码
 * @property string|null $email 邮箱
 * @property string $phone 手机号码
 * @property string $sex 性别
 * @property string $last_ip 登录IP
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $remember_token
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereLastIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereTruename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Models\Role $role
 */
class Admin extends Authenticatable
{
    //继承 trait
    use  SoftDeletes,Btn;
    //指定软删除字段 delete_at 数据表中的字段
    protected  $dates = ['deleted_at'];

    //黑名单  create方法
    protected  $guarded = [];

    //修改器
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    //用户与角色间的关系  属于
    public function role()
    {
        return $this->belongsTo(Role::class,'role_id');
    }
}
