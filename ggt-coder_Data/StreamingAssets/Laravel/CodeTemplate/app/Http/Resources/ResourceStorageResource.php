<?php

namespace App\Http\Resources;

use App\Models\Exhibition;
use Storage;

class ResourceStorageResource extends JsonResource
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
      'url'  => $this->getUrl($this->name),
      //<------ fields↑
      /*$this->mergeWhen(Account::isPlatform(), [
            ]),*/
    ];
  }

  /**
   * 获取地址
   */
  private function getUrl($name)
  {
    $disk = Storage::disk('oss');
    return $disk->signUrl($name, 10);
  }
}
