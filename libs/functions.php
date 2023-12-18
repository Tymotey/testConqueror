<?php
	function get_version_link_params(){
		if(ENABLE_DEBUG) return '?=' . rand();
		else return '';
	}

	// Get all enabled challenges sorted
	function get_challenges($order_by = 'popularity', $order_dir = 'ASC'){
        $return_data = [ 'error' => true, 'data' => '', 'message' => 'No challenges found' ];

        $items = DB::query( "SELECT * FROM " . DB_TABLE_ITEMS . " WHERE enabled = '1' ORDER BY " . $order_by . " " . $order_dir );
        if(count($items) > 0){
            $return_data['error'] = false;
            $return_data['data'] = $items;
            $return_data['message'] = '';
        }

        return $return_data;
    }

    // Generate single challenge html for the list
	function get_list_challenge($challenge){
        $html = '';

        if($challenge['enabled'] === '1'){
            $is_new = get_is_new($challenge['added_on']);

            $html = '<div class="challenge_data" attr-id="' . $challenge['id'] . '">';
                $html .= ($is_new ? '<div class="is_new">New</div>' : '');
                $html .= '<div class="div_top">
                    <div class="image_challenge_background">
                        <img src=' . SITE_IMAGES_DIR . $challenge['back_image'] . ' alt="' . $challenge['name'] . '" title="' . $challenge['name'] . '" />
                    </div>
                    <div class="image_challenge">
                        <img src=' . SITE_IMAGES_DIR . $challenge['image'] . ' alt="' . $challenge['name'] . '" title="' . $challenge['name'] . '" />
                    </div>
                </div>';
                $html .= '<div class="div_details">
                    <h2>' . $challenge['name'] . '</h2>
                    <div class="div_route">' . get_lengths($challenge['route_length']) . '</div>
                    <div class="div_postcards">' . ((int) $challenge['postcards'] > 0 ? $challenge['postcards'] : 'No' ) . ' Virtual Postcards</div>
                    <div class="div_streetview">' . ((int) $challenge['street_view'] === 1 ? 'Has' : 'No' ) . ' StreetView</div>
                    <button class="add_to_cart" title="Add ' . $challenge['name'] . ' to Cart">Add challenge</button>
                </div>';
            $html .= '</div>';
        }

        return $html;
    }

    // Get challenge lengths
	function get_lengths($length, $measure = 'km'){
        $new_length = $length;

        if( $measure === "km" ){
            $new_length = number_format( (int) $length / 1.609344, 0) . ' mi / ' . $length . ' km';
        }


        return $new_length;
    }

    // If challenge is new
	function get_is_new($date){
        $return_val = false;

        $challenge_date = new DateTime( $date );
        $max_date = (new DateTime())->modify('-30 day');
        
        if($challenge_date > $max_date){
            $return_val = true;
        }

        return $return_val;
    }

    // Generate html for cart line
	function get_cart_html($data){
        $return_data = [ 'html' => '', 'total' => 0 ];
        $return_html = '<ul>';
        $total = 0;

        foreach($data as $k => $item){
            $item_db_data = get_item($k);
            $total += ((int) $item_db_data['data']['price'] * (int) $item->qty);
            
            if($item_db_data['error'] === false){
                $return_html .= get_cart_item_html($item_db_data, $item);
            }
        }
        $return_html .= '</ul>';

        $return_data['html'] = $return_html;
        $return_data['total'] = $total;

        return $return_data;
    }

    // Generate html for checkout
	function get_checkout_html($data){
        $return_data = [ 'html' => '' ];

        $return_html = '<table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Item Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>';
        $total = 0;

        if(count((array)$data)>0){
            foreach($data as $k => $item){
                $item_db_data = get_item($k);
                $total += ((int) $item_db_data['data']['price'] * (int) $item->qty);
                
                if($item_db_data['error'] === false){
                    $result = get_checkout_item_html($item_db_data, $item);
                    $return_html .= $result;
                }
            }
        }
        else{
            $return_html .= '<tr><td colspan="5">No items added to cart</td></tr>';
        }
        $return_html .= '</tbody>
        <tfoot>
            <tr class="total_tr">
                <td colspan="4" class="text-right">Total:</td>
                <td class="text-center">' . $total . 'LEI</td>
            </tr>
        </tfoot>
        </table>
        <button id="to_checkout">Continue to checkout</button>';

        $return_data['html'] = $return_html;

        return $return_html;
    }

    // Get item from DB
    function get_item($id){
        $return_data = [ 'error' => true, 'data' => '', 'message' => 'No challenge found' ];
        $item = DB::query( "SELECT * FROM " . DB_TABLE_ITEMS . " WHERE id = '" . $id . "' LIMIT 1" );

        if(count($item) > 0){
            $return_data['error'] = false;
            $return_data['data'] = $item[0];
            $return_data['message'] = '';
        }

        return $return_data;
    }

    // Generate html for cart items
    function get_cart_item_html($item_db_data, $item_data){
        $return_html = '<li attr-id="' . $item_db_data['data']['id'] . '">
            <div class="image">
                <img src="' . SITE_IMAGES_DIR . $item_db_data['data']['image'] . '" alt="' . $item_db_data['data']['name'] . '" title="' . $item_db_data['data']['name'] . '" />
            </div>
            <div class="qty">
                <input type="number" value="' . $item_data->qty . '" step="1" min="0" class="main_cart_input" />
            </div>
            <div class="delete" title="Remove ' . $item_db_data['data']['name'] . '">
                <svg class="main_cart_delete" xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
            </div>
        </li>';
        
        return $return_html;
    }

    // Generate html for checkout line
	function get_checkout_item_html($item_db_data, $item){
        $total = ((int) $item_db_data['data']['price'] * (int) $item->qty);
        
        $return_html = '<tr attr-id="' . $item_db_data['data']['id'] . '">
            <td class="name_image">
                <div class="title_div">' . $item_db_data['data']['name'] . '</div>
                <img src="' . SITE_IMAGES_DIR . $item_db_data['data']['image'] . '" alt="' . $item_db_data['data']['name'] . '" title="' . $item_db_data['data']['name'] . '" />
            </td>
            <td class="subtotal"><span class="item_price_text">' . (int) $item_db_data['data']['price'] . '</span>LEI</td>
            <td class="qty">
                <input type="number" value="' . $item->qty . '" step="1" min="0" class="main_cart_input" />
            </td>
            <td class="subtotal"><span class="subtotal_text">' . $total . '</span>LEI</td>
            <td class="delete" title="Remove ' . $item_db_data['data']['name'] . '">
                <svg class="checkout_delete" xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
            </td>
        </tr>';

        return $return_html;
    }