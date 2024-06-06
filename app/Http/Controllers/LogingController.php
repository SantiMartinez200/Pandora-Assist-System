<?php

namespace App\Http\Controllers;

use App\Models\Loging;
use Illuminate\Http\Request;

//$_SERVER['HTTP_SEC_CH_UA]
class LogingController extends Controller
{
  public function getLogs()
  {
    return view('logs.index', [
      'logs' => Loging::all(),
    ]);
  }

  public static function logIngUserModule($action)
  {
    $user = auth()->user()->name;
    $ip = request()->ip();
    $browser = "";
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $browser = LogingController::get_browser_name($user_agent);
    //dd($user, $ip, $browser, $action);
    Loging::create([
      'user_name' => $user,
      'action' => $action,
      'ip' => $ip,
      'browser' => $browser
    ]);
  }

public static function get_browser_name($user_agent)
  {
    if (stripos($user_agent, 'Opera') || stripos($user_agent, 'OPR/')) {
      $browser = 'Opera';
    } elseif (stripos($user_agent, 'Edge')) {
      $browser = 'Edge';
    } elseif (stripos($user_agent, 'Chrome')) {
      $browser = 'Chrome';
    } elseif (stripos($user_agent, 'Safari')) {
      $browser = 'Safari';
    } elseif (stripos($user_agent, 'Firefox')) {
      $browser = 'Firefox';
    } elseif (stripos($user_agent, 'MSIE') || stripos($user_agent, 'Trident/7')) {
      $browser = 'Internet Explorer';
    } else {
      $browser = 'Otro';
    }
    return $browser;
  }
}
