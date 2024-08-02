<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use IPPanel\Client;
use IPPanel\Errors\Error;
use IPPanel\Errors\HttpException;
use IPPanel\Errors\ResponseCodes;



class SendPasswordResetSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $code;

    public function __construct($user, $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    public function handle()
    {
        $apiKey = "_hwHG1E5zI6P5DlhRBzTvpOawfFCD8i1NGNiZ1RHKi0=";
        $client = new Client($apiKey);
        $pattern = [
            "verification-code" => $this->code,
        ];

        try
        {
            $message = $client->sendPattern(
                "zqrndlv8xwkz01x",     // pattern code
                "+983000505",           // originator
                $this->user->phone_number,      // recipient
                $pattern                       // pattern values
            );
        }
        catch (Error $e)
        {
            var_dump($e->unwrap());
            echo $e->getCode();

            if ($e->code() == ResponseCodes::ErrUnprocessableEntity)
            {
                echo "Unprocessable entity";
            }
        }
        catch (HttpException $e)
        {
            var_dump($e->getMessage());
            echo $e->getCode();
        }
    }
}
