<?php

namespace App\Http\Controllers\Telegram;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\FileUpload\InputFile;

class TelegramBotController extends Controller
{
    public function updatedActivity()
    {
        $activity = Telegram::getUpdates();
        dd($activity);
    }
 
    public function sendMessage()
    {
        return view('telegram.message');
    }
 
    public function storeMessage(Request $request)
    {
        $request->validate([
            'message' => 'required'
        ]);
 
        $text = $request->message;
        // $mesin = ["SURDIAL 55 PLUS | BARU | SERI1234","NCU 18 | BEKAS |SERI0012"];
        // $strmesin = "";
        // for($i=0;$i < count($mesin); $i++){
        //     $strmesin = $strmesin."\n -".$mesin[$i];
        // }
            
        // $text = "<b>Penerimaan Mesin</b>\n\n"
        //         ."<b>Gudang :</b> Kedinding\n"
        //         ."<b>Customer :</b> RSUD SIDOARJO\n\n"
        //         ."<b>Detail Mesin</b>"
        //         .$strmesin;
                
        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHANNEL_ID', '-1001235870534'),
            'parse_mode' => 'HTML',
            'text' => $text
        ]);
        
        return redirect()->back()->withSuccess("Telegram Message Broadcast Success");
    }
 
    public function sendPhoto()
    {
        return view('telegram.photo');
    }
 
    public function storePhoto(Request $request)
    {
        $request->validate([
            'file' => 'file|mimes:jpeg,png,gif'
        ]);
 
        $photo = $request->file('file');
 
        Telegram::sendPhoto([
            'chat_id' => env('TELEGRAM_CHANNEL_ID', '-1001235870534'),
            'photo' => InputFile::createFromContents(file_get_contents($photo->getRealPath()), str_random(10) . '.' . $photo->getClientOriginalExtension())
        ]);
 
        return redirect()->back()->withSuccess("Telegram Image Broadcast Success");
    }

    public function sendDocument()
    {
        return view('telegram.document');
    }
 
    public function storeDocument(Request $request)
    {
        $request->validate([
            'file' => 'file|mimes:xls,xlsx,doc,docx,ppt,pptx,odt,pdf',
            'caption' => 'required'
        ]);
 
        $doc = $request->file('file');
        $caption = $request->caption;

        Telegram::sendDocument([
            'chat_id' => env('TELEGRAM_CHANNEL_ID', '-1001235870534'),
            'document' => InputFile::createFromContents(file_get_contents($doc->getRealPath()), str_random(10) . '.' . $doc->getClientOriginalExtension()),
            'caption' => $caption,
        ]);
 
        return redirect()->back()->withSuccess("Telegram Document Broadcast Success");
    }
}