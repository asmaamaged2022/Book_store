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

                 </tr>
             </thead>
             <tbody id="DoneTable">
                 <?php
                    if (!empty($orders['done']['data'])) {
                        foreach ($orders['done']['data'] as $order) {

                            echo " 
                            <tr>
                                <td>{$order['id']}</td>
                                <td>{$order['customer_name']}</td>
                                <td>{$order['total_price']}</td>
                                <td>
                                   <a 
                                        onclick='getItemsInCart({$order['id']}, &quot;showOrder&quot;)'
                                        class='pointer'
                                    >
                                        Show
                                    </a>
                                </td>
                            
                                <td>{$order['created_at']}</td>
                        
                            </tr>
                                ";
                        }
                    } else {
                        echo "
                                <tr>
                                    <td colspan='5'>
                                        <p class='alert alert-warning w-75 text-center mx-auto mb-0'>
                                            There are no Data
                                        </p>
                                    </td>
                                </tr>
                            ";
                    }
                    ?>

             </tbody>

         </table>
     </div>
     <?php
        preparePagination($orders['done'], "done");
        ?>