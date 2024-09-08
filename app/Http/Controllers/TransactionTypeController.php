<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\TransactionType;
use Illuminate\Http\Request;

class TransactionTypeController extends Controller
{
    public function index()
    {
        $typesList = TransactionType::all();

        return response()->json($typesList);
    }

    public function report() 
    {
        $types = TransactionType::all();

        // Массив для хранения итогового баланса
        $balance = [];

        // Обрабатываем каждый тип счета
        foreach ($types as $type) {
            // Получаем транзакции для текущего типа счета
            $transactions = Transactions::where('type_id', $type->id)->get();

            // Группируем транзакции по операциям и подсчитываем суммы
            $income = $transactions->where('operation', 'income')->sum('total');
            $payment = $transactions->where('operation', 'payment')->sum('total');

            // Добавляем информацию в массив баланса
            $balance[] = [
                'account' => $type->title,
                'income' => $income,
                'payment' => $payment,
                'net_balance' => $income - $payment,
            ];
        }

        // Возвращаем данные в формате JSON
        return response()->json($balance);
    }
}
