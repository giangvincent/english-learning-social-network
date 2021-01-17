<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class BotController extends Controller
{
    /**
     * The verification token for Facebook
     *
     * @var string
     */
    protected $token;

    public function __construct()
    {
        $this->token = 'thatsgood_token';
    }

    /**
     * Verify the token from Messenger. This helps verify your bot.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function verify_token(Request $request)
    {
        $mode = $request->get('hub_mode');
        $token = $request->get('hub_verify_token');

        if ($mode === "subscribe" && $this->token and $token === $this->token) {
            return response($request->get('hub_challenge'));
        }

        return response("Invalid token!", 400);
    }

    /**
     * Handle the query sent to the bot.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function handle_query(Request $request)
    {
        $entry = $request->get('entry');

        $sender = Arr::get($entry, '0.messaging.0.sender.id');
        $message = mb_strtolower(Arr::get($entry, '0.messaging.0.message.text'), 'UTF-8');
        Log::info('start handle entry : ' . json_encode($entry));
        if ($message == 'register' || $message == 'đăng ký') {
            $this->dispatchResponse($sender, 'Cảm ơn bạn đã đăng ký. Tin nhắn để nhắc nhở bạn học hàng ngày sẽ được gửi đi đều đặn. Nhớ truy cập https://thatsgood.info nhé!');
        } else {
            $this->dispatchResponse($sender, 'Sai cú pháp! Xin vui lòng gõ "đăng ký" hoặc "register". Xin cảm ơn.');
        }

        return response('', 200);
    }

    /**
     * Post a message to the Facebook messenger API.
     *
     * @param  integer $id
     * @param  string  $response
     * @return bool
     */
    protected function dispatchResponse($id, $response)
    {
        $access_token = 'EAAL60j78yO8BAL6mgH6TfI6SJLs6mZBsOAKqQgy77YhM4L7yvymgKeZBxuVvikvGbCopom7jnns30e5HHdgCF2Fsm1lgu31MdQU6stLGQ1cSe5nr048nwohTw4P2TQJxPJVoSrQ2FpgSo7FdwS3GAkKUuuFNZCmw9ilsnwQyljc1hH7dIhAIyd6KKqWWkoZD';
        $url = "https://graph.facebook.com/v9.0/me/messages?access_token={$access_token}";

        $data = json_encode([
            "messaging_type" => 'UPDATE',
            'recipient' => ['id' => $id],
            'message' => ['text' => $response],
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
