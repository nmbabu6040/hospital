<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\Payment;
use App\Services\SslcommerzService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function initiatePackagePayment(Request $request, Package $package)
    {
        $request->validate([
            'payer_name' => ['required', 'string', 'max:255'],
            'payer_email' => ['required', 'email', 'max:255'],
            'payer_phone' => ['required', 'string', 'max:20'],
        ]);

        $payment = Payment::create([
            'transaction_id' => Payment::generateTransactionId(),
            'package_id' => $package->id,
            'patient_id' => auth('patient')->id(),
            'payer_name' => $request->payer_name,
            'payer_email' => $request->payer_email,
            'payer_phone' => $request->payer_phone,
            'amount' => $package->price,
            'status' => 'pending',
        ]);

        return $this->redirectToGateway($payment, 'Package: ' . $package->name);
    }

    public function initiateInvoicePayment(Invoice $invoice)
    {
        if ($invoice->payment_status === 'paid') {
            return back()->with('error', 'This invoice is already paid.');
        }

        $payment = Payment::create([
            'transaction_id' => Payment::generateTransactionId(),
            'invoice_id' => $invoice->id,
            'patient_id' => $invoice->patient_id,
            'payer_name' => $invoice->patient_name,
            'payer_email' => $invoice->email ?: 'noemail@example.com',
            'payer_phone' => $invoice->phone,
            'amount' => $invoice->total,
            'status' => 'pending',
        ]);

        return $this->redirectToGateway($payment, 'Invoice: ' . $invoice->invoice_no);
    }

    private function redirectToGateway(Payment $payment, string $productName)
    {
        $gatewayUrl = SslcommerzService::initiate([
            'total_amount' => $payment->amount,
            'tran_id' => $payment->transaction_id,
            'success_url' => route('payment.success'),
            'fail_url' => route('payment.fail'),
            'cancel_url' => route('payment.cancel'),
            'ipn_url' => route('payment.ipn'),
            'cus_name' => $payment->payer_name,
            'cus_email' => $payment->payer_email,
            'cus_phone' => $payment->payer_phone,
            'product_name' => $productName,
        ]);

        if (! $gatewayUrl) {
            $payment->update(['status' => 'failed']);

            return back()->with('error', 'পেমেন্ট গেটওয়ে চালু করা যায়নি। অনুগ্রহ করে কিছুক্ষণ পর আবার চেষ্টা করুন অথবা হটলাইনে যোগাযোগ করুন।');
        }

        return redirect()->away($gatewayUrl);
    }

    public function success(Request $request)
    {
        $payment = Payment::where('transaction_id', $request->tran_id)->first();

        if (! $payment) {
            return redirect()->route('home')->with('error', 'Payment record not found.');
        }

        // SSLCommerz সার্ভারের সাথে পেমেন্ট validate করা (নিরাপত্তার জন্য আবশ্যক)
        $isValid = SslcommerzService::validateTransaction($request->val_id);

        if (! $isValid) {
            $payment->update(['status' => 'failed', 'gateway_response' => $request->all()]);

            return redirect()->route('home')->with('error', 'পেমেন্ট যাচাই করা যায়নি। যদি টাকা কেটে থাকে, হটলাইনে যোগাযোগ করুন।');
        }

        $payment->update([
            'status' => 'success',
            'payment_method' => $request->card_issuer ?? $request->bank_tran_id,
            'card_type' => $request->card_type,
            'gateway_response' => $request->all(),
            'paid_at' => now(),
        ]);

        if ($payment->invoice_id) {
            $payment->invoice->update(['payment_status' => 'paid', 'payment_method' => 'Online Payment']);
        }

        return redirect()->route('payment.receipt', $payment)->with('success', 'পেমেন্ট সফল হয়েছে! ধন্যবাদ।');
    }

    public function fail(Request $request)
    {
        $payment = Payment::where('transaction_id', $request->tran_id)->first();
        $payment?->update(['status' => 'failed', 'gateway_response' => $request->all()]);

        return redirect()->route('home')->with('error', 'দুঃখিত, পেমেন্ট ব্যর্থ হয়েছে। আবার চেষ্টা করুন।');
    }

    public function cancel(Request $request)
    {
        $payment = Payment::where('transaction_id', $request->tran_id)->first();
        $payment?->update(['status' => 'cancelled', 'gateway_response' => $request->all()]);

        return redirect()->route('home')->with('error', 'পেমেন্ট বাতিল করা হয়েছে।');
    }

    public function ipn(Request $request)
    {
        $payment = Payment::where('transaction_id', $request->tran_id)->first();

        if ($payment && $request->status === 'VALID') {
            $isValid = SslcommerzService::validateTransaction($request->val_id);

            if ($isValid) {
                $payment->update([
                    'status' => 'success',
                    'gateway_response' => $request->all(),
                    'paid_at' => now(),
                ]);

                if ($payment->invoice_id) {
                    $payment->invoice->update(['payment_status' => 'paid']);
                }
            }
        }

        return response('IPN received', 200);
    }

    public function receipt(Payment $payment)
    {
        return view('front.payment.receipt', compact('payment'));
    }
}
