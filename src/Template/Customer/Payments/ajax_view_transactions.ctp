<?php

if ($payments->count() > 0) {
    $html = "";
    foreach ($payments as $payment) {
        $dueDate = date('M, d, Y', strtotime($payment->due_date));
        $status = ($payment->status == 1) ? "<span style='padding-top: 4px;' class='label label-sm label-success ng-scope'>Paid</span>" : "<span style='padding-top: 4px;' class='label label-sm label-warning ng-scope'>Unpaid</span>";
        $paymentLink = ($payment->status == 0) ? " <a target='_blank' href='customer/pay-now/" . urlencode(base64_encode($payment->uniq_id)) . "' class='btn btn-xs btn-success'> Pay Now </a>" : "";
        $html .= <<<HTML
        <tr class='ng-scope'>                                    
            <td style='text-align: left;'   class='ng-binding'> {$payment->merchant->name} </td>
            <td style='text-align: left;'   class='ng-binding'> {$payment->name} </td>
            <td style='text-align: left;'   class='ng-binding'> {$payment->email} </td>
            <td style='text-align: right;'  class='ng-binding'> Rs. {$payment->total_fee} </td>                                        
            <td style='text-align: center;' class='ng-binding'> {$dueDate} </td>                              
            <td style='text-align: center;' class='ng-binding'> {$status} </td>                              
            <td style='text-align: center;'>
                <div class='hidden-sm hidden-xs action-buttons'>
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
