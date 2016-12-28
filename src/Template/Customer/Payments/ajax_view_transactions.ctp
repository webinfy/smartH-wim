<?php

if ($payments->count() > 0) {
    $html = "";
    foreach ($payments as $payment) {
        $dueDate = date('M, d, Y', strtotime($payment->uploaded_payment_file->payment_cycle_date));
        $paymentDate = !empty($payment->status == 1) ? date('M, d, Y', strtotime($payment->payment_date)) : '--';
        $txnStatus = !empty($payment->unmappedstatus) ? $payment->unmappedstatus : '--';
        $paymentStatus = ($payment->status == 1) ? "<span style='padding-top: 4px;' class='label label-sm label-success ng-scope'>Paid</span>" : "<span style='padding-top: 4px;' class='label label-sm label-warning ng-scope'>Unpaid</span>";
        $paymentLink = "--";
        if ($payment->status == 0) {
            $paymentLink = "<a target='_blank' href='customer/pay-now/" . $payment->uniq_id . "' > <span class='label label-success arrowed-in-right arrowed'>Pay Now</span> </a>";
        } else if ($payment->status == 1) {
            $paymentLink = "<a target='_blank' href='customer/payments/print-receipt/" . $payment->id . "' > <span class='label label-success arrowed-in-right arrowed'>Print</span> </a>";
        }
        $totalFee = ($payment->status == 1) ? $payment->paid_amount : $payment->fee; // + $payment->convenience_fee_amount + $payment->late_fee_amount;
        $html .= <<<HTML
        <tr class='ng-scope'>  
            <td style='text-align: left;'   class='ng-binding'> {$payment->name} </td>
            <td style='text-align: left;'   class='ng-binding'> {$payment->email} </td>
            <!--<td style='text-align: left;'   class='ng-binding'> {$payment->phone} </td>-->
            <td style='text-align: right;'  class='ng-binding'> Rs. {$totalFee} </td>                                        
            <td style='text-align: center;' class='ng-binding'> {$dueDate} </td>    
            <td style='text-align: center;' class='ng-binding'> {$paymentDate} </td>     
            <td style='text-align: center;' class='ng-binding'> {$txnStatus} </td>   
            <td style='text-align: center;' class='ng-binding'> {$paymentStatus} </td>   
            <td style='text-align: center;'>
                <div class='action-buttons'>
                     $paymentLink                   
                </div>  
            </td>
        </tr>
HTML;
    }
} else {
    $html = "<tr><td style='text-align: center; color: red;' colspan='8'> No Data Found </td></tr>";
}

echo json_encode(['status' => 'success', 'html' => $html]);
