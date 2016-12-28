<?php

$pagingLinks = $counter = "";

//if ($payments->count() > 0) {

if ($this->Paginator->numbers()):
    $pagingLinks .= $this->Paginator->prev('< ' . __('previous'));
    $pagingLinks .= $this->Paginator->numbers();
    $pagingLinks .= $this->Paginator->next(__('next') . ' >');
endif;

$counter = $this->Paginator->counter('Showing {{start}} to {{end}} of {{count}} entries');

echo json_encode(['status' => 'success', 'payments' => $payments, 'webfront' => $webfront, 'paging' => $pagingLinks, 'counter' => $counter]);
//} else {
//    echo json_encode(['status' => 'error']);
//}


exit;
