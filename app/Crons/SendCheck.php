<?php

namespace App\Crons;

use App\Models\BotUser;
use App\Models\Order;
use App\Models\OrderProducts;
use App\Utils\Api;

require_once(__DIR__ . '/../../bootstrap.php');

class SendCheck
{
    public function __construct()
    {
        $bot = new Api(env('TELEGRAM_BOT_TOKEN'));

        $waitingOrders = Order::where('status', 'WAITING_FOR_CHECK_TO_BE_SEND')->get();
        foreach ($waitingOrders as $order) {
            $user = BotUser::find($order->user_id);
            $orderProducts = OrderProducts::where('order_id', $order->id)->get();

            $labeledPrices = [];
            foreach ($orderProducts as $key => $orderProduct) {
                $labeledPrices[] = [
                    'label' => $orderProduct->name,
                    'amount' => $orderProduct->price+1000,
                ];
            }

            $bot->sendInvoice($user->chat_id, 'Ваше замовлення #'.$order->id, ' ', '632593626:TEST:sandbox_i87641777711', '632593626:TEST:sandbox_i87641777711', 'sandbox_i87641777711', 'UAH', $labeledPrices);
            Order::where('id', $order->id)->update([
                'status' => 'INVOICE_SENT'
            ]);
        }
    }
}

(new SendCheck());