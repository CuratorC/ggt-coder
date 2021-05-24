<?php

namespace App\Http\Resources;

use App\Models\ExhibitionHall;
use App\Models\User;

class UserResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request): array
  {
    return [
      //<------ relations↑
      'id' => $this->id,
      'status' => User::getStatusName()[$this->status],
      'name' => $this->name,
      //<------ fields↑
      /*$this->mergeWhen(Account::isPlatform(), [
            ]),*/
    ];
  }
}
