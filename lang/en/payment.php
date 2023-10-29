<?php

return [
    "enums" => [],
    "messages" => [
        "payment_list_found_successfully" => "Payment list found successfully",
        "payment_successfully_created" => "Payment successfuly created",
        "payment_successfully_verified" => "Payment successfuly Verified",
        "payment_successfuly_found" => "Payment successfuly found",
        "the_payment_was_successfully_rejected" => "The payment was successfully rejected",
        "balance_transferred" => "Balance Successfully Transferred",
        "duplicate_payment_exists" => "A Similar Payment (:amount :currency) Has Done In Recent 5 Minutes",
        "successfully_removed" => "Payment Successfully Removed",
    ],
    "validations" => [],
    "errors" => [
        "you_can_only_decline_pending_payments" => "You can only reject pending payments",
        "you_can_only_verify_pending_payments" => "You can only verify pending payments",
        "payment_notfound" => "Payment Not Found",
        "payment_has_transaction" => "This Payment Already Has a Transaction",
        "from_user_notfound" => "Origin User Not Found",
        "to_user_notfound" => "Destination User Not Found",
        "not_enough_balance" => "Origin User Does Not Have Enough Balance",
        "cant_destroy_pending" => "You Can Only Remove Pending Payments",
    ],
];
