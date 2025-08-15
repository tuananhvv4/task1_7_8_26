<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Casts\Json;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $archived =  $request->get('archived', 0);
        $bills = Bill::where('is_archive', $archived)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();

        return view('billList', [
            'archived' => $archived,
            'bills' => $bills
        ]);
    }


    /**
     * Return a listing of the resource.
     * JSON DATA 
     * POST
     */
    public function filter(Request $request)
    {
        $query = Bill::query();


        if ($request->ids) {
            $query->whereIn('id', (array) $request->ids);
        } else {
            if ($request->filled('account_number')) {
                $query->where('account_number', 'LIKE', '%' . $request->account_number . '%');
            }

            if ($request->filled('bill_id')) {
                $query->where('bill_id', 'LIKE', '%' . $request->bill_id . '%');
            }

            if ($request->filled('service')) {
                $query->where('service', 'LIKE', '%' . $request->service . '%');
            }

            if ($request->filled('category')) {
                $query->where('category', 'LIKE', '%' . $request->category . '%');
            }
        }

        $bills = $query->get();

        return response()->json([
            'data' => $bills
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('billAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'account_number' => 'required',
                'bill_id' => 'required|unique:bills,bill_id',
                'amount' => 'required|numeric|min:0',
                'service' => 'required',
                'category' => 'required',
                'status' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    'message' => $validator->errors()->first()
                ]);
            }
            // Create a new bill
            $newBill = new Bill;
            $newBill->bill_id = $request->bill_id;
            $newBill->amount = $request->amount;
            $newBill->service = $request->service;
            $newBill->account_number = $request->account_number;
            $newBill->category = $request->category;
            $newBill->comment = $request->comment;
            $newBill->ordered_at = Carbon::now();
            $newBill->status = $request->status;

            $newBill->save();

            return response()->json([
                "success" => true,
                'message' => 'add new bill success!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bill = Bill::find($id);

        return view('billDetail', [
            'bill' => $bill
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bill = Bill::find($id);

        if (!$bill) {
            return redirect()->route('bill.index');
        }

        return view('editBill', [
            'bill' => $bill
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        try {

            // sleep(1);
            // Validate the request
            $validator = Validator::make($request->all(), [
                'amount' => 'numeric|min:0|max:999999',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    'message' => $validator->errors()->first()
                ]);
            }

            $bill = Bill::where('id', $id)->first();

            if (!$bill) {
                return response()->json([
                    "success" => false,
                    'message' => 'Bill not found!'
                ]);
            }

            if ($request->bill_id) {
                $bill->bill_id = $request->bill_id;
            }
            if ($request->amount) {
                $bill->amount = $request->amount;
            }
            if ($request->account_number) {
                $bill->account_number = $request->account_number;
            }
            if ($request->service) {
                $bill->service = $request->service;
            }
            if ($request->category) {
                $bill->category = $request->category;
            }
            if ($request->status) {
                $bill->status = $request->status;
            }
            if ($request->comment) {
                $bill->comment = $request->comment;
            }
            if ($request->ordered_at) {
                $bill->ordered_at = $request->ordered_at;
            }

            $bill->save();

            return response()->json([
                "success" => true,
                'message' => 'Edit bill success!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function massUpdate(Request $request)
    {
        try {

            if ($request->ids) {
                $ids = $request->ids;

                foreach ($ids as $id) {

                    $bill = Bill::where('id', $id)->first();
                    if (!$bill) {
                        return response()->json([
                            "success" => false,
                            'message' => 'Bill ' . $id .  'not found!'
                        ]);
                    }

                    if ($request->bill_id) {
                        $bill->bill_id = $request->bill_id;
                    }
                    if ($request->amount) {
                        $bill->amount = $request->amount;
                    }
                    if ($request->account_number) {
                        $bill->account_number = $request->account_number;
                    }
                    if ($request->service) {
                        $bill->service = $request->service;
                    }
                    if ($request->category) {
                        $bill->category = $request->category;
                    }
                    if ($request->status) {
                        $bill->status = $request->status;
                    }
                    if ($request->comment) {
                        $bill->comment = $request->comment;
                    }
                    if ($request->ordered_at) {
                        $bill->ordered_at = $request->ordered_at;
                    }

                    $bill->save();
                }
            }

            return response()->json([
                "success" => true,
                'message' => 'Mass update bill success!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Archive the specified resource.
     */

    public function checkBill(Request $request)
    {
        $new_bill_id = $request->bill_id;
        $exclude_id = $request->get('exclude_id', -1);



        if ($bill = Bill::where("bill_id", $new_bill_id)->first()) {
            if ($exclude_id != $bill['id']) {
                return response()->json([
                    'success' => false,
                    'message' => "Bill ID already exist!"
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }

    public function archive(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([
                "success" => false,
                'message' => 'No bills selected for archiving!'
            ]);
        }

        $bills = Bill::whereIn('id', $ids)->get();

        if ($bills->isEmpty()) {
            return response()->json([
                "success" => false,
                'message' => 'No bills found for the provided IDs!'
            ]);
        }

        foreach ($bills as $bill) {
            $bill->is_archive = !$bill->is_archive;
            $bill->save();
        }

        return response()->json([
            "success" => true,
            'message' => 'Bills archived successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bill = Bill::find($id);

        if (!$bill) {
            return response()->json([
                "success" => false,
                'message' => 'Bill not found!'
            ]);
        }

        $bill->delete();

        return response()->json([
            "success" => true,
            'message' => 'Bill deleted successfully!'
        ]);
    }
}
