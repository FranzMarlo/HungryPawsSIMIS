<?php
function getStockClass(int $stock_level, int $reorder_point)
{
    if ($stock_level > $reorder_point * 1.5) {
        return 'stable-stock';
    } else if ($stock_level > $reorder_point) {
        return 'warning-stock';
    } else {
        return 'low-stock';
    }
}

function getServiceClass(int $is_service)
{
    if ($is_service == 1) {
        return 'ecommerce-status completed';
    } else {
        return 'ecommerce-status failed';
    }
}

function getServiceText(int $is_service)
{
    if ($is_service == 1) {
        return 'Yes';
    } else {
        return 'No';
    }
}

function getRequestStatusClass(string $status)
{
    if ($status == "Requested") {
        return 'ecommerce-status on-hold';
    } else if ($status == "Approved") {
        return 'ecommerce-status processing';
    } else if ($status == "Cancelled") {
        return 'ecommerce-status cancelled';
    } else {
        return 'ecommerce-status completed';
    }
}

function getPrevOrderClass(int $recent, int $previous)
{
    if ($recent > $previous) {
        return [
            'text' => "Orders <strong>UP &uarr;</strong>",
            'class' => "text-color-success"
        ];
    } elseif ($recent < $previous) {
        return [
            'text' => "Orders <strong>DOWN &darr;</strong>",
            'class' => "text-color-danger"
        ];
    } else {
        return [
            'text' => "<strong>NO CHANGES &rarr;</strong>",
            'class' => "text-color-default"
        ];
    }
}

function getStatusClass(int $is_disabled)
{
    if ($is_disabled == 0) {
        return 'ecommerce-status completed';
    } else {
        return 'ecommerce-status failed';
    }
}

function getStatusText(int $is_disabled)
{
    if ($is_disabled == 0) {
        return 'Active';
    } else {
        return 'Disabled';
    }
}

function getArchivedClass(int $is_archived)
{
    if ($is_archived == 0) {
        return 'ecommerce-status completed';
    } else {
        return 'ecommerce-status failed';
    }
}

function getArchivedText(int $is_archived)
{
    if ($is_archived == 0) {
        return 'Available';
    } else {
        return 'Archived';
    }
}

function getPerishableClass(int $is_perishable)
{
    if ($is_perishable == 0) {
        return 'ecommerce-status completed';
    } else {
        return 'ecommerce-status cancelled';
    }
}

function getPerishableText(int $is_perishable)
{
    if ($is_perishable == 0) {
        return 'No';
    } else {
        return 'Yes';
    }
}
