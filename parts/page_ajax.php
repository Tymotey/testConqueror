<?php
$return_type = 'json';
$return_data = $return_type === 'json' ? [ 'error' => true, 'data' => '', 'message' => 'Incorrect action sent' ] : '';
$ajax_action = $_GET['action'];

switch ($ajax_action){
	case 'getCartData':
		$id = false;
		if( isset($_POST['cartData']) ){
            $data = json_decode($_POST['cartData']);
            $data_cart = get_cart_html($data);

            $return_data['data'] = [
                'html' => count((array) $data) > 0 ? $data_cart['html'] : 'No items added to cart',
                'total' => $data_cart['total']
            ];
			$return_data['error'] = false;
            $return_data['message'] = '';
		}
		else{
			$return_data['message'] = 'No data sent';
		}
		
		break;
    case 'getCheckoutData':
        $id = false;
		if( isset($_POST['cartData']) ){
            $data = json_decode($_POST['cartData']);
            $data_checkout = get_checkout_html($data);

            $return_data['data'] = $data_checkout;
			$return_data['error'] = false;
            $return_data['message'] = '';
		}
		else{
			$return_data['message'] = 'No data sent';
		}
        
        break;
	case 'getChallengesSort':
		$id = false;
		if( isset($_POST['orderBy']) ){
			$order = explode('-', $_POST['orderBy']);
			$orderBy = isset($order[1]) ? $order[1] : 'popularity';
			$orderDir = isset($order[2]) ? $order[2] : 'desc';
			
			$list = get_challenges($orderBy, $orderDir);
			foreach($list['data'] as $challenge){
                $html = get_list_challenge($challenge);
                $return_data['data'] .= $html;
            }
            $return_data['error'] = false;
            $return_data['message'] = '';
		}
		else{
			$return_data['message'] = 'No sort order sent';
		}
		
		break;
}

if($return_type === 'json'){
	header('Content-Type: application/json; charset=utf-8');	
	echo json_encode($return_data);
}
die();