<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
  /**
   * A list of the exception types that are not reported.
   *
   * @var array
   */
  protected $dontReport = [
    //
  ];

  /**
   * A list of the inputs that are never flashed for validation exceptions.
   *
   * @var array
   */
  protected $dontFlash = [
    'password',
    'password_confirmation',
  ];

  /**
   * Register the exception handling callbacks for the application.
   *
   * @return void
   */
  public function register()
  {
    $this->reportable(function (Throwable $e) {
      //
    });

    $this->renderable(function (\Illuminate\Validation\ValidationException $exception, $request) {
      $this->putMessageByErrors($exception);
    });
  }
  /**
   *ㅤ根据 errors 拼接 message
   * @param \Illuminate\Validation\ValidationException $exception
   * @throws \ReflectionException
   * @date 2020/10/19
   * @author Curator
   */
  private function putMessageByErrors(\Illuminate\Validation\ValidationException $exception)
  {
    $errors = $exception->errors();
    $errorMessage = [];
    foreach ($errors as $error) {
      foreach ($error as $item) {
        $errorMessage[] = $item;
      }
    }
    $message = implode(" ", $errorMessage);
    $reflectionObject = new \ReflectionObject($exception);
    $reflectionObjectProp = $reflectionObject->getProperty('message');
    $reflectionObjectProp->setAccessible(true);
    $reflectionObjectProp->setValue($exception, $message);
  }
}
