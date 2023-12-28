<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;
use Toastr;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
        });
        $this->renderable(function (Throwable $e, $request) {
            if ($e instanceof ValidationException) {
                // dd($e);
                foreach ($e->errors() as $err) {
                    Toastr::error($err[0], 'Thông báo');
                }
                return;
                // return redirect()->back();
            }
            else if ($e instanceof Exception) {
                Toastr::error($e->getMessage(), 'Thông báo');
                // return redirect()->back();
                return;
            }
        });
    }
}
