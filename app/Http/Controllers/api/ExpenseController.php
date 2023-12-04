<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Expense;
use App\Models\Meal;
use App\Models\Travel;
use App\Models\Hotel;
use App\Models\ExpenseDa;
use App\Models\OtherExpense;
use App\Models\ExpenseAmount;

class ExpenseController extends ApiController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function createExpense(Request $request){
        // $this->pp($request->all());
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'expense_start_date' => 'required',
            'expense_end_date' => 'required',
            'expense_description' => 'required',
            'expense_total_amount' => 'required'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors()]);
        }
        

        $expenses = json_decode($request->expenses);
        if(count($expenses) < 1){
            return $this->sendError("Minimum one expense type is required");
        }

        $data['user_id'] = $request->user_id;
        $data['start_date'] = $request->expense_start_date;
        $data['end_date'] = $request->expense_end_date;
        $data['description'] = $request->expense_description;
        $data['total_amount'] = $request->expense_total_amount;
        $data['status'] = 'pending';
        if(!empty($request->status)){
            if($request->status == 'draft'){
                $data['status'] = 'draft';
            } 
        }
        
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $expense_id = Expense::insertGetId($data);
        if($expense_id){

            foreach($expenses as $e){
                if($e->type == 'meal'){
                    $dm['expense_id'] = $expense_id;
                    $dm['ex_date'] = $e->ex_date;
                    $dm['breakfast'] = !empty($e->breakfast)? $e->breakfast : '';
                    $dm['lunch'] = !empty($e->lunch)? $e->lunch : '';
                    $dm['dinner'] = !empty($e->dinner)? $e->dinner : '';
                    $dm['breakfast_tag'] = !empty($e->breakfast_tag)? $e->breakfast_tag : '';
                    $dm['lunch_tag'] = !empty($e->lunch_tag)? $e->lunch_tag : '';
                    $dm['dinner_tag'] = !empty($e->dinner_tag)? $e->dinner_tag : '';
                    $dm['created_at'] = date('Y-m-d H:i:s');
                    $dm['updated_at'] = date('Y-m-d H:i:s');

                    $mi = Meal::insertGetId($dm);
                }else if($e->type == 'travel'){
                    $dt['expense_id'] = $expense_id;
                    $dt['travel_type'] = $e->travel_type;
                    $dt['vehicle'] = $e->vehicle;
                    $dt['start_location'] = !empty($e->start_location) ? $e->start_location : '';
                    $dt['end_location'] = !empty($e->end_location) ? $e->end_location : '';
                    $dt['actual_distance'] = !empty($e->actual_distance) ? $e->actual_distance : '';
                    $dt['calculated_distance'] = !empty($e->calculated_distance) ? $e->calculated_distance : '';
                    $dt['created_at'] = date('Y-m-d H:i:s');
                    $dt['updated_at'] = date('Y-m-d H:i:s');
                    $ti = Travel::insertGetId($dt);
                    if($ti){
                        $amnt = $e->amount;
                        foreach($amnt as $a){
                            $da['ei_id'] = $ti;
                            $da['amount'] = $a->amount;
                            $da['ei_type'] = 'amount';
                            $da['ei_info'] = 'travel';
                            $da['created_at'] = date('Y-m-d H:i:s');
                            $da['updated_at'] = date('Y-m-d H:i:s');
                            ExpenseAmount::insertGetId($da);
                        }

                        $parking = $e->parking;
                        foreach($parking as $p){
                            $dp['ei_id'] = $ti;
                            $dp['amount'] = $p->amount;
                            $dp['ei_type'] = 'parking';
                            $dp['ei_info'] = 'travel';
                            $dp['created_at'] = date('Y-m-d H:i:s');
                            $dp['updated_at'] = date('Y-m-d H:i:s');
                            ExpenseAmount::insertGetId($dp);
                        }

                        $toll = $e->toll;
                        foreach($toll as $t){
                            $dtt['ei_id'] = $ti;
                            $dtt['amount'] = $t->amount;
                            $dtt['ei_type'] = 'toll';
                            $dtt['ei_info'] = 'travel';
                            $dtt['created_at'] = date('Y-m-d H:i:s');
                            $dtt['updated_at'] = date('Y-m-d H:i:s');
                            ExpenseAmount::insertGetId($dtt);
                        }
                    } 
                }
                
                else if($e->type == 'hotel'){
                    $dh['expense_id'] = $expense_id;
                    $dh['city'] = $e->city;
                    $dh['check_in_date'] = $e->check_in_date;
                    $dh['check_out_date'] = $e->check_out_date;
                    $dh['days_count'] = $e->days_count;
                    $dh['created_at'] = date('Y-m-d H:i:s');
                    $dh['updated_at'] = date('Y-m-d H:i:s');

                    $hi = Hotel::insertGetId($dh);
                    $amnt = $e->amount;
                    foreach($amnt as $a){
                        $dha['ei_id'] = $hi;
                        $dha['amount'] = $a->amount;
                        $dha['ei_type'] = 'amount';
                        $dha['ei_info'] = 'hotel';
                        $dha['created_at'] = date('Y-m-d H:i:s');
                        $dha['updated_at'] = date('Y-m-d H:i:s');
                        ExpenseAmount::insertGetId($dha);
                    }
                }else if($e->type == 'da'){
                    $dea['expense_id'] = $expense_id;
                    $dea['ex_date'] = $e->date;
                    $dea['city'] = $e->city;
                    $dea['amount'] = $e->amount;
                    $dea['created_at'] = date('Y-m-d H:i:s');
                    $dea['updated_at'] = date('Y-m-d H:i:s');
                    ExpenseDa::insertGetId($dea);
                }else{
                    $doa['expense_id'] = $expense_id;
                    $doa['title'] = $e->title;
                    $doa['remark'] = $e->remark;
                    $doa['created_at'] = date('Y-m-d H:i:s');
                    $doa['updated_at'] = date('Y-m-d H:i:s');
                    $doi = OtherExpense::insertGetId($doa);

                    $amnt = $e->amount;
                    foreach($amnt as $a){
                        $dota['ei_id'] = $doi;
                        $dota['amount'] = $a->amount;
                        $dota['ei_type'] = 'amount';
                        $dota['ei_info'] = 'other';
                        $dota['created_at'] = date('Y-m-d H:i:s');
                        $dota['updated_at'] = date('Y-m-d H:i:s');
                        ExpenseAmount::insertGetId($dota);
                    }
                }
            }
            return $this->sendResponse($data, 'Expense Created Succssfully.');
        }else{
            return $this->sendError();
        }

    }


    public function getPendingExpenses(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if($validator->fails()){
            return response(['error' => $validator->errors()]);
        }

        $data = Expense::where('user_id',$request->user_id)->where('status','pending')->get();
        $result = array();
        if(!empty($data)){
            foreach($data as $d){
                $type = "";
                $m = Meal::where('expense_id',$d->id)->count();
                if($m > 0){
                    $type .= "Meal";
                }

                $t = Travel::where('expense_id',$d->id)->count();
                if($t > 0){
                    if($type == ''){
                        $type .= "Travel";
                    }else{
                        $type .= ", Travel";
                    }                    
                }

                $h = Hotel::where('expense_id',$d->id)->count();
                if($h > 0){
                    if($type == ''){
                        $type .= "Hotel";
                    }else{
                        $type .= ", Hotel";
                    }                    
                }

                $ed = ExpenseDa::where('expense_id',$d->id)->count();
                if($ed > 0){
                    if($type == ''){
                        $type .= "DA";
                    }else{
                        $type .= ", DA";
                    }                    
                }

                $oe = OtherExpense::where('expense_id',$d->id)->count();
                if($oe > 0){
                    if($type == ''){
                        $type .= "Other";
                    }else{
                        $type .= ", Other";
                    }                    
                }
                

                $d['expense_type'] = $type;
                array_push($result,$d);
            }
        }
        return $this->sendResponse($result, 'Expense Pending List.');
    }

    public function getDraftExpenses(Request $request){
        $a = array(
            array(
                'type' => 'meal',
                'ex_date' => '2023-11-25',
                'breakfast' => '',
                'lunch' => '500',
                'dinner' => '400',
                'invoice_file' => 'file',
                'breakfast_tag' => '',
                'lunch_tag' => '',
                'dinner_tag' => ''
            ),
            array(
                'type' => 'meal',
                'ex_date' => '2023-11-25',
                'breakfast' => '',
                'lunch' => '500',
                'dinner' => '400',
                'invoice_file' => 'file',
                'breakfast_tag' => '',
                'lunch_tag' => '',
                'dinner_tag' => ''
            ),
            array(
                'type' => 'travel',
                'travel_type' => 'domestic',
                'vehicle' => '4 Wheeler',
                'start_location' => 'Pune',
                'end_location' => 'Pune',
                'actual_distance' => '60',
                'calculated_distance' => '50',
                'amount' => array(
                                array(
                                    'amount' => '500',
                                    'invoice_file' => 'file'
                                ),
                                array(
                                    'amount' => '500',
                                    'invoice_file' => 'file'
                                )
                            ),
                'parking' => array(
                                array(
                                    'amount' => '500',
                                    'invoice_file' => 'file'
                                ),
                                array(
                                    'amount' => '500',
                                    'invoice_file' => 'file'
                                )
                            ),
                'toll' => array(
                                array(
                                    'amount' => '500',
                                    'invoice_file' => 'file'
                                ),
                                array(
                                    'amount' => '500',
                                    'invoice_file' => 'file'
                                )
                            )							
            ),
            array(
                array(
                    'type' => 'hotel',
                    'city' => 'Patna',
                    'check_in_date' => '2023-11-25',
                    'check_out_date' => '23-11-26',
                    'days_count' => '2',
                    'amount' => array(
                                    array(
                                        'amount' => '500',
                                        'invoice_file' => 'file'
                                    ),
                                    array(
                                        'amount' => '500',
                                        'invoice_file' => 'file'
                                    )
                                )
                                        
                )
            ),
            array(
                'type' => 'da',
                'date' => '2023-11-25',
                'city' => 'Patna',
                'amount' => '60'							
            ),
            array(
                'type' => 'other',
                'title' => 'some title',
                'remark' => 'some remark in detail',
                'amount' => array(
                                array(
                                    'amount' => '500',
                                    'invoice_file' => 'file'
                                ),
                                array(
                                    'amount' => '500',
                                    'invoice_file' => 'file'
                                )
                            )							
            )	
                                );
        print_r(json_encode($a));
        exit;
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if($validator->fails()){
            return response(['error' => $validator->errors()]);
        }

        $data = Expense::where('user_id',$request->user_id)->where('status','draft')->get();
        $result = array();
        if(!empty($data)){
            foreach($data as $d){
                $type = "";
                $m = Meal::where('expense_id',$d->id)->count();
                if($m > 0){
                    $type .= "Meal";
                }

                $t = Travel::where('expense_id',$d->id)->count();
                if($t > 0){
                    if($type == ''){
                        $type .= "Travel";
                    }else{
                        $type .= ", Travel";
                    }                    
                }

                $h = Hotel::where('expense_id',$d->id)->count();
                if($h > 0){
                    if($type == ''){
                        $type .= "Hotel";
                    }else{
                        $type .= ", Hotel";
                    }                    
                }

                $ed = ExpenseDa::where('expense_id',$d->id)->count();
                if($ed > 0){
                    if($type == ''){
                        $type .= "DA";
                    }else{
                        $type .= ", DA";
                    }                    
                }

                $oe = OtherExpense::where('expense_id',$d->id)->count();
                if($oe > 0){
                    if($type == ''){
                        $type .= "Other";
                    }else{
                        $type .= ", Other";
                    }                    
                }
                

                $d['expense_type'] = $type;
                array_push($result,$d);
            }
        }
        return $this->sendResponse($result, 'Expense Draft List.');
    }

    public function getApprovedExpenses(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if($validator->fails()){
            return response(['error' => $validator->errors()]);
        }

        $data = Expense::where('user_id',$request->user_id)->where('status','approved')->get();
        $result = array();
        if(!empty($data)){
            foreach($data as $d){
                $type = "";
                $m = Meal::where('expense_id',$d->id)->count();
                if($m > 0){
                    $type .= "Meal";
                }

                $t = Travel::where('expense_id',$d->id)->count();
                if($t > 0){
                    if($type == ''){
                        $type .= "Travel";
                    }else{
                        $type .= ", Travel";
                    }                    
                }

                $h = Hotel::where('expense_id',$d->id)->count();
                if($h > 0){
                    if($type == ''){
                        $type .= "Hotel";
                    }else{
                        $type .= ", Hotel";
                    }                    
                }

                $ed = ExpenseDa::where('expense_id',$d->id)->count();
                if($ed > 0){
                    if($type == ''){
                        $type .= "DA";
                    }else{
                        $type .= ", DA";
                    }                    
                }

                $oe = OtherExpense::where('expense_id',$d->id)->count();
                if($oe > 0){
                    if($type == ''){
                        $type .= "Other";
                    }else{
                        $type .= ", Other";
                    }                    
                }
                

                $d['expense_type'] = $type;
                array_push($result,$d);
            }
        }
        return $this->sendResponse($result, 'Expense Approved List.');
    }

    public function getRejectedExpenses(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if($validator->fails()){
            return response(['error' => $validator->errors()]);
        }

        $data = Expense::where('user_id',$request->user_id)->where('status','rejected')->get();
        $result = array();
        if(!empty($data)){
            foreach($data as $d){
                $type = "";
                $m = Meal::where('expense_id',$d->id)->count();
                if($m > 0){
                    $type .= "Meal";
                }

                $t = Travel::where('expense_id',$d->id)->count();
                if($t > 0){
                    if($type == ''){
                        $type .= "Travel";
                    }else{
                        $type .= ", Travel";
                    }                    
                }

                $h = Hotel::where('expense_id',$d->id)->count();
                if($h > 0){
                    if($type == ''){
                        $type .= "Hotel";
                    }else{
                        $type .= ", Hotel";
                    }                    
                }

                $ed = ExpenseDa::where('expense_id',$d->id)->count();
                if($ed > 0){
                    if($type == ''){
                        $type .= "DA";
                    }else{
                        $type .= ", DA";
                    }                    
                }

                $oe = OtherExpense::where('expense_id',$d->id)->count();
                if($oe > 0){
                    if($type == ''){
                        $type .= "Other";
                    }else{
                        $type .= ", Other";
                    }                    
                }
                

                $d['expense_type'] = $type;
                array_push($result,$d);
            }
        }
        return $this->sendResponse($result, 'Expense Rejected List.');
    }


    public function getExpenseDetails(Request $request){
        $validator = Validator::make($request->all(), [
            'expense_id' => 'required'
        ]);
        if($validator->fails()){
            return response(['error' => $validator->errors()]);
        }

        $data = Expense::with(['meals','travels.invoices','hotels.invoices','das','others.invoices'])->where('id',$request->expense_id)->get();
        return $this->sendResponse($data, 'Expense Details.');
    }


    public function approveExpense(Request $request){
        $validator = Validator::make($request->all(), [
            'expense_id' => 'required',
            'approved_amount' => 'required'
        ]);
        if($validator->fails()){
            return response(['error' => $validator->errors()]);
        }

        $data['approved_amount'] = $request->approved_amount;
        $data['approved_date'] = date('Y-m-d');
        $data['status'] = 'approved';
        $data['updated_at'] = date('Y-m-d H:i:s');

        $status = Expense::where('id',$request->expense_id)->value('status');
        if($status == 'pending'){
            $id = Expense::where('id',$request->expense_id)->update($data);

            if($id){
                return $this->sendResponse($data, 'Expense Approved.');
            }else{
                return $this->sendError();
            }
        }else{
            return $this->sendError("Expense is already " .$status);
        }

        
    }

    public function rejectExpense(Request $request){
        $validator = Validator::make($request->all(), [
            'expense_id' => 'required',
            'rejected_by' => 'required',
            'rejected_reason' => 'required'
        ]);
        if($validator->fails()){
            return response(['error' => $validator->errors()]);
        }

        
        $data['rejected_date'] = date('Y-m-d');
        $data['rejected_by'] = $request->rejected_by;
        $data['rejected_reason'] = $request->rejected_reason;
        $data['status'] = 'rejected';
        $data['updated_at'] = date('Y-m-d H:i:s');

        $status = Expense::where('id',$request->expense_id)->value('status');
        
        if($status == 'pending'){
            $id = Expense::where('id',$request->expense_id)->update($data);

            if($id){
                return $this->sendResponse($data, 'Expense Rejected.');
            }else{
                return $this->sendError();
            }
        }else{
            return $this->sendError("Expense is already " .$status);
        }
    }
}
