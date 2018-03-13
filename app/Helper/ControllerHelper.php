<?php 

namespace App\Helpers;

use File;
use Setting;
use Illuminate\Support\Facades\Mail;

class Helper
{

    public static function upload_picture($picture)
    {
        $file_name = time();
        $file_name .= rand();
        $file_name = sha1($file_name);
        if ($picture) {
            $ext = $picture->getClientOriginalExtension();
            $picture->move(public_path() . "/uploads", $file_name . "." . $ext);
            $local_url = $file_name . "." . $ext;

            $s3_url = url('/').'/uploads/'.$local_url;
            
            return $s3_url;
        }
        return "";
    }


    public static function delete_picture($picture) {
        File::delete( public_path() . "/uploads/" . basename($picture));
        return true;
    }

    public static function generate_booking_id() {
        return Setting::get('booking_prefix').mt_rand(100000, 999999);
    }

    public static function site_sendmail($user){

        $site_details=Setting::all();
       

        
        Mail::send('emails.invoice', ['user' => $user,'site_details'=>$site_details], function ($mail) use ($user,$site_details) {
           // $mail->from('harapriya@appoets.com', 'Your Application');

            $mail->to($user->user->email, $user->user->first_name.' '.$user->user->last_name)->subject('Invoice');
        });

        return true;
    }

}
