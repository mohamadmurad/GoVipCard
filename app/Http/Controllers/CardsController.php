<?php

namespace App\Http\Controllers;

use App\Http\Requests\addCard;
use App\Http\Requests\deposit;
use App\Http\Requests\info;
use App\Http\Requests\withdraw;
use App\Models\cards;
use App\Models\Withdrawal;
use Carbon\Carbon;
use http\Env\Response;
use http\Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CardsController extends Controller
{

    public function create(){
        return view('card.create');
    }

    public function addCard(addCard $request){

        $firstBarcode = $request->get('firstBarcode');
        $lastBarcode = $request->get('lastBarcode');
        $balance = $request->get('balance');
        DB::beginTransaction();
        try {

            for ($i = $firstBarcode;$i<=$lastBarcode;$i++){
                $card = cards::create([
                    'barcode' => $i,
                    'balance' =>$balance,
                ]);
            }
            DB::commit();

            return redirect('/');


        }catch (QueryException $e){

            DB::rollBack();

            return redirect('/create')->with('error','Duplicate entry ');
        }




    }


    public function info(info $request){

        $barcode = $request->get('barcode');

        $card = cards::where('barcode','=',$barcode)->with(['withdraw','deposits'])->first();

        //dd($card);
        return view('card.info',compact('card'));

    }


    public function withdraw(withdraw $request){

        $barcode = $request->get('barcode');
        $amount = $request->get('amount');
        $orderNo = $request->get('orderNo');




        DB::beginTransaction();
        try {

            $withdraw = Withdrawal::create([
                'barcode' => $barcode,
                'amount' => $amount,
                'orderNo' =>$orderNo,
                'date' => Carbon::now(),
                'user_id' => Auth::id(),
            ]);

            $card = cards::where('barcode','=',$barcode)->with('withdraw')->first();
            $card->balance = $card->balance - $amount;
            $card->update();
            DB::commit();


            return redirect('/info?barcode='.$card->barcode);

        }catch (Exception $e){

            DB::rollBack();


            return redirect('/info?barcode='.$card->barcode);

        }





    }

    public function deposit(deposit $request){ // add money


        $barcode = $request->get('barcode');
        $OrderAmount = $request->get('amount');
        $orderNo = $request->get('orderNo');
        $amount = $OrderAmount * 5 / 100;
        DB::beginTransaction();
        try {

            $deposit = \App\Models\deposit::create([
                'barcode' => $barcode,
                'amount' => $amount,
                'orderNo' => $orderNo,
                'date' => Carbon::now(),
                'user_id' => Auth::id(),
            ]);

            $card = cards::where('barcode','=',$barcode)->with('deposits')->first();
            $card->balance = $card->balance + $amount;
            $card->update();

            DB::commit();

            return redirect('/info?barcode='.$card->barcode);
         /*   return response()->json([
                'data' => true,
            ]);*/


        }catch (Exception $e){

            DB::rollBack();


            return redirect('/info?barcode='.$card->barcode);

        }

    }

    public function deleteDeposit(Request $request){ // delete add money


        $id = $request['id'];

        $deposit = \App\Models\deposit::findOrFail($id);
        if ($deposit){
            DB::beginTransaction();
            try {

                $card = $deposit->card;

                $amount = $deposit->amount;
                $card->balance =  $card->balance - $amount;
                $card->update();
                $deposit->delete();
                DB::commit();

                return redirect('/info?barcode='.$card->barcode);

            }catch (Exception $e){

                DB::rollBack();

                return redirect('/info?barcode='.$card->barcode);
            }


        }
        return redirect()->back();

    }

    public function DeleteWithdraw(Request $request){ // delete remove money

        $id = $request['id'];

        $withdraw = \App\Models\Withdrawal::findOrFail($id);
        if ($withdraw){
            DB::beginTransaction();
            try {

                $card = $withdraw->card;

                $amount = $withdraw->amount;
                $card->balance =  $card->balance + $amount;
                $card->update();
                $withdraw->delete();

                DB::commit();

                return redirect('/info?barcode='.$card->barcode);

            }catch (Exception $e){

                DB::rollBack();

                return redirect('/info?barcode='.$card->barcode);
            }


        }
        return redirect()->back();

    }


    public function withdrawToDeposit(Request $request){ // delete to add

        $id = $request['id'];

        $withdraw = \App\Models\Withdrawal::findOrFail($id);
        if ($withdraw){
            DB::beginTransaction();
            try {

                $card = $withdraw->card;

                $amount = $withdraw->amount;
                $card->balance =  $card->balance + $amount;


                $card->update();



                $amount = $amount * 5 / 100;
                $deposit = \App\Models\deposit::create([
                    'barcode' => $withdraw->barcode,
                    'amount' => $amount,
                    'orderNo' => $withdraw->orderNo,
                    'date' => Carbon::now(),
                    'user_id' => Auth::id(),
                ]);

                $card->balance =  $card->balance + $amount;
                $card->update();

                $withdraw->delete();

                DB::commit();

                return redirect('/info?barcode='.$card->barcode);

            }catch (Exception $e){

                DB::rollBack();

                return redirect('/info?barcode='.$card->barcode);
            }


        }
        return redirect()->back();

    }

    public function addName(Request $request){

        $barcode = $request->get('barcode');
        $name = $request->get('name');

        $this->validate($request,[
            'barcode' => 'required|exists:cards,barcode',
            'name' => 'required|string'
        ]);

        $card = cards::where('barcode','=',$request['barcode'])->first();

        $card->fill([
            'name' => $request['name'],
        ])->save();
        return redirect('addName');

    }

    public function createName(Request $request){
        return view('card.createName');


    }

    public function cardReport(Request $request){

        $cards = cards::select('barcode','balance','name')->withSum('withdraw','amount')->withSum('deposits','amount')->get();


        $allWithdraw = Withdrawal::sum('amount');
        $allDeposits = \App\Models\deposit::sum('amount');


     //   dd($cards);

     /*   $card_withdraw = \App\Models\deposit::with('card')->groupBy('barcode')
            ->selectRaw('sum(amount) as sum, barcode')->orderBy('barcode')
            ->get();
        $card_deposit = Withdrawal::with('card')->groupBy('barcode')
            ->selectRaw('sum(amount) as sum, barcode')->orderBy('barcode')
            ->get();
*/

        return view('card.report',[
            'cards' => $cards,
            'allWithdraw' => $allWithdraw,
            'allDeposits' => $allDeposits,

        ]);


    }
}
