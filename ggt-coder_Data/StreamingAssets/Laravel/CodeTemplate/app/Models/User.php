<?php

namespace App\Models;

use App\Models\Traits\MiddleTableOperate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JwtSubject
{
  use HasFactory, Notifiable, MiddleTableOperate;

  // Status
  const STATUS_CODE_NORMAL = 1;
  const STATUS_CODE_CLOSE = 9;
  public static function getStatusName(): array
  {
    return [
      self::STATUS_CODE_NORMAL => '正常',
      self::STATUS_CODE_CLOSE => '关闭',
    ];
  }

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'password',
    'company_name',
    'linkman_name',
    'linkman_phone',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ]; //<------ casts↑


  public function getJWTIdentifier()
  {
    return $this->getKey();
  }

  public function getJWTCustomClaims()
  {
    return [];
  }

  //<------ Fields↑

  //<------ Relations↑

  public function getList($request)
  {
    $this->searchRequest = $request;
    return $this->withWhere()->with()->coderOrder()->coderPaginate();
  }

  /**
   * @description 查询条件
   * @param $query
   * @return mixed
   * @author CuratorC
   * @date 2021-05-17
   */
  public function scopeWithWhere($query)
  {
    $query->coderWhen('name', function ($query, $value) {
      $query->where('name', 'like', '%' . $value . '%');
    }); //<------ search↑

    return $query->coderWhenKeyword();
  }
}
