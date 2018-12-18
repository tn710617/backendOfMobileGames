<?php

namespace App\Http\Controllers;

use App\Payment;
use App\PaymentDetail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller {

    public function paymentShow(Request $request)
    {

        return view('payment');
    }


    public function paymentResponse(Request $request)
    {
        $MerchantTradeNo = $_POST['MerchantTradeNo'];
        $PayAmt = $_POST['PayAmt'];
        $PaymentDate = $_POST['PaymentDate'];
        $PaymentType = $_POST['PaymentType'];
        $RtnCode = $_POST['RtnCode'];
        $CheckMacValue = $_POST['CheckMacValue'];
        $Payer= Payment::where('MerchantTradeNo', $MerchantTradeNo)->first();
        $Status = $Payer->Status;
        $UserId = $Payer->user_id;
        $RemainingPoints = User::getTotalRemainingPoints($UserId);

        if (($RtnCode == 1) && ($Status !== 1))
        {
            Payment::where('MerchantTradeNo', $MerchantTradeNo)->update(['PaymentDate' => $PaymentDate, 'Status' => 1]);
            User::where('id', $UserId)->update(['RemainingPoints' => $RemainingPoints + $PayAmt]);
            PaymentDetail::forceCreate([
                'user_id' => $UserId,
                'add' => $PayAmt,
                'remainingPoints' => User::getTotalRemainingPoints($UserId),
            ]);
        }

        $myfile = fopen("/Users/ray/code/test/$MerchantTradeNo", "a") or die("Unable to open file!");

        $txt = print_r($_POST, true);
        fwrite($myfile, $txt);
        fclose($myfile);

    }

    public function showOrders(Request $request)
    {
        $orders = Payment::where('user_id', auth()->id())->get();

        return view('order', compact('orders'));
    }

    public function paymentConnect(Request $request)

    {
        $this->validate(request(), [
            'unitPrice' => 'required|numeric|max:10000',
        ]);
        $merchantTradeNo = 'Test' . time();
        $merchantTradeDate = date('Y/m/d H:i:s');
//        $tradeDescription = $request->tradeDescription;
        $tradeDescription = 'Energy Points';
//        $itemName = $request->itemName;
        $itemName = 'Energy Points';
        $unitPrice = $request->unitPrice;
//        $quantity = $request->quantity;
        $quantity = 1;
        $amount = $unitPrice * $quantity;


        Payment::forceCreate([
            'user_id'           => auth()->id(),
            'MerchantTradeNo'   => $merchantTradeNo,
            'MerchantTradeDate' => $merchantTradeDate,
            'TradeDescription'  => $tradeDescription,
            'ItemName'          => $itemName,
            'UnitPrice'         => $unitPrice,
            'Quantity'          => $quantity,
            'Amount'            => $amount,
        ]);

        //載入SDK(路徑可依系統規劃自行調整)
        include('AllPay.Payment.Integration.php');
        try
        {

            $obj = new \AllInOne();

            //服務參數
            $obj->ServiceURL = "https://payment-stage.opay.tw/Cashier/AioCheckOut/V5";         //服務位置
            $obj->HashKey = '5294y06JbISpM5x9';                                            //測試用Hashkey，請自行帶入AllPay提供的HashKey
            $obj->HashIV = 'v77hoKGq4kWxNNIS';                                            //測試用HashIV，請自行帶入AllPay提供的HashIV
            $obj->MerchantID = '2000132';                                                      //測試用MerchantID，請自行帶入AllPay提供的MerchantID
            $obj->EncryptType = \EncryptType::ENC_SHA256;                                        //CheckMacValue加密類型，請固定填入1，使用SHA256加密


            //基本參數(請依系統規劃自行調整)
            $obj->Send['ReturnURL'] = 'http://1a77a175.ngrok.io/api/paymentResponse';    //付款完成通知回傳的網址
            $obj->Send['ClientBackURL'] = 'http://1a77a175.ngrok.io/';    //付款完成通知回傳的網址
            $obj->Send['MerchantTradeNo'] = $merchantTradeNo;
            $obj->Send['MerchantTradeDate'] = $merchantTradeDate;                              //交易時間
            $obj->Send['TotalAmount'] = $amount;                                             //交易金額
            $obj->Send['TradeDesc'] = $tradeDescription;                                 //交易描述
            $obj->Send['ChoosePayment'] = \PaymentMethod::Credit;                           //付款方式:Credit

            //訂單的商品資料
            array_push($obj->Send['Items'], array('Name'     => $itemName, 'Price' => (int) $unitPrice,
                                                  'Currency' => "元", 'Quantity' => (int) $quantity, 'URL' => "dedwed"));


            //Credit信用卡分期付款延伸參數(可依系統需求選擇是否代入)
            //以下參數不可以跟信用卡定期定額參數一起設定
            $obj->SendExtend['CreditInstallment'] = '';    //分期期數，預設0(不分期)，信用卡分期可用參數為:3,6,12,18,24
            $obj->SendExtend['Redeem'] = false;           //是否使用紅利折抵，預設false
            $obj->SendExtend['UnionPay'] = false;          //是否為聯營卡，預設false;

            //Credit信用卡定期定額付款延伸參數(可依系統需求選擇是否代入)
            //以下參數不可以跟信用卡分期付款參數一起設定
            // $obj->SendExtend['PeriodAmount'] = '' ;    //每次授權金額，預設空字串
            // $obj->SendExtend['PeriodType']   = '' ;    //週期種類，預設空字串
            // $obj->SendExtend['Frequency']    = '' ;    //執行頻率，預設空字串
            // $obj->SendExtend['ExecTimes']    = '' ;    //執行次數，預設空字串

            # 電子發票參數
            /*
            $obj->Send['InvoiceMark'] = InvoiceState::Yes;
            $obj->SendExtend['RelateNumber'] = $MerchantTradeNo;
            $obj->SendExtend['CustomerEmail'] = 'test@opay.tw';
            $obj->SendExtend['CustomerPhone'] = '0911222333';
            $obj->SendExtend['TaxType'] = TaxType::Dutiable;
            $obj->SendExtend['CustomerAddr'] = '台北市南港區三重路19-2號5樓D棟';
            $obj->SendExtend['InvoiceItems'] = array();
            // 將商品加入電子發票商品列表陣列
            foreach ($obj->Send['Items'] as $info)
            {
                array_push($obj->SendExtend['InvoiceItems'],array('Name' => $info['Name'],'Count' =>
                    $info['Quantity'],'Word' => '個','Price' => $info['Price'],'TaxType' => TaxType::Dutiable));
            }
            $obj->SendExtend['InvoiceRemark'] = '測試發票備註';
            $obj->SendExtend['DelayDay'] = '0';
            $obj->SendExtend['InvType'] = InvType::General;
            */


            //產生訂單(auto submit至AllPay)
            $obj->CheckOut();


        } catch (\Exception $e)
        {
            echo $e->getMessage();
        }

    }

}
