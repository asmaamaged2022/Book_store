<?php

/**
 * @var array $orders
 */
?>
<div class="table-responsive mb-3">
    <table class="table table-info table-striped align-middle mb-0 ">

        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>price</th>
                <th>Details</th>
                <th>created_at</th>
                <?php
                if (isAuth("admin")) {

                    echo "  <th>Options</th>";
                }
                ?>
            </tr>
        </thead>

        <tbody id="orderedTable">
            <?php

            if (!empty($orders['ordered']['data'])) {
                foreach ($orders['ordered']['data'] as $order) {
                    $adminControls = isAuth("admin")
                        ? "
                        <td>
                            <button class='btn btn-info text-white' onclick='DoneOrder({$order['id']})'>Done</button>
                            <button class='btn btn-danger' onclick='cancelOrder({$order['id']})'>Cancel</button>
                        </td>
                   "
                        : "";

                    echo " 
                            <tr id='trOrder-id-{$order['id']}'>
                                <td>{$order['id']}</td>
                                <td>{$order['customer_name']}</td>
                                <td>{$order['total_price']}</td>
                                <td>
                                    <a 
                                        onclick='getItemsInCart({$order['id']}, &quot;showOrder&quot;)'
                                        style='cursor: pointer'
                                    >
                                        Show
                                    </a>
                                </td>                             
                                <td>{$order['created_at']}</td>
                                {$adminControls}
                            
                            </tr>
                         ";
                }
            } else {
                if (isAuth("admin")) {
                    echo "
                    <tr>
                      
                        <td colspan='6'>
                            <p class='alert alert-warning w-75 text-center mx-auto mb-0'>
                                There are no Data
                            </p>
                        </td>
                    </tr>
                ";
                } else {
                    echo "
                    <tr>
                      
                        <td colspan='5' id='WarningInOrderTable'>
                            <p class='alert alert-warning w-75 text-center mx-auto mb-0' >
                                There are no Data
                            </p>
                        </td>
                    </tr>
                ";
                }
            }
            ?>

        </tbody>

    </table>
</div>
<?php
preparePagination($orders['ordered'], "ordered");
?>