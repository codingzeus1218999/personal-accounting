<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use App\Mail\TransactionCreatedMail;
use App\Events\TransactionCreated;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    // Retrieve transactions with filters
    public function index(Request $request)
    {
        try {
            $query = Transaction::query();

            // Apply filters dynamically
            $filters = [
                'title' => fn($value) => $query->where('title', 'LIKE', "%$value%"),
                'type' => fn($value) => $query->where('amount', $value === 'income' ? '>' : '<', 0),
                'amount_min' => fn($value) => $query->where('amount', '>=', $value),
                'amount_max' => fn($value) => $query->where('amount', '<=', $value),
                'start_date' => fn($value) => $query->where('created_at', '>=', $value),
                'end_date' => fn($value) => $query->where('created_at', '<=', $value),
            ];

            foreach ($filters as $filter => $callback) {
                if ($request->has($filter)) {
                    $callback($request->input($filter));
                }
            }

            // Retrieve results
            $transactions = $query->get();

            return $this->successResponse($transactions, 'Transactions retrieved successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse('An unexpected error occurred while retrieving transactions.', $e);
        }
    }

    // Store a new transaction
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'amount' => 'required|integer',
            ]);

            $transaction = Transaction::create([
                'title' => $validated['title'],
                'amount' => $validated['amount'],
                'author_id' => auth()->id(),
            ]);

            Log::info('Transaction created', [
                'transaction_id' => $transaction->id,
                'user_id' => auth()->id(),
                'title' => $transaction->title,
                'amount' => $transaction->amount,
            ]);

            try {
                Mail::to(auth()->user()->email)->send(new TransactionCreatedMail($transaction));
            } catch (\Exception $e) {
                \Log::error('Mail Sending Error: ' . $e->getMessage());
                return response()->json([
                    'status' => false,
                    'data' => null,
                    'message' => 'Failed to send the email: ' . $e->getMessage(),
                ], 500);
            }

            event(new TransactionCreated($transaction));

            return $this->successResponse($transaction, 'Transaction added successfully.', 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('An unexpected error occurred while creating the transaction.', $e);
        }
    }

    // Show a single transaction
    public function show(Transaction $transaction)
    {
        return $this->successResponse($transaction, 'Transaction retrieved successfully.');
    }

    // Delete a transaction
    public function destroy(Transaction $transaction)
    {
        try {
            $transaction->delete();

            return $this->successResponse(null, 'Transaction deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->errorResponse('A database error occurred during deletion.', $e);
        } catch (\Exception $e) {
            return $this->errorResponse('An unexpected error occurred while deleting the transaction.', $e);
        }
    }

    // Helper method for success responses
    private function successResponse($data, $message, $status = 200)
    {
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    // Helper method for validation error responses
    private function validationErrorResponse($exception)
    {
        return response()->json([
            'status' => false,
            'data' => null,
            'message' => 'Validation failed.',
            'errors' => $exception->errors(),
        ], 422);
    }

    // Helper method for error responses
    private function errorResponse($message, $exception, $status = 500)
    {
        Log::error("$message: " . $exception->getMessage());

        return response()->json([
            'status' => false,
            'data' => null,
            'message' => $message,
        ], $status);
    }
}
