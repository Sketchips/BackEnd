<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Midtrans\Config;
use Midtrans\Snap;

class TransactionController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration from config file
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Generate order ID
        $orderId = 'ORDER-' . time() . '-' . uniqid();

        // Set transaction parameters
        $transactionParams = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $request->amount,
            ],
            'customer_details' => [
                'first_name' => $request->name,
                'email' => $request->email,
            ],
            'enabled_payments' => ['qris'],
            'callbacks' => [
                'finish' => url('/api/payment/finish'),
            ],
        ];

        try {
            // Get Snap Token
            $snapToken = Snap::getSnapToken($transactionParams);

            // Save transaction to database
            $transaction = Transaction::create([
                'order_id' => $orderId,
                'amount' => $request->amount,
                'name' => $request->name,
                'email' => $request->email,
                'status' => 'pending',
                'snap_token' => $snapToken,
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'transaction_id' => $transaction->id,
                    'order_id' => $orderId,
                    'token' => $snapToken,
                    'redirect_url' => 'https://app.' . (config('midtrans.is_production') ? '' : 'sandbox.') . 'midtrans.com/snap/v2/vtweb/' . $snapToken
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction Failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function notificationHandler(Request $request)
    {
        $notificationBody = json_decode($request->getContent(), true);

        // Get order ID from the notification
        $orderId = $notificationBody['order_id'];

        // Find the transaction by order ID
        $transaction = Transaction::where('order_id', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Update transaction status based on the notification
        $transactionStatus = $notificationBody['transaction_status'];
        $fraudStatus = isset($notificationBody['fraud_status']) ? $notificationBody['fraud_status'] : null;

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $transaction->status = 'challenge';
            } else if ($fraudStatus == 'accept') {
                $transaction->status = 'success';
            }
        } else if ($transactionStatus == 'settlement') {
            $transaction->status = 'success';
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $transaction->status = 'failed';
        } else if ($transactionStatus == 'pending') {
            $transaction->status = 'pending';
        }

        // Store additional transaction details
        $transaction->payment_type = $notificationBody['payment_type'] ?? null;
        $transaction->transaction_time = $notificationBody['transaction_time'] ?? null;
        $transaction->transaction_id = $notificationBody['transaction_id'] ?? null;
        $transaction->payment_status_message = json_encode($notificationBody);
        $transaction->save();

        return response()->json(['message' => 'Notification processed successfully']);
    }

    public function getTransactionStatus(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $transaction->id,
                'order_id' => $transaction->order_id,
                'amount' => $transaction->amount,
                'status' => $transaction->status,
                'payment_type' => $transaction->payment_type,
                'transaction_time' => $transaction->transaction_time,
            ]
        ]);
    }
}
